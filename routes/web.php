<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema; // Tambahan biar route fix database gak error
use Illuminate\Database\Schema\Blueprint; // Tambahan biar route fix database gak error
use App\Models\User;
use App\Models\Event;

// --- CONTROLLERS ---
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController; // Controller OTP
use App\Helpers\WhatsappHelper; // Helper WA

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
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified']) // Verified akan kita pakai setelah ini
        ->name('dashboard');

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
    Route::get('/ticket/download-pdf/{id}', [RegistrationController::class, 'downloadTicket'])->name('ticket.download.pdf');

    // Route untuk melihat Detail User & Riwayat Event
    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
});

// 4. MENU ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::delete('/participants/{id}', [RegistrationController::class, 'destroy'])->name('participants.destroy');
    Route::patch('/participants/{id}', [RegistrationController::class, 'updateStatus'])->name('participants.updateStatus');
    Route::get('/scan', [RegistrationController::class, 'scanIndex'])->name('scan.index');
    Route::post('/scan', [RegistrationController::class, 'processScan'])->name('scan.process');
});

// Load Route Auth Bawaan Breeze (Login, Register, dll)
if (file_exists(__DIR__.'/auth.php')) { require __DIR__.'/auth.php'; }


// ==============================================================================
// 🛠️ ZONE PERBAIKAN & DEBUG (Bisa dihapus nanti kalau web sudah jadi)
// ==============================================================================

// Route Verifikasi OTP (Hanya bisa diakses kalau sudah login)

Route::get('/fix-roles', function () {
    $log = "<div style='font-family:sans-serif; padding:50px; text-align:center;'><h1>HASIL PERUBAHAN JABATAN:</h1><ul style='list-style:none;'>";
    $amirul = User::where('name', 'LIKE', '%Amirul%')->first();
    if ($amirul) { $amirul->usertype = 'user'; $amirul->save(); $log .= "<li>⬇️ <b>" . $amirul->name . "</b> jadi USER.</li>"; }
    $rahma = User::where('name', 'LIKE', '%Rahma%')->first();
    if ($rahma) { $rahma->usertype = 'admin'; $rahma->save(); $log .= "<li>⬆️ <b>" . $rahma->name . "</b> jadi ADMIN.</li>"; }
    return $log;
});

// Fix Registration Table
Route::get('/fix-registration-table', function () {
    if (!Schema::hasTable('registrations')) {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('event_id');
            $table->string('status')->default('confirmed');
            $table->timestamps();
        });
        return "Tabel registrations dibuat.";
    }
    return "Tabel sudah ada.";
});

// Reset Registration Table
Route::get('/reset-registration-table', function () {
    Schema::dropIfExists('registrations');
    Schema::create('registrations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('event_id')->constrained()->onDelete('cascade');
        $table->string('status')->default('confirmed');
        $table->timestamps();
    });
    return "Tabel di-reset total.";
});

// Update Event Table
Route::get('/update-event-table', function () {
    if (!Schema::hasColumn('events', 'kategori_peserta')) {
        Schema::table('events', function (Blueprint $table) {
            $table->string('kategori_peserta')->default('umum')->after('description');
            $table->string('target_peserta')->nullable()->after('kategori_peserta');
        });
        return "Kolom kategori ditambahkan.";
    }
    return "Kolom sudah ada.";
});
