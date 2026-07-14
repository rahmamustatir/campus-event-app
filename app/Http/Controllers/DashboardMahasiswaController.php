<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        // Menampilkan dashboard utama mahasiswa
        return view('dashboards.mahasiswa', ['user' => auth()->user()]);
    }

    public function explore()
    {
        // Hanya menampilkan event yang sudah disetujui (status 'approved')
        $events = Event::where('status', 'approved')->get();
        return view('mahasiswa.explore', compact('events'));
    }

    public function daftarEvent(Request $request, $id)
    {
        // 1. Cek apakah sudah pernah daftar
        $isRegistered = Registration::where('user_id', Auth::id())
                                    ->where('event_id', $id)
                                    ->exists();

        if ($isRegistered) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di event ini!');
        }

        // 2. Simpan pendaftaran
        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $id,
            'status_presence' => 'absent',
            'registration_code' => 'REG-' . strtoupper(bin2hex(random_bytes(3)))
        ]);

        return redirect()->route('history')->with('success', 'Berhasil mendaftar event!');
    }
}