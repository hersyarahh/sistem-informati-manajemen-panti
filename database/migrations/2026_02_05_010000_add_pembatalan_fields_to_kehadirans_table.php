<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->timestamp('pembatalan_diajukan_at')->nullable()->after('catatan');
            $table->text('pembatalan_alasan')->nullable()->after('pembatalan_diajukan_at');
        });
    }

    public function down(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->dropColumn(['pembatalan_diajukan_at', 'pembatalan_alasan']);
        });
    }
};
