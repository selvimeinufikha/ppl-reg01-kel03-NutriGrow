<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardPenggunaController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\InformasiNutrisiController;

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

// Rute Autentikasi & Registrasi
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

// Rute Dashboard Admin & Portal Tenaga Kesehatan
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('admin.root');

    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.password.update');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Data Informasi Nutrisi (Portal Admin / Nakes)
    Route::get('/informasi-nutrisi', [InformasiNutrisiController::class, 'index'])->name('admin.informasi-nutrisi.index');
    Route::get('/data-informasi-nutrisi', [InformasiNutrisiController::class, 'index'])->name('admin.informasi-nutrisi.alias');
    Route::get('/informasi-nutrisi/create', [InformasiNutrisiController::class, 'create'])->name('admin.informasi-nutrisi.create');
    Route::post('/informasi-nutrisi', [InformasiNutrisiController::class, 'store'])->name('admin.informasi-nutrisi.store');
    Route::get('/informasi-nutrisi/{informasi_nutrisi}', [InformasiNutrisiController::class, 'show'])->name('admin.informasi-nutrisi.show');
});

// Alias rute admin umum
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});
Route::get('/login-admin', function () {
    return redirect()->route('admin.login');
});
Route::get('/dashboard-admin', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard.admin');

Route::get('/dashboard-pengguna', [DashboardPenggunaController::class, 'index'])->name('dashboard.pengguna');

// Rute Pengelolaan Data Anak (PBI-007)
Route::resource('data-anak', AnakController::class);
Route::get('/dashboard/data-anak', [AnakController::class, 'index'])->name('dashboard.data-anak');

// Daftar Anak & Umur (sub-halaman tabel daftar anak)
Route::get('/daftar-anak', [AnakController::class, 'daftarAnak'])->name('daftar-anak.index');

// Rute Informasi Nutrisi & Rekomendasi Gizi (PBI-025)
Route::resource('informasi-nutrisi', InformasiNutrisiController::class);
Route::get('/rekomendasi-nutrisi', [InformasiNutrisiController::class, 'index'])->name('rekomendasi-nutrisi.index');
Route::get('/admin/informasi-nutrisi/create', [InformasiNutrisiController::class, 'create'])->name('admin.informasi-nutrisi.create');
Route::post('/admin/informasi-nutrisi', [InformasiNutrisiController::class, 'store'])->name('admin.informasi-nutrisi.store');
