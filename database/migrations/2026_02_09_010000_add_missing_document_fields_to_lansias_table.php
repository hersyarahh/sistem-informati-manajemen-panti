<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lansias', function (Blueprint $table) {
            if (!Schema::hasColumn('lansias', 'dokumen_ktp')) {
                $table->string('dokumen_ktp')->nullable();
            }
            if (!Schema::hasColumn('lansias', 'dokumen_kk')) {
                $table->string('dokumen_kk')->nullable();
            }
            if (!Schema::hasColumn('lansias', 'dokumen_bpjs')) {
                $table->string('dokumen_bpjs')->nullable();
            }
            if (!Schema::hasColumn('lansias', 'dokumen_surat_terlantar')) {
                $table->string('dokumen_surat_terlantar')->nullable();
            }
            if (!Schema::hasColumn('lansias', 'dokumen_surat_sehat')) {
                $table->string('dokumen_surat_sehat')->nullable();
            }
            if (!Schema::hasColumn('lansias', 'dokumen_surat_pengantar')) {
                $table->string('dokumen_surat_pengantar')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('lansias', function (Blueprint $table) {
            $table->dropColumn([
                'dokumen_ktp',
                'dokumen_kk',
                'dokumen_bpjs',
                'dokumen_surat_terlantar',
                'dokumen_surat_sehat',
                'dokumen_surat_pengantar',
            ]);
        });
    }
};
