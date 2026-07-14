<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OtpVerification;
use Carbon\Carbon;

class AuthController extends Controller
{
    // =========================================================================
    // 1. TAMPILAN ANTARMUKA (VIEW)
    // =========================================================================
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function otpView()
    {
        return view('auth.otp');
    }

    // =========================================================================
    // 2. LOGIKA PROSES (CONTROLLER)
    // =========================================================================

    /**
     * Proses Registrasi Akun Mahasiswa
     */
    public function registerProcess(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'whatsapp_number' => 'required|string|unique:users,whatsapp_number',
            'password' => 'required|min:6|confirmed'
        ]);

        // 2. Simpan Data User (Default: mahasiswa, belum terverifikasi)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp_number' => $request->whatsapp_number,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'is_verified' => false,
        ]);

        // 3. Generate 6 Digit OTP Unik
        $otpCode = rand(100000, 999999);

        // 4. Simpan OTP ke tabel otp_verifications (Berlaku 5 menit)
        OtpVerification::create([
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'expired_at' => Carbon::now()->addMinutes(5),
            'is_used' => false,
        ]);

        // 5. TODO: Integrasi WhatsApp API Gateway (Fonnte/Wablas/dsb)
        // Di sini nantinya kamu letakkan script CURL untuk mengirim $otpCode ke $request->whatsapp_number
        // Contoh Logika Semu: WhatsAppAPI::send($user->whatsapp_number, "Kode OTP Campus Event Anda: " . $otpCode);

        // 6. Redirect ke halaman verifikasi OTP
        return redirect()->route('otp.view')->with('success', 'Akun berhasil dibuat. Silakan periksa WhatsApp Anda untuk kode OTP.');
    }

    /**
     * Proses Verifikasi OTP
     */
    public function otpProcess(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric|digits:6'
        ]);

        // Cari OTP di database yang belum kadaluarsa dan belum dipakai
        $otp = OtpVerification::where('otp_code', $request->otp_code)
            ->where('is_used', false)
            ->where('expired_at', '>=', Carbon::now())
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid atau sudah kadaluarsa.']);
        }

        // Jika Valid: Update status OTP & User
        $otp->update(['is_used' => true]);
        
        $user = User::find($otp->user_id);
        $user->update(['is_verified' => true]);

        return redirect()->route('login')->with('success', 'Verifikasi berhasil! Silakan Login.');
    }

    /**
     * Proses Login & Redirect Berdasarkan Role
     */
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Cek apakah akun sudah diverifikasi (kecuali Super Admin)
            if (!$user->is_verified && $user->role !== 'super_admin') {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Akun belum diverifikasi OTP.']);
            }

            // PENGALIHAN STRICT (Strict Segregation)
            switch ($user->role) {
                case 'super_admin':
                    return redirect()->route('superadmin.dashboard');
                case 'biro_akademik':
                    return redirect()->route('biro.dashboard');
                case 'prodi':
                    return redirect()->route('prodi.dashboard');
                case 'admin': // Panitia Event
                    return redirect()->route('admin.dashboard');
                case 'mahasiswa':
                    return redirect()->route('mahasiswa.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Role tidak dikenali.']);
            }
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}