<?php

namespace Database\Seeders;

use App\Models\Lansia;
use Illuminate\Database\Seeder;

class DummyKeluargaLansiaSeeder extends Seeder
{
    public function run(): void
    {
        $relasi = ['Anak', 'Cucu', 'Keponakan', 'Saudara', 'Tetangga'];
        $counter = 0;

        Lansia::orderBy('id')->get()->each(function (Lansia $lansia) use (&$counter, $relasi) {
            $counter++;
            $nama = 'Keluarga ' . $lansia->nama_lengkap;
            $telp = '08' . str_pad((string) (100000000 + $counter), 9, '0', STR_PAD_LEFT);
            $hubungan = $relasi[$counter % count($relasi)];
            $alamat = $lansia->alamat_asal ?? $lansia->daerah_asal ?? '-';

            $lansia->update([
                'kontak_darurat_nama' => $nama,
                'kontak_darurat_telp' => $telp,
                'kontak_darurat_hubungan' => $hubungan,
                'kontak_darurat_alamat' => $alamat,
            ]);
        });
    }
}
