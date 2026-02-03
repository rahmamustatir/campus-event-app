<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Update: Tambahkan 'with('biodata')' agar data lengkap terangkut
        $users = User::with('biodata')
                     ->where('usertype', '!=', 'admin')
                     ->latest()
                     ->get();

        return view('admin.users.index', compact('users'));
    }
    // FUNGSI BARU: MENAMPILKAN DETAIL MAHASISWA & RIWAYAT
    public function show($id)
    {
        // Ambil Data User Lengkap (Biodata + Event)
        $user = \App\Models\User::with(['biodata', 'registrations.event'])
                    ->findOrFail($id);

        // UBAH KE ALAMAT INI (Sesuai lokasi file Anda):
        // resources/views/admin/event/show.blade.php  -->  'admin.event.show'
        return view('admin.events.show', compact('user'));
    }
}