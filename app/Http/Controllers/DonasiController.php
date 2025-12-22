<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    public function index()
    {
        // Ambil 10 donasi terbaru untuk ditampilkan
        $donasi_terbaru = Donasi::where('status', 'diterima')
            ->orderBy('tanggal_donasi', 'desc')
            ->take(10)
            ->get();

        // Hitung total donasi bulan ini
        $total_donasi_bulan_ini = Donasi::where('status', 'diterima')
            ->whereMonth('tanggal_donasi', now()->month)
            ->whereYear('tanggal_donasi', now()->year)
            ->sum('nominal');

        // Hitung total donatur
        $total_donatur = Donasi::where('status', 'diterima')->count();

        return view('public.donasi', compact('donasi_terbaru', 'total_donasi_bulan_ini', 'total_donatur'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string|max:20',
            'jenis_donasi' => 'required|in:uang,barang,makanan,lainnya',
            'nominal' => 'required_if:jenis_donasi,uang|nullable|numeric|min:0',
            'deskripsi_barang' => 'required_unless:jenis_donasi,uang|nullable|string',
            'bukti_donasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // Upload bukti donasi jika ada
        if ($request->hasFile('bukti_donasi')) {
            $path = $request->file('bukti_donasi')->store('donasi', 'public');
            $validated['bukti_donasi'] = $path;
        }

        // Set tanggal donasi dan status
        $validated['tanggal_donasi'] = now();
        $validated['status'] = 'diproses'; // Admin akan approve nanti

        // Simpan donasi
        Donasi::create($validated);

        return redirect()->route('donasi.index')
            ->with('success', 'Terima kasih! Donasi Anda sedang diproses oleh admin.');
    }
}