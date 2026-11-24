<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\RiwayatTumbuhKembang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TumbuhKembangAnakSeeder extends Seeder
{
    /**
     * Run the database seeds matching the exact reference mockup.
     */
    public function run(): void
    {
        $nakes = User::whereIn('role', ['admin', 'nakes'])->first() ?: User::first();
        $nakesName = $nakes ? $nakes->name : 'dr. Siti Nurhaliza, Sp.A';
        $faskesName = 'Puskesmas Kecamatan Tebet & Posyandu Melati 03';

        // 6 Pasien Anak Sesuai Gambar Mockup
        $items = [
            [
                'parent_name' => 'Ny. Siti Aminah',
                'parent_email' => 'siti.aminah@gmail.com',
                'anak_nama' => 'An. Muhammad Rayyan',
                'nik' => '3171052204240001',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2024-04-15',
                'pengukuran' => [
                    'tanggal_pemeriksaan' => '2025-10-24',
                    'usia_bulan' => 18,
                    'berat_badan' => 11.2,
                    'tinggi_badan' => 82.5,
                    'lingkar_kepala' => 47.0,
                    'lingkar_lengan_atas' => 15.5,
                    'z_score_bb_u' => '+0.2 SD (Gizi Baik)',
                    'z_score_tb_u' => '+0.1 SD (Normal)',
                    'z_score_bb_tb' => '+0.2 SD',
                    'status_pertumbuhan' => 'Gizi Baik (Normal)',
                    'status_type' => 'normal',
                    'catatan_klinis' => 'Nafsu makan baik, motorik kasar dan halus sesuai tahapan usia 18 bulan.',
                    'kpsp_status' => 'Sesuai Umur (10/10)',
                    'imunisasi' => 'DPT-HB-Hib Lanjutan & Campak Rubella',
                    'vitamin_a' => 'Kapsul Merah (Agustus)',
                    'obat_cacing' => 'Sudah Diberikan',
                    'delta_bb' => '+0.4 kg (Naik)',
                    'posisi_tb' => 'Berdiri (TB)',
                    'kondisi_lk' => 'Normocephaly',
                ],
            ],
            [
                'parent_name' => 'Ny. Dewi Sartika',
                'parent_email' => 'dewi.sartika@gmail.com',
                'anak_nama' => 'An. Kenzo Pratama',
                'nik' => '3171081408240003',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2024-08-14',
                'pengukuran' => [
                    'tanggal_pemeriksaan' => '2025-10-23',
                    'usia_bulan' => 14,
                    'berat_badan' => 7.9,
                    'tinggi_badan' => 70.8,
                    'lingkar_kepala' => 44.5,
                    'lingkar_lengan_atas' => 12.0,
                    'z_score_bb_u' => '-2.4 SD (Gizi Kurang)',
                    'z_score_tb_u' => '-2.6 SD (Stunted)',
                    'z_score_bb_tb' => '-2.3 SD',
                    'status_pertumbuhan' => 'Risiko Stunting (TB/U < -2 SD)',
                    'status_type' => 'danger',
                    'catatan_klinis' => 'KRITIS: Terindikasi weight faltering 2 bulan berturut-turut. Rujukan segera ke Poli Anak Sp.A untuk intervensi PKMK/F-75.',
                    'kpsp_status' => 'Meragukan (8/10)',
                    'imunisasi' => 'PCV 3 & Polio Suntik (IPV)',
                    'vitamin_a' => 'Kapsul Merah',
                    'obat_cacing' => 'Tunda (Kondisi Khusus)',
                    'delta_bb' => '-0.2 kg (Faltering)',
                    'posisi_tb' => 'Pendek / Stunted',
                    'kondisi_lk' => 'Perlu Evaluasi',
                ],
            ],
            [
                'parent_name' => 'Ny. Ratna Sari',
                'parent_email' => 'ratna.sari@gmail.com',
                'anak_nama' => 'An. Alula Farzana',
                'nik' => '3171062010230002',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2023-10-20',
                'pengukuran' => [
                    'tanggal_pemeriksaan' => '2025-10-22',
                    'usia_bulan' => 24,
                    'berat_badan' => 12.0,
                    'tinggi_badan' => 86.4,
                    'lingkar_kepala' => 48.0,
                    'lingkar_lengan_atas' => 16.0,
                    'z_score_bb_u' => '+0.1 SD (Gizi Baik)',
                    'z_score_tb_u' => '+0.3 SD (Normal)',
                    'z_score_bb_tb' => '+0.1 SD',
                    'status_pertumbuhan' => 'Gizi Baik (Normal)',
                    'status_type' => 'normal',
                    'catatan_klinis' => 'Tumbuh kembang 2 tahun optimal. Kosakata aktif bertambah dan mandiri makan sendiri.',
                    'kpsp_status' => 'Sesuai Umur (10/10)',
                    'imunisasi' => 'Lengkap sampai 24 Bulan',
                    'vitamin_a' => 'Kapsul Merah',
                    'obat_cacing' => 'Sudah Diberikan',
                    'delta_bb' => '+0.3 kg (Naik)',
                    'posisi_tb' => 'Berdiri (TB)',
                    'kondisi_lk' => 'Normocephaly',
                ],
            ],
            [
                'parent_name' => 'Ny. Fitri Handayani',
                'parent_email' => 'fitri.handayani@gmail.com',
                'anak_nama' => 'An. Keenan Danendra',
                'nik' => '3171091504250005',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2025-04-15',
                'pengukuran' => [
                    'tanggal_pemeriksaan' => '2025-10-20',
                    'usia_bulan' => 6,
                    'berat_badan' => 7.4,
                    'tinggi_badan' => 66.0,
                    'lingkar_kepala' => 43.0,
                    'lingkar_lengan_atas' => 14.2,
                    'z_score_bb_u' => '+0.0 SD (Gizi Baik)',
                    'z_score_tb_u' => '+0.1 SD (Normal)',
                    'z_score_bb_tb' => '+0.0 SD',
                    'status_pertumbuhan' => 'Gizi Baik (Normal)',
                    'status_type' => 'normal',
                    'catatan_klinis' => 'Kenaikan Berat Minimal (KBM) tercapai (+500 gram). Konseling persiapan MP-ASI padat gizi protein hewani.',
                    'kpsp_status' => 'Sesuai Umur (10/10)',
                    'imunisasi' => 'DPT-HB-Hib 3 & Polio 4',
                    'vitamin_a' => 'Kapsul Biru (6 Bulan)',
                    'obat_cacing' => 'Belum Usia',
                    'delta_bb' => '+0.5 kg (KBM Tercapai)',
                    'posisi_tb' => 'Berbaring (PB)',
                    'kondisi_lk' => 'Normocephaly',
                ],
            ],
            [
                'parent_name' => 'Ny. Linda Permata',
                'parent_email' => 'linda.permata@gmail.com',
                'anak_nama' => 'An. Aisyah Putri',
                'nik' => '3171041201250004',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2025-01-12',
                'pengukuran' => [
                    'tanggal_pemeriksaan' => '2025-10-19',
                    'usia_bulan' => 9,
                    'berat_badan' => 6.8,
                    'tinggi_badan' => 68.2,
                    'lingkar_kepala' => 43.8,
                    'lingkar_lengan_atas' => 13.0,
                    'z_score_bb_u' => '-1.8 SD (Risiko Gizi Kurang)',
                    'z_score_tb_u' => '-1.2 SD (Normal)',
                    'z_score_bb_tb' => '-1.6 SD',
                    'status_pertumbuhan' => 'Weight Faltering (BB Tidak Naik)',
                    'status_type' => 'warning',
                    'catatan_klinis' => 'BB mendatar / tidak naik (2T). Ibu diedukasi frekuensi dan densitas energi MP-ASI (tambah santan/minyak kelapa dan telur).',
                    'kpsp_status' => 'Sesuai Umur (9/10)',
                    'imunisasi' => 'Campak-Rubella (MR)',
                    'vitamin_a' => 'Kapsul Biru',
                    'obat_cacing' => 'Belum Usia',
                    'delta_bb' => '— 0.0 kg (BB Tetap 2T)',
                    'posisi_tb' => 'Berbaring (PB)',
                    'kondisi_lk' => 'Normocephaly',
                ],
            ],
            [
                'parent_name' => 'Ny. Nurul Hidayah',
                'parent_email' => 'nurul.hidayah@gmail.com',
                'anak_nama' => 'An. Bintang Pratama',
                'nik' => '3171020508220008',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2022-08-05',
                'pengukuran' => [
                    'tanggal_pemeriksaan' => '2025-10-18',
                    'usia_bulan' => 38,
                    'berat_badan' => 17.5,
                    'tinggi_badan' => 98.0,
                    'lingkar_kepala' => 50.2,
                    'lingkar_lengan_atas' => 17.8,
                    'z_score_bb_u' => '+2.3 SD (Gizi Lebih)',
                    'z_score_tb_u' => '+0.8 SD (Normal)',
                    'z_score_bb_tb' => '+2.2 SD (Risiko Gemuk)',
                    'status_pertumbuhan' => 'Gizi Lebih / Obesitas',
                    'status_type' => 'warning',
                    'catatan_klinis' => 'Berat badan melebihi kurva median (+2 SD). Kurangi konsumsi minuman manis kemasan, tingkatkan aktivitas fisik bermain aktif.',
                    'kpsp_status' => 'Sesuai Umur (10/10)',
                    'imunisasi' => 'Lengkap Balita',
                    'vitamin_a' => 'Kapsul Merah',
                    'obat_cacing' => 'Sudah Diberikan',
                    'delta_bb' => '↑ +0.8 kg',
                    'posisi_tb' => 'Berdiri (TB)',
                    'kondisi_lk' => 'Normocephaly',
                ],
            ],
        ];

        foreach ($items as $item) {
            // 1. Pastikan orang tua ada
            $user = User::firstOrCreate(
                ['email' => $item['parent_email']],
                [
                    'name' => $item['parent_name'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                ]
            );

            // 2. Buat atau perbarui anak
            $anak = Anak::firstOrCreate(
                ['nik' => $item['nik']],
                [
                    'user_id' => $user->id,
                    'nama' => $item['anak_nama'],
                    'jenis_kelamin' => $item['jenis_kelamin'],
                    'tanggal_lahir' => $item['tanggal_lahir'],
                    'status_gizi' => $item['pengukuran']['status_pertumbuhan'],
                ]
            );

            // 3. Buat rekaman riwayat tumbuh kembang jika belum ada untuk anak & tanggal tsb
            $p = $item['pengukuran'];
            RiwayatTumbuhKembang::firstOrCreate(
                [
                    'anak_id' => $anak->id,
                    'tanggal_pemeriksaan' => $p['tanggal_pemeriksaan'],
                ],
                [
                    'usia_bulan' => $p['usia_bulan'],
                    'berat_badan' => $p['berat_badan'],
                    'tinggi_badan' => $p['tinggi_badan'],
                    'lingkar_kepala' => $p['lingkar_kepala'],
                    'lingkar_lengan_atas' => $p['lingkar_lengan_atas'],
                    'z_score_bb_u' => $p['z_score_bb_u'],
                    'z_score_tb_u' => $p['z_score_tb_u'],
                    'z_score_bb_tb' => $p['z_score_bb_tb'],
                    'status_pertumbuhan' => $p['status_pertumbuhan'],
                    'status_type' => $p['status_type'],
                    'catatan_klinis' => $p['catatan_klinis'],
                    'nama_nakes' => $nakesName,
                    'faskes_pemeriksa' => $faskesName,
                    'kpsp_status' => $p['kpsp_status'],
                    'imunisasi' => $p['imunisasi'],
                    'vitamin_a' => $p['vitamin_a'],
                    'obat_cacing' => $p['obat_cacing'],
                ]
            );
        }
    }
}

