<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    // 1. Tampilkan Halaman Input OTP
    public function show()
    {
        return view('auth.verify-otp');
    }

    // 2. Proses Cek Kode OTP
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = Auth::user();

        // Cek 1: Apakah kode sama?
        if ($request->otp == $user->otp_code) {
            
            // Cek 2: Apakah kode kadaluarsa? (Opsional, nanti saja biar mudah)
            
            // Jika Benar:
            $user->is_verified = true;
            $user->otp_code = null; // Hapus kode biar gak dipake lagi
            $user->save();

            // Redirect ke Dashboard (Selesai!)
            return redirect('/')->with('status', 'Akun berhasil diverifikasi!');
        }

        // Jika Salah:
        return back()->withErrors(['otp' => 'Kode OTP salah! Coba cek WA lagi.']);
    }
}