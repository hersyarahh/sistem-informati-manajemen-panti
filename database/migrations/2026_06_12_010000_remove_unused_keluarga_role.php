<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            return;
        }

        $roleId = DB::table('roles')->where('name', 'keluarga')->value('id');

        if (!$roleId) {
            return;
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role_id')) {
            $updates = ['role_id' => null];

            if (Schema::hasColumn('users', 'is_active')) {
                $updates['is_active'] = false;
            }

            DB::table('users')
                ->where('role_id', $roleId)
                ->update($updates);
        }

        DB::table('roles')->where('id', $roleId)->delete();
    }

    public function down(): void
    {
        if (!Schema::hasTable('roles')) {
            return;
        }

        DB::table('roles')->updateOrInsert(
            ['name' => 'keluarga'],
            [
                'label' => 'Keluarga',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
};
