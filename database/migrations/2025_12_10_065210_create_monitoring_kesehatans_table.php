<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->dateTime('tanggal_waktu');
            $table->decimal('tekanan_darah_sistolik', 5, 2)->nullable(); // 120
            $table->decimal('tekanan_darah_diastolik', 5, 2)->nullable(); // 80
            $table->decimal('berat_badan', 5, 2)->nullable(); // kg
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
            $table->decimal('suhu_tubuh', 4, 2)->nullable(); // celcius
            $table->integer('denyut_nadi')->nullable(); // bpm
            $table->integer('saturasi_oksigen')->nullable(); // %
            $table->decimal('gula_darah', 5, 2)->nullable(); // mg/dL
            $table->text('catatan')->nullable();
            $table->string('petugas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_kesehatans');
    }
};