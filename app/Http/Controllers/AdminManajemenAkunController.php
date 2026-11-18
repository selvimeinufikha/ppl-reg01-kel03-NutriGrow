<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FasilitasKesehatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AdminManajemenAkunController extends Controller
{
    /**
     * Dapatkan user admin yang sedang aktif atau fallback ke user demo.
     */
    protected function getActiveAdmin(): User
    {
        if (Auth::check() && Auth::user()->isStaffOrAdmin()) {
            return Auth::user();
        }

        return User::firstOrCreate(
            ['email' => 'admin@nutrigrow.id'],
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
     * Tampilkan halaman utama Manajemen Akun Administrator & Nakes (PBI-028).
     */
    public function index(Request $request)
    {
        $currentAdmin = $this->getActiveAdmin();
        Carbon::setLocale('id');

        // Pastikan ada beberapa akun contoh jika masih kosong untuk demonstrasi testing
        $this->ensureDemoAccounts();

        $query = User::whereIn('role', ['superadmin', 'admin', 'nakes', 'dokter', 'bidan', 'ahli_gizi', 'petugas']);

        // Filter Pencarian (Nama, Email, NIP/STR, Faskes)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip_str', 'like', "%{$search}%")
                  ->orWhere('faskes_name', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        // Filter Berdasarkan Role / Hak Akses
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Filter Berdasarkan Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $adminList = $query->orderBy('created_at', 'desc')->get();

        // Hitung statistik ringkas
        $totalAdmin = User::whereIn('role', ['superadmin', 'admin', 'nakes', 'dokter', 'bidan', 'ahli_gizi', 'petugas'])->count();
        $totalNakes = User::whereIn('role', ['nakes', 'dokter', 'bidan', 'ahli_gizi'])->count();
        $totalSuper = User::where('role', 'superadmin')->count();
        $totalAktif = User::whereIn('role', ['superadmin', 'admin', 'nakes', 'dokter', 'bidan', 'ahli_gizi', 'petugas'])
            ->where(function ($q) {
                $q->where('status', 'active')->orWhereNull('status');
            })->count();

        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        $viewName = view()->exists('DashboardSuperAdmin.ManajemenAkun.index')
            ? 'DashboardSuperAdmin.ManajemenAkun.index'
            : (view()->exists('DashboardSuperAdmin.index') ? 'DashboardSuperAdmin.index' : 'DashboardAdmin.ManajemenAkun.index');

        return view($viewName, [
            'currentAdmin' => $currentAdmin,
            'adminName' => $currentAdmin->name,
            'adminRole' => $currentAdmin->role_label,
            'faskesName' => $currentAdmin->faskes_name ?? 'Kementerian Kesehatan RI',
            'tanggalHariIni' => $tanggalHariIni,
            'adminList' => $adminList,
            'totalAdmin' => $totalAdmin,
            'totalNakes' => $totalNakes,
            'totalSuper' => $totalSuper,
            'totalAktif' => $totalAktif,
            'filterSearch' => $request->get('search', ''),
            'filterRole' => $request->get('role', 'all'),
            'filterStatus' => $request->get('status', 'all'),
        ]);
    }

    /**
     * Tampilkan formulir tambah akun administrator baru (PBI-028).
     */
    public function create()
    {
        $currentAdmin = $this->getActiveAdmin();
        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        // Daftar faskes untuk opsi dropdown cepat
        $daftarFaskes = [
            'Puskesmas Gambir',
            'Puskesmas Menteng',
            'Puskesmas Kebayoran Baru',
            'RSUD Tarakan Jakarta',
            'RSIA Bunda Sehat',
            'Posyandu Melati II',
            'Dinas Kesehatan Provinsi DKI Jakarta',
        ];

        $viewName = view()->exists('DashboardSuperAdmin.ManajemenAkun.create')
            ? 'DashboardSuperAdmin.ManajemenAkun.create'
            : 'DashboardAdmin.ManajemenAkun.create';

        return view($viewName, [
            'currentAdmin' => $currentAdmin,
            'adminName' => $currentAdmin->name,
            'adminRole' => $currentAdmin->role_label,
            'faskesName' => $currentAdmin->faskes_name ?? 'Kementerian Kesehatan RI',
            'tanggalHariIni' => $tanggalHariIni,
            'daftarFaskes' => $daftarFaskes,
        ]);
    }

    /**
     * Simpan akun administrator/nakes baru ke database (PBI-028).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:superadmin,admin,nakes,dokter,bidan,ahli_gizi'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'faskes_name' => ['required', 'string', 'max:255'],
            'nip_str' => ['nullable', 'string', 'max:50'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'in:active,inactive'],
        ], [
            'name.required' => 'Nama lengkap dan gelar administrator wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar untuk pengguna lain.',
            'role.required' => 'Hak akses / peran pengguna wajib dipilih.',
            'role.in' => 'Hak akses yang dipilih tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'faskes_name.required' => 'Fasilitas kesehatan penugasan wajib diisi.',
        ]);

        $newUser = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'faskes_name' => trim($validated['faskes_name']),
            'nip_str' => !empty($validated['nip_str']) ? trim($validated['nip_str']) : null,
            'jabatan' => !empty($validated['jabatan']) ? trim($validated['jabatan']) : null,
            'phone' => !empty($validated['phone']) ? trim($validated['phone']) : null,
            'status' => $validated['status'] ?? 'active',
        ]);

        $redirectRoute = request()->routeIs('superadmin.*') || request()->is('superadmin/*')
            ? (Route::has('superadmin.akun.index') ? 'superadmin.akun.index' : 'admin.akun.index')
            : 'admin.akun.index';

        return redirect()->route($redirectRoute)
            ->with('success', "Akun administrator baru '{$newUser->name}' ({$newUser->role_label}) berhasil didaftarkan ke sistem!");
    }

    /**
     * Pastikan akun contoh admin tersedia untuk eksplorasi.
     */
    protected function ensureDemoAccounts(): void
    {
        if (User::whereIn('role', ['admin', 'nakes', 'dokter', 'bidan'])->count() < 3) {
            User::firstOrCreate(
                ['email' => 'bidan.anita@nutrigrow.id'],
                [
                    'name' => 'Bdn. Anita Rahmawati, S.Tr.Keb',
                    'password' => bcrypt('password123'),
                    'role' => 'bidan',
                    'faskes_name' => 'Puskesmas Gambir',
                    'nip_str' => 'STR-19920815-2022-044',
                    'phone' => '081234567891',
                    'jabatan' => 'Bidan Koordinator KIA',
                    'status' => 'active',
                ]
            );

            User::firstOrCreate(
                ['email' => 'ahli.gizi@nutrigrow.id'],
                [
                    'name' => 'Dimas Maulana, S.Gz',
                    'password' => bcrypt('password123'),
                    'role' => 'ahli_gizi',
                    'faskes_name' => 'Puskesmas Menteng',
                    'nip_str' => 'STR-19950311-2023-088',
                    'phone' => '081298765431',
                    'jabatan' => 'Nutrisionis Pelaksana Lanjutan',
                    'status' => 'active',
                ]
            );

            User::firstOrCreate(
                ['email' => 'admin.faskes@nutrigrow.id'],
                [
                    'name' => 'Hendra Setiawan, S.Kom',
                    'password' => bcrypt('password123'),
                    'role' => 'admin',
                    'faskes_name' => 'RSUD Tarakan Jakarta',
                    'nip_str' => 'NIP-19850720-2010-001',
                    'phone' => '081345678910',
                    'jabatan' => 'Administrator Sistem Informasi Kesehatan',
                    'status' => 'active',
                ]
            );
        }
    }
}
