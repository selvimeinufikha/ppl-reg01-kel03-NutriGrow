<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TambahAkunAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_manajemen_akun_admin_dapat_diakses(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'admin@nutrigrow.id',
        ]);

        $response = $this->actingAs($superadmin)->get(route('admin.akun.index'));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Akun Administrator');
    }

    public function test_halaman_form_tambah_akun_admin_dapat_diakses(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'admin@nutrigrow.id',
        ]);

        $response = $this->actingAs($superadmin)->get(route('admin.akun.create'));

        $response->assertStatus(200);
        $response->assertSee('Formulir Registrasi Akun Administrator Faskes');
    }

    public function test_validasi_gagal_jika_field_wajib_kosong(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'admin@nutrigrow.id',
        ]);

        $response = $this->actingAs($superadmin)->post(route('admin.akun.store'), [
            'name' => '',
            'email' => '',
            'role' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'role', 'password', 'faskes_name']);
    }

    public function test_berhasil_menambahkan_akun_administrator_baru(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'admin@nutrigrow.id',
        ]);

        $payload = [
            'name' => 'dr. Bambang Sudiro, Sp.A',
            'email' => 'bambang.sudiro@nutrigrow.id',
            'role' => 'dokter',
            'faskes_name' => 'RSUD Tarakan Jakarta',
            'nip_str' => 'STR-19850912-2021-009',
            'jabatan' => 'Dokter Spesialis Anak Konsultan Gizi',
            'phone' => '081299887766',
            'password' => 'Dokter123#',
            'password_confirmation' => 'Dokter123#',
            'status' => 'active',
        ];

        $response = $this->actingAs($superadmin)->post(route('admin.akun.store'), $payload);

        $response->assertRedirect(route('admin.akun.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'bambang.sudiro@nutrigrow.id',
            'name' => 'dr. Bambang Sudiro, Sp.A',
            'role' => 'dokter',
            'faskes_name' => 'RSUD Tarakan Jakarta',
        ]);

        $createdUser = User::where('email', 'bambang.sudiro@nutrigrow.id')->first();
        $this->assertTrue(Hash::check('Dokter123#', $createdUser->password));
    }
}
