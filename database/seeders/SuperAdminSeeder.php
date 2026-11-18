<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Seed akun Super Administrator default untuk sistem NutriGrow.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@nutrigrow.id'],
            [
                'name'       => 'Super Admin NutriGrow',
                'password'   => Hash::make('SuperAdmin@2026'),
                'role'       => 'superadmin',
                'faskes_name'=> 'Dinas Kesehatan Pusat',
                'nip_str'    => 'SA-000001',
                'phone'      => '081200000001',
                'status'     => 'active',
                'jabatan'    => 'Super Administrator Sistem',
            ]
        );

        $this->command->info('✅ Akun Super Admin berhasil dibuat/diperbarui:');
        $this->command->table(
            ['Field', 'Value'],
            [
                ['Email', 'superadmin@nutrigrow.id'],
                ['Password', 'SuperAdmin@2026'],
                ['Role', 'superadmin'],
                ['Faskes', 'Dinas Kesehatan Pusat'],
            ]
        );
    }
}
