<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->nullable()
                ->after('email')
                ->constrained('roles')
                ->nullOnDelete();
        });

        $now = now();
        $roles = [
            ['name' => 'admin', 'label' => 'Admin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'pekerja_sosial', 'label' => 'Pekerja Sosial', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(['name' => $role['name']], $role);
        }

        $roleIds = DB::table('roles')->pluck('id', 'name');

        if (Schema::hasColumn('users', 'role')) {
            foreach ($roleIds as $name => $id) {
                DB::table('users')->where('role', $name)->update(['role_id' => $id]);
            }

            if (isset($roleIds['pekerja_sosial'])) {
                DB::table('users')
                    ->whereNull('role_id')
                    ->update(['role_id' => $roleIds['pekerja_sosial']]);
            }

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pekerja_sosial'])
                ->default('pekerja_sosial')
                ->after('email');
        });

        $roles = DB::table('roles')->pluck('name', 'id');

        foreach ($roles as $id => $name) {
            DB::table('users')
                ->where('role_id', $id)
                ->update(['role' => $name]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
