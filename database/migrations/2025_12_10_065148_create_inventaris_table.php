<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->enum('kategori', ['tempat_tidur', 'kursi_roda', 'alat_bantu_jalan', 'obat', 'peralatan_medis', 'furniture', 'elektronik', 'lainnya']);
            $table->integer('jumlah')->default(1);
            $table->string('satuan')->default('unit'); // unit, box, botol, dll
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'perlu_perbaikan'])->default('baik');
            $table->text('lokasi')->nullable();
            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('harga_satuan', 12, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};