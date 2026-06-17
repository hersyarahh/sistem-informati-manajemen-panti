<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Admin']
        );

        Role::firstOrCreate(
            ['name' => 'pekerja_sosial'],
            ['label' => 'Pekerja Sosial']
        );
    }
}
