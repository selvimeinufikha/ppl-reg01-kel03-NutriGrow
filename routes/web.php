<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

// Rute navigasi placeholder sesuai struktur folder di resources
Route::get('/login', function () {
    if (view()->exists('HalamanLogin.index')) {
        return view('HalamanLogin.index');
    }
    return redirect()->route('home')->with('info', 'Halaman Login sedang disiapkan');
})->name('login');

Route::get('/register', function () {
    if (view()->exists('HalamanLogin.register')) {
        return view('HalamanLogin.register');
    }
    return redirect()->route('home')->with('info', 'Halaman Registrasi sedang disiapkan');
})->name('register');

Route::get('/dashboard-admin', function () {
    if (view()->exists('DashboardAdmiin.index')) {
        return view('DashboardAdmiin.index');
    }
    return redirect()->route('home');
})->name('dashboard.admin');

Route::get('/dashboard-pengguna', function () {
    if (view()->exists('DashboardPengguna.index')) {
        return view('DashboardPengguna.index');
    }
    return redirect()->route('home');
})->name('dashboard.pengguna');
