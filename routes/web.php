<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminEdukasiGiziController;
use App\Http\Controllers\AdminPengukuranAnakController;
use App\Http\Controllers\DashboardPenggunaController;
use App\Http\Controllers\TumbuhKembangAnakController;
use App\Services\StatusGiziCalculator;
use App\Models\Anak;

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

// =========================================================================
// API: PBI-017 — Hitung Umur & Status Gizi Otomatis (Real-time / AJAX)
// Acceptance Criteria: Sistem menghitung umur & status gizi secara otomatis
// =========================================================================
Route::get('/api/hitung-status-gizi', function (\Illuminate\Http\Request $request) {
    $anakId       = $request->query('anak_id');
    $tglUkur      = $request->query('tanggal_pemeriksaan', date('Y-m-d'));
    $bb           = (float) $request->query('berat_badan', 0);
    $tb           = (float) $request->query('tinggi_badan', 0);

    $anak = \App\Models\Anak::find($anakId);
    if (! $anak || ! $anak->tanggal_lahir) {
        return response()->json(['error' => 'Data anak tidak ditemukan'], 404);
    }

    // Hitung umur otomatis (PBI-017 AC #1)
    $umurData = \App\Services\StatusGiziCalculator::hitungUmur(
        $anak->tanggal_lahir->format('Y-m-d'),
        $tglUkur
    );

    $result = ['umur' => $umurData];

    // Hitung status gizi jika BB & TB tersedia (PBI-017 AC #2)
    if ($bb > 0 && $tb > 0) {
        $giziData = \App\Services\StatusGiziCalculator::hitungStatusGizi(
            $umurData['bulan'],
            $bb,
            $tb,
            $anak->jenis_kelamin
        );
        $result['gizi'] = $giziData;
    }

    return response()->json($result);
})->name('api.hitung-status-gizi');

// Lupa & Reset Password Pengguna
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.request.id');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password', function () {
    return redirect()->route('password.reset', ['token' => 'simulator', 'email' => 'ibu.anita@nutrigrow.id']);
});
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Dashboard Pengguna (Keluarga & Orang Tua) — hanya role: user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard-pengguna', [DashboardPenggunaController::class, 'index'])->name('dashboard.pengguna');
    Route::get('/dashboard', [DashboardPenggunaController::class, 'index'])->name('dashboard');

    // Rekam Medis: Riwayat Tumbuh Kembang Anak (PBI-016 / F-06) — hanya untuk pengguna
    Route::get('/tumbuh-kembang-anak', [TumbuhKembangAnakController::class, 'index'])->name('tumbuh-kembang.index');
    Route::get('/riwayat-tumbuh-kembang', [TumbuhKembangAnakController::class, 'index'])->name('riwayat-tumbuh-kembang');
    Route::get('/dashboard-pengguna/tumbuh-kembang-anak', [TumbuhKembangAnakController::class, 'index'])->name('dashboard.tumbuh-kembang');
});


// =========================================================================
// 2. WEBSITE ADMIN (Portal Khusus Faskes & Tenaga Kesehatan)
// =========================================================================

Route::prefix('admin')->group(function () {
    // Autentikasi Admin & Nakes (URL: /admin/login) — BEBAS diakses
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Lupa & Reset Password Admin & Nakes (URL: /admin/forgot-password)
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.password.update');

    // ===================================================================
    // Route yang hanya boleh diakses oleh Admin & Tenaga Kesehatan (Nakes)
    // PBI-016: Pemisahan akses berdasarkan role
    // ===================================================================
    Route::middleware(['auth', 'role:admin,nakes'])->group(function () {
        // Dashboard Admin (URL: /admin/dashboard)
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Data Edukasi Gizi (URL: /admin/edukasi-gizi)
        Route::get('/edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.index');
        Route::get('/data-edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.alias');
        Route::post('/edukasi-gizi', [AdminEdukasiGiziController::class, 'store'])->name('admin.edukasi.store');
        Route::put('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update');
        Route::post('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update.post');
        Route::delete('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'destroy'])->name('admin.edukasi.destroy');

        // Pengelolaan Pengukuran dan Status Gizi Anak (PBI-016 / F-06)
        // Acceptance Criteria: Admin memilih pengguna dan anak, lalu mengisi hasil pengukuran
        Route::get('/pengukuran-anak', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.index');
        Route::get('/tumbuh-kembang-anak', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.tumbuh-kembang');
        Route::get('/data-tumbuh-kembang', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.alias');
        Route::post('/pengukuran-anak', [AdminPengukuranAnakController::class, 'store'])->name('admin.pengukuran.store');
        // PBI-018: Edit & Update pengukuran
        Route::get('/pengukuran-anak/{id}/edit', [AdminPengukuranAnakController::class, 'edit'])->name('admin.pengukuran.edit');
        Route::put('/pengukuran-anak/{id}', [AdminPengukuranAnakController::class, 'update'])->name('admin.pengukuran.update');
        Route::post('/pengukuran-anak/{id}/update', [AdminPengukuranAnakController::class, 'update'])->name('admin.pengukuran.update.post');
        Route::delete('/pengukuran-anak/{id}', [AdminPengukuranAnakController::class, 'destroy'])->name('admin.pengukuran.destroy');
    });

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
