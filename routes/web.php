<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Keluarga\DashboardController as KeluargaDashboardController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\Admin\LansiaController;
use App\Http\Controllers\Admin\KegiatanController;

use Illuminate\Support\Facades\Route;

// ======================
//   Landing Page
// ======================
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/tentang-kami', function () {
    return view('public.tentang');
})->name('tentang');

Route::get('/donasi', [DonasiController::class, 'index'])->name('donasi.index');
Route::post('/donasi', [DonasiController::class, 'store'])->name('donasi.store');

// ======================
// Dashboard Redirect
// ======================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isKaryawan()) return redirect()->route('karyawan.dashboard');
    if ($user->isKeluarga()) return redirect()->route('keluarga.dashboard');

    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// ======================
//  Semua user login
// ======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ======================
//   ADMIN ROUTES
// ======================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ======================
        // Lansia
        // ======================
        Route::resource('lansia', LansiaController::class)
            ->parameters(['lansia' => 'lansia']);

        Route::get('/lansia/{lansia}/download', [LansiaController::class, 'download'])
            ->name('lansia.download');

        Route::patch('/lansia/{lansia}/status', [LansiaController::class, 'updateStatus'])
            ->name('lansia.update-status');

        // ======================
        // Kegiatan
        // ======================
        Route::resource('kegiatan', KegiatanController::class);

        // Kehadiran
        Route::post('/kegiatan/{kegiatan}/kehadiran',
            [KegiatanController::class, 'storeKehadiran']
        )->name('kegiatan.kehadiran.store');

        Route::get('/kegiatan/{kegiatan}/kehadiran',
            [KegiatanController::class, 'kehadiran']
        )->name('kegiatan.kehadiran');

        // ======================
        // REKAP & EXPORT
        // ======================
        Route::get('/kegiatan-rekap',
            [KegiatanController::class, 'rekap']
        )->name('kegiatan.rekap');

        Route::get('/kegiatan-rekap/export-excel',
            [KegiatanController::class, 'exportExcel']
        )->name('kegiatan.export-excel');

        Route::get('/kegiatan-rekap/export-pdf',
            [KegiatanController::class, 'exportPdf']
        )->name('kegiatan.export-pdf');
    });

// ======================
//  Karyawan
// ======================
Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {
        Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    });

// ======================
//  Keluarga
// ======================
Route::middleware(['auth', 'role:keluarga'])
    ->prefix('keluarga')
    ->name('keluarga.')
    ->group(function () {
        Route::get('/dashboard', [KeluargaDashboardController::class, 'index'])->name('dashboard');
    });

require __DIR__.'/auth.php';