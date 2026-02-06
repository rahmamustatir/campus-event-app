<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // <--- BARIS INI WAJIB ADA!
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Daftarkan Alias Middleware "role"
        // Ini agar kita bisa pakai kode 'role:admin' di routes nanti
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // 2. Setting CSRF (Keamanan Form)
        // Kita kosongkan array ini agar keamanan menyala sepenuhnya.
        // Konsekuensi: Tes di Postman akan error 419 jika tidak pakai cookie, 
        // tapi ini WAJIB untuk keamanan website asli.
        $middleware->validateCsrfTokens(except: [
            // Kosongkan, atau biarkan route API scan jika perlu akses luar
             'admin/api/check-in' 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Biarkan default
    })->create();