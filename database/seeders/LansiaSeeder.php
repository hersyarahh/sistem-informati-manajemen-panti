<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lansia;
use App\Models\KeluargaLansia;
use App\Models\User;

class LansiaSeeder extends Seeder
{
    public function run(): void
    {
        // Lansia 1
        $lansia1 = Lansia::create([
            'nama_lengkap' => 'Haji Abdul Rahman',
            'nik' => '1471010101500001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1950-01-15',
            'alamat_asal' => 'Jl. Veteran No. 123, Pekanbaru',
            'no_kamar' => 'A-101',
            'kondisi_kesehatan' => 'sehat',
            'riwayat_penyakit' => 'Hipertensi, Diabetes',
            'alergi' => 'Seafood',
            'kontak_darurat_nama' => 'Ahmad Dahlan',
            'kontak_darurat_telp' => '081234567893',
            'kontak_darurat_hubungan' => 'Anak',
            'tanggal_masuk' => '2023-01-10',
            'status' => 'aktif',
        ]);

        // Hubungkan dengan keluarga (user_id 4 = Ahmad Dahlan)
        KeluargaLansia::create([
            'user_id' => 4,
            'lansia_id' => $lansia1->id,
            'hubungan' => 'Anak',
            'nama_lengkap' => 'Ahmad Dahlan',
            'no_telp' => '081234567893',
            'email' => 'ahmad@gmail.com',
            'alamat' => 'Jl. Keluarga No. 15',
            'status' => 'aktif',
        ]);

        // Lansia 2
        $lansia2 = Lansia::create([
            'nama_lengkap' => 'Hajjah Siti Aminah',
            'nik' => '1471010202450001',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '1945-02-20',
            'alamat_asal' => 'Jl. Sudirman No. 456, Pekanbaru',
            'no_kamar' => 'A-102',
            'kondisi_kesehatan' => 'sakit_ringan',
            'riwayat_penyakit' => 'Asam urat, Kolesterol tinggi',
            'alergi' => 'Tidak ada',
            'kontak_darurat_nama' => 'Dewi Sartika',
            'kontak_darurat_telp' => '081234567894',
            'kontak_darurat_hubungan' => 'Anak',
            'tanggal_masuk' => '2023-03-15',
            'status' => 'aktif',
        ]);

        KeluargaLansia::create([
            'user_id' => 5,
            'lansia_id' => $lansia2->id,
            'hubungan' => 'Anak',
            'nama_lengkap' => 'Dewi Sartika',
            'no_telp' => '081234567894',
            'email' => 'dewi@gmail.com',
            'alamat' => 'Jl. Harmoni No. 20',
            'status' => 'aktif',
        ]);

        // Lansia 3
        $lansia3 = Lansia::create([
            'nama_lengkap' => 'Pak Suparman',
            'nik' => '1471010303480001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1948-03-10',
            'alamat_asal' => 'Jl. Nangka No. 789, Pekanbaru',
            'no_kamar' => 'B-201',
            'kondisi_kesehatan' => 'perawatan_khusus',
            'riwayat_penyakit' => 'Stroke, Parkinson',
            'alergi' => 'Obat tertentu',
            'kontak_darurat_nama' => 'Joko Widodo',
            'kontak_darurat_telp' => '081234567895',
            'kontak_darurat_hubungan' => 'Cucu',
            'tanggal_masuk' => '2022-11-20',
            'status' => 'aktif',
        ]);

        KeluargaLansia::create([
            'user_id' => 6,
            'lansia_id' => $lansia3->id,
            'hubungan' => 'Cucu',
            'nama_lengkap' => 'Joko Widodo',
            'no_telp' => '081234567895',
            'email' => 'joko@gmail.com',
            'alamat' => 'Jl. Kasih Sayang No. 25',
            'status' => 'aktif',
        ]);

        // Lansia 4
        Lansia::create([
            'nama_lengkap' => 'Ibu Mariam',
            'nik' => '1471010404470001',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '1947-04-25',
            'alamat_asal' => 'Jl. Melati No. 321, Pekanbaru',
            'no_kamar' => 'B-202',
            'kondisi_kesehatan' => 'sehat',
            'riwayat_penyakit' => 'Tidak ada',
            'alergi' => 'Tidak ada',
            'kontak_darurat_nama' => 'Keluarga Besar',
            'kontak_darurat_telp' => '081234567800',
            'kontak_darurat_hubungan' => 'Keluarga',
            'tanggal_masuk' => '2024-01-05',
            'status' => 'aktif',
        ]);

        // Lansia 5
        Lansia::create([
            'nama_lengkap' => 'Pak Hasan',
            'nik' => '1471010505460001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1946-05-30',
            'alamat_asal' => 'Jl. Anggrek No. 654, Pekanbaru',
            'no_kamar' => 'C-301',
            'kondisi_kesehatan' => 'sakit_ringan',
            'riwayat_penyakit' => 'Asma, Arthritis',
            'alergi' => 'Debu, serbuk sari',
            'kontak_darurat_nama' => 'Keluarga',
            'kontak_darurat_telp' => '081234567801',
            'kontak_darurat_hubungan' => 'Keluarga',
            'tanggal_masuk' => '2023-06-10',
            'status' => 'aktif',
        ]);
    }
}