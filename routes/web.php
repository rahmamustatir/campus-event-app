<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HistoryController; // <--- TAMBAHAN BARU (Import Controller Riwayat)
use App\Models\Event;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN DEPAN (HOMEPAGE) ---
Route::get('/', function () {
    // Tampilkan event yang akan datang (event_date >= now) di halaman depan
    $events = Event::withCount('registrations')
                ->where('event_date', '>=', now()) 
                ->orderBy('event_date', 'asc')
                ->get();     
    return view('welcome', compact('events'));
})->name('home');


// --- 2. DASHBOARD MAHASISWA ---
Route::get('/dashboard', function () {
    // Ambil tiket event yang AKAN DATANG (Upcoming)
    $myRegistrations = auth()->user()->registrations()
                        ->whereHas('event', function($q) {
                            $q->where('event_date', '>=', now());
                        })
                        ->with('event')
                        ->latest()
                        ->get();
    return view('dashboard', compact('myRegistrations'));
})->middleware(['auth', 'verified'])->name('dashboard');


// --- 3. FITUR USER/MAHASISWA (LOGIN DULU) ---
Route::middleware('auth')->group(function () {
    // A. Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // B. Transaksi Event (Daftar & Download)
    Route::post('/event/{id}/register', [RegistrationController::class, 'store'])->name('event.register');
    Route::get('/ticket/{id}/download', [RegistrationController::class, 'downloadPdf'])->name('ticket.download');

    // C. RIWAYAT EVENT (MENU BARU)
    // Menampilkan event masa lalu yang sudah selesai
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
});

    // Jangan lupa import di paling atas:
use App\Http\Controllers\HelpController; 

// ...

Route::middleware('auth')->group(function () {
    // ... route lain ...
    Route::get('/history', [HistoryController::class, 'index'])->name('history');

    // ROUTE BANTUAN (BARU)
    Route::get('/help', [HelpController::class, 'index'])->name('help');
});

// --- 4. AREA ADMIN (KHUSUS ROLE ADMIN) ---
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    
    // A. Manajemen Event (CRUD)
    Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('/admin/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/admin/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/admin/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit'); 
    Route::put('/admin/events/{event}', [EventController::class, 'update'])->name('admin.events.update'); 
    Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy'); 
    
    // B. Detail Peserta per Event
    Route::get('/admin/events/{event}', [EventController::class, 'show'])->name('admin.events.show');
    Route::delete('/admin/participants/{id}', [EventController::class, 'destroyParticipant'])->name('admin.participants.destroy');

    // C. Data Mahasiswa (User Management)
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // D. Laporan & Export Excel
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');

    // E. Scan QR Tiket
    Route::view('/admin/scan', 'admin.scan')->name('admin.scan.index');
    Route::post('/admin/scan', [RegistrationController::class, 'checkInApi'])->name('admin.scan.process');
});

require __DIR__.'/auth.php';