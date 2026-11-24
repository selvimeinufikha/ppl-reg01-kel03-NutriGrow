<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\Kehamilan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataAnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan akun keluarga / user utama tersedia
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Keluarga Pratama',
                'email' => 'pratama@nutrigrow.id',
                'password' => Hash::make('password123'),
            ]);
        }

        // Buat data kehamilan terkait (Kehamilan Ke-1)
        $kehamilan = Kehamilan::firstOrCreate(
            [
                'user_id' => $user->id,
                'gravida' => 'Kehamilan Ke-1',
            ],
            [
                'hpht' => '2022-03-15',
                'hpl' => '2022-12-20',
                'tinggi_badan' => 158.00,
                'berat_badan_pra_hamil' => 52.00,
                'lila_pra_hamil' => 24.5,
                'status' => 'melahirkan',
            ]
        );

        // Buat data anak 1 (Sesuai Desain: Kinan Pratama, Laki-laki, 22 Desember 2022)
        Anak::firstOrCreate(
            [
                'user_id' => $user->id,
                'nama' => 'Kinan Pratama',
            ],
            [
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2022-12-22',
                'kehamilan_id' => $kehamilan->id,
                'nik' => '3171012212220001',
                'tempat_lahir' => 'Jakarta Selatan',
                'anak_ke' => 1,
                'berat_lahir' => 3.25,
                'panjang_lahir' => 49.0,
                'lingkar_kepala_lahir' => 34.0,
                'golongan_darah' => 'O',
                'catatan' => 'Lahir sehat dan normal di RSIA Bunda Sehat.',
            ]
        );

        // Buat data anak 2 (Sesuai Desain: Alya Putri Pratama, Perempuan, 10 Januari 2024, Tanpa kehamilan terkait)
        Anak::firstOrCreate(
            [
                'user_id' => $user->id,
                'nama' => 'Alya Putri Pratama',
            ],
            [
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2024-01-10',
                'kehamilan_id' => null,
                'nik' => '3171011001240002',
                'tempat_lahir' => 'Jakarta Selatan',
                'anak_ke' => 2,
                'berat_lahir' => 3.10,
                'panjang_lahir' => 48.5,
                'lingkar_kepala_lahir' => 33.5,
                'golongan_darah' => 'A',
                'catatan' => 'Kondisi sehat ceria, ASI eksklusif lancar.',
            ]
        );
    }
}
