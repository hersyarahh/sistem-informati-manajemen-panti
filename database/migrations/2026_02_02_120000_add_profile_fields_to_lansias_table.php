<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lansias', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('nik');
            $table->string('agama', 100)->nullable()->after('tanggal_lahir');
            $table->string('nomor_kk', 32)->nullable()->after('agama');
            $table->string('pendidikan_terakhir', 100)->nullable()->after('nomor_kk');
            $table->string('daerah_asal', 150)->nullable()->after('alamat_asal');
        });
    }

    public function down(): void
    {
        Schema::table('lansias', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'agama',
                'nomor_kk',
                'pendidikan_terakhir',
                'daerah_asal',
            ]);
        });
    }
};
