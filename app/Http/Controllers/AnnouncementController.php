<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    Carbon::setLocale('id');

    $today = Carbon::today();

    $announcements = Announcement::where('date_start', '<=', $today)
        ->where('date_end', '>=', $today)->orderBy('category')->orderBy('date_start')->get();

    $categoryMap = [
        1 => 'Diakonia',
        2 => 'Persekutuan dan Keesaan',
        3 => 'Pembinaan',
        4 => 'Sarana Penunjang',
    ];

    $lastCategory = null;

    foreach ($announcements as $announcement) {
        $announcement->date_start_formatted = Carbon::parse($announcement->date_start)->translatedFormat('j F Y');

        $announcement->category_name = $categoryMap[$announcement->category] ?? 'Lainnya';

        if ($announcement->category !== $lastCategory) {
            $announcement->show_category = true;
            $lastCategory = $announcement->category;
        } else {
            $announcement->show_category = false;
        }
    }

    return view('announcement.index', compact('announcements'));
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('announcement.show', compact('announcement'));
    }
}
