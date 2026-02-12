<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Untuk kirim ke Bot WA
use Carbon\Carbon; // Untuk urusan waktu

class OtpController extends Controller
{
    // 1. Tampilkan Halaman
    public function create()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // [PENTING] Ambil data user paling baru dari database
        $user = Auth::user()->fresh(); 
        
        $timeLeft = 0;

        if ($user->otp_expires_at) {
            // Kita ubah ke Timestamp (Angka Detik Murni) agar tidak kena masalah Timezone
            $expireTime = Carbon::parse($user->otp_expires_at)->timestamp;
            $now = Carbon::now()->timestamp;

            // Hitung selisih
            $timeLeft = $expireTime - $now;
        }

        // Jika hasilnya minus (waktu habis), paksa jadi 0
        if ($timeLeft < 0) {
            $timeLeft = 0;
        }

        return view('auth.verify-otp', [
            'user' => $user,
            'timeLeft' => $timeLeft 
        ]);
    }

    // 2. Cek Kode OTP
    public function store(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = Auth::user();
        $now = Carbon::now();
        $expiredTime = Carbon::parse($user->otp_expires_at);

        // Cek 1: Apakah Kode Cocok?
        if ($user->otp_code != $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah! Coba cek lagi.']);
        }

        // Cek 2: Apakah Kadaluarsa? (Lewat 1 menit)
        if ($now->greaterThan($expiredTime)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan klik tombol "Kirim Ulang".']);
        }

        // SUKSES: Reset OTP & Verifikasi User
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => $now,
        ]);

        return redirect()->route('dashboard')->with('success', 'Verifikasi Berhasil!');
    }

    // 3. Fungsi Kirim Ulang (Resend)
    public function resend()
    {
        $user = Auth::user();

        // Generate OTP Baru
        $otp = rand(100000, 999999);
        
        // Update di Database: Waktu Sekarang + 60 Detik
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addSeconds(60) 
        ]);

        // --- KIRIM WA (Kode Anda) ---
        try {
            $phone = $user->whatsapp; 
            if(!str_ends_with($phone, '@s.whatsapp.net')) {
                $phone .= '@s.whatsapp.net';
            }
            Http::timeout(5)->post('http://127.0.0.1:3000/send/message', [
                'phone' => $phone,
                'message' => "Kode OTP Baru: *{$otp}*",
            ]);
            return back()->with('status', 'Kode OTP baru telah dikirim!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal kirim WA.');
        }
    }
}