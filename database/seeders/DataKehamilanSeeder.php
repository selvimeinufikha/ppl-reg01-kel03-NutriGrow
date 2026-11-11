<?php

namespace Database\Seeders;

use App\Models\Kehamilan;
use App\Models\Pasangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DataKehamilanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan User Sarah Rahmawati ada
        $user = User::firstOrCreate(
            ['email' => 'sarah@nutrigrow.id'],
            [
                'name' => 'Sarah Rahmawati',
                'password' => bcrypt('password123'),
            ]
        );

        // 2. Buat data Pasangan (Dimas Prasetyo)
        $pasangan = Pasangan::firstOrCreate(
            ['user_id' => $user->id, 'nama_lengkap' => 'Dimas Prasetyo'],
            [
                'nik' => '3171012304950002',
                'pekerjaan' => 'Karyawan Swasta',
                'no_telepon' => '081298765432',
                'golongan_darah' => 'O',
                'hubungan' => 'Calon Ayah',
            ]
        );

        // 3. Catat Kehamilan Ke-1 (Riwayat Selesai - Melahirkan)
        Kehamilan::firstOrCreate(
            [
                'user_id' => $user->id,
                'kehamilan_ke' => 1,
            ],
            [
                'pasangan_id' => $pasangan->id,
                'hpht' => '2022-03-15',
                'hpl' => '2022-12-20',
                'status' => 'melahirkan',
                'gravida' => 'G1P0A0',
                'tanggal_persalinan' => '2022-12-22',
                'status_persalinan' => 'Aterm (Cukup Bulan)',
                'nama_anak' => 'Kinan Pratama',
                'tinggi_badan' => 160.00,
                'berat_badan_pra_hamil' => 52.00,
                'catatan' => 'Persalinan spontan pervaginam di RSIA Bunda Sejahtera ditolong Bidan & Sp.OG. BB lahir: 3.200 gr, PB: 49 cm, APGAR 9/10.',
            ]
        );

        // 4. Catat Kehamilan Ke-2 (Sedang Berlangsung / Aktif)
        Kehamilan::firstOrCreate(
            [
                'user_id' => $user->id,
                'kehamilan_ke' => 2,
            ],
            [
                'pasangan_id' => $pasangan->id,
                'hpht' => '2023-12-23',
                'hpl' => '2024-09-28',
                'status' => 'berlangsung',
                'gravida' => 'G2P1A0',
                'tinggi_badan' => 160.00,
                'berat_badan_pra_hamil' => 54.00,
                'catatan' => 'Janin berukuran sebesar jagung manis (~30 cm, 600 gram). Kondisi ibu sehat, tensi stabil 110/70 mmHg, telah menerima tablet tambah darah.',
            ]
        );
    }
}
