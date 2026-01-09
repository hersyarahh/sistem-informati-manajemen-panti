<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\KeluargaLansia;
use App\Models\Kegiatan;
use App\Models\Kunjungan;
use App\Models\RiwayatKesehatan;
use App\Models\JadwalObat;
use App\Models\Kehadiran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data keluarga lansia berdasarkan user yang login
        $keluargaLansia = KeluargaLansia::where('user_id', auth()->id())
            ->with('lansia')
            ->first();

        if (!$keluargaLansia) {
            return view('keluarga.dashboard', [
                'message' => 'Anda belum terdaftar sebagai keluarga dari lansia manapun. Silakan hubungi admin.',
                'lansia' => null,
            ]);
        }

        $lansia = $keluargaLansia->lansia;

        $kegiatanQuery = Kegiatan::whereDate('tanggal', today())
            ->orderBy('waktu_mulai');

        if (Kehadiran::where('lansia_id', $lansia->id)->exists()) {
            $kegiatanQuery->whereHas('kehadirans', function ($query) use ($lansia) {
                $query->where('lansia_id', $lansia->id);
            });
        }

        $data = [
            'lansia' => $lansia,
            'keluarga_lansia' => $keluargaLansia,
            'kegiatan_hari_ini' => $kegiatanQuery->get(),
            'kunjungan_mendatang' => Kunjungan::where('lansia_id', $lansia->id)
                ->where('user_id', auth()->id())
                ->where('tanggal_kunjungan', '>=', today())
                ->orderBy('tanggal_kunjungan')
                ->get(),
            'riwayat_kesehatan' => RiwayatKesehatan::where('lansia_id', $lansia->id)
                ->orderBy('tanggal_periksa', 'desc')
                ->take(5)
                ->get(),
            'jadwal_obat_aktif' => JadwalObat::where('lansia_id', $lansia->id)
                ->where('status', 'aktif')
                ->whereDate('tanggal_mulai', '<=', today())
                ->where(function($query) {
                    $query->whereNull('tanggal_selesai')
                        ->orWhereDate('tanggal_selesai', '>=', today());
                })
                ->get(),
        ];

        return view('keluarga.dashboard', $data);
    }
}
