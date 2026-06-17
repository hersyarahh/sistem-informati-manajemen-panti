<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\PekerjaSosial\DashboardController as PekerjaSosialDashboardController;
use App\Http\Controllers\PekerjaSosial\LansiaController as PekerjaSosialLansiaController;
use App\Http\Controllers\PekerjaSosial\KegiatanController as PekerjaSosialKegiatanController;
use App\Http\Controllers\Admin\LansiaController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\TerminasiLansiaController;
use App\Http\Controllers\Admin\RekapLansiaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RiwayatKesehatanController;
use App\Http\Controllers\Admin\PekerjaSosialAssignmentController;
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
    if ($user->isPekerjaSosial()) return redirect()->route('pekerja-sosial.riwayat-kesehatan');

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
        Route::redirect('/riwayat-kesehatan/{lansia}/rekap', '/admin/riwayat-kesehatan/{lansia}')
            ->name('riwayat-kesehatan.rekap');
        Route::get('/riwayat-kesehatan/{lansia}/download', [RiwayatKesehatanController::class, 'download'])
            ->name('riwayat-kesehatan.download');
        Route::redirect('/riwayat-kesehatan-rekap', '/admin/riwayat-kesehatan')
            ->name('riwayat-kesehatan.rekap-all');
        Route::get('/riwayat-kesehatan/assign/pekerja-sosial', [PekerjaSosialAssignmentController::class, 'index'])
            ->name('riwayat-kesehatan.assign');
        Route::post('/riwayat-kesehatan/assign/pekerja-sosial/select', [PekerjaSosialAssignmentController::class, 'selectPekerjaSosial'])
            ->name('riwayat-kesehatan.assign.select');
        Route::get('/riwayat-kesehatan/assign/pekerja-sosial/reset', [PekerjaSosialAssignmentController::class, 'resetFilter'])
            ->name('riwayat-kesehatan.assign.reset');
        Route::post('/riwayat-kesehatan/assign/pekerja-sosial', [PekerjaSosialAssignmentController::class, 'store'])
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

    });

// ======================
//  Admin + Pekerja Sosial akses lansia
// ======================
Route::middleware(['auth', 'role:admin,pekerja_sosial'])
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
//  Pekerja Sosial
// ======================
Route::middleware(['auth', 'role:pekerja_sosial'])
    ->prefix('pekerja-sosial')
    ->name('pekerja-sosial.')
    ->group(function () {
        Route::redirect('/dashboard', '/pekerja-sosial/riwayat-kesehatan')->name('dashboard');
        Route::get('/riwayat-kesehatan', [PekerjaSosialDashboardController::class, 'riwayatKesehatan'])->name('riwayat-kesehatan');
        Route::get('/riwayat-kegiatan', [PekerjaSosialKegiatanController::class, 'index'])->name('riwayat-kegiatan');
        Route::post('/riwayat-kegiatan', [PekerjaSosialKegiatanController::class, 'store'])->name('riwayat-kegiatan.store');
        Route::put('/riwayat-kegiatan/{kehadiran}', [PekerjaSosialKegiatanController::class, 'update'])->name('riwayat-kegiatan.update');
        Route::post('/riwayat-kegiatan/{kehadiran}/cancel', [PekerjaSosialKegiatanController::class, 'requestCancel'])->name('riwayat-kegiatan.cancel');
        Route::get('/kegiatan/{kegiatan}/kehadiran', [PekerjaSosialKegiatanController::class, 'kehadiran'])->name('kegiatan.kehadiran');
        Route::get('/lansia/{lansia}/edit', [PekerjaSosialLansiaController::class, 'edit'])->name('lansia.edit');
        Route::put('/lansia/{lansia}', [PekerjaSosialLansiaController::class, 'update'])->name('lansia.update');
        Route::patch('/lansia/{lansia}', [PekerjaSosialLansiaController::class, 'update']);
    });

require __DIR__.'/auth.php';
