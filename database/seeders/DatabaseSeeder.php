<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::updateOrCreate(
            ['email' => 'ibu.anita@nutrigrow.id'],
            [
                'name' => 'Ibu Anita Rahmawati',
                'password' => Hash::make('password'),
                'role' => 'user',
                'faskes_name' => 'Posyandu Melati II',
                'phone' => '085712345678',
            ]
        );
    }
}
