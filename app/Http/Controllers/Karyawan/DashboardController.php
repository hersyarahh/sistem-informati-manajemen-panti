<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Lansia;

class DashboardController extends Controller
{
    public function riwayatKesehatan()
    {
        $lansias = Lansia::with(['riwayatKesehatan' => function ($query) {
                $query->where('created_by', auth()->id())
                    ->orderBy('tanggal_periksa', 'desc');
            }])
            ->whereHas('karyawans', function ($query) {
                $query->where('users.id', auth()->id());
            })
            ->when(request()->filled('search'), function ($query) {
                $query->where('nama_lengkap', 'like', '%' . request('search') . '%');
            })
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->paginate(5)
            ->withQueryString();

        return view('pekerjasosial.riwayat-kesehatan', compact('lansias'));
    }

    public function riwayatKegiatan()
    {
        return view('pekerjasosial.riwayat-kegiatan');
    }
}
