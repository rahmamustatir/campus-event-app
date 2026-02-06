<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Helpers\WhatsappHelper; // Panggil Helper WA kita

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'whatsapp' => ['required', 'numeric', 'unique:'.User::class], // Wajib isi WA
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Simpan User ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role' => 'student', // Default role
        ]);

        event(new Registered($user));

        // 3. GENERATE OTP & KIRIM WA
        // Bikin 6 angka acak
        $otp = rand(100000, 999999);
        
        // Simpan OTP ke database user yang barusan daftar
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10); // Berlaku 10 menit
        $user->save();

        // Kirim Pesan WA
        WhatsappHelper::send($user->whatsapp, "Halo {$user->name}! Kode verifikasi akun Campus Event Anda adalah: *{$otp}*");

        // 4. Login Otomatis & Redirect ke Halaman Verifikasi
        Auth::login($user);

        // Arahkan ke rute 'otp.verify' (yang akan kita buat setelah ini)
        return redirect()->route('otp.verify');
    }
}