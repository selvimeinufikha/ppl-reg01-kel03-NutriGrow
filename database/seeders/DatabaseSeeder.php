<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anak;
use App\Models\RiwayatTumbuhKembang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin NutriGrow Health Platform
        User::updateOrCreate(
            ['email' => 'admin@nutrigrow.id'],
            [
                'name' => 'dr. Sarah Nakes (Admin Faskes)',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'faskes_name' => 'Puskesmas Kecamatan Tebet & NutriGrow Health',
                'nip_str' => 'STR-19880412-2023-019',
                'phone' => '081234567890',
            ]
        );

        // 2. Petugas Puskesmas / Tenaga Kesehatan
        User::updateOrCreate(
            ['email' => 'petugas@puskesmas.go.id'],
            [
                'name' => 'Bidan Nurul Fitriah, S.Tr.Keb',
                'password' => Hash::make('admin123'),
                'role' => 'nakes',
                'faskes_name' => 'Puskesmas Pembina Jakarta Selatan',
                'nip_str' => 'NIP-199205162019032008',
                'phone' => '081298765432',
            ]
        );

        // 3. Pengguna / Akun Keluarga (Orang Tua)
        $userIbu = User::updateOrCreate(
            ['email' => 'ibu.anita@nutrigrow.id'],
            [
                'name' => 'Ibu Anita Rahmawati',
                'password' => Hash::make('password'),
                'role' => 'user',
                'faskes_name' => 'Posyandu Melati II',
                'phone' => '085712345678',
            ]
        );

        // 4. Akun Pengujian Pengguna (Arya)
        $userArya = User::updateOrCreate(
            ['email' => 'aku123@gmail.com'],
            [
                'name' => 'Arya',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'faskes_name' => 'Posyandu Mawar 1 & Puskesmas Sejahtera',
                'phone' => '081234567899',
            ]
        );

        // 5. Data Anak (Sesuai Mockup Figma)
        $anak1 = Anak::updateOrCreate(
            ['nik' => '3171056508210002'],
            [
                'user_id' => $userIbu->id,
                'nama' => 'Aisyah Putri Rahmawati',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2022-02-14',
                'status_gizi' => 'Batita Aktif & Sehat',
            ]
        );

        $anak2 = Anak::updateOrCreate(
            ['nik' => '3171051204200001'],
            [
                'user_id' => $userIbu->id,
                'nama' => 'Muhammad Rayyan Rahmawati',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2020-04-12',
                'status_gizi' => 'Balita Sehat & Normal',
            ]
        );

        // 6. Data Riwayat Tumbuh Kembang (4 Catatan Sesuai Figma)
        $riwayats = [
            [
                'anak_id' => $anak1->id,
                'tanggal_pemeriksaan' => '2024-05-14',
                'usia_bulan' => 27,
                'berat_badan' => 12.4,
                'tinggi_badan' => 88.5,
                'lingkar_kepala' => 47.8,
                'lingkar_lengan_atas' => 15.6,
                'z_score_bb_u' => '+0.2 SD (Gizi Baik)',
                'z_score_tb_u' => '+0.1 SD (Normal)',
                'z_score_bb_tb' => '+0.1 SD (Gizi Baik)',
                'status_pertumbuhan' => 'Pertumbuhan Baik & Normal',
                'status_type' => 'normal',
                'catatan_klinis' => 'Perkembangan motorik kasar dan halus sangat baik. Mampu menyusun balok 6 tingkat dan melompat 2 kaki mandiri. Tetap pertahankan asupan protein hewani & serat sayur.',
                'nama_nakes' => 'Bdn. Siti Nurhaliza, S.Tr.Keb',
                'faskes_pemeriksa' => 'Posyandu Melati 3 & Puskesmas Sejahtera',
                'kpsp_status' => 'Sesuai Umur (10 dari 10 indikator terpenuhi)',
                'imunisasi' => 'Lengkap sampai usia 2 tahun + booster PCV',
                'vitamin_a' => 'Kapsul Merah (Diberikan Feb 2024)',
                'obat_cacing' => 'Telah Diberikan',
            ],
            [
                'anak_id' => $anak1->id,
                'tanggal_pemeriksaan' => '2024-02-12',
                'usia_bulan' => 24,
                'berat_badan' => 11.8,
                'tinggi_badan' => 86.0,
                'lingkar_kepala' => 47.2,
                'lingkar_lengan_atas' => 15.4,
                'z_score_bb_u' => '+0.1 SD (Gizi Baik)',
                'z_score_tb_u' => '-0.1 SD (Normal)',
                'z_score_bb_tb' => '+0.2 SD (Gizi Baik)',
                'status_pertumbuhan' => 'Pertumbuhan Baik & Normal',
                'status_type' => 'normal',
                'catatan_klinis' => 'Evaluasi tumbuh kembang usia 2 tahun lengkap. Imunisasi lanjutan DPT-HB-Hib 4 tercatat. Tumbuh kembang optimal, nafsu makan aktif.',
                'nama_nakes' => 'dr. Budi Santoso, Sp.A',
                'faskes_pemeriksa' => 'Puskesmas Sejahtera (Poli Anak)',
                'kpsp_status' => 'Sesuai Umur (9 dari 9 indikator)',
                'imunisasi' => 'DPT-HB-Hib 4 (Lanjutan Booster)',
                'vitamin_a' => 'Kapsul Merah 200.000 IU',
                'obat_cacing' => 'Diberikan Albendazole 200mg',
            ],
            [
                'anak_id' => $anak1->id,
                'tanggal_pemeriksaan' => '2023-11-10',
                'usia_bulan' => 21,
                'berat_badan' => 11.1,
                'tinggi_badan' => 83.5,
                'lingkar_kepala' => 46.8,
                'lingkar_lengan_atas' => 15.2,
                'z_score_bb_u' => '+0.1 SD (Gizi Baik)',
                'z_score_tb_u' => '-0.1 SD (Normal)',
                'z_score_bb_tb' => '+0.0 SD (Gizi Baik)',
                'status_pertumbuhan' => 'Pertumbuhan Baik & Normal',
                'status_type' => 'normal',
                'catatan_klinis' => 'Nafsu makan stabil, pola tidur teratur. Stimulasi bicara berjalan lancar, respon pendengaran tajam, konsumsi air putih cukup.',
                'nama_nakes' => 'Bdn. Siti Nurhaliza, S.Tr.Keb',
                'faskes_pemeriksa' => 'Posyandu Melati 3',
                'kpsp_status' => 'Sesuai Umur',
                'imunisasi' => 'Campak Rubella (MR) Booster',
                'vitamin_a' => 'Sudah dapat periode Agustus 2023',
                'obat_cacing' => '-',
            ],
            [
                'anak_id' => $anak1->id,
                'tanggal_pemeriksaan' => '2023-08-15',
                'usia_bulan' => 18,
                'berat_badan' => 10.5,
                'tinggi_badan' => 81.0,
                'lingkar_kepala' => 46.2,
                'lingkar_lengan_atas' => 14.9,
                'z_score_bb_u' => '-1.6 SD (Risiko Berat Badan Kurang)',
                'z_score_tb_u' => '+0.1 SD (Normal)',
                'z_score_bb_tb' => '-1.2 SD (Normal Bawah)',
                'status_pertumbuhan' => 'Perlu Pantauan Berat (Kuning)',
                'status_type' => 'warning',
                'catatan_klinis' => 'Kenaikan BB sedikit di bawah garis oranye (KMS) pasca batuk pilek ringan. Telah diberikan konseling PMT kaya protein hewani (telur & ikan) dan vitamin penambah nafsu makan.',
                'nama_nakes' => 'Kader Posyandu & Pendamping Gizi Melati 3',
                'faskes_pemeriksa' => 'Posyandu Melati 3',
                'kpsp_status' => 'Meragukan di aspek motorik kasar pasca demam, evaluasi ulang 2 minggu',
                'imunisasi' => 'DPT Booster 18 Bulan',
                'vitamin_a' => 'Kapsul Merah 200.000 IU',
                'obat_cacing' => 'Diberikan Albendazole',
            ],
        ];

        foreach ($riwayats as $data) {
            RiwayatTumbuhKembang::updateOrCreate(
                [
                    'anak_id' => $data['anak_id'],
                    'tanggal_pemeriksaan' => $data['tanggal_pemeriksaan'],
                ],
                $data
            );
        }
    }
}
