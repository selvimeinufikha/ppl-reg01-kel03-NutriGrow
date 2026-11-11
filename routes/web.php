<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPenggunaController;
use App\Http\Controllers\KehamilanController;
use App\Http\Controllers\ProfileController;

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

// Rute Dashboard
Route::get('/dashboard-admin', function () {
    if (view()->exists('DashboardAdmiin.index')) {
        return view('DashboardAdmiin.index');
    }
    return redirect()->route('home');
})->name('dashboard.admin');

Route::get('/dashboard-pengguna', [DashboardPenggunaController::class, 'index'])->name('dashboard.pengguna');
Route::get('/dashboard', [DashboardPenggunaController::class, 'index'])->name('dashboard');

// Rute Data Kehamilan (PBI-004, PBI-005, PBI-006: Pencatatan, Usia Kehamilan, Trimester, Perbarui & Hapus)
Route::prefix('data-kehamilan')->name('kehamilan.')->group(function () {
    Route::get('/', [KehamilanController::class, 'index'])->name('index');
    Route::get('/catat', [KehamilanController::class, 'create'])->name('create');
    Route::post('/', [KehamilanController::class, 'store'])->name('store');
    Route::post('/kalkulator', [KehamilanController::class, 'kalkulator'])->name('kalkulator');
    Route::get('/kalkulator', [KehamilanController::class, 'kalkulator'])->name('kalkulator.get');
    Route::get('/{id}', [KehamilanController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [KehamilanController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KehamilanController::class, 'update'])->name('update');
    Route::delete('/{id}', [KehamilanController::class, 'destroy'])->name('destroy');
});

// Rute Profil Pengguna (PBI-010: Kelola Profil Pengguna & Acuan Layanan Kesehatan)
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});
