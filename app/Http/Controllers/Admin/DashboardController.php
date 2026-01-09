<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\User;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalLansia' => Lansia::where('status', 'aktif')->count(),
            'totalKaryawan' => User::whereHas('role', function ($query) {
                $query->where('name', 'karyawan');
            })->count(),
            'kegiatanHariIni' => Kegiatan::whereDate('tanggal', today())->count(),
            'totalKeluarga' => User::whereHas('role', function ($query) {
                $query->where('name', 'keluarga');
            })->count(),
        ]);
    }
}
