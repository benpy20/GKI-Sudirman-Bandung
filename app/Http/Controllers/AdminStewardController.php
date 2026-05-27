<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Steward;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminStewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Steward::with('commission');

        if ($request->filled('search')) {
            $query->where('field', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('commission')) {
            if ($request->commission === 'umum') {
                $query->whereNull('commissions_id');
            } else {
                $query->where('commissions_id', $request->commission);
            }
        }

        $stewards = $query->latest('id')->paginate(10)->withQueryString();

        $commissions = Commission::where('name', '!=', 'Umum')->get();

        return view('admin.steward.index', compact('stewards', 'commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $commissions = Commission::where('name', '!=', 'Umum')->get();

        return view('admin.steward.create', compact('commissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'commissions_id' => $request->commissions_id ?: null,
        ]);

        $request->validate([
            'field' => 'required|string|max:100',
            'commissions_id' => 'nullable|exists:commissions,id',
        ], [
            'field.required' => 'Nama pelayanan wajib diisi.',
            'field.string' => 'Nama pelayanan harus berupa teks.',
            'field.max' => 'Nama pelayanan tidak boleh lebih dari 100 karakter.',
            'commissions_id.required' => 'Kategori komisi wajib dipilih.',
            'commissions_id.in' => 'Kategori komisi tidak valid.',
        ]);

        Steward::create([
            'field' => $request->field,
            'commissions_id' => $request->commissions_id,
        ]);

        return redirect()->route('admin.steward.index')->with('success', 'Data pelayan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Carbon::setLocale('id');
        
        $steward = Steward::with('commission')->findOrFail($id);

        $memberStatus = [
            1 => 'Koordinator Hamba Tuhan',
            2 => 'Pendeta',
            3 => 'Penginjil',
            4 => 'Penatua',
            5 => 'Diaken',
            6 => 'Jemaat Biasa',
        ];

        $members = $steward->members()->latest('id')->get()->map(function ($member) use ($memberStatus) {
            $member->memberStatus = $memberStatus[$member->status];
            return $member;
        });

        foreach ($members as $member) {
            $member->birth_date_formatted = Carbon::parse($member->birth_date)->translatedFormat('j F Y');
        }

        return view('admin.steward.show', compact('steward', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $steward = Steward::findOrFail($id);

        $commissions = Commission::where('name', '!=', 'Umum')->get();

        return view('admin.steward.edit', compact('steward', 'commissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $steward = Steward::findOrFail($id);

        $request->merge([
            'commissions_id' => $request->commissions_id ?: null,
        ]);

        $request->validate([
            'field' => 'required|string|max:100',
            'commissions_id' => 'nullable|exists:commissions,id',
        ], [
            'field.required' => 'Nama pelayanan wajib diisi.',
            'field.string' => 'Nama pelayanan harus berupa teks.',
            'field.max' => 'Nama pelayanan tidak boleh lebih dari 100 karakter.',
            'commissions_id.required' => 'Kategori komisi wajib dipilih.',
            'commissions_id.in' => 'Kategori komisi tidak valid.',
        ]);

        $steward->update([
            'field' => $request->field,
            'commissions_id' => $request->commissions_id,
        ]);

        return redirect()->route('admin.steward.index')->with('success', 'Data pelayan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $steward = Steward::findOrFail($id);

        $steward->delete();

        return redirect()->route('admin.steward.index')->with('success', 'Data pelayan berhasil dihapus!');
    }
}
