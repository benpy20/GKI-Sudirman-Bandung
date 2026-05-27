<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminAboutController;
use App\Http\Controllers\AdminAnnouncementController;
use App\Http\Controllers\AdminCommissionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDevotionController;
use App\Http\Controllers\AdminLiturgicalCalendarController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminPreacherController;
use App\Http\Controllers\AdminRegionController;
use App\Http\Controllers\AdminStewardController;
use App\Http\Controllers\AdminSuperAdminController;
use App\Http\Controllers\AdminWorshipController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArticleTeologisController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DevotionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SundayServicesController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\WartaController;
use App\Http\Controllers\WartaJemaatController;
use App\Http\Controllers\WartaKebaktianController;
use App\Http\Controllers\WartaKegiatanController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('home.index');
});

Route::get('home', [HomeController::class, 'index'])->name('home.index');

// Route::resource('warta_kebaktian', WartaKebaktianController::class);
// Route::resource('warta_jemaat', WartaJemaatController::class);
// Route::resource('warta_kegiatan', WartaKegiatanController::class);
// Route::get('/warta/{category}', [WartaController::class, 'index'])->name('warta.kategori');
Route::get('kebaktian_minggu', [SundayServicesController::class, 'index'])->name('sunday_services.index');
Route::get('warta', [AnnouncementController::class, 'index'])->name('announcement.index');
Route::get('warta/{id}', [AnnouncementController::class, 'show'])->name('announcement.show');
Route::get('renungan_harian', [DevotionController::class, 'index'])->name('devotion.index');
Route::get('renungan_harian/{id}', [DevotionController::class, 'show'])->name('devotion.show');
// Route::resource('artikel_teologis', ArticleTeologisController::class);
Route::get('hubungi_kami', [ContactUsController::class, 'index'])->name('contact_us.index');
// Route::resource('visi_misi', VisiMisiController::class);

Route::prefix('tentang_kami')->name('about_us.')->controller(AboutUsController::class)->group(function () {
    Route::get('visi_misi', 'visionMission')->name('vision_mission');
    Route::get('struktur_kemajelisan', 'assemblyStructure')->name('assembly_structure');
    Route::get('rayon', 'region')->name('region');
    Route::get('tema_gereja', 'church_theme')->name('church_theme');
});

// Route::prefix('tentang')->name('tentang.')->group(function () {
//     Route::get('keanggotaan', function () {
//         return view('tentang.keanggotaan');
//     })->name('keanggotaan');

//     Route::get('baptis_nikah', function () {
//         return view('tentang.baptis_nikah');
//     })->name('baptis_nikah');

//     Route::get('struktur', function () {
//         return view('tentang.struktur');
//     })->name('struktur');
// });
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('member', AdminMemberController::class);
    Route::resource('commission', AdminCommissionController::class);
    Route::resource('region', AdminRegionController::class);
    Route::resource('steward', AdminStewardController::class);
    Route::resource('worship', AdminWorshipController::class);
    Route::resource('liturgical_calendar', AdminLiturgicalCalendarController::class);
    Route::resource('announcement', AdminAnnouncementController::class);
    Route::resource('devotion', AdminDevotionController::class);
    Route::resource('preacher', AdminPreacherController::class);
    Route::resource('about', AdminAboutController::class);
    Route::resource('super_admin', AdminSuperAdminController::class)->middleware('superadmin');
});

require __DIR__.'/auth.php';