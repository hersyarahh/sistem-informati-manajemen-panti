<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan_lansia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'lansia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan_lansia');
    }
};
