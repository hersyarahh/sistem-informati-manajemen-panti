<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use Illuminate\Database\Seeder;

class DummyInventarisSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_barang' => 'Kasur Medis',
                'kategori' => 'Perawatan',
                'jenis' => 'Tempat tidur',
                'jumlah' => 6,
                'kondisi' => 'Baik',
                'sumber_dana' => 'APBD',
                'tahun_pengadaan' => 2025,
                'lokasi' => 'Gudang A',
                'keterangan' => 'Kasur standar panti',
            ],
            [
                'nama_barang' => 'Kursi Roda',
                'kategori' => 'Perawatan',
                'jenis' => 'Alat bantu',
                'jumlah' => 3,
                'kondisi' => 'Baik',
                'sumber_dana' => 'CSR',
                'tahun_pengadaan' => 2024,
                'lokasi' => 'Ruang Perawatan',
                'keterangan' => 'Digunakan harian',
            ],
            [
                'nama_barang' => 'Lemari Pakaian',
                'kategori' => 'Asrama',
                'jenis' => 'Perabot',
                'jumlah' => 10,
                'kondisi' => 'Baik',
                'sumber_dana' => 'Donatur',
                'tahun_pengadaan' => 2023,
                'lokasi' => 'Asrama Putri',
                'keterangan' => 'Lemari kayu',
            ],
            [
                'nama_barang' => 'Tensi Meter Digital',
                'kategori' => 'Perawatan',
                'jenis' => 'Alat kesehatan',
                'jumlah' => 4,
                'kondisi' => 'Baik',
                'sumber_dana' => 'APBD',
                'tahun_pengadaan' => 2025,
                'lokasi' => 'Klinik',
                'keterangan' => 'Pemeriksaan rutin',
            ],
            [
                'nama_barang' => 'Kompor Gas',
                'kategori' => 'Dapur',
                'jenis' => 'Peralatan',
                'jumlah' => 2,
                'kondisi' => 'Rusak Ringan',
                'sumber_dana' => 'Donatur',
                'tahun_pengadaan' => 2022,
                'lokasi' => 'Dapur',
                'keterangan' => 'Perlu servis ringan',
            ],
        ];

        foreach ($data as $row) {
            Inventaris::create($row);
        }
    }
}
