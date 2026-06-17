<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roleIds = Role::whereIn('name', ['admin', 'pekerja_sosial'])
            ->pluck('id', 'name');

        $adminRoleId = $roleIds->get('admin');
        $pekerjaSosialRoleId = $roleIds->get('pekerja_sosial');

        if (!$adminRoleId || !$pekerjaSosialRoleId) {
            throw new RuntimeException('Roles not found. Run RoleSeeder first.');
        }

        User::updateOrCreate(
            ['email' => 'admin@panti.com'],
            [
                'name' => 'Admin Panti',
                'password' => Hash::make('password'),
                'role_id' => $adminRoleId,
            ]
        );

        // Pekerja sosial
        User::updateOrCreate([
            'email' => 'budi@panti.com',
        ], [
            'name' => 'Dr. Budi Santoso',
            'password' => Hash::make('password'),
            'role_id' => $pekerjaSosialRoleId,
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        User::updateOrCreate([
            'email' => 'siti@panti.com',
        ], [
            'name' => 'Siti Nurhaliza',
            'password' => Hash::make('password'),
            'role_id' => $pekerjaSosialRoleId,
            'phone' => '081234567892',
            'is_active' => true,
        ]);
    }
}
