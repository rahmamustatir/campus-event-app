<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin (Penyelenggara)
        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password'), // Password default: password
            'role' => 'admin',
            'nim' => null,
            'major' => null,
        ]);

        // 2. Buat Akun Mahasiswa (Contoh Peserta)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@mhs.kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'nim' => '12345678',
            'major' => 'Teknik Informatika',
            'phone' => '081234567890',
        ]);
    }
}