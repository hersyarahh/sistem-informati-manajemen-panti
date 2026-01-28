<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Keluarga\DashboardController as KeluargaDashboardController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\Admin\LansiaController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\Admin\TerminasiLansiaController;
use App\Http\Controllers\Admin\RekapLansiaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Keluarga\LansiaInfoController;
use App\Http\Controllers\Keluarga\ChatController as KeluargaChatController;


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
        // User Management
        // ======================
        Route::resource('users', UserController::class)->except(['show']);

        // ======================
        // Chat Keluarga (Widget)
        // ======================
        Route::get('/chat', [AdminChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/{thread}', [AdminChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{thread}', [AdminChatController::class, 'store'])->name('chat.store');
        
        // ======================
        // REKAP LANSIA
        // ======================
        Route::get('/lansia/rekap', [RekapLansiaController::class, 'index'])
            ->name('lansia.rekap');

        // ======================
        // Lansia
        // ======================
        Route::resource('lansia', LansiaController::class)
            ->parameters(['lansia' => 'lansia']);

        Route::get('/lansia/{lansia}/download', [LansiaController::class, 'download'])
            ->name('lansia.download');

        Route::patch('/lansia/{lansia}/status', [LansiaController::class, 'updateStatus'])
            ->name('lansia.update-status');

        Route::get('/lansia/{lansia}/terminasi',[TerminasiLansiaController::class, 'create'])
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
        Route::get('/profil-lansia', [LansiaInfoController::class, 'profile'])->name('profile');
        Route::get('/jadwal-kegiatan', [LansiaInfoController::class, 'kegiatan'])->name('kegiatan');
        Route::get('/riwayat-kesehatan', [LansiaInfoController::class, 'riwayat'])->name('riwayat-kesehatan');
        Route::get('/pesan', [KeluargaChatController::class, 'index'])->name('chat');
        Route::get('/pesan/kontak', [KeluargaChatController::class, 'contacts'])->name('chat.contacts');
        Route::post('/pesan/assign', [KeluargaChatController::class, 'assignAdmin'])->name('chat.assign');
        Route::post('/pesan/{thread}', [KeluargaChatController::class, 'store'])->name('chat.store');
    });

require __DIR__.'/auth.php';
