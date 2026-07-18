<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, DashboardSuperAdminController, DashboardBiroController,
    DashboardProdiController, DashboardAdminController, DashboardMahasiswaController,
    LaporanController, ReportController, EventController, RegistrationController,
    BiodataController, HelpController, UserController, ScanController
};

// --- PUBLIC ROUTES ---
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
Route::get('/verify-otp', [AuthController::class, 'otpView'])->name('otp.view');
Route::post('/verify-otp', [AuthController::class, 'otpProcess'])->name('otp.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PROTECTED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // A. Super Admin
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/super-admin/dashboard', [DashboardSuperAdminController::class, 'index'])->name('superadmin.dashboard');
        Route::resource('superadmin/users', UserController::class);
        Route::get('/register-prodi', [UserController::class, 'create'])->name('register.prodi');
        Route::post('/register-prodi', [UserController::class, 'store']);
    });

    // B. Biro Akademik
    Route::middleware(['role:biro_akademik'])->group(function () {
        Route::get('/biro/dashboard', [DashboardBiroController::class, 'index'])->name('biro.dashboard');
        Route::get('/biro/laporan', [LaporanController::class, 'index'])->name('biro.laporan');
    });

    // C. Kaprodi
    Route::middleware(['role:prodi'])->group(function () {
        Route::get('/prodi/dashboard', [DashboardProdiController::class, 'index'])->name('prodi.dashboard');
    });

    // D. Panitia Event (Admin) - SEMUA RUTE ADMIN DI SINI
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('events', EventController::class, ['as' => 'admin']);
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/scan', [ScanController::class, 'index'])->name('admin.scan.index');
        Route::post('/scan/verify', [ScanController::class, 'verify'])->name('admin.scan.verify');
        Route::post('/events/{id}/ajukan', [EventController::class, 'updateStatus'])->name('admin.events.ajukan');

        // Rute Laporan Admin
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/laporan/{id}', [ReportController::class, 'downloadLaporanEvent'])->name('admin.reports.laporan');
        Route::get('/reports/bulanan', [ReportController::class, 'downloadLaporanBulanan'])->name('admin.reports.bulanan');
        Route::get('/reports/download/{id}', [ReportController::class, 'exportParticipants'])->name('admin.reports.export_participants');
        Route::post('/admin/scan/process', [RegistrationController::class, 'processScan'])->name('admin.scan.process');
    });

    // E. Mahasiswa
 // RUTE MAHASISWA
    Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    // Rute ini akan membuat /mahasiswa/mahasiswa/dashboard
    Route::get('/mahasiswa/dashboard', [App\Http\Controllers\DashboardMahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/mahasiswa/mahasiswa/explore', [DashboardMahasiswaController::class, 'explore'])->name('explore');
    Route::get('/mahasiswa/history', [App\Http\Controllers\RegistrationController::class, 'history'])->name('history');
    Route::get('/mahasiswa/biodata', [App\Http\Controllers\DashboardMahasiswaController::class, 'biodata'])->name('biodata');
    });
});