<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->date('tanggal_periksa');
            $table->string('jenis_pemeriksaan'); // rutin, darurat, konsultasi
            $table->text('keluhan')->nullable();
            $table->text('diagnosa')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('resep_obat')->nullable();
            $table->string('nama_dokter')->nullable();
            $table->string('nama_petugas')->nullable();
            $table->text('catatan')->nullable();
            $table->string('file_hasil')->nullable(); // untuk upload hasil lab, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_kesehatans');
    }
};