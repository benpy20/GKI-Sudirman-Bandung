<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Announcement;
use App\Models\Commission;
use App\Models\Devotion;
use App\Models\Member;
use App\Models\Worship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Carbon::setLocale('id');

        $today = Carbon::today('Asia/Jakarta');
        
        $abouts = About::get();

        $devotions = Devotion::whereDate('date', $today)->latest()->get();

        $devotionCategory = [
            1 => 'Umum',
            2 => 'Remaja/Pemuda',
            3 => 'Anak Sekolah Minggu',
            4 => 'Usia Indah',
        ];

        foreach($devotions as $devotion) {
            $devotion->formatted_date = Carbon::parse($devotion->date, 'Asia/Jakarta')->translatedFormat('l, d F Y');
            $devotion->devotionCategory = $devotionCategory[$devotion->category];
        }

        $announcements = Announcement::whereDate('date_start', '<=', $today)->whereDate('date_end', '>=', $today)->latest()->take(4)->get();

        $announcementCategory = [
            1 => 'Diakonia',
            2 => 'Persekutuan dan Keesaan',
            3 => 'Pembinaan',
            4 => 'Sarana Penunjang',
        ];

        foreach($announcements as $announcement) {
            $announcement->announcementCategory = $announcementCategory[$announcement->category];
        }

        $startWorship = $today->copy()->startOfWeek(Carbon::SUNDAY)->subWeek();
        $endWorship = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $worships = Worship::where('category', 0)->take(2)
            ->whereBetween('date', [$startWorship, $endWorship])->orderBy('date', 'desc')->get();

        foreach ($worships as $worship) {
            $worship->date_formatted = Carbon::parse($worship->date)
                ->translatedFormat('l, j F Y');
        }

        $start = $today->copy()->startOfWeek(Carbon::MONDAY)->subWeek();
        $end = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $members = Member::where('is_active', 1)->get()->filter(function ($member) use ($start, $end) {
            $birth = Carbon::parse($member->birth_date);
            $birthdayThisYear = Carbon::create(
                now()->year,
                $birth->month,
                $birth->day
            );
            return $birthdayThisYear->between($start, $end);
        });

        foreach ($members as $member) {
            $member->birth_date_formatted = Carbon::parse($member->birth_date)
                ->translatedFormat('j F');
        }

        $commissions = Commission::orderBy('day')->orderBy('time_start')->latest('id')->get();

        foreach ($commissions as $item) {
            $item->time_start_formatted = Carbon::parse($item->time_start)->format('H.i');
            $item->time_end_formatted = Carbon::parse($item->time_end)->format('H.i');
        }

        $commissions = $commissions->groupBy('day');

        $order = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

        $commissions = $commissions->sortBy(function ($_, $day) use ($order) {
            return array_search($day, $order);
        });
        
        return view('home.index', compact('abouts', 'devotions', 'announcements', 'worships', 'members', 'commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
