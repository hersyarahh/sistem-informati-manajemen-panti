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
        Schema::table('lansias', function (Blueprint $table) {
            // STATUS SOSIAL
            $table->string('status_sosial')->nullable()->after('status');
            // contoh: miskin / terlantar / ditelantarkan

            // DOKUMEN ADMINISTRASI TAMBAHAN
            $table->string('dokumen_surat_pernyataan_tinggal')->nullable()->after('status_sosial');
            $table->string('dokumen_surat_terminasi')->nullable()->after('dokumen_surat_pernyataan_tinggal');
            $table->string('dokumen_berita_acara')->nullable()->after('dokumen_surat_terminasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lansias', function (Blueprint $table) {
            $table->dropColumn([
                'status_sosial',
                'dokumen_surat_pernyataan_tinggal',
                'dokumen_surat_terminasi',
                'dokumen_berita_acara',
            ]);
        });
    }
};
