<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Khusus Admin & Tenaga Kesehatan (Faskes).
     */
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Data admin / nakes fallback untuk demonstrasi jika belum ada sesi
        $adminName = $user ? $user->name : 'dr. Sarah Nakes (Admin Faskes)';
        $adminEmail = $user ? $user->email : 'admin@nutrigrow.id';
        $adminRole = $user && $user->role === 'nakes' ? 'Tenaga Kesehatan (Bidan/Dokter)' : 'Administrator Faskes';
        $faskesName = $user && $user->faskes_name ? $user->faskes_name : 'Puskesmas Kecamatan Tebet & Posyandu Melati';
        $nipStr = $user && $user->nip_str ? $user->nip_str : 'STR-19880412-2023-019';

        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        // Statistik agregat pemantauan gizi & stunting
        $statistics = [
            'total_balita' => 1248,
            'balita_normal' => 1178, // 94.4%
            'balita_stunting' => 42,   // 3.4%
            'balita_gizi_kurang' => 28, // 2.2%
            'ibu_hamil_dipantau' => 315,
            'kunjungan_bulan_ini' => 482,
            'faskes_terintegrasi' => 'SatuSehat Kemenkes RI (Aktif)',
        ];

        // Daftar pemantauan balita terkini
        $recentChildren = [
            [
                'id' => 'BLT-0821',
                'nama' => 'Muhammad Kenzo Ardiansyah',
                'usia' => '14 Bulan',
                'nama_ibu' => 'Ibu Rina Sastrawan',
                'bb' => '10.2 kg',
                'tb' => '78.5 cm',
                'status_gizi' => 'Optimal / Sesuai Kurva WHO',
                'status_badge' => 'emerald',
                'posyandu' => 'Posyandu Mawar I',
                'terakhir_periksa' => 'Hari ini, 08:45 WIB',
            ],
            [
                'id' => 'BLT-0822',
                'nama' => 'Aisyah Putri Azzahra',
                'usia' => '9 Bulan',
                'nama_ibu' => 'Ibu Siti Aminah',
                'bb' => '6.8 kg',
                'tb' => '66.0 cm',
                'status_gizi' => 'Risiko Stunting (Perlu PMT)',
                'status_badge' => 'amber',
                'posyandu' => 'Posyandu Melati II',
                'terakhir_periksa' => 'Hari ini, 09:15 WIB',
            ],
            [
                'id' => 'BLT-0823',
                'nama' => 'Rafa Danendra',
                'usia' => '22 Bulan',
                'nama_ibu' => 'Ibu Dian Pratiwi',
                'bb' => '11.8 kg',
                'tb' => '85.2 cm',
                'status_gizi' => 'Optimal / Sesuai Kurva WHO',
                'status_badge' => 'emerald',
                'posyandu' => 'Puskesmas Tebet Barat',
                'terakhir_periksa' => 'Kemarin, 14:10 WIB',
            ],
            [
                'id' => 'BLT-0824',
                'nama' => 'Zhafira Humaira',
                'usia' => '6 Bulan',
                'nama_ibu' => 'Ibu Anita Wijaya',
                'bb' => '7.4 kg',
                'tb' => '64.8 cm',
                'status_gizi' => 'Optimal (Transisi MPASI)',
                'status_badge' => 'blue',
                'posyandu' => 'Posyandu Melati II',
                'terakhir_periksa' => 'Kemarin, 10:30 WIB',
            ],
            [
                'id' => 'BLT-0825',
                'nama' => 'Bintang Al-Ghifari',
                'usia' => '18 Bulan',
                'nama_ibu' => 'Ibu Maya Lestari',
                'bb' => '8.9 kg',
                'tb' => '76.0 cm',
                'status_gizi' => 'Gizi Kurang (Intervensi Puskesmas)',
                'status_badge' => 'rose',
                'posyandu' => 'Posyandu Teratai III',
                'terakhir_periksa' => '06 Nov 2026',
            ],
        ];

        return view('DashboardAdmin.index', compact(
            'adminName',
            'adminEmail',
            'adminRole',
            'faskesName',
            'nipStr',
            'tanggalHariIni',
            'statistics',
            'recentChildren'
        ));
    }
}

