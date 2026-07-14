<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin Kampus',
                'email' => 'superadmin@unu.ac.id',
                'password' => Hash::make('password123'),
                'whatsapp_number' => '08111111111',
                'role' => 'super_admin',
                'is_verified' => true,
            ],
            [
                'name' => 'Biro Akademik UNU',
                'email' => 'biro@unu.ac.id',
                'password' => Hash::make('password123'),
                'whatsapp_number' => '08222222222',
                'role' => 'biro_akademik',
                'is_verified' => true,
            ],
            [
                'name' => 'Kaprodi Informatika',
                'email' => 'prodi@unu.ac.id',
                'password' => Hash::make('password123'),
                'whatsapp_number' => '08333333333',
                'role' => 'prodi',
                'is_verified' => true,
            ],
            [
                'name' => 'Admin HIMA',
                'email' => 'admin@unu.ac.id',
                'password' => Hash::make('password123'),
                'whatsapp_number' => '08444444444',
                'role' => 'admin',
                'is_verified' => true,
            ],
            [
                'name' => 'Rahma Yunita',
                'email' => 'rahma@mahasiswa.unu.ac.id',
                'password' => Hash::make('password123'),
                'whatsapp_number' => '08555555555',
                'role' => 'mahasiswa',
                'is_verified' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}