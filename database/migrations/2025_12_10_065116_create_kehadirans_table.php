<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('kehadirans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kegiatan_id')->constrained()->cascadeOnDelete();
        $table->foreignId('lansia_id')->constrained()->cascadeOnDelete();
        $table->boolean('hadir')->default(false);
        $table->timestamps();

        $table->unique(['kegiatan_id', 'lansia_id']);
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};