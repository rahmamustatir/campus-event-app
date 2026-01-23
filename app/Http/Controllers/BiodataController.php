<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    // 1. Tampilkan Halaman Form
    public function index()
    {
        $user = Auth::user();
        return view('biodata', compact('user'));
    }

    // 2. Proses Simpan Data
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'nullable|string|max:20',
            'jurusan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
        ]);

        // Simpan ke database
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
        ]);

        return back()->with('success', 'Biodata berhasil diperbarui! ✨');
    }
}