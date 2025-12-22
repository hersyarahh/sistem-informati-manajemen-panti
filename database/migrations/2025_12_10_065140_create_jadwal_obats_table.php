<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->string('nama_obat');
            $table->string('dosis');
            $table->string('frekuensi'); // 3x sehari, 2x sehari, dll
            $table->text('waktu_minum'); // pagi, siang, malam (JSON format)
            $table->enum('waktu_konsumsi', ['sebelum_makan', 'sesudah_makan', 'saat_makan', 'tidak_tergantung']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dihentikan'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_obats');
    }
};