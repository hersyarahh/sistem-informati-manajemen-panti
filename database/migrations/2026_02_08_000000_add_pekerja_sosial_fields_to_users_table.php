<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable()->after('address');
            $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tempat_lahir');
            $table->string('foto')->nullable()->after('jenis_kelamin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'foto']);
        });
    }
};
