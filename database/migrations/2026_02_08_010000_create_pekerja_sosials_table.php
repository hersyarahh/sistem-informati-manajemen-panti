<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pekerja_sosials', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nik', 16)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->enum('status_pegawai', ['Tetap', 'Honorer', 'Kontrak'])->nullable();
            $table->date('tanggal_mulai_bertugas')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pekerja_sosials');
    }
};
