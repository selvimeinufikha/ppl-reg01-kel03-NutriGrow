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
use App\Http\Controllers\PasanganController;
use App\Http\Controllers\KehamilanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminPengukuranAnakController;
use App\Http\Controllers\TumbuhKembangAnakController;
use App\Http\Controllers\AnakController;

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

// Rute Data Pasangan (PBI-001, PBI-002, PBI-003: Kelola Data Pasangan)
Route::prefix('data-pasangan')->name('pasangan.')->group(function () {
    Route::get('/', [PasanganController::class, 'index'])->name('index');
    Route::get('/tambah', [PasanganController::class, 'create'])->name('create');
    Route::post('/', [PasanganController::class, 'store'])->name('store');
    Route::get('/{id}', [PasanganController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PasanganController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PasanganController::class, 'update'])->name('update');
    Route::delete('/{id}', [PasanganController::class, 'destroy'])->name('destroy');
});

// Rekam Medis: Riwayat Tumbuh Kembang Anak (PBI-016 / F-06)
Route::get('/tumbuh-kembang-anak', [TumbuhKembangAnakController::class, 'index'])->name('tumbuh-kembang.index');
Route::get('/riwayat-tumbuh-kembang', [TumbuhKembangAnakController::class, 'index'])->name('riwayat-tumbuh-kembang');
Route::get('/dashboard-pengguna/tumbuh-kembang-anak', [TumbuhKembangAnakController::class, 'index'])->name('dashboard.tumbuh-kembang');

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

    // Manajemen Akun Admin: Tambah Akun Administrator (PBI-028)
    Route::get('/manajemen-akun', [AdminManajemenAkunController::class, 'index'])->name('admin.akun.index');
    Route::get('/manajemen-akun/tambah', [AdminManajemenAkunController::class, 'create'])->name('admin.akun.create');
    Route::post('/manajemen-akun', [AdminManajemenAkunController::class, 'store'])->name('admin.akun.store');

    // Pengelolaan Pengukuran dan Status Gizi Anak (PBI-016 / F-06)
    Route::get('/pengukuran-anak', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.index');
    Route::get('/tumbuh-kembang-anak', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.tumbuh-kembang');
    Route::get('/data-tumbuh-kembang', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.alias');
    Route::post('/pengukuran-anak', [AdminPengukuranAnakController::class, 'store'])->name('admin.pengukuran.store');
    Route::delete('/pengukuran-anak/{id}', [AdminPengukuranAnakController::class, 'destroy'])->name('admin.pengukuran.destroy');

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

// Rute Profil Pengguna (PBI-010: Kelola Profil Pengguna, PBI-011: Upload Foto Profil, PBI-012: Ganti Kata Sandi)
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::post('/foto', [ProfileController::class, 'uploadFoto'])->name('foto.upload');
    Route::delete('/foto', [ProfileController::class, 'hapusFoto'])->name('foto.destroy');
    Route::get('/ganti-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/ganti-password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Alias rute mandiri untuk ganti kata sandi
Route::get('/ganti-password', [ProfileController::class, 'editPassword'])->name('password.change');
Route::put('/ganti-password', [ProfileController::class, 'updatePassword'])->name('password.change.update');

// Rute Pengelolaan Data Anak (PBI-007, PBI-008, PBI-009)
Route::resource('data-anak', AnakController::class);
Route::get('/dashboard/data-anak', [AnakController::class, 'index'])->name('dashboard.data-anak');
Route::get('/daftar-anak', [AnakController::class, 'daftarAnak'])->name('daftar-anak.index');

Route::get('/data-edukasi-gizi', function () {
    return redirect()->route('admin.edukasi.index');
});
