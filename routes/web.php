<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPemeriksaanKehamilanController;
use App\Http\Controllers\DashboardPenggunaController;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi NutriGrow
|--------------------------------------------------------------------------
| Pemisahan terstruktur dan independen antara:
| 1. Website Pengguna / Orang Tua (User Portal)
| 2. Website Admin & Tenaga Kesehatan (Admin & Nakes Portal)
*/

// =========================================================================
// 1. WEBSITE USER (Pengguna, Keluarga & Orang Tua)
// =========================================================================

// Halaman Utama & Edukasi Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.page');
Route::get('/homepages', [HomeController::class, 'index'])->name('homepages');

// Autentikasi Pengguna (Login, Register & Logout User)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/api/check-email', [AuthController::class, 'checkEmail'])->name('api.check-email');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa & Reset Password Pengguna
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.request.id');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password', function () {
    return redirect()->route('password.reset', ['token' => 'simulator', 'email' => 'ibu.anita@nutrigrow.id']);
});
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Dashboard Pengguna (Keluarga & Orang Tua)
Route::get('/dashboard-pengguna', [DashboardPenggunaController::class, 'index'])->name('dashboard.pengguna');
Route::get('/dashboard', [DashboardPenggunaController::class, 'index'])->name('dashboard');


// =========================================================================
// 2. WEBSITE ADMIN (Portal Khusus Faskes & Tenaga Kesehatan)
// =========================================================================

Route::prefix('admin')->group(function () {
    // Autentikasi Admin & Nakes (URL: /admin/login)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Lupa & Reset Password Admin & Nakes (URL: /admin/forgot-password)
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.password.update');

    // Dashboard Admin (URL: /admin/dashboard)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Data Pemeriksaan Kehamilan (URL: /admin/pemeriksaan-kehamilan)
    Route::get('/pemeriksaan-kehamilan', [AdminPemeriksaanKehamilanController::class, 'index'])->name('admin.pemeriksaan.index');
    Route::get('/data-pemeriksaan-kehamilan', [AdminPemeriksaanKehamilanController::class, 'index'])->name('admin.pemeriksaan.alias');
    Route::get('/pemeriksaan-kehamilan/pasien/{kehamilanId}', [AdminPemeriksaanKehamilanController::class, 'getPasienInfo'])->name('admin.pemeriksaan.pasien-info');
    Route::post('/pemeriksaan-kehamilan', [AdminPemeriksaanKehamilanController::class, 'store'])->name('admin.pemeriksaan.store');
    Route::get('/pemeriksaan-kehamilan/{id}', [AdminPemeriksaanKehamilanController::class, 'show'])->name('admin.pemeriksaan.show');
    Route::get('/pemeriksaan-kehamilan/{id}/edit', [AdminPemeriksaanKehamilanController::class, 'edit'])->name('admin.pemeriksaan.edit');
    Route::put('/pemeriksaan-kehamilan/{id}', [AdminPemeriksaanKehamilanController::class, 'update'])->name('admin.pemeriksaan.update');
    Route::post('/pemeriksaan-kehamilan/{id}', [AdminPemeriksaanKehamilanController::class, 'update'])->name('admin.pemeriksaan.update.post');
    Route::delete('/pemeriksaan-kehamilan/{id}', [AdminPemeriksaanKehamilanController::class, 'destroy'])->name('admin.pemeriksaan.destroy');

    // Data Edukasi Gizi (URL: /admin/edukasi-gizi)
    if (class_exists(\App\Http\Controllers\AdminEdukasiGiziController::class)) {
        Route::get('/edukasi-gizi', [\App\Http\Controllers\AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.index');
        Route::get('/data-edukasi-gizi', [\App\Http\Controllers\AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.alias');
        Route::post('/edukasi-gizi', [\App\Http\Controllers\AdminEdukasiGiziController::class, 'store'])->name('admin.edukasi.store');
        Route::put('/edukasi-gizi/{id}', [\App\Http\Controllers\AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update');
        Route::post('/edukasi-gizi/{id}', [\App\Http\Controllers\AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update.post');
        Route::delete('/edukasi-gizi/{id}', [\App\Http\Controllers\AdminEdukasiGiziController::class, 'destroy'])->name('admin.edukasi.destroy');
    }

    // Beralih Peran Superadmin / Admin (Demonstrasi & Pengujian)
    Route::get('/switch-role/{role}', [AdminDashboardController::class, 'switchRole'])->name('admin.switch-role');
    Route::post('/switch-role', [AdminDashboardController::class, 'switchRole'])->name('admin.switch-role.post');

    // Manajemen Akun Admin (Khusus Superadmin)
    Route::post('/users/create-admin', [AdminDashboardController::class, 'storeAdmin'])->name('admin.users.create');
    Route::post('/users/{id}/update-role', [AdminDashboardController::class, 'updateAdminRole'])->name('admin.users.update-role');
    Route::delete('/users/{id}/delete', [AdminDashboardController::class, 'deleteAdmin'])->name('admin.users.delete');

    // Pengalihan dasar /admin selalu ke /admin/login
    Route::get('/', function () {
        return redirect()->route('admin.login');
    })->name('admin.root');
});

// Alias & Pengalihan kompatibilitas rute Admin
Route::get('/login-admin', function () {
    return redirect()->route('admin.login');
});
Route::get('/lupa-password-admin', function () {
    return redirect()->route('admin.password.request');
});
Route::get('/admin/lupa-password', function () {
    return redirect()->route('admin.password.request');
});
Route::get('/dashboard-admin', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard.admin');
Route::get('/pemeriksaan-kehamilan', function () {
    return redirect()->route('admin.pemeriksaan.index');
});
