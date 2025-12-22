<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nama_donatur');
            $table->string('email')->nullable();
            $table->string('no_telp')->nullable();
            $table->enum('jenis_donasi', ['uang', 'barang', 'makanan', 'lainnya']);
            $table->decimal('nominal', 12, 2)->nullable(); // untuk donasi uang
            $table->text('deskripsi_barang')->nullable(); // untuk donasi barang
            $table->date('tanggal_donasi');
            $table->enum('status', ['diterima', 'diproses', 'selesai'])->default('diterima');
            $table->text('catatan')->nullable();
            $table->string('bukti_donasi')->nullable(); // foto/dokumen
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};