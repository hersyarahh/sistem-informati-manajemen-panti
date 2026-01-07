<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\TerminasiLansia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TerminasiLansiaController extends Controller
{
    public function create(Lansia $lansia)
    {
        if ($lansia->isTerminasi()) {
            abort(403, 'Lansia sudah diterminasi');
        }

        return view('admin.terminasi.create', compact('lansia'));
    }

    public function store(Request $request, Lansia $lansia)
    {
        if ($lansia->isTerminasi()) {
            abort(403, 'Lansia sudah diterminasi');
        }

        $validated = $request->validate([
            'tanggal_keluar'   => 'required|date|after_or_equal:' . $lansia->tanggal_masuk,
            'jenis_terminasi'  => 'required|in:meninggal,dipulangkan',
            'lokasi_meninggal' => 'nullable|required_if:jenis_terminasi,meninggal|in:panti,keluarga',
            'keterangan'       => 'nullable|string',
        ]);

        TerminasiLansia::create([
            'lansia_id'        => $lansia->id,
            'tanggal_keluar'   => $validated['tanggal_keluar'],
            'jenis_terminasi'  => $validated['jenis_terminasi'],
            'lokasi_meninggal' => $validated['jenis_terminasi'] === 'meninggal'
                ? $validated['lokasi_meninggal']
                : null,
            'keterangan'       => $validated['keterangan'] ?? null,
        ]);

        // Update status lansia di tabel utama
        $lansia->update([
            'status' => $validated['jenis_terminasi'] === 'meninggal' ? 'meninggal' : 'keluar',
        ]);

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Terminasi lansia berhasil disimpan');
    }
}
