<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Admin\LansiaController as AdminLansiaController;
use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\RiwayatKesehatan;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    public function edit(Lansia $lansia)
    {
        $lansia->load('latestRiwayatKesehatan');

        return view('karyawan.lansia-kesehatan-edit', [
            'lansia' => $lansia,
        ]);
    }

    public function update(Request $request, Lansia $lansia)
    {
        $data = $request->validate([
            'no_kamar' => 'nullable|string|max:50',
            'kondisi_kesehatan' => 'nullable|in:sehat,sakit_ringan,sakit_berat,perawatan_khusus',
            'riwayat_penyakit' => 'nullable|string',
            'alergi' => 'nullable|string',
            'riwayat_tanggal_periksa' => 'nullable|date',
            'riwayat_jenis_pemeriksaan' => 'nullable|string|max:255',
            'riwayat_keluhan' => 'nullable|string',
            'riwayat_diagnosa' => 'nullable|string',
            'riwayat_tindakan' => 'nullable|string',
            'riwayat_resep_obat' => 'nullable|string',
            'riwayat_nama_petugas' => 'nullable|string|max:255',
            'riwayat_catatan' => 'nullable|string',
            'riwayat_file_hasil' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $lansia->update([
            'no_kamar' => $data['no_kamar'] ?? $lansia->no_kamar,
            'kondisi_kesehatan' => $data['kondisi_kesehatan'] ?? $lansia->kondisi_kesehatan,
            'riwayat_penyakit' => $data['riwayat_penyakit'] ?? $lansia->riwayat_penyakit,
            'alergi' => $data['alergi'] ?? $lansia->alergi,
        ]);

        $riwayatFilled = !empty($data['riwayat_tanggal_periksa'])
            || !empty($data['riwayat_jenis_pemeriksaan'])
            || !empty($data['riwayat_nama_petugas'])
            || !empty($data['riwayat_keluhan'])
            || !empty($data['riwayat_diagnosa'])
            || !empty($data['riwayat_tindakan'])
            || !empty($data['riwayat_resep_obat'])
            || !empty($data['riwayat_catatan'])
            || $request->hasFile('riwayat_file_hasil');

        if ($riwayatFilled) {
            $riwayatData = [
                'lansia_id' => $lansia->id,
                'tanggal_periksa' => $data['riwayat_tanggal_periksa'] ?? null,
                'jenis_pemeriksaan' => $data['riwayat_jenis_pemeriksaan'] ?? null,
                'keluhan' => $data['riwayat_keluhan'] ?? null,
                'diagnosa' => $data['riwayat_diagnosa'] ?? null,
                'tindakan' => $data['riwayat_tindakan'] ?? null,
                'resep_obat' => $data['riwayat_resep_obat'] ?? null,
                'nama_petugas' => $data['riwayat_nama_petugas'] ?? null,
                'catatan' => $data['riwayat_catatan'] ?? null,
            ];

            if ($request->hasFile('riwayat_file_hasil')) {
                $riwayatData['file_hasil'] = $request
                    ->file('riwayat_file_hasil')
                    ->store('dokumen/riwayat-kesehatan', 'public');
            }

            RiwayatKesehatan::create($riwayatData);
        }

        return redirect()
            ->route('karyawan.riwayat-kesehatan')
            ->with('success', 'Data kesehatan berhasil diperbarui.');
    }
}
