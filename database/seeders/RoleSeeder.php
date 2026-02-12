<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Pakai firstOrCreate: Cek dulu, kalau belum ada baru buat.
        // Kalau sudah ada, dia akan skip (tidak error).
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'mahasiswa']);
    }
}