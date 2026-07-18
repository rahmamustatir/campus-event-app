<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category; // Ini yang tadi kurang

class DashboardSuperAdminController extends Controller 
{
   public function index() 
{
    $users = \App\Models\User::all();

    foreach ($users as $user) {
        // Kita ubah logikanya: Jika user adalah 'admin', kita tampilkan teks statis 
        // atau hitung berdasarkan apa yang ada di tabel.
        // Jika tabel 'events' tidak punya 'user_id', kita ganti jadi hitung total event saja.
        
        if ($user->role === 'admin') {
            $count = \App\Models\Event::count(); // Hitung total event saja, aman dari error kolom
            $user->details = $count . ' Total Event Terdaftar';
        } elseif ($user->role === 'mahasiswa') {
            // Jika tabel 'registrations' tidak punya 'user_id', ganti ke '-'
            // Anda bisa mencoba cek nama kolom di tabel 'registrations' Anda
            $user->details = '-'; 
        } else {
            $user->details = '-';
        }
    }

    return view('dashboards.superadmin', [
        'users' => $users
    ]);
}
}