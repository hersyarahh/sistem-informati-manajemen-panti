<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pekerja_sosials') && Schema::hasColumn('pekerja_sosials', 'nik')) {
            DB::statement("ALTER TABLE pekerja_sosials MODIFY nik VARCHAR(18) NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pekerja_sosials') && Schema::hasColumn('pekerja_sosials', 'nik')) {
            DB::statement("ALTER TABLE pekerja_sosials MODIFY nik VARCHAR(16) NULL");
        }
    }
};

