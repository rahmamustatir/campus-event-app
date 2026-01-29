<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// --- CONTROLLERS ---
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Models\Event;

/*
|--------------------------------------------------------------------------
| Web Routes (FINAL FIXED - STRUKTUR JABATAN)
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
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    
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
    Route::get('/ticket/download-pdf/{id}', [RegistrationController::class, 'downloadTicket'])->name('ticket.download.pdf');
});

// 4. MENU ADMIN (Kita hapus middleware yang bikin error tadi)
// Cukup kelompokkan biasa. Keamanan akan dihandle oleh Tampilan (Menu hilang kalau bukan admin).
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::delete('/participants/{id}', [RegistrationController::class, 'destroy'])->name('participants.destroy');
    Route::patch('/participants/{id}', [RegistrationController::class, 'updateStatus'])->name('participants.updateStatus');
    Route::get('/scan', [RegistrationController::class, 'scanIndex'])->name('scan.index');
    Route::post('/scan', [RegistrationController::class, 'processScan'])->name('scan.process');
});

if (file_exists(__DIR__.'/auth.php')) { require __DIR__.'/auth.php'; }


// ==============================================================================
// 🔥 OBAT PENGATUR JABATAN (Jalankan Sekali Saja)
// ==============================================================================
Route::get('/fix-roles', function () {
    $log = "<div style='font-family:sans-serif; padding:50px; text-align:center;'><h1>HASIL PERUBAHAN JABATAN:</h1><ul style='list-style:none;'>";

    // 1. TURUNKAN JABATAN: M. Amirul Mustofa -> User
    // Cari nama yang mirip 'Amirul'
    $amirul = User::where('name', 'LIKE', '%Amirul%')->first();
    if ($amirul) {
        $amirul->usertype = 'user'; // Turunkan jadi user biasa
        $amirul->save();
        $log .= "<li style='color:red; font-size:18px; margin-bottom:10px;'>⬇️ <b>" . $amirul->name . "</b> sekarang menjadi <b>USER BIASA</b>.</li>";
    } else {
        $log .= "<li>⚠️ Akun Amirul tidak ditemukan.</li>";
    }

    // 2. NAIKKAN JABATAN: Rahma Mustatir -> Admin
    $rahma = User::where('name', 'LIKE', '%Rahma%')->first();
    if ($rahma) {
        $rahma->usertype = 'admin'; // Naikkan jadi Admin
        $rahma->save();
        $log .= "<li style='color:green; font-size:18px; margin-bottom:10px;'>⬆️ <b>" . $rahma->name . "</b> resmi menjadi <b>ADMIN</b>.</li>";
    } else {
        $log .= "<li>⚠️ Akun Rahma tidak ditemukan.</li>";
    }

    // 3. PASTIKAN ADMIN KAMPUS TETAP ADMIN
    $adminKampus = User::where('name', 'LIKE', '%Admin Kampus%')->orWhere('email', 'LIKE', '%admin%')->first();
    if ($adminKampus) {
        $adminKampus->usertype = 'admin';
        $adminKampus->save();
        $log .= "<li style='color:green; font-size:18px; margin-bottom:10px;'>⬆️ <b>" . $adminKampus->name . "</b> dipastikan sebagai <b>ADMIN</b>.</li>";
    }

    $log .= "</ul><br><br><a href='/dashboard' style='background:blue; color:white; padding:15px 30px; text-decoration:none; border-radius:5px; font-weight:bold;'>Selesai & Cek Dashboard &rarr;</a></div>";
    return $log;
});