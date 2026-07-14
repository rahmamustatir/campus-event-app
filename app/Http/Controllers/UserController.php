<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Pastikan model User sudah di-import di bagian atas file
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        return view('admin.users.index', compact('mahasiswa'));
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
    public function store(Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Hash::make($request->password), // Password di-enkripsi
        'role' => 'prodi',
    ]);

    return redirect()->back()->with('success', 'Akun Prodi berhasil dibuat!');
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
