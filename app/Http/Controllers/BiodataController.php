<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biodata; // Pastikan Model Biodata dipanggil

class BiodataController extends Controller
{
    // 1. MENAMPILKAN FORMULIR (INDEX)
    public function index()
    {
        $user = Auth::user();
        
        // Cek apakah user sudah punya biodata di database?
        // Kita cari berdasarkan user_id
        $biodata = null;
        if (class_exists(Biodata::class)) {
            $biodata = Biodata::where('user_id', $user->id)->first();
        }

        return view('biodata', compact('biodata'));
    }

    // 2. MENYIMPAN DATA (STORE) - Bagian yang tadi Error
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nim'      => 'required|string|max:20',
            'prodi'    => 'required|string|max:100',
            'fakultas' => 'nullable|string|max:100',
            'phone'    => 'required|string|max:20',
            'address'  => 'nullable|string',
        ]);

        // Simpan atau Update (Pakai updateOrCreate biar praktis)
        // Artinya: Cari data punya user ini. Kalau ada update, kalau belum ada buat baru.
        Biodata::updateOrCreate(
            ['user_id' => Auth::id()], // Kunci pencarian
            [
                'nim'      => $request->nim,
                'prodi'    => $request->prodi,
                'fakultas' => $request->fakultas,
                'phone'    => $request->phone,
                'address'  => $request->address,
            ]
        );

        return redirect()->route('biodata')
            ->with('success', 'Alhamdulillah! Biodata berhasil disimpan.');
    }

    // 3. UPDATE (Cadangan jika route pakai PUT)
    public function update(Request $request)
    {
        return $this->store($request);
    }
}
