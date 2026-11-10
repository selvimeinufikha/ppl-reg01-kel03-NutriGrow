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

        // PBI-015: Sinkronisasi Riwayat Pemeriksaan Terkini dari Database
        $kehamilanAktif = $user ? ($user->kehamilanAktif ?: $user->kehamilans()->latest('id')->first()) : null;
        $pemeriksaanTerbaru = $kehamilanAktif ? $kehamilanAktif->pemeriksaans()->first() : ($user ? $user->pemeriksaanKehamilans()->first() : null);
        $riwayatPemeriksaan = $kehamilanAktif ? $kehamilanAktif->pemeriksaans()->take(6)->get() : ($user ? $user->pemeriksaanKehamilans()->take(6)->get() : collect());

        $kehamilanStatus = [
            'trimester' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->trimester : 2,
            'minggu' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->usia_gestasi_minggu : 24,
            'hari' => 3,
            'hpl' => $kehamilanAktif && $kehamilanAktif->hpl ? Carbon::parse($kehamilanAktif->hpl)->translatedFormat('d F Y') : '18 Februari 2026',
            'sisaHari' => $kehamilanAktif && $kehamilanAktif->hpl ? max(0, Carbon::now()->diffInDays(Carbon::parse($kehamilanAktif->hpl), false)) : 112,
            'persentase' => 60,
            'ukuranJanin' => 'Jagung Manis (±30 cm, 600 gram)',
            'beratBadan' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->perubahan_bb !== null
                ? ($pemeriksaanTerbaru->perubahan_bb >= 0 ? '+' : '') . $pemeriksaanTerbaru->perubahan_bb . ' kg'
                : '+6.5 kg',
            'targetBb' => '11.5 - 16 kg',
            'tensi' => $pemeriksaanTerbaru ? $pemeriksaanTerbaru->tekanan_darah . ' mmHg' : '115 / 75 mmHg',
            'kepatuhanTtd' => '21 / 30 Hari',
        ];

        $jadwalTerdekat = [
            'nama' => 'Antenatal Care (ANC) & Kontrol Rutin',
            'dokter' => $pemeriksaanTerbaru && $pemeriksaanTerbaru->nakes ? $pemeriksaanTerbaru->nakes->name : 'Bidan / Dokter Sp.OG Faskes',
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
            'jadwalTerdekat' => $jadwalTerdekat,
            'riwayatPemeriksaan' => $riwayatPemeriksaan,
            'pemeriksaanTerbaru' => $pemeriksaanTerbaru,
        ]);
    }
}

