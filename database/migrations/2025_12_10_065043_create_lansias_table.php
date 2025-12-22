<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lansias', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nik')->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->text('alamat_asal');
            $table->string('foto')->nullable();
            $table->string('no_kamar')->nullable();
            $table->enum('kondisi_kesehatan', ['sehat', 'sakit_ringan', 'sakit_berat', 'perawatan_khusus'])->default('sehat');
            $table->text('riwayat_penyakit')->nullable();
            $table->text('alergi')->nullable();
            $table->string('kontak_darurat_nama')->nullable();
            $table->string('kontak_darurat_telp')->nullable();
            $table->string('kontak_darurat_hubungan')->nullable();
            $table->date('tanggal_masuk');
            $table->enum('status', ['aktif', 'keluar', 'meninggal'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lansias');
    }
};