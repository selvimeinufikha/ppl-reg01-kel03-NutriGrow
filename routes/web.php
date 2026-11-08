<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminEdukasiGiziController;
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

    // Data Edukasi Gizi (URL: /admin/edukasi-gizi)
    Route::get('/edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.index');
    Route::get('/data-edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.alias');
    Route::post('/edukasi-gizi', [AdminEdukasiGiziController::class, 'store'])->name('admin.edukasi.store');
    Route::put('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update');
    Route::post('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update.post');
    Route::delete('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'destroy'])->name('admin.edukasi.destroy');

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
Route::get('/data-edukasi-gizi', function () {
    return redirect()->route('admin.edukasi.index');
});
