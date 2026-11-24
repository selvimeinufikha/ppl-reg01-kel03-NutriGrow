<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FasilitasKesehatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminDashboardController extends Controller
{
    /**
     * Dapatkan user admin yang sedang login atau fallback akun Super Admin resmi.
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
     * Halaman Dashboard Super Admin dengan gaya visual Dashboard Pengguna (PBI-028).
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->withErrors([
                'login_error' => 'Silakan masuk sebagai Super Administrator.',
            ]);
        }

        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Halaman Dashboard Super Admin hanya dapat diakses oleh Super Administrator.');
        }

        if ((Auth::user()->status ?? 'active') === 'inactive') {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors([
                'login_error' => 'Akun Anda berstatus nonaktif.',
            ]);
        }

        $currentAdmin = $this->getActiveAdmin();
        Carbon::setLocale('id');

        $query = User::whereIn('role', ['superadmin', 'admin', 'nakes', 'dokter', 'bidan', 'ahli_gizi', 'petugas']);

        // Filter pencarian
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

        // Filter Role
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Filter Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $adminList = $query->orderBy('created_at', 'desc')->get();

        // Statistik Administrator
        $totalAdmin = User::whereIn('role', ['superadmin', 'admin', 'nakes', 'dokter', 'bidan', 'ahli_gizi', 'petugas'])->count();
        $totalNakes = User::whereIn('role', ['nakes', 'dokter', 'bidan', 'ahli_gizi'])->count();
        $totalSuper = User::where('role', 'superadmin')->count();
        $totalAktif = User::whereIn('role', ['superadmin', 'admin', 'nakes', 'dokter', 'bidan', 'ahli_gizi', 'petugas'])
            ->where(function ($q) {
                $q->where('status', 'active')->orWhereNull('status');
            })->count();
        $totalFaskes = class_exists(FasilitasKesehatan::class) ? FasilitasKesehatan::count() : 12;

        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        $daftarFaskes = [
            'Puskesmas Gambir',
            'Puskesmas Menteng',
            'Puskesmas Kebayoran Baru',
            'RSUD Tarakan Jakarta',
            'RSIA Bunda Sehat',
            'Posyandu Melati II',
            'Dinas Kesehatan Provinsi DKI Jakarta',
        ];

        return view('DashboardSuperAdmin.index', [
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
            'totalFaskes' => $totalFaskes,
            'filterSearch' => $request->get('search', ''),
            'filterRole' => $request->get('role', 'all'),
            'filterStatus' => $request->get('status', 'all'),
            'daftarFaskes' => $daftarFaskes,
        ]);
    }
}
