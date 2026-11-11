<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardPenggunaController extends Controller
{
    /**
     * Tampilkan halaman Dashboard Pengguna (Keluarga).
     */
    public function index()
    {
        $user = Auth::user();
        $userName = $user ? $user->name : 'Ibu Sarah Rahmawati';
        $userId = $user ? 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT' : 'NGW-88291-JKT';

        // Tanggal real-time otomatis berbahasa Indonesia
        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        return view('DashboardPengguna.index', [
            'user' => $user,
            'userName' => $userName,
            'userId' => $userId,
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Melati II',
            'kehamilanStatus' => [
                'trimester' => 2,
                'minggu' => 24,
                'hari' => 3,
                'hpl' => '18 Februari 2026',
                'sisaHari' => 112,
                'persentase' => 60,
                'ukuranJanin' => 'Jagung Manis (±30 cm, 600 gram)',
                'beratBadan' => '+6.5 kg',
                'targetBb' => '11.5 - 16 kg',
                'tensi' => '115 / 75 mmHg',
                'kepatuhanTtd' => '21 / 30 Hari',
            ],
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

