<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\RiwayatTumbuhKembang;
use App\Services\StatusGiziCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class TumbuhKembangAnakController extends Controller
{
    /**
     * Menampilkan halaman Riwayat Tumbuh Kembang Anak.
     * PBI-017: Menghitung Umur dan Status Gizi Anak secara Otomatis.
     */
    public function index(Request $request)
    {
        $user       = Auth::user();
        $userName   = $user ? $user->name : 'Sarah Rahmawati';
        $userId     = $user ? 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT' : 'NGW-88291-JKT';

        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');
        $today          = Carbon::now()->format('Y-m-d');

        // ============================================================
        // 1. Ambil Data Anak â€” Filter berdasarkan user yang login
        //    PBI-017 AC #1: Hitung umur otomatis dari tanggal lahir
        // ============================================================
        $anakList = [];

        if (Schema::hasTable('anaks') && Anak::count() > 0) {
            // Jika login sebagai user, tampilkan hanya anak miliknya
            // Jika admin/nakes (atau tidak login), tampilkan semua
            $query = Anak::query();
            if ($user && $user->role === 'user') {
                $query->where('user_id', $user->id);
            }
            $dbAnaks = $query->get();

            foreach ($dbAnaks as $a) {
                // PBI-017: Hitung umur otomatis (bukan hardcoded)
                $tglLahir = $a->tanggal_lahir ? $a->tanggal_lahir->format('Y-m-d') : '2022-01-01';
                $umurData = StatusGiziCalculator::hitungUmur($tglLahir, $today);

                $anakList[] = [
                    'id'            => $a->id,
                    'nama'          => $a->nama,
                    'usia'          => $umurData['label'],
                    'usia_bulan'    => $umurData['bulan'],
                    'nik'           => $a->nik ?? '-',
                    'jenis_kelamin' => $a->jenis_kelamin,
                    'tanggal_lahir' => $a->tanggal_lahir
                        ? $a->tanggal_lahir->translatedFormat('d F Y')
                        : '-',
                    'tgl_lahir_raw' => $tglLahir,
                    'status_gizi'   => $a->status_gizi ?? 'Batita Aktif & Sehat',
                ];
            }
        }

        // Fallback data demo jika tabel masih kosong
        if (empty($anakList)) {
            $umur1 = StatusGiziCalculator::hitungUmur('2022-02-14', $today);
            $umur2 = StatusGiziCalculator::hitungUmur('2020-04-12', $today);
            $anakList = [
                [
                    'id'            => 1,
                    'nama'          => 'Aisyah Putri Rahmawati',
                    'usia'          => $umur1['label'],
                    'usia_bulan'    => $umur1['bulan'],
                    'nik'           => '3171056508210002',
                    'jenis_kelamin' => 'Perempuan',
                    'tanggal_lahir' => '14 Februari 2022',
                    'tgl_lahir_raw' => '2022-02-14',
                    'status_gizi'   => 'Batita Aktif & Sehat',
                ],
                [
                    'id'            => 2,
                    'nama'          => 'Muhammad Rayyan Rahmawati',
                    'usia'          => $umur2['label'],
                    'usia_bulan'    => $umur2['bulan'],
                    'nik'           => '3171051204200001',
                    'jenis_kelamin' => 'Laki-Laki',
                    'tanggal_lahir' => '12 April 2020',
                    'tgl_lahir_raw' => '2020-04-12',
                    'status_gizi'   => 'Balita Sehat & Normal',
                ],
            ];
        }

        $selectedAnakId = $request->query('anak_id', $anakList[0]['id']);
        $selectedAnak   = collect($anakList)->firstWhere('id', (int) $selectedAnakId) ?? $anakList[0];

        // ============================================================
        // 2. Ambil Catatan Pemantauan + Hitung Ulang Status Gizi
        //    PBI-017 AC #2: Status gizi ditentukan otomatis (Permenkes No.2/2020)
        // ============================================================
        $catatanPemantauan = [];

        if (Schema::hasTable('riwayat_tumbuh_kembang')) {
            $dbRiwayat = RiwayatTumbuhKembang::where('anak_id', $selectedAnak['id'])
                ->orderBy('tanggal_pemeriksaan', 'desc')
                ->get();

            foreach ($dbRiwayat as $r) {
                $tgl     = Carbon::parse($r->tanggal_pemeriksaan);
                $tglRaw  = $r->tanggal_pemeriksaan->format('Y-m-d');

                // PBI-017: Hitung ulang umur saat pengukuran (akurat)
                $umurSaatUkur = StatusGiziCalculator::hitungUmur(
                    $selectedAnak['tgl_lahir_raw'],
                    $tglRaw
                );

                // PBI-017: Hitung ulang status gizi dengan Permenkes No.2/2020
                $giziCalc = StatusGiziCalculator::hitungStatusGizi(
                    $umurSaatUkur['bulan'],
                    (float) $r->berat_badan,
                    (float) $r->tinggi_badan,
                    $selectedAnak['jenis_kelamin']
                );

                $catatanPemantauan[] = [
                    'id'               => $r->id,
                    'tanggal'          => $tgl->translatedFormat('d F Y'),
                    'raw_date'         => $tglRaw,
                    // Usia dihitung otomatis (bukan dari kolom usia_bulan yang tersimpan)
                    'usia'             => $umurSaatUkur['label'],
                    'usia_bulan_num'   => $umurSaatUkur['bulan'],
                    // Status dari Permenkes No.2/2020
                    'status_badge'     => $giziCalc['status_pertumbuhan'],
                    'status_type'      => $giziCalc['status_type'],
                    'status_bb_u'      => $giziCalc['status_bb_u'],
                    'status_tb_u'      => $giziCalc['status_tb_u'],
                    'bb'               => number_format($r->berat_badan, 1) . ' kg',
                    'tb'               => number_format($r->tinggi_badan, 1) . ' cm',
                    'lk'               => $r->lingkar_kepala ? number_format($r->lingkar_kepala, 1) . ' cm' : '-',
                    'lila'             => $r->lingkar_lengan_atas ? number_format($r->lingkar_lengan_atas, 1) . ' cm' : '-',
                    'bb_num'           => (float) $r->berat_badan,
                    'tb_num'           => (float) $r->tinggi_badan,
                    'lk_num'           => (float) $r->lingkar_kepala,
                    'lila_num'         => (float) $r->lingkar_lengan_atas,
                    'catatan'          => $r->catatan_klinis,
                    'tenaga_kesehatan' => $r->nama_nakes,
                    'faskes'           => $r->faskes_pemeriksa,
                    // Z-Score dihitung otomatis Permenkes No.2/2020
                    'z_score_bb_u'     => $giziCalc['z_score_bb_u'] . ' (' . $giziCalc['status_bb_u'] . ')',
                    'z_score_tb_u'     => $giziCalc['z_score_tb_u'] . ' (' . $giziCalc['status_tb_u'] . ')',
                    'z_score_bb_tb'    => $giziCalc['z_score_bb_u'],
                    'rekomendasi'      => $giziCalc['rekomendasi'],
                    'referensi'        => $giziCalc['referensi'],
                    'kpsp_status'      => $r->kpsp_status,
                    'imunisasi'        => $r->imunisasi,
                    'vit_a'            => $r->vitamin_a,
                    'obat_cacing'      => $r->obat_cacing,
                ];
            }
        }

        // Fallback data demo jika database kosong
        if (empty($catatanPemantauan)) {
            $demoData = [
                ['2024-05-14', '2022-02-14', 12.4, 88.5, 47.8, 15.6, 'Bdn. Siti Nurhaliza, S.Tr.Keb', 'Posyandu Melati 3 & Puskesmas Sejahtera', 'Perkembangan motorik kasar dan halus sangat baik. Mampu menyusun balok 6 tingkat.', 'Sesuai Umur (10 dari 10)', 'Lengkap + booster PCV', 'Kapsul Merah (Feb 2024)', 'Telah Diberikan'],
                ['2024-02-12', '2022-02-14', 11.8, 86.0, 47.2, 15.4, 'dr. Budi Santoso, Sp.A', 'Puskesmas Sejahtera (Poli Anak)', 'Evaluasi tumbuh kembang usia 2 tahun lengkap. Tumbuh kembang optimal.', 'Sesuai Umur (9 dari 9)', 'DPT-HB-Hib 4 Booster', 'Kapsul Merah 200.000 IU', 'Diberikan Albendazole 200mg'],
                ['2023-11-10', '2022-02-14', 11.1, 83.5, 46.8, 15.2, 'Bdn. Siti Nurhaliza, S.Tr.Keb', 'Posyandu Melati 3', 'Nafsu makan stabil, pola tidur teratur. Stimulasi bicara berjalan lancar.', 'Sesuai Umur', 'Campak Rubella Booster', 'Sudah (Agustus 2023)', '-'],
                ['2023-08-15', '2022-02-14', 10.5, 81.0, 46.2, 14.9, 'Kader Posyandu Melati 3', 'Posyandu Melati 3', 'Kenaikan BB sedikit di bawah garis oranye. Telah diberikan konseling PMT.', 'Meragukan (evaluasi 2 minggu)', 'DPT Booster 18 Bulan', 'Kapsul Merah 200.000 IU', 'Diberikan Albendazole'],
            ];

            foreach ($demoData as $i => [$tglUkur, $tglLahir, $bb, $tb, $lk, $lila, $nakes, $faskes, $catatan, $kpsp, $imun, $vita, $obat]) {
                $umurCalc = StatusGiziCalculator::hitungUmur($tglLahir, $tglUkur);
                $giziCalc = StatusGiziCalculator::hitungStatusGizi($umurCalc['bulan'], $bb, $tb, 'Perempuan');
                $catatanPemantauan[] = [
                    'id'               => $i + 1,
                    'tanggal'          => Carbon::parse($tglUkur)->translatedFormat('d F Y'),
                    'raw_date'         => $tglUkur,
                    'usia'             => $umurCalc['label'],
                    'usia_bulan_num'   => $umurCalc['bulan'],
                    'status_badge'     => $giziCalc['status_pertumbuhan'],
                    'status_type'      => $giziCalc['status_type'],
                    'status_bb_u'      => $giziCalc['status_bb_u'],
                    'status_tb_u'      => $giziCalc['status_tb_u'],
                    'bb'               => $bb . ' kg',
                    'tb'               => $tb . ' cm',
                    'lk'               => $lk . ' cm',
                    'lila'             => $lila . ' cm',
                    'bb_num'           => $bb,
                    'tb_num'           => $tb,
                    'lk_num'           => $lk,
                    'lila_num'         => $lila,
                    'catatan'          => $catatan,
                    'tenaga_kesehatan' => $nakes,
                    'faskes'           => $faskes,
                    'z_score_bb_u'     => $giziCalc['z_score_bb_u'] . ' (' . $giziCalc['status_bb_u'] . ')',
                    'z_score_tb_u'     => $giziCalc['z_score_tb_u'] . ' (' . $giziCalc['status_tb_u'] . ')',
                    'z_score_bb_tb'    => $giziCalc['z_score_bb_u'],
                    'rekomendasi'      => $giziCalc['rekomendasi'],
                    'referensi'        => $giziCalc['referensi'],
                    'kpsp_status'      => $kpsp,
                    'imunisasi'        => $imun,
                    'vit_a'            => $vita,
                    'obat_cacing'      => $obat,
                ];
            }
        }

        // ============================================================
        // 3. Ringkasan 4 Kartu Metrik Utama (dari catatan terbaru)
        //    Z-Score & Status diambil dari perhitungan Permenkes No.2/2020
        // ============================================================
        $terbaru = $catatanPemantauan[0] ?? null;

        $ringkasanMetrik = [
            'usia_terkini' => [
                'nilai'       => $selectedAnak['usia'],
                'label'       => 'Usia Terkini',
                'status'      => $selectedAnak['status_gizi'],
                'status_type' => 'success',
            ],
            'pemeriksaan_terakhir' => [
                'nilai'  => $terbaru ? $terbaru['tanggal'] : '-',
                'label'  => 'Pemeriksaan Terakhir',
                'faskes' => $terbaru ? ($terbaru['faskes'] ?? '-') : '-',
            ],
            'berat_badan' => [
                'nilai'      => $terbaru ? $terbaru['bb_num'] : '-',
                'satuan'     => 'kg',
                'label'      => 'Berat Badan (BB)',
                // Z-score diambil dari kalkulasi otomatis Permenkes No.2/2020
                'z_score'    => $terbaru ? (explode(' (', $terbaru['z_score_bb_u'])[0] ?? '-') : '-',
                'keterangan' => $terbaru ? ($terbaru['status_bb_u'] ?? '-') : '-',
                'status_type'=> $terbaru ? $terbaru['status_type'] : 'normal',
            ],
            'tinggi_badan' => [
                'nilai'      => $terbaru ? $terbaru['tb_num'] : '-',
                'satuan'     => 'cm',
                'label'      => 'Tinggi Badan (TB)',
                // Z-score diambil dari kalkulasi otomatis Permenkes No.2/2020
                'z_score'    => $terbaru ? (explode(' (', $terbaru['z_score_tb_u'])[0] ?? '-') : '-',
                'keterangan' => $terbaru ? ($terbaru['status_tb_u'] ?? '-') : '-',
                'status_type'=> $terbaru ? $terbaru['status_type'] : 'normal',
            ],
        ];

        // ============================================================
        // 4. Titik Grafik Pertumbuhan Berkala (dari data real terbaru)
        // ============================================================
        $grafikLabels = [];
        $grafikBB     = [];
        $grafikTB     = [];
        $grafikWHOBB  = [];
        $grafikWHOTB  = [];

        // Susun data grafik dari catatan (urut terlama ke terbaru)
        $catatanUrut = array_reverse($catatanPemantauan);
        foreach ($catatanUrut as $c) {
            $grafikLabels[] = $c['usia_bulan_num'] . ' Bln';
            $grafikBB[]     = $c['bb_num'];
            $grafikTB[]     = $c['tb_num'];
            // Median WHO untuk BB & TB (dari tabel standar)
            $grafikWHOBB[]  = $this->getWhoMedianBB($c['usia_bulan_num'], $selectedAnak['jenis_kelamin']);
            $grafikWHOTB[]  = $this->getWhoMedianTB($c['usia_bulan_num'], $selectedAnak['jenis_kelamin']);
        }

        // Fallback grafik jika kosong
        if (empty($grafikLabels)) {
            $grafikLabels = ['18 Bln', '21 Bln', '24 Bln', '27 Bln'];
            $grafikBB     = [10.5, 11.1, 11.8, 12.4];
            $grafikTB     = [81.0, 83.5, 86.0, 88.5];
            $grafikWHOBB  = [10.9, 11.5, 11.5, 12.1];
            $grafikWHOTB  = [80.7, 83.7, 86.4, 88.3];
        }

        $grafikPertumbuhan = [
            'labels'       => $grafikLabels,
            'berat_badan'  => ['anak' => $grafikBB, 'who_median' => $grafikWHOBB],
            'tinggi_badan' => ['anak' => $grafikTB, 'who_median' => $grafikWHOTB],
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

    /**
     * Ambil median BB/U WHO sesuai jenis kelamin dan usia (bulan).
     */
    private function getWhoMedianBB(int $bulan, string $jenisKelamin): float
    {
        // Median BB perempuan & laki-laki WHO 2006 (bulan => median kg)
        $medianPerempuan = [
            0=>3.2,1=>4.2,2=>5.1,3=>5.8,4=>6.4,5=>6.9,6=>7.3,7=>7.6,8=>7.9,9=>8.2,
            10=>8.5,11=>8.7,12=>8.9,13=>9.2,14=>9.4,15=>9.6,16=>9.8,17=>10.0,18=>10.2,
            19=>10.4,20=>10.6,21=>10.9,22=>11.1,23=>11.3,24=>11.5,25=>11.7,26=>11.9,
            27=>12.1,28=>12.3,29=>12.5,30=>12.7,31=>12.9,32=>13.1,33=>13.3,34=>13.5,
            35=>13.7,36=>13.9,37=>14.1,38=>14.3,39=>14.5,40=>14.7,41=>14.9,42=>15.1,
            43=>15.3,44=>15.5,45=>15.7,46=>16.0,47=>16.2,48=>16.4,49=>16.6,50=>16.8,
            51=>17.1,52=>17.3,53=>17.5,54=>17.8,55=>18.0,56=>18.2,57=>18.5,58=>18.7,
            59=>18.9,60=>19.2
        ];
        $medianLaki = [
            0=>3.3,1=>4.5,2=>5.6,3=>6.4,4=>7.0,5=>7.5,6=>7.9,7=>8.3,8=>8.6,9=>8.9,
            10=>9.2,11=>9.4,12=>9.6,13=>9.9,14=>10.1,15=>10.3,16=>10.5,17=>10.7,18=>10.9,
            19=>11.1,20=>11.3,21=>11.5,22=>11.8,23=>12.0,24=>12.2,25=>12.4,26=>12.5,
            27=>12.7,28=>12.9,29=>13.1,30=>13.3,31=>13.5,32=>13.7,33=>13.8,34=>14.0,
            35=>14.2,36=>14.3,37=>14.5,38=>14.7,39=>14.9,40=>15.1,41=>15.3,42=>15.5,
            43=>15.7,44=>15.8,45=>16.0,46=>16.2,47=>16.4,48=>16.6,49=>16.8,50=>17.0,
            51=>17.2,52=>17.4,53=>17.5,54=>17.7,55=>17.9,56=>18.1,57=>18.3,58=>18.5,
            59=>18.7,60=>18.9
        ];
        $b = min(60, max(0, $bulan));
        $tabel = stripos($jenisKelamin, 'laki') !== false ? $medianLaki : $medianPerempuan;
        return $tabel[$b] ?? 12.0;
    }

    /**
     * Ambil median TB/U WHO sesuai jenis kelamin dan usia (bulan).
     */
    private function getWhoMedianTB(int $bulan, string $jenisKelamin): float
    {
        $medianPerempuan = [
            0=>49.1,1=>53.7,2=>57.1,3=>59.8,4=>62.1,5=>64.0,6=>65.7,7=>67.3,8=>68.7,9=>70.1,
            10=>71.5,11=>72.8,12=>74.0,13=>75.2,14=>76.4,15=>77.5,16=>78.6,17=>79.7,18=>80.7,
            19=>81.7,20=>82.7,21=>83.7,22=>84.6,23=>85.5,24=>86.4,25=>87.4,26=>88.3,27=>89.1,
            28=>89.9,29=>90.7,30=>91.5,31=>92.4,32=>93.2,33=>94.0,34=>94.7,35=>95.5,36=>96.1,
            37=>96.9,38=>97.6,39=>98.4,40=>99.1,41=>99.9,42=>100.6,43=>101.4,44=>102.1,
            45=>102.9,46=>103.6,47=>104.3,48=>105.0,49=>105.8,50=>106.5,51=>107.2,52=>107.9,
            53=>108.7,54=>109.4,55=>110.1,56=>110.8,57=>111.5,58=>112.2,59=>112.9,60=>113.6
        ];
        $medianLaki = [
            0=>49.9,1=>54.7,2=>58.4,3=>61.4,4=>63.9,5=>65.9,6=>67.6,7=>69.2,8=>70.6,9=>72.0,
            10=>73.3,11=>74.5,12=>75.7,13=>76.9,14=>78.0,15=>79.1,16=>80.2,17=>81.2,18=>82.3,
            19=>83.2,20=>84.2,21=>85.1,22=>86.0,23=>86.9,24=>87.8,25=>88.0,26=>88.8,27=>89.6,
            28=>90.4,29=>91.2,30=>91.9,31=>92.7,32=>93.4,33=>94.2,34=>94.9,35=>95.6,36=>96.1,
            37=>96.9,38=>97.6,39=>98.4,40=>99.1,41=>99.7,42=>100.4,43=>101.1,44=>101.8,
            45=>102.5,46=>103.2,47=>103.8,48=>104.5,49=>105.2,50=>105.8,51=>106.5,52=>107.1,
            53=>107.8,54=>108.4,55=>109.1,56=>109.7,57=>110.4,58=>111.0,59=>111.7,60=>112.0
        ];
        $b = min(60, max(0, $bulan));
        $tabel = stripos($jenisKelamin, 'laki') !== false ? $medianLaki : $medianPerempuan;
        return $tabel[$b] ?? 85.0;
    }
}
