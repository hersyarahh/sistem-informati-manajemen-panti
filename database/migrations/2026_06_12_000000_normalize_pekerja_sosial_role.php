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

        $legacyRole = DB::table('roles')->where('name', 'karyawan')->first();
        $pekerjaSosialRole = DB::table('roles')->where('name', 'pekerja_sosial')->first();

        if ($legacyRole && $pekerjaSosialRole) {
            if (Schema::hasColumn('users', 'role_id')) {
                DB::table('users')
                    ->where('role_id', $legacyRole->id)
                    ->update(['role_id' => $pekerjaSosialRole->id]);
            }

            DB::table('roles')->where('id', $legacyRole->id)->delete();
        } elseif ($legacyRole) {
            DB::table('roles')
                ->where('id', $legacyRole->id)
                ->update([
                    'name' => 'pekerja_sosial',
                    'label' => 'Pekerja Sosial',
                    'updated_at' => now(),
                ]);
        } elseif (!$pekerjaSosialRole) {
            DB::table('roles')->insert([
                'name' => 'pekerja_sosial',
                'label' => 'Pekerja Sosial',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('roles')
            ->where('name', 'pekerja_sosial')
            ->update(['label' => 'Pekerja Sosial', 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('roles')
            ->where('name', 'pekerja_sosial')
            ->update([
                'name' => 'karyawan',
                'label' => 'Karyawan',
                'updated_at' => now(),
            ]);
    }
};
