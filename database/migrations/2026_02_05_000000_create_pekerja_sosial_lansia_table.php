<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pekerja_sosial_lansia')) {
            return;
        }

        if (Schema::hasTable('karyawan_lansia')) {
            Schema::rename('karyawan_lansia', 'pekerja_sosial_lansia');

            return;
        }

        $lansiaTable = Schema::hasTable('lansia') ? 'lansia' : 'lansias';

        Schema::create('pekerja_sosial_lansia', function (Blueprint $table) use ($lansiaTable) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lansia_id')->constrained($lansiaTable)->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'lansia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pekerja_sosial_lansia');
    }
};
