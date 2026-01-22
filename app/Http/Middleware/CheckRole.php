<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login DAN apakah role-nya sesuai
        // $request->user() = Mengambil data user yang sedang login
        // $role = Role yang diminta di route (misal: 'admin')
        if (! $request->user() || $request->user()->role !== $role) {
            
            // --- LOGIKA HYBRID (Agar rapi di Postman & Browser) ---

            // Jika yang akses adalah API / Postman (Minta JSON)
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akses Ditolak: Anda tidak memiliki izin (Unauthorized).'
                ], 403);
            }

            // Jika yang akses adalah Browser Biasa
            // Tampilkan halaman Error 403 bawaan Laravel
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika lolos pengecekan, silakan lanjut
        return $next($request);
    }
}