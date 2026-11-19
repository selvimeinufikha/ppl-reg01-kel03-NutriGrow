<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminEdukasiGiziController;
use App\Http\Controllers\AdminFasilitasKesehatanController;
use App\Http\Controllers\AdminManajemenAkunController;
use App\Http\Controllers\DashboardPenggunaController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\PasanganController;

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

// Dashboard Dinamis (Mengarahkan sesuai peran pengguna: Super Admin, Pegawai/Nakes, atau Pengguna)
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();

    if (($user->status ?? 'active') === 'inactive') {
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'login_error' => 'Akun Anda dinonaktifkan.',
        ]);
    }

    if ($user->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    }

    if ($user->isStaffOrAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard.pengguna');
})->name('dashboard');

// =========================================================================
// 2. WEBSITE SUPER ADMIN (Portal Pengelola Sistem & Kementerian/Dinkes)
// =========================================================================
Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/manajemen-akun', [AdminManajemenAkunController::class, 'index'])->name('akun.index');
    Route::get('/manajemen-akun/tambah', [AdminManajemenAkunController::class, 'create'])->name('akun.create');
    Route::post('/manajemen-akun', [AdminManajemenAkunController::class, 'store'])->name('akun.store');
    Route::get('/manajemen-akun/{id}/edit', [AdminManajemenAkunController::class, 'edit'])->name('akun.edit');
    Route::put('/manajemen-akun/{id}', [AdminManajemenAkunController::class, 'update'])->name('akun.update');
    Route::post('/manajemen-akun/{id}', [AdminManajemenAkunController::class, 'update'])->name('akun.update.post');
    Route::post('/manajemen-akun/{id}/toggle-status', [AdminManajemenAkunController::class, 'toggleStatus'])->name('akun.toggle-status');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::get('/dashboard-superadmin', function () {
    return redirect()->route('superadmin.dashboard');
})->name('dashboard.superadmin');

// Rute Data Pasangan (PBI-001, PBI-002, PBI-003: Kelola Data Pasangan)
if (class_exists(PasanganController::class)) {
    Route::prefix('data-pasangan')->name('pasangan.')->group(function () {
        Route::get('/', [PasanganController::class, 'index'])->name('index');
        Route::get('/tambah', [PasanganController::class, 'create'])->name('create');
        Route::post('/', [PasanganController::class, 'store'])->name('store');
        Route::get('/{id}', [PasanganController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PasanganController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PasanganController::class, 'update'])->name('update');
        Route::delete('/{id}', [PasanganController::class, 'destroy'])->name('destroy');
    });
}


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

    // Data Edukasi Gizi: Lihat & Tambah Artikel (PBI-019)
    // URL: GET  /admin/edukasi-gizi  → tampilkan daftar artikel
    // URL: POST /admin/edukasi-gizi  → simpan artikel baru
    Route::get('/edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.index');
    Route::get('/data-edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.alias');
    Route::post('/edukasi-gizi', [AdminEdukasiGiziController::class, 'store'])->name('admin.edukasi.store');

    // Data Edukasi Gizi: Ubah & Hapus Artikel (PBI-020)
    // URL: PUT    /admin/edukasi-gizi/{id}  → perbarui artikel
    // URL: POST   /admin/edukasi-gizi/{id}  → perbarui artikel (alias untuk browser yang tidak support PUT)
    // URL: DELETE /admin/edukasi-gizi/{id}  → hapus artikel
    Route::put('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update');
    Route::post('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update.post');
    Route::delete('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'destroy'])->name('admin.edukasi.destroy');

    // Data Edukasi Gizi: Atur Status Publikasi (PBI-021)
    // URL: POST /admin/edukasi-gizi/{id}/toggle-status → toggle terbit/draft langsung dari tabel
    Route::post('/edukasi-gizi/{id}/toggle-status', [AdminEdukasiGiziController::class, 'toggleStatus'])->name('admin.edukasi.toggle-status');

    // Data Layanan Kesehatan: Tambah Fasilitas (PBI-022)
    // URL: GET  /admin/layanan-kesehatan  → tampilkan direktori fasilitas kesehatan
    // URL: POST /admin/layanan-kesehatan  → simpan fasilitas kesehatan baru
    Route::get('/layanan-kesehatan', [AdminFasilitasKesehatanController::class, 'index'])->name('admin.fasilitas.index');
    Route::get('/data-layanan-kesehatan', [AdminFasilitasKesehatanController::class, 'index'])->name('admin.fasilitas.alias');
    Route::post('/layanan-kesehatan', [AdminFasilitasKesehatanController::class, 'store'])->name('admin.fasilitas.store');

    // Data Layanan Kesehatan: Ubah & Hapus Fasilitas (PBI-023)
    // URL: PUT    /admin/layanan-kesehatan/{id}  → perbarui fasilitas kesehatan
    // URL: POST   /admin/layanan-kesehatan/{id}  → perbarui fasilitas (alias kompatibilitas browser)
    // URL: DELETE /admin/layanan-kesehatan/{id}  → hapus fasilitas kesehatan
    Route::put('/layanan-kesehatan/{id}', [AdminFasilitasKesehatanController::class, 'update'])->name('admin.fasilitas.update');
    Route::post('/layanan-kesehatan/{id}', [AdminFasilitasKesehatanController::class, 'update'])->name('admin.fasilitas.update.post');
    Route::delete('/layanan-kesehatan/{id}', [AdminFasilitasKesehatanController::class, 'destroy'])->name('admin.fasilitas.destroy');

    // Manajemen Akun Admin: Tambah Akun Administrator (PBI-028) & Kelola Hak Akses (PBI-029)
    Route::get('/manajemen-akun', [AdminManajemenAkunController::class, 'index'])->name('admin.akun.index');
    Route::get('/manajemen-akun/tambah', [AdminManajemenAkunController::class, 'create'])->name('admin.akun.create');
    Route::post('/manajemen-akun', [AdminManajemenAkunController::class, 'store'])->name('admin.akun.store');
    Route::get('/manajemen-akun/{id}/edit', [AdminManajemenAkunController::class, 'edit'])->name('admin.akun.edit');
    Route::put('/manajemen-akun/{id}', [AdminManajemenAkunController::class, 'update'])->name('admin.akun.update');
    Route::post('/manajemen-akun/{id}', [AdminManajemenAkunController::class, 'update'])->name('admin.akun.update.post');
    Route::post('/manajemen-akun/{id}/toggle-status', [AdminManajemenAkunController::class, 'toggleStatus'])->name('admin.akun.toggle-status');

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
