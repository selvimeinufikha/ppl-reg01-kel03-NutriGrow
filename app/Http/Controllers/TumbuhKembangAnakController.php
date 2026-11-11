<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\RiwayatTumbuhKembang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class TumbuhKembangAnakController extends Controller
{
    /**
     * Menampilkan halaman Riwayat Tumbuh Kembang Anak (PBI-016 / F-06).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userName = $user ? $user->name : 'Sarah Rahmawati';
        $userId = $user ? 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT' : 'NGW-88291-JKT';

        Carbon::setLocale('id');
        $tanggalHariIni = 'Rabu, 24 Mei 2024';

        // 1. Ambil Data Anak (dari Database jika tersedia, atau fallback default)
        $anakList = [];
        if (Schema::hasTable('anaks') && Anak::count() > 0) {
            $dbAnaks = Anak::all();
            foreach ($dbAnaks as $a) {
                $usiaBulan = $a->tanggal_lahir ? Carbon::parse($a->tanggal_lahir)->diffInMonths(Carbon::parse('2024-05-24')) : 27;
                $tahun = floor($usiaBulan / 12);
                $bulan = $usiaBulan % 12;
                $anakList[] = [
                    'id' => $a->id,
                    'nama' => $a->nama,
                    'usia' => "{$tahun} Tahun {$bulan} Bulan",
                    'usia_bulan' => $usiaBulan,
                    'nik' => $a->nik ?? '3171056508210002',
                    'jenis_kelamin' => $a->jenis_kelamin,
                    'tanggal_lahir' => $a->tanggal_lahir ? Carbon::parse($a->tanggal_lahir)->translatedFormat('d F Y') : '14 Februari 2022',
                    'status_gizi' => $a->status_gizi ?? 'Batita Aktif & Sehat',
                ];
            }
        }

        if (empty($anakList)) {
            $anakList = [
                [
                    'id' => 1,
                    'nama' => 'Aisyah Putri Rahmawati',
                    'usia' => '2 Tahun 3 Bulan',
                    'usia_bulan' => 27,
                    'nik' => '3171056508210002',
                    'jenis_kelamin' => 'Perempuan',
                    'tanggal_lahir' => '14 Februari 2022',
                    'status_gizi' => 'Batita Aktif & Sehat',
                ],
                [
                    'id' => 2,
                    'nama' => 'Muhammad Rayyan Rahmawati',
                    'usia' => '4 Tahun 1 Bulan',
                    'usia_bulan' => 49,
                    'nik' => '3171051204200001',
                    'jenis_kelamin' => 'Laki-Laki',
                    'tanggal_lahir' => '12 April 2020',
                    'status_gizi' => 'Balita Sehat & Normal',
                ],
            ];
        }

        $selectedAnakId = $request->query('anak_id', $anakList[0]['id']);
        $selectedAnak = collect($anakList)->firstWhere('id', (int) $selectedAnakId) ?? $anakList[0];

        // 2. Ambil Catatan Pemantauan Berkala
        $catatanPemantauan = [];
        if (Schema::hasTable('riwayat_tumbuh_kembang')) {
            $dbRiwayat = RiwayatTumbuhKembang::where('anak_id', $selectedAnak['id'])
                ->orderBy('tanggal_pemeriksaan', 'desc')
                ->get();

            foreach ($dbRiwayat as $r) {
                $tgl = Carbon::parse($r->tanggal_pemeriksaan);
                $catatanPemantauan[] = [
                    'id' => $r->id,
                    'tanggal' => $tgl->translatedFormat('d F Y'),
                    'raw_date' => $r->tanggal_pemeriksaan->format('Y-m-d'),
                    'usia' => $r->usia_bulan . ' Bulan',
                    'status_badge' => $r->status_pertumbuhan,
                    'status_type' => $r->status_type ?? 'normal',
                    'bb' => number_format($r->berat_badan, 1) . ' kg',
                    'tb' => number_format($r->tinggi_badan, 1) . ' cm',
                    'lk' => $r->lingkar_kepala ? number_format($r->lingkar_kepala, 1) . ' cm' : '-',
                    'lila' => $r->lingkar_lengan_atas ? number_format($r->lingkar_lengan_atas, 1) . ' cm' : '-',
                    'bb_num' => (float) $r->berat_badan,
                    'tb_num' => (float) $r->tinggi_badan,
                    'lk_num' => (float) $r->lingkar_kepala,
                    'lila_num' => (float) $r->lingkar_lengan_atas,
                    'catatan' => $r->catatan_klinis,
                    'tenaga_kesehatan' => $r->nama_nakes,
                    'faskes' => $r->faskes_pemeriksa,
                    'z_score_bb_u' => $r->z_score_bb_u,
                    'z_score_tb_u' => $r->z_score_tb_u,
                    'z_score_bb_tb' => $r->z_score_bb_tb,
                    'kpsp_status' => $r->kpsp_status,
                    'imunisasi' => $r->imunisasi,
                    'vit_a' => $r->vitamin_a,
                    'obat_cacing' => $r->obat_cacing,
                ];
            }
        }

        // Fallback jika database belum ada isinya
        if (empty($catatanPemantauan)) {
            $catatanPemantauan = [
                [
                    'id' => 1,
                    'tanggal' => '14 Mei 2024',
                    'raw_date' => '2024-05-14',
                    'usia' => '27 Bulan',
                    'status_badge' => 'Pertumbuhan Baik & Normal',
                    'status_type' => 'normal',
                    'bb' => '12.4 kg',
                    'tb' => '88.5 cm',
                    'lk' => '47.8 cm',
                    'lila' => '15.6 cm',
                    'bb_num' => 12.4,
                    'tb_num' => 88.5,
                    'lk_num' => 47.8,
                    'lila_num' => 15.6,
                    'catatan' => 'Perkembangan motorik kasar dan halus sangat baik. Mampu menyusun balok 6 tingkat dan melompat 2 kaki mandiri. Tetap pertahankan asupan protein hewani & serat sayur.',
                    'tenaga_kesehatan' => 'Bdn. Siti Nurhaliza, S.Tr.Keb',
                    'faskes' => 'Posyandu Melati 3 & Puskesmas Sejahtera',
                    'z_score_bb_u' => '+0.2 SD (Gizi Baik)',
                    'z_score_tb_u' => '+0.1 SD (Normal)',
                    'z_score_bb_tb' => '+0.1 SD (Gizi Baik)',
                    'kpsp_status' => 'Sesuai Umur (10 dari 10 indikator terpenuhi)',
                    'imunisasi' => 'Lengkap sampai usia 2 tahun + booster PCV',
                    'vit_a' => 'Kapsul Merah (Diberikan Feb 2024)',
                    'obat_cacing' => 'Telah Diberikan',
                ],
                [
                    'id' => 2,
                    'tanggal' => '12 Februari 2024',
                    'raw_date' => '2024-02-12',
                    'usia' => '24 Bulan',
                    'status_badge' => 'Pertumbuhan Baik & Normal',
                    'status_type' => 'normal',
                    'bb' => '11.8 kg',
                    'tb' => '86.0 cm',
                    'lk' => '47.2 cm',
                    'lila' => '15.4 cm',
                    'bb_num' => 11.8,
                    'tb_num' => 86.0,
                    'lk_num' => 47.2,
                    'lila_num' => 15.4,
                    'catatan' => 'Evaluasi tumbuh kembang usia 2 tahun lengkap. Imunisasi lanjutan DPT-HB-Hib 4 tercatat. Tumbuh kembang optimal, nafsu makan aktif.',
                    'tenaga_kesehatan' => 'dr. Budi Santoso, Sp.A',
                    'faskes' => 'Puskesmas Sejahtera (Poli Anak)',
                    'z_score_bb_u' => '+0.1 SD (Gizi Baik)',
                    'z_score_tb_u' => '-0.1 SD (Normal)',
                    'z_score_bb_tb' => '+0.2 SD (Gizi Baik)',
                    'kpsp_status' => 'Sesuai Umur (9 dari 9 indikator)',
                    'imunisasi' => 'DPT-HB-Hib 4 (Lanjutan Booster)',
                    'vit_a' => 'Kapsul Merah 200.000 IU',
                    'obat_cacing' => 'Diberikan Albendazole 200mg',
                ],
                [
                    'id' => 3,
                    'tanggal' => '10 November 2023',
                    'raw_date' => '2023-11-10',
                    'usia' => '21 Bulan',
                    'status_badge' => 'Pertumbuhan Baik & Normal',
                    'status_type' => 'normal',
                    'bb' => '11.1 kg',
                    'tb' => '83.5 cm',
                    'lk' => '46.8 cm',
                    'lila' => '15.2 cm',
                    'bb_num' => 11.1,
                    'tb_num' => 83.5,
                    'lk_num' => 46.8,
                    'lila_num' => 15.2,
                    'catatan' => 'Nafsu makan stabil, pola tidur teratur. Stimulasi bicara berjalan lancar, respon pendengaran tajam, konsumsi air putih cukup.',
                    'tenaga_kesehatan' => 'Bdn. Siti Nurhaliza, S.Tr.Keb',
                    'faskes' => 'Posyandu Melati 3',
                    'z_score_bb_u' => '+0.1 SD (Gizi Baik)',
                    'z_score_tb_u' => '-0.1 SD (Normal)',
                    'z_score_bb_tb' => '+0.0 SD (Gizi Baik)',
                    'kpsp_status' => 'Sesuai Umur',
                    'imunisasi' => 'Campak Rubella (MR) Booster',
                    'vit_a' => 'Sudah dapat periode Agustus 2023',
                    'obat_cacing' => '-',
                ],
                [
                    'id' => 4,
                    'tanggal' => '15 Agustus 2023',
                    'raw_date' => '2023-08-15',
                    'usia' => '18 Bulan',
                    'status_badge' => 'Perlu Pantauan Berat (Kuning)',
                    'status_type' => 'warning',
                    'bb' => '10.5 kg',
                    'tb' => '81.0 cm',
                    'lk' => '46.2 cm',
                    'lila' => '14.9 cm',
                    'bb_num' => 10.5,
                    'tb_num' => 81.0,
                    'lk_num' => 46.2,
                    'lila_num' => 14.9,
                    'catatan' => 'Kenaikan BB sedikit di bawah garis oranye (KMS) pasca batuk pilek ringan. Telah diberikan konseling PMT kaya protein hewani (telur & ikan) dan vitamin penambah nafsu makan.',
                    'tenaga_kesehatan' => 'Kader Posyandu & Pendamping Gizi Melati 3',
                    'faskes' => 'Posyandu Melati 3',
                    'z_score_bb_u' => '-1.6 SD (Risiko Berat Badan Kurang)',
                    'z_score_tb_u' => '+0.1 SD (Normal)',
                    'z_score_bb_tb' => '-1.2 SD (Normal Bawah)',
                    'kpsp_status' => 'Meragukan di aspek motorik kasar pasca demam, evaluasi ulang 2 minggu',
                    'imunisasi' => 'DPT Booster 18 Bulan',
                    'vit_a' => 'Kapsul Merah 200.000 IU',
                    'obat_cacing' => 'Diberikan Albendazole',
                ],
            ];
        }

        // 3. Ringkasan 4 Kartu Metrik Utama (Diambil dari catatan terbaru)
        $terbaru = $catatanPemantauan[0] ?? null;

        $ringkasanMetrik = [
            'usia_terkini' => [
                'nilai' => $selectedAnak['usia'],
                'label' => 'Usia Terkini',
                'status' => $selectedAnak['status_gizi'],
                'status_type' => 'success',
            ],
            'pemeriksaan_terakhir' => [
                'nilai' => $terbaru ? $terbaru['tanggal'] : '14 Mei 2024',
                'label' => 'Pemeriksaan Terakhir',
                'faskes' => $terbaru ? ($terbaru['faskes'] ?? 'Posyandu Melati 3') : 'Posyandu Melati 3',
            ],
            'berat_badan' => [
                'nilai' => $terbaru ? $terbaru['bb_num'] : '12.4',
                'satuan' => 'kg',
                'label' => 'Berat Badan (BB)',
                'z_score' => '+0.2 SD',
                'keterangan' => 'Normal (Sesuai Kurva WHO)',
                'status_type' => 'success',
            ],
            'tinggi_badan' => [
                'nilai' => $terbaru ? $terbaru['tb_num'] : '88.5',
                'satuan' => 'cm',
                'label' => 'Tinggi Badan (TB)',
                'z_score' => '+0.1 SD',
                'keterangan' => 'Normal (Bebas Stunting)',
                'status_type' => 'success',
            ],
        ];

        // 4. Titik Grafik Pertumbuhan Berkala
        $grafikPertumbuhan = [
            'labels' => ['6 Bln', '12 Bln', '18 Bln', '21 Bln', '24 Bln', '27 Bln (Kini)'],
            'berat_badan' => [
                'anak' => [7.3, 8.9, 10.5, 11.1, 11.8, 12.4],
                'who_median' => [7.3, 8.9, 10.2, 10.9, 11.5, 12.2],
            ],
            'tinggi_badan' => [
                'anak' => [65.7, 74.0, 81.0, 83.5, 86.0, 88.5],
                'who_median' => [65.7, 74.0, 80.7, 83.7, 86.4, 88.3],
            ],
        ];

        return view('DashboardPengguna.tumbuh-kembang-anak', compact(
            'user',
            'userName',
            'userId',
            'tanggalHariIni',
            'anakList',
            'selectedAnak',
            'ringkasanMetrik',
            'grafikPertumbuhan',
            'catatanPemantauan'
        ));
    }
}
