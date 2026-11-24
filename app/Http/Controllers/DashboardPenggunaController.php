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
            $kehamilanAktif = $user->kehamilanAktif ?: Kehamilan::where('user_id', $user->id)
                ->where('status', 'berlangsung')
                ->latest()
                ->first();
        }

        if (!$kehamilanAktif) {
            $kehamilanAktif = Kehamilan::where('status', 'berlangsung')->latest()->first();
        }

        // PBI-015: Sinkronisasi Riwayat Pemeriksaan Terkini dari Database
        $pemeriksaanTerbaru = $kehamilanAktif && method_exists($kehamilanAktif, 'pemeriksaans') ? $kehamilanAktif->pemeriksaans()->first() : ($user && method_exists($user, 'pemeriksaanKehamilans') ? $user->pemeriksaanKehamilans()->first() : null);
        $riwayatPemeriksaan = $kehamilanAktif && method_exists($kehamilanAktif, 'pemeriksaans') ? $kehamilanAktif->pemeriksaans()->take(6)->get() : ($user && method_exists($user, 'pemeriksaanKehamilans') ? $user->pemeriksaanKehamilans()->take(6)->get() : collect());

        if ($kehamilanAktif && $kehamilanAktif->hpht) {
            $calc = PregnancyCalculatorService::hitungLengkap($kehamilanAktif->hpht);
            $kehamilanStatus = [
                'trimester' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->trimester : $calc['trimester']['nomor'],
                'trimesterLabel' => $calc['trimester']['label'],
                'minggu' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->usia_gestasi_minggu : $calc['usia_minggu'],
                'hari' => $calc['usia_hari'],
                'hpl' => $calc['hpl_formatted'],
                'sisaHari' => $calc['sisa_hari'],
                'persentase' => (int) $calc['persentase'],
                'ukuranJanin' => $calc['milestone']['nama'] . ' (' . $calc['milestone']['panjang'] . ', ' . $calc['milestone']['berat'] . ')',
                'beratBadan' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->perubahan_bb !== null
                    ? ($pemeriksaanTerbaru->perubahan_bb >= 0 ? '+' : '') . $pemeriksaanTerbaru->perubahan_bb . ' kg'
                    : '+6.5 kg',
                'targetBb' => '11.5 - 16 kg',
                'tensi' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->tekanan_darah . ' mmHg' : '115 / 75 mmHg',
                'kepatuhanTtd' => '21 / 30 Hari',
                'kehamilanId' => $kehamilanAktif->id,
            ];
        } else {
            // Fallback status
            $kehamilanStatus = [
                'trimester' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->trimester : 2,
                'trimesterLabel' => 'Trimester 2 (14–27 Mg)',
                'minggu' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->usia_gestasi_minggu : 24,
                'hari' => 3,
                'hpl' => $kehamilanAktif && $kehamilanAktif->hpl ? Carbon::parse($kehamilanAktif->hpl)->translatedFormat('d F Y') : '28 September 2026',
                'sisaHari' => $kehamilanAktif && $kehamilanAktif->hpl ? max(0, Carbon::now()->diffInDays(Carbon::parse($kehamilanAktif->hpl), false)) : 112,
                'persentase' => 60,
                'ukuranJanin' => 'Jagung Manis (±30 cm, 600 gram)',
                'beratBadan' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->perubahan_bb !== null
                    ? ($pemeriksaanTerbaru->perubahan_bb >= 0 ? '+' : '') . $pemeriksaanTerbaru->perubahan_bb . ' kg'
                    : '+6.5 kg',
                'targetBb' => '11.5 - 16 kg',
                'tensi' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->tekanan_darah . ' mmHg' : '115 / 75 mmHg',
                'kepatuhanTtd' => '21 / 30 Hari',
                'kehamilanId' => $kehamilanAktif ? $kehamilanAktif->id : null,
            ];
        }

        $jadwalTerdekat = [
            'nama' => 'Antenatal Care (ANC) & Kontrol Rutin',
            'dokter' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->nakes ? $pemeriksaanTerbaru->nakes->name : 'dr. Linda Sp.OG — RSIA Bunda Sehat Jakarta',
            'hariTanggal' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->tgl_kontrol_berikutnya
                ? Carbon::parse($pemeriksaanTerbaru->tgl_kontrol_berikutnya)->translatedFormat('l, j F Y')
                : 'Sabtu, 28 Oktober 2025',
            'waktu' => '09:30 - 10:15 WIB (Sesi Pagi)',
            'sisaHari' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->tgl_kontrol_berikutnya
                ? (Carbon::now()->startOfDay()->diffInDays(Carbon::parse($pemeriksaanTerbaru->tgl_kontrol_berikutnya)->startOfDay(), false) >= 0
                    ? Carbon::now()->startOfDay()->diffInDays(Carbon::parse($pemeriksaanTerbaru->tgl_kontrol_berikutnya)->startOfDay(), false) . ' Hari Lagi'
                    : 'Hari Ini')
                : '4 Hari Lagi',
            'nomorAntrean' => 'B-08',
            'status' => 'Terkonfirmasi',
            'proteinUrin' => 'Negatif (-)',
            'glukosaPuasa' => '88 mg/dL',
            'detakJantung' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->djj ? $pemeriksaanTerbaru->djj . ' bpm' : '142 bpm',
        ];

        return view('DashboardPengguna.index', [
            'user' => $user,
            'userName' => $userName,
            'userId' => $userId,
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Melati II',
            'kehamilanStatus' => $kehamilanStatus,
            'kehamilanAktif' => $kehamilanAktif,
            'jadwalTerdekat' => $jadwalTerdekat,
            'riwayatPemeriksaan' => $riwayatPemeriksaan,
            'pemeriksaanTerbaru' => $pemeriksaanTerbaru,
        ]);
    }
}
