<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Lansia;

class DashboardController extends Controller
{
    public function index()
    {
        $kondisiCounts = Lansia::selectRaw('kondisi_kesehatan, COUNT(*) as total')
            ->whereNotNull('kondisi_kesehatan')
            ->groupBy('kondisi_kesehatan')
            ->pluck('total', 'kondisi_kesehatan')
            ->toArray();

        $labels = [
            'sehat' => 'Sehat',
            'sakit_ringan' => 'Sakit Ringan',
            'sakit_berat' => 'Sakit Berat',
            'perawatan_khusus' => 'Perawatan Khusus',
        ];

        $chartLabels = [];
        $chartData = [];

        foreach ($labels as $key => $label) {
            $chartLabels[] = $label;
            $chartData[] = (int) ($kondisiCounts[$key] ?? 0);
        }

        return view('karyawan.dashboard', [
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }

    public function riwayatKesehatan()
    {
        $lansias = Lansia::with('latestRiwayatKesehatan')
            ->whereHas('karyawans', function ($query) {
                $query->where('users.id', auth()->id());
            })
            ->when(request()->filled('search'), function ($query) {
                $query->where('nama_lengkap', 'like', '%' . request('search') . '%');
            })
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->paginate(6)
            ->withQueryString();

        return view('karyawan.riwayat-kesehatan', compact('lansias'));
    }

    public function riwayatKegiatan()
    {
        return view('karyawan.riwayat-kegiatan');
    }
}
