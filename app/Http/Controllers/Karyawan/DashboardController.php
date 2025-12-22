<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\Kegiatan;
use App\Models\JadwalObat;
use App\Models\MonitoringKesehatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_lansia' => Lansia::where('status', 'aktif')->count(),
            'kegiatan_hari_ini' => Kegiatan::whereDate('tanggal', today())->count(),
            'jadwal_obat_aktif' => JadwalObat::where('status', 'aktif')
                ->whereDate('tanggal_mulai', '<=', today())
                ->where(function($query) {
                    $query->whereNull('tanggal_selesai')
                        ->orWhereDate('tanggal_selesai', '>=', today());
                })
                ->count(),
            'monitoring_hari_ini' => MonitoringKesehatan::whereDate('tanggal_waktu', today())->count(),
            'lansia_perlu_perhatian' => Lansia::whereIn('kondisi_kesehatan', ['sakit_berat', 'perawatan_khusus'])->get(),
            'kegiatan_hari_ini_list' => Kegiatan::with('kehadirans.lansia')
                ->whereDate('tanggal', today())
                ->orderBy('waktu_mulai')
                ->get(),
            'jadwal_obat_hari_ini' => JadwalObat::with('lansia')
                ->where('status', 'aktif')
                ->whereDate('tanggal_mulai', '<=', today())
                ->where(function($query) {
                    $query->whereNull('tanggal_selesai')
                        ->orWhereDate('tanggal_selesai', '>=', today());
                })
                ->get(),
        ];

        return view('karyawan.dashboard', $data);
    }
}