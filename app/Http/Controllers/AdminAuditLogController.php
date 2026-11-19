<?php

namespace App\Http\Controllers;

use App\Models\AdminActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuditLogController extends Controller
{
    /**
     * Pastikan pengguna adalah Super Admin resmi (PBI-030 AC 2: Log hanya dapat dilihat oleh Super Admin).
     */
    protected function ensureSuperAdmin()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'Silakan masuk sebagai Super Administrator terlebih dahulu.']);
        }

        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            abort(403, 'Akses Ditolak: Fitur Log Aktivitas dan Audit hanya dapat diakses oleh Super Administrator.');
        }

        if (($user->status ?? 'active') === 'inactive') {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'Akun Super Admin Anda dinonaktifkan. Silakan hubungi pengelola sistem.']);
        }

        return null;
    }

    /**
     * Dapatkan user admin aktif.
     */
    protected function getActiveAdmin(): User
    {
        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return Auth::user();
        }

        return User::firstOrCreate(
            ['email' => 'superadmin@nutrigrow.id'],
            [
                'name' => 'dr. Siti Nurhaliza, Sp.A',
                'password' => bcrypt('password123'),
                'role' => 'superadmin',
                'faskes_name' => 'Kementerian Kesehatan RI & NutriGrow Central',
                'nip_str' => 'STR-19880412-2023-019',
                'phone' => '081122334455',
                'jabatan' => 'Super Administrator / Dokter Spesialis Anak',
                'status' => 'active',
            ]
        );
    }

    /**
     * Tampilkan halaman log aktivitas dan audit administrator (PBI-030).
     */
    public function index(Request $request)
    {
        if ($redirect = $this->ensureSuperAdmin()) {
            return $redirect;
        }

        $currentAdmin = $this->getActiveAdmin();
        Carbon::setLocale('id');

        $this->ensureDemoLogs();

        $query = AdminActivityLog::with(['user', 'targetUser'])->latest();

        // Pencarian teks (pelaku, target, deskripsi, email)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('actor_name', 'like', "%{$search}%")
                  ->orWhere('actor_email', 'like', "%{$search}%")
                  ->orWhere('target_name', 'like', "%{$search}%")
                  ->orWhere('target_email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter jenis aksi
        if ($request->filled('action') && $request->action !== 'all') {
            $query->where('action', $request->action);
        }

        // Filter rentang waktu
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        $logs = $query->paginate(15)->withQueryString();

        // Statistik audit
        $totalLogs = AdminActivityLog::count();
        $logsToday = AdminActivityLog::whereDate('created_at', Carbon::today())->count();
        $totalTambahAkun = AdminActivityLog::where('action', 'TAMBAH_AKUN')->count();
        $totalUbahAkses = AdminActivityLog::whereIn('action', ['UBAH_HAK_AKSES', 'TOGGLE_STATUS'])->count();

        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        $viewName = view()->exists('DashboardSuperAdmin.LogAktivitas.index')
            ? 'DashboardSuperAdmin.LogAktivitas.index'
            : (view()->exists('DashboardAdmin.LogAktivitas.index') ? 'DashboardAdmin.LogAktivitas.index' : 'DashboardSuperAdmin.LogAktivitas.index');

        return view($viewName, [
            'currentAdmin' => $currentAdmin,
            'adminName' => $currentAdmin->name,
            'adminRole' => $currentAdmin->role_label,
            'faskesName' => $currentAdmin->faskes_name ?? 'Kementerian Kesehatan RI & NutriGrow Central',
            'tanggalHariIni' => $tanggalHariIni,
            'logs' => $logs,
            'totalLogs' => $totalLogs,
            'logsToday' => $logsToday,
            'totalTambahAkun' => $totalTambahAkun,
            'totalUbahAkses' => $totalUbahAkses,
            'selectedAction' => $request->get('action', 'all'),
            'selectedPeriod' => $request->get('period', 'all'),
            'searchQuery' => $request->get('search', ''),
        ]);
    }

    /**
     * Pastikan ada demo log jika tabel masih kosong untuk kemudahan demonstrasi pengujian.
     */
    protected function ensureDemoLogs(): void
    {
        if (AdminActivityLog::count() === 0) {
            $superadmin = $this->getActiveAdmin();

            AdminActivityLog::create([
                'user_id' => $superadmin->id,
                'actor_name' => $superadmin->name,
                'actor_email' => $superadmin->email,
                'actor_role' => 'superadmin',
                'action' => 'LOGIN_ADMIN',
                'description' => "Super Admin '{$superadmin->name}' berhasil masuk ke portal pengelola sistem NutriGrow.",
                'target_user_id' => $superadmin->id,
                'target_name' => $superadmin->name,
                'target_email' => $superadmin->email,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'created_at' => Carbon::now()->subHours(4),
            ]);

            AdminActivityLog::create([
                'user_id' => $superadmin->id,
                'actor_name' => $superadmin->name,
                'actor_email' => $superadmin->email,
                'actor_role' => 'superadmin',
                'action' => 'TAMBAH_AKUN',
                'description' => "Menambahkan akun administrator baru 'dr. Budi Setiawan, Sp.GK' dengan peran Dokter Spesialis Gizi di RSUD Tarakan Jakarta.",
                'target_name' => 'dr. Budi Setiawan, Sp.GK',
                'target_email' => 'budi.setiawan@nutrigrow.id',
                'new_values' => ['role' => 'dokter', 'status' => 'active', 'faskes' => 'RSUD Tarakan Jakarta'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'created_at' => Carbon::now()->subHours(2),
            ]);

            AdminActivityLog::create([
                'user_id' => $superadmin->id,
                'actor_name' => $superadmin->name,
                'actor_email' => $superadmin->email,
                'actor_role' => 'superadmin',
                'action' => 'UBAH_HAK_AKSES',
                'description' => "Memperbarui hak akses akun 'Bdn. Anita Rahmawati, S.Tr.Keb': Peran diubah ke Bidan Koordinator Faskes, status Aktif.",
                'target_name' => 'Bdn. Anita Rahmawati, S.Tr.Keb',
                'target_email' => 'anita.rahmawati@nutrigrow.id',
                'old_values' => ['role' => 'bidan', 'status' => 'active'],
                'new_values' => ['role' => 'bidan', 'status' => 'active', 'jabatan' => 'Bidan Koordinator'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'created_at' => Carbon::now()->subMinutes(45),
            ]);
        }
    }
}
