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
        $roleIds = Role::whereIn('name', ['admin', 'karyawan', 'keluarga'])
            ->pluck('id', 'name');

        $adminRoleId = $roleIds->get('admin');
        $karyawanRoleId = $roleIds->get('karyawan');
        $keluargaRoleId = $roleIds->get('keluarga');

        if (!$adminRoleId || !$karyawanRoleId || !$keluargaRoleId) {
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

        // Karyawan
        User::updateOrCreate([
            'email' => 'budi@panti.com',
        ], [
            'name' => 'Dr. Budi Santoso',
            'password' => Hash::make('password'),
            'role_id' => $karyawanRoleId,
            'phone' => '081234567891',
            'address' => 'Jl. Kesehatan No. 5',
        ]);

        User::updateOrCreate([
            'email' => 'siti@panti.com',
        ], [
            'name' => 'Siti Nurhaliza',
            'password' => Hash::make('password'),
            'role_id' => $karyawanRoleId,
            'phone' => '081234567892',
            'address' => 'Jl. Perawat No. 10',
        ]);

        // Keluarga
        User::updateOrCreate([
            'email' => 'ahmad@gmail.com',
        ], [
            'name' => 'Ahmad Dahlan',
            'password' => Hash::make('password'),
            'role_id' => $keluargaRoleId,
            'phone' => '081234567893',
            'address' => 'Jl. Keluarga No. 15',
        ]);

        User::updateOrCreate([
            'email' => 'dewi@gmail.com',
        ], [
            'name' => 'Dewi Sartika',
            'password' => Hash::make('password'),
            'role_id' => $keluargaRoleId,
            'phone' => '081234567894',
            'address' => 'Jl. Harmoni No. 20',
        ]);

        User::updateOrCreate([
            'email' => 'joko@gmail.com',
        ], [
            'name' => 'Joko Widodo',
            'password' => Hash::make('password'),
            'role_id' => $keluargaRoleId,
            'phone' => '081234567895',
            'address' => 'Jl. Kasih Sayang No. 25',
        ]);
    }
}
