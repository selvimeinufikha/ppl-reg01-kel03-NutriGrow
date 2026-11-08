<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardPenggunaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute untuk aplikasi NutriGrow
|
*/

// Rute Halaman Utama (HomePages)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.page');
Route::get('/homepages', [HomeController::class, 'index'])->name('homepages');

// Rute Autentikasi Pengguna / Orang Tua
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/api/check-email', [AuthController::class, 'checkEmail'])->name('api.check-email');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Lupa & Reset Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.request.id');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password', function () {
    return redirect()->route('password.reset', ['token' => 'simulator', 'email' => 'ibu.anita@nutrigrow.id']);
});
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Rute Portal Admin & Tenaga Kesehatan (Faskes & Nakes)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});
Route::get('/login-admin', function () {
    return redirect()->route('admin.login');
});

// Rute Dashboard
Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/dashboard-pengguna', [DashboardPenggunaController::class, 'index'])->name('dashboard.pengguna');
Route::get('/dashboard', [DashboardPenggunaController::class, 'index'])->name('dashboard');
