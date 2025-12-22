<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // keluarga yang berkunjung
            $table->string('nama_pengunjung');
            $table->string('hubungan');
            $table->date('tanggal_kunjungan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai')->nullable();
            $table->text('keperluan')->nullable();
            $table->enum('status', ['dijadwalkan', 'sedang_berlangsung', 'selesai', 'dibatalkan'])->default('dijadwalkan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};