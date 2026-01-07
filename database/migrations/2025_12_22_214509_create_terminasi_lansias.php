<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('terminasi_lansias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lansia_id')
                ->constrained('lansias')
                ->cascadeOnDelete();

            $table->date('tanggal_keluar');

            $table->enum('jenis_terminasi', [
                'meninggal',
                'dipulangkan'
            ]);

            $table->enum('lokasi_meninggal', [
                'panti',
                'keluarga'
            ])->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            // 1 lansia hanya boleh 1 terminasi
            $table->unique('lansia_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminasi_lansias');
    }
};
