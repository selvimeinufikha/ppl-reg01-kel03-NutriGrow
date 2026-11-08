<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $tanggalHariIni = 'Rabu, 24 Mei 2024'; // Sesuai referensi Figma mockup atau real-time format

        // Data Profil Anak yang Dipantau
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

        $selectedAnakId = $request->query('anak_id', 1);
        $selectedAnak = collect($anakList)->firstWhere('id', (int) $selectedAnakId) ?? $anakList[0];

        // Ringkasan 4 Kartu Metrik Utama
        $ringkasanMetrik = [
            'usia_terkini' => [
                'nilai' => '2 Tahun 3 Bulan',
                'label' => 'Usia Terkini',
                'status' => 'Batita Aktif & Sehat',
                'status_type' => 'success',
            ],
            'pemeriksaan_terakhir' => [
                'nilai' => '14 Mei 2024',
                'label' => 'Pemeriksaan Terakhir',
                'faskes' => 'Posyandu Melati 3',
            ],
            'berat_badan' => [
                'nilai' => '12.4',
                'satuan' => 'kg',
                'label' => 'Berat Badan (BB)',
                'z_score' => '+0.2 SD',
                'keterangan' => 'Normal (Sesuai Kurva WHO)',
                'status_type' => 'success',
            ],
            'tinggi_badan' => [
                'nilai' => '88.5',
                'satuan' => 'cm',
                'label' => 'Tinggi Badan (TB)',
                'z_score' => '+0.1 SD',
                'keterangan' => 'Normal (Bebas Stunting)',
                'status_type' => 'success',
            ],
        ];

        // Data Titik Grafik Pertumbuhan Berkala
        $grafikPertumbuhan = [
            'labels' => ['6 Bln', '12 Bln', '18 Bln', '21 Bln', '24 Bln', '27 Bln (Kini)'],
            'berat_badan' => [
                'anak' => [7.3, 8.9, 10.5, 11.1, 11.8, 12.4],
                'who_median' => [7.3, 8.9, 10.2, 10.9, 11.5, 12.2],
                'who_minus_2sd' => [6.1, 7.4, 8.6, 9.2, 9.7, 10.3],
                'who_plus_2sd' => [8.8, 10.6, 12.2, 13.0, 13.8, 14.6],
            ],
            'tinggi_badan' => [
                'anak' => [65.7, 74.0, 81.0, 83.5, 86.0, 88.5],
                'who_median' => [65.7, 74.0, 80.7, 83.7, 86.4, 88.3],
                'who_minus_2sd' => [61.2, 68.9, 75.3, 78.0, 80.5, 82.3],
                'who_plus_2sd' => [70.1, 79.1, 86.1, 89.4, 92.3, 94.3],
            ],
        ];

        // 4 Catatan Pemantauan Berkala (Sesuai Figma Screenshot 3 & 4)
        $catatanPemantauan = [
            [
                'id' => 1,
                'tanggal' => '14 Mei 2024',
                'raw_date' => '2024-05-14',
                'usia' => '27 Bulan',
                'status_badge' => 'Pertumbuhan Baik & Normal',
                'status_type' => 'normal', // normal | warning | danger
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
