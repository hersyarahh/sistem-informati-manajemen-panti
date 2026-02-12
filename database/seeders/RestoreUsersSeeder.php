<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RestoreUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::updateOrCreate(
            ['name' => 'admin'],
            ['label' => 'Admin']
        );

        $staffRole = Role::updateOrCreate(
            ['name' => 'karyawan'],
            ['label' => 'Pekerja Sosial']
        );

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@panti.com',
                'password' => 'password',
                'role_id' => $adminRole->id,
            ],
            [
                'name' => 'Habib',
                'email' => 'habib@gmail.com',
                'password' => '33333333',
                'role_id' => $staffRole->id,
            ],
            [
                'name' => 'Kacee',
                'email' => 'kaceehyunji@gmail.com',
                'password' => '11111111',
                'role_id' => $staffRole->id,
            ],
            [
                'name' => 'Yuniati',
                'email' => 'yuniati@gmail.com',
                'password' => '22222222',
                'role_id' => $staffRole->id,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role_id' => $data['role_id'],
                    'is_active' => true,
                ]
            );
        }
    }
}
