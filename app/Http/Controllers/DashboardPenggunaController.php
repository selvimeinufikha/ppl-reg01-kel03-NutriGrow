<?php

namespace App\Http\Controllers;

use App\Models\Kehamilan;
use App\Models\User;
use App\Services\PregnancyCalculatorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPenggunaController extends Controller
{
    /**
     * Tampilkan halaman Dashboard Pengguna (Keluarga).
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            $user = User::where('email', 'sarah@nutrigrow.id')->first();
        }

        $userName = $user ? $user->name : 'Ibu Sarah Rahmawati';
        $userId = $user ? 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT' : 'NGW-88291-JKT';

        // Tanggal real-time otomatis berbahasa Indonesia
        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        // Ambil data kehamilan aktif yang sedang berlangsung
        $kehamilanAktif = null;
        if ($user) {
            $kehamilanAktif = Kehamilan::where('user_id', $user->id)
                ->where('status', 'berlangsung')
                ->latest()
                ->first();
        }

        if (!$kehamilanAktif) {
            $kehamilanAktif = Kehamilan::where('status', 'berlangsung')->latest()->first();
        }

        if ($kehamilanAktif) {
            $calc = PregnancyCalculatorService::hitungLengkap($kehamilanAktif->hpht);
            $kehamilanStatus = [
                'trimester' => $calc['trimester']['nomor'],
                'trimesterLabel' => $calc['trimester']['label'],
                'minggu' => $calc['usia_minggu'],
                'hari' => $calc['usia_hari'],
                'hpl' => $calc['hpl_formatted'],
                'sisaHari' => $calc['sisa_hari'],
                'persentase' => (int) $calc['persentase'],
                'ukuranJanin' => $calc['milestone']['nama'] . ' (' . $calc['milestone']['panjang'] . ', ' . $calc['milestone']['berat'] . ')',
                'beratBadan' => '+6.5 kg',
                'targetBb' => '11.5 - 16 kg',
                'tensi' => '115 / 75 mmHg',
                'kepatuhanTtd' => '21 / 30 Hari',
                'kehamilanId' => $kehamilanAktif->id,
            ];
        } else {
            // Default fallback status
            $kehamilanStatus = [
                'trimester' => 2,
                'trimesterLabel' => 'Trimester 2 (14–27 Mg)',
                'minggu' => 24,
                'hari' => 3,
                'hpl' => '28 September 2026',
                'sisaHari' => 112,
                'persentase' => 60,
                'ukuranJanin' => 'Jagung Manis (±30 cm, 600 gram)',
                'beratBadan' => '+6.5 kg',
                'targetBb' => '11.5 - 16 kg',
                'tensi' => '115 / 75 mmHg',
                'kepatuhanTtd' => '21 / 30 Hari',
                'kehamilanId' => null,
            ];
        }

        return view('DashboardPengguna.index', [
            'user' => $user,
            'userName' => $userName,
            'userId' => $userId,
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Melati II',
            'kehamilanStatus' => $kehamilanStatus,
            'kehamilanAktif' => $kehamilanAktif,
            'jadwalTerdekat' => [
                'nama' => 'Antenatal Care (ANC Ke-4) & USG Rutin',
                'dokter' => 'dr. Linda Sp.OG — RSIA Bunda Sehat Jakarta',
                'hariTanggal' => 'Sabtu, 28 Oktober 2025',
                'waktu' => '09:30 - 10:15 WIB (Sesi Pagi)',
                'sisaHari' => '4 Hari Lagi',
                'nomorAntrean' => 'B-08',
                'status' => 'Terkonfirmasi',
                'proteinUrin' => 'Negatif (-)',
                'glukosaPuasa' => '88 mg/dL',
                'detakJantung' => '142 bpm',
            ],
        ]);
    }
}
