<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Menampilkan daftar user
        $users = User::with('biodata')
                     ->where('usertype', '!=', 'admin')
                     ->latest()
                     ->paginate(5);

        return view('admin.users.index', compact('users'));
    }

    // FUNGSI MENAMPILKAN DETAIL MAHASISWA
    public function show($id)
    {
        // 1. Ambil Data User Lengkap
        $user = User::with(['biodata', 'registrations.event'])
                    ->findOrFail($id);

        // 2. PERBAIKAN DI SINI:
        // Arahkan ke folder 'users', bukan 'events'
        // Kita akan buat file show.blade.php di folder users setelah ini.
        return view('admin.users.show', compact('user'));
    }

    // ... (kode sebelumnya)

    // FUNGSI MENGHAPUS MAHASISWA
    public function destroy($id)
    {
        // 1. Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // 2. Hapus data (Otomatis menghapus biodata & event jika relasi database sudah benar)
        $user->delete();

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.users.index')
                         ->with('success', 'Data mahasiswa berhasil dihapus');
    }
}
