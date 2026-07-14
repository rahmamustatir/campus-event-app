<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Ambil role user dari database
        $userRole = auth()->user()->role; 

        // 3. Jika role user tidak sama dengan role yang diminta di web.php
        if ($userRole !== $role) {
            
            // Arahkan user ke dashboard yang benar sesuai dengan role-nya di database
            // Ini mencegah error "Route not defined"
            if ($userRole === 'admin' || $userRole === 'super_admin') {
                return redirect()->route('admin.dashboard')
                                 ->with('error', 'Anda tidak memiliki izin akses tersebut.');
            } 
            
            if ($userRole === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard')
                                 ->with('error', 'Anda tidak memiliki izin akses tersebut.');
            }

            // Jika role tidak dikenal, log out saja demi keamanan
            return redirect()->route('login');
        }

        return $next($request);
    }
}