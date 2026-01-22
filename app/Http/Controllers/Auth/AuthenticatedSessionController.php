<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. JIKA API/POSTMAN (Minta JSON)
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Login Berhasil!',
                'user' => Auth::user(),
                'role' => Auth::user()->role, // Biar tau dia login sebagai apa
            ], 200);
        }

        // 2. JIKA WEBSITE (Cek Role Dulu)
        $user = $request->user();

        if ($user->role === 'admin') {
            // Jika Admin -> Lempar ke Halaman List Event
            return redirect()->route('admin.events.index');
        }

        // Jika Mahasiswa -> Lempar ke Dashboard Tiket
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse|JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Logout Berhasil!'
            ], 200);
        }

        return redirect('/');
    }
}