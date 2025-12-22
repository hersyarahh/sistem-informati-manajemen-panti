<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluarga_lansias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->string('hubungan'); // anak, cucu, menantu, dll
            $table->string('nama_lengkap');
            $table->string('no_telp');
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluarga_lansias');
    }
};