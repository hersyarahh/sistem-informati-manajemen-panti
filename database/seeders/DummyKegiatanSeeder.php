<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DummyKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $start = Carbon::today();

        $templates = [
            [
                'nama_kegiatan' => 'Senam Pagi Lansia',
                'jenis_kegiatan' => 'Olahraga',
                'waktu_mulai' => '07:30',
                'waktu_selesai' => '08:30',
                'lokasi' => 'Aula Panti',
                'deskripsi' => 'Instruktur senam',
            ],
            [
                'nama_kegiatan' => 'Pemeriksaan Kesehatan',
                'jenis_kegiatan' => 'Kesehatan',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '10:30',
                'lokasi' => 'Klinik',
                'deskripsi' => 'Narasumber petugas kesehatan',
            ],
            [
                'nama_kegiatan' => 'Pengajian Rutin',
                'jenis_kegiatan' => 'Keagamaan',
                'waktu_mulai' => '10:45',
                'waktu_selesai' => '11:45',
                'lokasi' => 'Mushola',
                'deskripsi' => 'Ustadz pembina',
            ],
            [
                'nama_kegiatan' => 'Kegiatan Sosial',
                'jenis_kegiatan' => 'Sosial',
                'waktu_mulai' => '14:00',
                'waktu_selesai' => '15:30',
                'lokasi' => 'Taman Panti',
                'deskripsi' => 'Pendamping kegiatan',
            ],
            [
                'nama_kegiatan' => 'Hiburan Musik',
                'jenis_kegiatan' => 'Hiburan',
                'waktu_mulai' => '16:00',
                'waktu_selesai' => '17:00',
                'lokasi' => 'Aula Panti',
                'deskripsi' => 'Instruktur musik',
            ],
        ];

        foreach ($templates as $index => $row) {
            Kegiatan::create(array_merge($row, [
                'tanggal' => $start->copy()->addDays($index)->format('Y-m-d'),
            ]));
        }
    }
}
