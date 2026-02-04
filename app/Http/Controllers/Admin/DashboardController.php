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
        $endYear = (int) now()->year;
        $startYear = $endYear - 4;
        $lansiaPerTahun = Lansia::selectRaw('YEAR(tanggal_masuk) as tahun, COUNT(*) as total')
            ->whereNotNull('tanggal_masuk')
            ->whereBetween('tanggal_masuk', [$startYear . '-01-01', $endYear . '-12-31'])
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();
        $labels = $lansiaPerTahun->pluck('tahun')->map(fn ($y) => (string) $y)->values()->all();
        $counts = $lansiaPerTahun->pluck('total')->map(fn ($v) => (int) $v)->values()->all();

        return view('admin.dashboard', [
            'totalLansia' => Lansia::where('status', 'aktif')->count(),
            'totalKaryawan' => User::whereHas('role', function ($query) {
                $query->where('name', 'karyawan');
            })->count(),
            'kegiatanHariIni' => Kegiatan::whereDate('tanggal', today())->count(),
            'lansiaYearLabels' => $labels,
            'lansiaYearCounts' => $counts,
        ]);
    }
}
