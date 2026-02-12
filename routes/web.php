<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use App\Models\Event;

// --- CONTROLLERS ---
use App\Http\Controllers\ReportController; // Pastikan ini ada
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController;
use App\Helpers\WhatsappHelper;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN
Route::get('/', function () {
    try { $events = Event::latest()->take(6)->get(); } catch (\Exception $e) { $events = []; }
    return view('welcome', compact('events'));
});

// 2. LOGOUT
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// 3. MENU USER (Dapat Diakses Semua yang Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');
    Route::get('/explore', [DashboardController::class, 'explore'])->name('explore');
    Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');
    
    // Fitur Mahasiswa
    Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata');
    Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');
    Route::get('/help', [HelpController::class, 'index'])->name('help');
    Route::get('/history', [RegistrationController::class, 'history'])->name('history');
    
    // Profile
    if (class_exists(ProfileController::class)) {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    }

    // Event & Tiket
    Route::get('/event-detail/{id}', [EventController::class, 'show'])->name('event.detail');
    Route::post('/event/{id}/register', [RegistrationController::class, 'store'])->name('event.register');
    Route::get('/ticket/download/{id}', [RegistrationController::class, 'downloadTicket'])->name('ticket.download');
    Route::get('/certificate/download/{id}', [RegistrationController::class, 'downloadCertificate'])->name('certificate.download');
    
    // Route Detail User
    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
});

// 4. MENU ADMIN (Route Laporan Disulam di Sini)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Resource Controller Dasar
    Route::resource('events', EventController::class);
    Route::resource('users', UserController::class); // Saya rapikan penulisannya

    // --- BAGIAN LAPORAN (SULAM KODE DI SINI) ---
    // Route Halaman Laporan Utama
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    // Route Cetak Absensi PDF (Export Participants)
    Route::get('/reports/participants/{id}', [ReportController::class, 'exportParticipants'])->name('reports.export_participants');
    // -------------------------------------------

    // Peserta & Scan Tiket
    Route::delete('/participants/{id}', [RegistrationController::class, 'destroy'])->name('participants.destroy');
    Route::patch('/participants/{id}', [RegistrationController::class, 'updateStatus'])->name('participants.updateStatus');
    Route::get('/scan', [RegistrationController::class, 'scanIndex'])->name('scan.index');
    Route::post('/scan', [RegistrationController::class, 'processScan'])->name('scan.process');
});

// ==============================================================================
// 5. ROUTE OTP
// ==============================================================================
Route::get('/otp-verify', [OtpController::class, 'create'])->name('otp.verify');
Route::post('/otp-verify', [OtpController::class, 'store'])->name('otp.check');
Route::post('/otp-resend', [OtpController::class, 'resend'])->name('otp.resend');

// Load Route Auth Bawaan Breeze
if (file_exists(__DIR__.'/auth.php')) { require __DIR__.'/auth.php'; }

// ==============================================================================
// 🛠️ ZONE PERBAIKAN & DEBUG
// ==============================================================================
Route::get('/fix-roles', function () {
    $log = "<h1>HASIL:</h1>";
    $amirul = User::where('name', 'LIKE', '%Amirul%')->first();
    if ($amirul) { $amirul->usertype = 'user'; $amirul->save(); $log .= "Amirul jadi USER.<br>"; }
    $rahma = User::where('name', 'LIKE', '%Rahma%')->first();
    if ($rahma) { $rahma->usertype = 'admin'; $rahma->save(); $log .= "Rahma jadi ADMIN.<br>"; }
    return $log;
});
// (Sisa debug route lainnya tetap aman jika mau dipakai, opsional)