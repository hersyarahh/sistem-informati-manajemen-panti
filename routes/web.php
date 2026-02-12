<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\LansiaController as KaryawanLansiaController;
use App\Http\Controllers\Karyawan\KegiatanController as KaryawanKegiatanController;
use App\Http\Controllers\Admin\LansiaController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\Admin\TerminasiLansiaController;
use App\Http\Controllers\Admin\RekapLansiaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RiwayatKesehatanController;
use App\Http\Controllers\Admin\KaryawanAssignmentController;
use App\Http\Controllers\Admin\PekerjaSosialController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

// ======================
//   Landing Page
// ======================
Broadcast::routes(['middleware' => ['auth']]);
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/tentang-kami', function () {
    return view('public.tentang');
})->name('tentang');


// ======================
// Dashboard Redirect
// ======================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isKaryawan()) return redirect()->route('staff.riwayat-kesehatan');

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
        // User Management
        // ======================
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('pekerja-sosial', PekerjaSosialController::class);
        Route::get('pekerja-sosial-rekap', [PekerjaSosialController::class, 'rekap'])
            ->name('pekerja-sosial.rekap');

        // ======================
        // Riwayat Kesehatan
        // ======================
        Route::get('/riwayat-kesehatan', [RiwayatKesehatanController::class, 'index'])
            ->name('riwayat-kesehatan.index');
        Route::get('/riwayat-kesehatan/{lansia}', [RiwayatKesehatanController::class, 'show'])
            ->name('riwayat-kesehatan.show');
        Route::get('/riwayat-kesehatan/{lansia}/rekap', [RiwayatKesehatanController::class, 'rekap'])
            ->name('riwayat-kesehatan.rekap');
        Route::get('/riwayat-kesehatan/{lansia}/download', [RiwayatKesehatanController::class, 'download'])
            ->name('riwayat-kesehatan.download');
        Route::get('/riwayat-kesehatan-rekap', [RiwayatKesehatanController::class, 'rekapAll'])
            ->name('riwayat-kesehatan.rekap-all');
        Route::get('/riwayat-kesehatan/assign/staff', [KaryawanAssignmentController::class, 'index'])
            ->name('riwayat-kesehatan.assign');
        Route::post('/riwayat-kesehatan/assign/staff/select', [KaryawanAssignmentController::class, 'selectStaff'])
            ->name('riwayat-kesehatan.assign.select');
        Route::get('/riwayat-kesehatan/assign/staff/reset', [KaryawanAssignmentController::class, 'resetFilter'])
            ->name('riwayat-kesehatan.assign.reset');
        Route::post('/riwayat-kesehatan/assign/staff', [KaryawanAssignmentController::class, 'store'])
            ->name('riwayat-kesehatan.assign.store');

        // ======================
        // REKAP LANSIA
        // ======================
        Route::get('/lansia/rekap', [RekapLansiaController::class, 'index'])
            ->name('lansia.rekap');
        Route::get('/lansia/rekap-excel', [RekapLansiaController::class, 'exportExcel'])
            ->name('lansia.rekap-excel');

        // ======================
        // Lansia (Admin only)
        // ======================
        Route::get('/lansia/create', [LansiaController::class, 'create'])
            ->name('lansia.create');
        Route::post('/lansia', [LansiaController::class, 'store'])
            ->name('lansia.store');
        Route::delete('/lansia/{lansia}', [LansiaController::class, 'destroy'])
            ->name('lansia.destroy');

        Route::get('/lansia/{lansia}/download', [LansiaController::class, 'download'])
            ->name('lansia.download');

        Route::patch('/lansia/{lansia}/status', [LansiaController::class, 'updateStatus'])
            ->name('lansia.update-status');

        Route::get('/lansia/{lansia}/terminasi', [TerminasiLansiaController::class, 'create'])
            ->name('lansia.terminasi.create');
        Route::post('/lansia/{lansia}/terminasi', [TerminasiLansiaController::class, 'store'])
            ->name('lansia.terminasi.store');

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

        // ======================
        // Inventaris
        // ======================
        // CREATE
        Route::get(
            '/inventaris/create',
            [InventarisController::class, 'create']
        )->name('data-inventaris.create');

        // STORE
        Route::post(
            '/inventaris',
            [InventarisController::class, 'store']
        )->name('data-inventaris.store');

        // INDEX
        Route::get(
            '/inventaris',
            [InventarisController::class, 'index']
        )->name('data-inventaris.index');

        // EDIT & UPDATE
        Route::get(
            '/inventaris/{inventaris}/edit',
            [InventarisController::class, 'edit']
        )->name('data-inventaris.edit');

        Route::put(
            '/inventaris/{inventaris}',
            [InventarisController::class, 'update']
        )->name('data-inventaris.update');

        // DETAIL INVENTARIS
        Route::get(
            '/inventaris/{id}',
            [InventarisController::class, 'show']
        )->name('data-inventaris.show');

        // DELETE
        Route::delete(
            '/inventaris/{inventaris}',
            [InventarisController::class, 'destroy']
        )->name('data-inventaris.destroy');

        //DOWNLOAD LAPORAN
        Route::get(
            '/inventaris/{id}/download-laporan',
            [InventarisController::class, 'downloadLaporan']
        )->name('data-inventaris.download-laporan');
    });

// ======================
//  Admin + Karyawan akses lansia
// ======================
Route::middleware(['auth', 'role:admin,karyawan'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/lansia', [LansiaController::class, 'index'])
            ->name('lansia.index');
        Route::get('/lansia/{lansia}', [LansiaController::class, 'show'])
            ->name('lansia.show');
        Route::get('/lansia/{lansia}/edit', [LansiaController::class, 'edit'])
            ->name('lansia.edit');
        Route::put('/lansia/{lansia}', [LansiaController::class, 'update'])
            ->name('lansia.update');
        Route::patch('/lansia/{lansia}', [LansiaController::class, 'update']);
    });


// ======================
//  Karyawan
// ======================
Route::middleware(['auth', 'role:karyawan'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::redirect('/dashboard', '/staff/riwayat-kesehatan')->name('dashboard');
        Route::get('/riwayat-kesehatan', [KaryawanDashboardController::class, 'riwayatKesehatan'])->name('riwayat-kesehatan');
        Route::get('/riwayat-kegiatan', [KaryawanKegiatanController::class, 'index'])->name('riwayat-kegiatan');
        Route::post('/riwayat-kegiatan', [KaryawanKegiatanController::class, 'store'])->name('riwayat-kegiatan.store');
        Route::put('/riwayat-kegiatan/{kehadiran}', [KaryawanKegiatanController::class, 'update'])->name('riwayat-kegiatan.update');
        Route::post('/riwayat-kegiatan/{kehadiran}/cancel', [KaryawanKegiatanController::class, 'requestCancel'])->name('riwayat-kegiatan.cancel');
        Route::get('/kegiatan/{kegiatan}/kehadiran', [KaryawanKegiatanController::class, 'kehadiran'])->name('kegiatan.kehadiran');
        Route::get('/lansia/{lansia}/edit', [KaryawanLansiaController::class, 'edit'])->name('lansia.edit');
        Route::put('/lansia/{lansia}', [KaryawanLansiaController::class, 'update'])->name('lansia.update');
        Route::patch('/lansia/{lansia}', [KaryawanLansiaController::class, 'update']);
    });

Route::middleware(['auth', 'role:karyawan'])
    ->get('/karyawan/{path?}', function ($path = '') {
        $path = ltrim($path, '/');
        return redirect('/staff' . ($path ? '/' . $path : ''));
    })
    ->where('path', '.*');

require __DIR__.'/auth.php';
