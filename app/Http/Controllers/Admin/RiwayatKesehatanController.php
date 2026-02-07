<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatKesehatanController extends Controller
{
    public function index(Request $request)
    {
        $lansias = Lansia::with(['latestRiwayatKesehatan', 'karyawans'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
            })
            ->where('status', 'aktif')
            ->when($request->filled('no_kamar'), function ($query) use ($request) {
                $query->where('no_kamar', $request->no_kamar);
            })
            ->orderBy('nama_lengkap')
            ->paginate(5)
            ->withQueryString();

        $rooms = Lansia::where('status', 'aktif')
            ->whereNotNull('no_kamar')
            ->where('no_kamar', '!=', '')
            ->distinct()
            ->orderBy('no_kamar')
            ->pluck('no_kamar')
            ->values();

        return view('admin.riwayat-kesehatan.index', compact('lansias', 'rooms'));
    }

    public function show(Lansia $lansia)
    {
        $lansia->load('latestRiwayatKesehatan');

        return view('admin.riwayat-kesehatan.show', [
            'lansia' => $lansia,
        ]);
    }

    public function rekap(Lansia $lansia)
    {
        $riwayats = $lansia->riwayatKesehatan()
            ->orderByDesc('tanggal_periksa')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.riwayat-kesehatan.rekap', [
            'lansia' => $lansia,
            'riwayats' => $riwayats,
        ]);
    }

    public function rekapAll(Request $request)
    {
        $lansiaQuery = Lansia::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
            })
            ->orderBy('nama_lengkap');

        $lansias = $lansiaQuery->paginate(5)->withQueryString();

        return view('admin.riwayat-kesehatan.rekap-all', [
            'lansias' => $lansias,
        ]);
    }

    public function download(Lansia $lansia)
    {
        $riwayats = $lansia->riwayatKesehatan()
            ->orderByDesc('tanggal_periksa')
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('admin.riwayat-kesehatan.rekap-pdf', [
            'lansia' => $lansia,
            'riwayats' => $riwayats,
        ])->setPaper('A4', 'portrait');

        $filename = 'rekap-kesehatan-' . str_replace(' ', '-', strtolower($lansia->nama_lengkap)) . '.pdf';

        return $pdf->download($filename);
    }
}
