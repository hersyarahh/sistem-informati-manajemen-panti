<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@panti.com'],
            [
                'name' => 'Admin Panti',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Karyawan
        User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi@panti.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'phone' => '081234567891',
            'address' => 'Jl. Kesehatan No. 5',
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@panti.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'phone' => '081234567892',
            'address' => 'Jl. Perawat No. 10',
        ]);

        // Keluarga
        User::create([
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'keluarga',
            'phone' => '081234567893',
            'address' => 'Jl. Keluarga No. 15',
        ]);

        User::create([
            'name' => 'Dewi Sartika',
            'email' => 'dewi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'keluarga',
            'phone' => '081234567894',
            'address' => 'Jl. Harmoni No. 20',
        ]);

        User::create([
            'name' => 'Joko Widodo',
            'email' => 'joko@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'keluarga',
            'phone' => '081234567895',
            'address' => 'Jl. Kasih Sayang No. 25',
        ]);
    }
}