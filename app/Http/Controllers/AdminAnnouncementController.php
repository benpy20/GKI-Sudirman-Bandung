<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $today = Carbon::today('Asia/Jakarta');

        $query = Announcement::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereDate('date_start', '<=', $today)
                    ->whereDate('date_end', '>=', $today);
            } elseif ($request->status == 'expired') {
                $query->whereDate('date_end', '<', $today);
            } elseif ($request->status == 'upcoming') {
                $query->whereDate('date_start', '>', $today);
            }
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $announcements = $query->latest()->paginate(10)->withQueryString();

        $announcementCategory = [
            1 => 'Diakonia',
            2 => 'Persekutuan dan Keesaan',
            3 => 'Pembinaan',
            4 => 'Sarana Penunjang',
        ];

        foreach ($announcements as $announcement) {
            $today = Carbon::today('Asia/Jakarta');
            $start = Carbon::parse($announcement->date_start, 'Asia/Jakarta')->startOfDay();
            $end = Carbon::parse($announcement->date_end, 'Asia/Jakarta')->endOfDay();

            if ($today->between($start, $end)) {
                $announcement->status = 'active';
            } elseif ($today->lt($start)) {
                $announcement->status = 'upcoming';
            } else {
                $announcement->status = 'expired';
            }

            $announcement->is_date_active = $announcement->status === 'active';

            $announcement->date_start = Carbon::parse($announcement->date_start, 'Asia/Jakarta')->translatedFormat('j F Y');
            $announcement->date_end = Carbon::parse($announcement->date_end, 'Asia/Jakarta')->translatedFormat('j F Y');
            $announcement->announcementCategory = $announcementCategory[$announcement->category];
        }

        return view('admin.announcement.index', compact('announcements', 'announcementCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'users_id' => auth()->id()
        ]);

        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'category' => 'required|in:1,2,3,4',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ], [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'title.string' => 'Judul pengumuman harus berupa teks.',
            'title.max' => 'Judul pengumuman tidak boleh lebih dari 200 karakter.',
            'content.required' => 'Isi pengumuman wajib diisi.',
            'content.string' => 'Isi pengumuman harus berupa teks.',
            'category.required' => 'Kategori pengumuman wajib diisi.',
            'category.in' => 'Kategori pengumuman tidak valid.',
            'date_start.required' => 'Tanggal mulai wajib diisi.',
            'date_start.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'date_end.required' => 'Tanggal selesai wajib diisi.',
            'date_end.date' => 'Tanggal selesai harus berupa tanggal yang valid.',
            'date_end.after_or_equal' => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai.',
            'image_url.image' => 'File yang diunggah harus berupa gambar.',
            'image_url.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'image_url.max' => 'Ukuran gambar tidak boleh lebih dari 8MB.',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'users_id' => $request->users_id,
        ]);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $extension = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('announcements', $filename, 'public');
            $announcement->update(
                ['image_url' => $path]
            );
        }

        return redirect()->route('admin.announcement.index')->with('success', 'Data warta jemaat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Carbon::setLocale('id');

        $announcement = Announcement::with('users')->findOrFail($id);

        $announcementCategory = [
            1 => 'Diakonia',
            2 => 'Persekutuan dan Keesaan',
            3 => 'Pembinaan',
            4 => 'Sarana Penunjang',
        ];

        $today = Carbon::today('Asia/Jakarta');
        $start = Carbon::parse($announcement->date_start, 'Asia/Jakarta')->startOfDay();
        $end = Carbon::parse($announcement->date_end, 'Asia/Jakarta')->endOfDay();

        if ($today->between($start, $end)) {
            $announcement->status = 'active';
        } elseif ($today->lt($start)) {
            $announcement->status = 'upcoming';
        } else {
            $announcement->status = 'expired';
        }

        $announcement->is_date_active = $announcement->status === 'active';

        $announcement->date_start = Carbon::parse($announcement->date_start, 'Asia/Jakarta')->translatedFormat('j F Y');
        $announcement->date_end = Carbon::parse($announcement->date_end, 'Asia/Jakarta')->translatedFormat('j F Y');
        $announcement->announcementCategory = $announcementCategory[$announcement->category];

        $announcement->updated_at_local = Carbon::parse($announcement->updated_at, 'Asia/Jakarta')->timezone('Asia/Jakarta')->translatedFormat('j F Y H:i');

        return view('admin.announcement.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('admin.announcement.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'users_id' => auth()->id()
        ]);

        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'category' => 'required|in:1,2,3,4',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ], [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'title.string' => 'Judul pengumuman harus berupa teks.',
            'title.max' => 'Judul pengumuman tidak boleh lebih dari 200 karakter.',
            'content.required' => 'Isi pengumuman wajib diisi.',
            'content.string' => 'Isi pengumuman harus berupa teks.',
            'category.required' => 'Kategori pengumuman wajib diisi.',
            'category.in' => 'Kategori pengumuman tidak valid.',
            'date_start.required' => 'Tanggal mulai wajib diisi.',
            'date_start.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'date_end.required' => 'Tanggal selesai wajib diisi.',
            'date_end.date' => 'Tanggal selesai harus berupa tanggal yang valid.',
            'date_end.after_or_equal' => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai.',
            'image_url.image' => 'File yang diunggah harus berupa gambar.',
            'image_url.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'image_url.max' => 'Ukuran gambar tidak boleh lebih dari 8MB.',
        ]);

        $announcement = Announcement::findOrFail($id);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'users_id' => $request->users_id,
        ]);

        if ($request->hasFile('image_url')) {
            if ($announcement->image_url) {
                Storage::disk('public')->delete($announcement->image_url);
            }

            $file = $request->file('image_url');
            $extension = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('announcements', $filename, 'public');
            $announcement->update(
                ['image_url' => $path]
            );
        } elseif ($request->input('remove_image')) {
            if ($announcement->image_url) {
                Storage::disk('public')->delete($announcement->image_url);
                $announcement->update(['image_url' => null]);
            }
        }

        return redirect()->route('admin.announcement.index')->with('success', 'Data warta jemaat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($announcement->image_url) {
            Storage::disk('public')->delete($announcement->image_url);
        }

        $announcement->delete();

        return redirect()->route('admin.announcement.index')->with('success', 'Data warta jemaat berhasil dihapus!');
    }
}
