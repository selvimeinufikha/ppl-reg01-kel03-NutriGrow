<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminEdukasiGiziController;
use App\Http\Controllers\AdminFasilitasKesehatanController;
use App\Http\Controllers\AdminManajemenAkunController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\AdminAuditLogController;
use App\Http\Controllers\DashboardPenggunaController;
use App\Http\Controllers\PasanganController;
use App\Http\Controllers\KehamilanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminPengukuranAnakController;
use App\Http\Controllers\TumbuhKembangAnakController;
use App\Http\Controllers\AnakController;
use App\Services\StatusGiziCalculator;
use App\Models\Anak;
use App\Http\Controllers\InformasiNutrisiController;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi NutriGrow
|--------------------------------------------------------------------------
| Pemisahan terstruktur dan independen antara:
| 1. Website Pengguna / Orang Tua (User Portal)
| 2. Website Super Admin (Superadmin Portal)
| 3. Website Admin & Tenaga Kesehatan (Admin & Nakes Portal)
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

    if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    }

    if (method_exists($user, 'isStaffOrAdmin') && $user->isStaffOrAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard.pengguna');
})->name('dashboard');

// Dashboard Pengguna (Keluarga & Orang Tua) — hanya role: user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard-pengguna', [DashboardPenggunaController::class, 'index'])->name('dashboard.pengguna');

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
});

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
    // Log Aktivitas & Audit Administrator (PBI-030)
    Route::get('/log-aktivitas', [AdminAuditLogController::class, 'index'])->name('log.index');
    Route::get('/log-aktivitas/export-pdf', [AdminAuditLogController::class, 'exportPdf'])->name('log.export-pdf');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::get('/dashboard-superadmin', function () {
    return redirect()->route('superadmin.dashboard');
})->name('dashboard.superadmin');

// =========================================================================
// 3. WEBSITE ADMIN (Portal Khusus Faskes & Tenaga Kesehatan)
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

        // Data Edukasi Gizi: Lihat & Tambah Artikel (PBI-019)
        Route::get('/edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.index');
        Route::get('/data-edukasi-gizi', [AdminEdukasiGiziController::class, 'index'])->name('admin.edukasi.alias');
        Route::post('/edukasi-gizi', [AdminEdukasiGiziController::class, 'store'])->name('admin.edukasi.store');

        // Data Edukasi Gizi: Ubah & Hapus Artikel (PBI-020)
        Route::put('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update');
        Route::post('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'update'])->name('admin.edukasi.update.post');
        Route::delete('/edukasi-gizi/{id}', [AdminEdukasiGiziController::class, 'destroy'])->name('admin.edukasi.destroy');

        // Data Edukasi Gizi: Atur Status Publikasi (PBI-021)
        Route::post('/edukasi-gizi/{id}/toggle-status', [AdminEdukasiGiziController::class, 'toggleStatus'])->name('admin.edukasi.toggle-status');

        // Data Layanan Kesehatan: Tambah Fasilitas (PBI-022)
        Route::get('/layanan-kesehatan', [AdminFasilitasKesehatanController::class, 'index'])->name('admin.fasilitas.index');
        Route::get('/data-layanan-kesehatan', [AdminFasilitasKesehatanController::class, 'index'])->name('admin.fasilitas.alias');
        Route::post('/layanan-kesehatan', [AdminFasilitasKesehatanController::class, 'store'])->name('admin.fasilitas.store');

        // Data Layanan Kesehatan: Ubah & Hapus Fasilitas (PBI-023)
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

        // Log Aktivitas & Audit Administrator (PBI-030)
        Route::get('/log-aktivitas', [AdminAuditLogController::class, 'index'])->name('admin.log.index');
        Route::get('/log-aktivitas/export-pdf', [AdminAuditLogController::class, 'exportPdf'])->name('admin.log.export-pdf');

        // Pengelolaan Pengukuran dan Status Gizi Anak (PBI-016 / F-06)
        Route::get('/pengukuran-anak', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.index');
        Route::get('/tumbuh-kembang-anak', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.tumbuh-kembang');
        Route::get('/data-tumbuh-kembang', [AdminPengukuranAnakController::class, 'index'])->name('admin.pengukuran.alias');
        Route::post('/pengukuran-anak', [AdminPengukuranAnakController::class, 'store'])->name('admin.pengukuran.store');
        // PBI-018: Edit & Update pengukuran
        Route::get('/pengukuran-anak/{id}/edit', [AdminPengukuranAnakController::class, 'edit'])->name('admin.pengukuran.edit');
        Route::put('/pengukuran-anak/{id}', [AdminPengukuranAnakController::class, 'update'])->name('admin.pengukuran.update');
        Route::post('/pengukuran-anak/{id}/update', [AdminPengukuranAnakController::class, 'update'])->name('admin.pengukuran.update.post');
        Route::delete('/pengukuran-anak/{id}', [AdminPengukuranAnakController::class, 'destroy'])->name('admin.pengukuran.destroy');

        // Data Informasi Nutrisi (Portal Admin / Nakes - PBI-025 & PBI-026 & PBI-027)
        Route::get('/informasi-nutrisi', [InformasiNutrisiController::class, 'index'])->name('admin.informasi-nutrisi.index');
        Route::get('/data-informasi-nutrisi', [InformasiNutrisiController::class, 'index'])->name('admin.informasi-nutrisi.alias');
        Route::get('/informasi-nutrisi/create', [InformasiNutrisiController::class, 'create'])->name('admin.informasi-nutrisi.create');
        Route::post('/informasi-nutrisi', [InformasiNutrisiController::class, 'store'])->name('admin.informasi-nutrisi.store');
        Route::get('/informasi-nutrisi/{informasi_nutrisi}', [InformasiNutrisiController::class, 'show'])->name('admin.informasi-nutrisi.show');
        Route::get('/informasi-nutrisi/{informasi_nutrisi}/edit', [InformasiNutrisiController::class, 'edit'])->name('admin.informasi-nutrisi.edit');
        Route::put('/informasi-nutrisi/{informasi_nutrisi}', [InformasiNutrisiController::class, 'update'])->name('admin.informasi-nutrisi.update');
        Route::patch('/informasi-nutrisi/{informasi_nutrisi}', [InformasiNutrisiController::class, 'update']);
        Route::delete('/informasi-nutrisi/{informasi_nutrisi}', [InformasiNutrisiController::class, 'destroy'])->name('admin.informasi-nutrisi.destroy');
    });

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

// Rute Informasi Nutrisi & Rekomendasi Gizi (PBI-025, PBI-026, PBI-027)
Route::resource('informasi-nutrisi', InformasiNutrisiController::class);
Route::get('/rekomendasi-nutrisi', [InformasiNutrisiController::class, 'index'])->name('rekomendasi-nutrisi.index');
Route::get('/admin/informasi-nutrisi/create', [InformasiNutrisiController::class, 'create'])->name('admin.informasi-nutrisi.create');
Route::post('/admin/informasi-nutrisi', [InformasiNutrisiController::class, 'store'])->name('admin.informasi-nutrisi.store');
