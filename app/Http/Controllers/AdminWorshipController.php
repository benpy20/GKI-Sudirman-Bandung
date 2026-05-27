<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\LiturgicalCalendar;
use App\Models\Member;
use App\Models\Preacher;
use App\Models\Steward;
use App\Models\Worship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $query = Worship::with('liturgical_calendars');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('period')) {
            $now = Carbon::now('Asia/Jakarta');
            if ($request->period == '1m') {
                $query->where('date', '>=', $now->copy()->subMonth());
            } elseif ($request->period == '3m') {
                $query->where('date', '>=', $now->copy()->subMonths(3));
            } elseif ($request->period == '6m') {
                $query->where('date', '>=', $now->copy()->subMonths(6));
            } elseif ($request->period == '1y') {
                $query->where('date', '>=', $now->copy()->subYear());
            }
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $worships = $query->latest('id')->paginate(10)->withQueryString();

        // Ambil data komisi supaya ga hardcode jenis kebaktiannya
        $commission_names = Commission::where('name', '!=', 'Umum')->pluck('name', 'id');

        foreach ($worships as $worship) {
            $worship->date_formatted = Carbon::parse($worship->date, 'Asia/Jakarta')->translatedFormat('j F Y');
            $worship->time_formatted = Carbon::parse($worship->time, 'Asia/Jakarta')->format('H:i');
            if ($worship->category == 0) {
                $worship->category_label = 'Kebaktian Umum';
            } else {
                $worship->category_label = ('Ibadah ' . $commission_names[$worship->category]) ?? '-';
            }
        }

        return view('admin.worship.index', compact('worships', 'commission_names'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $liturgical_calendars = LiturgicalCalendar::all();

        $stewards = Steward::all();

        $commissions = Commission::where('name', '!=', 'Umum')->get();

        $members = Member::where('is_active', 1)->with('stewards')->get();

        $preachers = Preacher::all();

        return view('admin.worship.create', compact('liturgical_calendars', 'stewards', 'members', 'preachers', 'commissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'bible_verse' => 'required|string|max:100',
            'category' => 'required|integer',
            'video_url' => 'nullable|url',
            'date' => 'required|date',
            'time' => 'required',
            'liturgical_calendars_id' => 'nullable|exists:liturgical_calendars,id',
            'preachers_id' => 'nullable|exists:preachers,id',
            'stewards' => 'nullable|array',
        ], [
            'title.required' => 'Judul kebaktian wajib diisi.',
            'title.max' => 'Judul kebaktian tidak boleh lebih dari 200 karakter.',
            'bible_verse.required' => 'Ayat Alkitab wajib diisi.',
            'bible_verse.max' => 'Ayat Alkitab tidak boleh lebih dari 100 karakter.',
            'category.required' => 'Kategori kebaktian wajib dipilih.',
            'category.integer' => 'Kategori kebaktian tidak valid.',
            'video_url.url' => 'URL video tidak valid.',
            'date.required' => 'Tanggal kebaktian wajib diisi.',
            'date.date' => 'Tanggal kebaktian tidak valid.',
            'time.required' => 'Waktu kebaktian wajib diisi.',
            'liturgical_calendars_id.exists' => 'Kalender liturgi yang dipilih tidak valid.',
            'preachers_id.exists' => 'Pengkhotbah yang dipilih tidak valid.',
            'stewards.array' => 'Penatalayan harus berupa array.',
        ]);

        $worship = Worship::create([
            'title' => $request->title,
            'description' => $request->description,
            'bible_verse' => $request->bible_verse,
            'video_url' => $request->video_url,
            'date' => $request->date,
            'time' => $request->time,
            'category' => $request->category,
            'liturgical_calendars_id' => $request->liturgical_calendars_id,
            'preachers_id' => $request->preachers_id,
        ]);

        if ($request->filled('stewards')) {
            foreach ($request->stewards as $steward) {
                $data = json_decode($steward, true);
                if (!$data) continue;
                DB::table('sunday_services')->insert([
                    'members_id' => $data['member_id'],
                    'worships_id' => $worship->id,
                    'stewards_id' => $data['steward_id'],
                ]);
            }
        }

        return redirect()->route('admin.worship.index')->with('success', 'Data jadwal kebaktian berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Carbon::setLocale('id');

        $worship = Worship::with([
            'liturgical_calendars', 'preachers', 'sunday_services.members', 'sunday_services.stewards']
        )->findOrFail($id);

        $worship->date_formatted = Carbon::parse($worship->date, 'Asia/Jakarta')->translatedFormat('j F Y');
        $worship->time_formatted = Carbon::parse($worship->time, 'Asia/Jakarta')->format('H:i');
        if ($worship->category == 0) {
            $worship->category_label = 'Kebaktian Umum';
        } else {
            $commission = Commission::find($worship->category);
            $worship->category_label = 'Ibadah ' . $commission->name;
        }

        $sunday_services = $worship->sunday_services->groupBy(function ($item) {
            return $item->stewards->field ?? 'Lainnya';
        });

        $memberStatus = [
            1 => 'Koordinator Hamba Tuhan',
            2 => 'Pendeta',
            3 => 'Penginjil',
            4 => 'Penatua',
            5 => 'Diaken',
            6 => 'Jemaat Biasa',
        ];

        foreach ($worship->sunday_services as $service) {
            $service->members->memberStatus = $memberStatus[$service->members->status] ?? '-';
        }

        return view('admin.worship.show', compact('worship', 'sunday_services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $worship = Worship::with([
            'sunday_services.members',
            'sunday_services.stewards'
        ])->findOrFail($id);

        $liturgical_calendars = LiturgicalCalendar::all();

        $stewards = Steward::all();

        $commissions = Commission::where('name', '!=', 'Umum')->get();

        $members = Member::where('is_active', 1)->with('stewards')->get();

        $preachers = Preacher::all();

        $steward_members = [];

        foreach ($worship->sunday_services as $service) {
            if ($service->members) {
                $steward_members[$service->stewards_id][] = [
                    'id' => $service->members->id,
                    'name' => $service->members->name,
                ];
            }
        }
        return view('admin.worship.edit', compact('worship', 'liturgical_calendars', 'stewards', 'members', 'preachers', 'commissions', 'steward_members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'bible_verse' => 'required|string|max:100',
            'category' => 'required|integer',
            'video_url' => 'nullable|url',
            'date' => 'required|date',
            'time' => 'required',
            'liturgical_calendars_id' => 'nullable|exists:liturgical_calendars,id',
            'preachers_id' => 'nullable|exists:preachers,id',
            'stewards' => 'nullable|array',
        ], [
            'title.required' => 'Judul kebaktian wajib diisi.',
            'title.max' => 'Judul kebaktian tidak boleh lebih dari 200 karakter.',
            'bible_verse.required' => 'Ayat Alkitab wajib diisi.',
            'bible_verse.max' => 'Ayat Alkitab tidak boleh lebih dari 100 karakter.',
            'category.required' => 'Kategori kebaktian wajib dipilih.',
            'category.integer' => 'Kategori kebaktian tidak valid.',
            'video_url.url' => 'URL video tidak valid.',
            'date.required' => 'Tanggal kebaktian wajib diisi.',
            'date.date' => 'Tanggal kebaktian tidak valid.',
            'time.required' => 'Waktu kebaktian wajib diisi.',
            'liturgical_calendars_id.exists' => 'Kalender liturgi yang dipilih tidak valid.',
            'preachers_id.exists' => 'Pengkhotbah yang dipilih tidak valid.',
            'stewards.array' => 'Penatalayan harus berupa array.',
        ]);

        $worship = Worship::findOrFail($id);

        $worship->update([
            'title' => $request->title,
            'description' => $request->description,
            'bible_verse' => $request->bible_verse,
            'video_url' => $request->video_url,
            'date' => $request->date,
            'time' => $request->time,
            'category' => $request->category,
            'liturgical_calendars_id' => $request->liturgical_calendars_id,
            'preachers_id' => $request->preachers_id,
        ]);
        // Hapus penatalayan lama
        DB::table('sunday_services')->where('worships_id', $worship->id)->delete();

        // Tambah penatalayan baru
        if ($request->filled('stewards')) {

            $unique = collect($request->stewards)
                ->map(fn($s) => json_decode($s, true))
                ->filter()
                ->unique(fn($s) => $s['member_id'].'-'.$s['steward_id']);

            foreach ($unique as $data) {
                DB::table('sunday_services')->insert([
                    'members_id' => $data['member_id'],
                    'worships_id' => $worship->id,
                    'stewards_id' => $data['steward_id'],
                ]);
            }
        }

        return redirect()->route('admin.worship.index')->with('success', 'Data jadwal kebaktian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $worship = Worship::findOrFail($id);
        $worship->delete();

        return redirect()->route('admin.worship.index')->with('success', 'Data jadwal kebaktian berhasil dihapus!');
    }
}
