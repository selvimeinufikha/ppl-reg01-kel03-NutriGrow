<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelolaAkunAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_tabel_menampilkan_nama_email_instansi_hak_akses_dan_status_dengan_pencarian_dan_filter(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'superadmin@nutrigrow.id',
            'name' => 'dr. Super Admin Pusat',
        ]);

        $nakes1 = User::factory()->create([
            'name' => 'Bdn. Siti Aminah, S.Tr.Keb',
            'email' => 'siti.aminah@nutrigrow.id',
            'role' => 'bidan',
            'faskes_name' => 'Puskesmas Gambir',
            'status' => 'active',
        ]);

        $nakes2 = User::factory()->create([
            'name' => 'dr. Rudi Hermanto, Sp.A',
            'email' => 'rudi.hermanto@nutrigrow.id',
            'role' => 'dokter',
            'faskes_name' => 'RSUD Tarakan Jakarta',
            'status' => 'inactive',
        ]);

        // Akses daftar akun
        $response = $this->actingAs($superadmin)->get(route('admin.akun.index'));
        $response->assertStatus(200);
        $response->assertSee('Bdn. Siti Aminah, S.Tr.Keb');
        $response->assertSee('siti.aminah@nutrigrow.id');
        $response->assertSee('Puskesmas Gambir');
        $response->assertSee('dr. Rudi Hermanto, Sp.A');

        // Uji pencarian
        $searchResponse = $this->actingAs($superadmin)->get(route('admin.akun.index', ['search' => 'Siti Aminah']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Bdn. Siti Aminah, S.Tr.Keb');
        $searchResponse->assertDontSee('dr. Rudi Hermanto, Sp.A');

        // Uji filter role
        $filterRoleResponse = $this->actingAs($superadmin)->get(route('admin.akun.index', ['role' => 'dokter']));
        $filterRoleResponse->assertStatus(200);
        $filterRoleResponse->assertSee('dr. Rudi Hermanto, Sp.A');
        $filterRoleResponse->assertDontSee('Bdn. Siti Aminah, S.Tr.Keb');

        // Uji filter status
        $filterStatusResponse = $this->actingAs($superadmin)->get(route('admin.akun.index', ['status' => 'inactive']));
        $filterStatusResponse->assertStatus(200);
        $filterStatusResponse->assertSee('dr. Rudi Hermanto, Sp.A');
        $filterStatusResponse->assertDontSee('Bdn. Siti Aminah, S.Tr.Keb');
    }

    public function test_halaman_edit_hak_akses_dan_status_dapat_diakses(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'superadmin@nutrigrow.id',
        ]);

        $admin = User::factory()->create([
            'name' => 'Bdn. Siti Aminah, S.Tr.Keb',
            'email' => 'siti.aminah@nutrigrow.id',
            'role' => 'bidan',
            'faskes_name' => 'Puskesmas Gambir',
            'status' => 'active',
        ]);

        $response = $this->actingAs($superadmin)->get(route('admin.akun.edit', $admin->id));
        $response->assertStatus(200);
        $response->assertSee('Ubah Hak Akses &amp; Status Akun', false);
        $response->assertSee('siti.aminah@nutrigrow.id');
    }

    public function test_perubahan_hak_akses_dan_status_langsung_berlaku_pada_akun(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'superadmin@nutrigrow.id',
        ]);

        $admin = User::factory()->create([
            'name' => 'Bdn. Siti Aminah, S.Tr.Keb',
            'email' => 'siti.aminah@nutrigrow.id',
            'role' => 'bidan',
            'faskes_name' => 'Puskesmas Gambir',
            'status' => 'active',
        ]);

        // Update hak akses menjadi dokter dan status menjadi inactive
        $updatePayload = [
            'role' => 'dokter',
            'status' => 'inactive',
            'faskes_name' => 'RSUD Tarakan Jakarta',
            'jabatan' => 'Dokter Konsultan Tumbuh Kembang',
            'nip_str' => 'STR-999888-2026',
            'phone' => '081234567890',
        ];

        $response = $this->actingAs($superadmin)->put(route('admin.akun.update', $admin->id), $updatePayload);

        $response->assertRedirect(route('admin.akun.index'));
        $response->assertSessionHas('success');

        // Pastikan perubahan langsung tersimpan dan berlaku di database
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'role' => 'dokter',
            'status' => 'inactive',
            'faskes_name' => 'RSUD Tarakan Jakarta',
            'jabatan' => 'Dokter Konsultan Tumbuh Kembang',
        ]);

        $admin->refresh();
        $this->assertEquals('dokter', $admin->role);
        $this->assertEquals('inactive', $admin->status);
        $this->assertEquals('RSUD Tarakan Jakarta', $admin->faskes_name);
    }

    public function test_toggle_status_akun_dapat_berubah_secara_instan(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'superadmin@nutrigrow.id',
        ]);

        $admin = User::factory()->create([
            'status' => 'active',
        ]);

        // Toggle menjadi inactive
        $response = $this->actingAs($superadmin)->post(route('admin.akun.toggle-status', $admin->id));
        $response->assertRedirect();

        $admin->refresh();
        $this->assertEquals('inactive', $admin->status);

        // Toggle kembali menjadi active
        $response = $this->actingAs($superadmin)->post(route('admin.akun.toggle-status', $admin->id));
        $response->assertRedirect();

        $admin->refresh();
        $this->assertEquals('active', $admin->status);
    }

    public function test_selain_super_admin_ditolak_mengakses_fitur_manajemen_akun(): void
    {
        // 1. Akun Admin Faskes (bukan Super Admin)
        $adminFaskes = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin.faskes@nutrigrow.id',
        ]);

        $target = User::factory()->create([
            'role' => 'bidan',
            'status' => 'active',
        ]);

        $this->actingAs($adminFaskes)->get(route('admin.akun.index'))->assertStatus(403);
        $this->actingAs($adminFaskes)->get(route('admin.akun.create'))->assertStatus(403);
        $this->actingAs($adminFaskes)->post(route('admin.akun.store'), [
            'name' => 'Test',
            'email' => 'test@nutrigrow.id',
            'role' => 'bidan',
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
            'faskes_name' => 'Puskesmas Gambir',
        ])->assertStatus(403);
        $this->actingAs($adminFaskes)->get(route('admin.akun.edit', $target->id))->assertStatus(403);
        $this->actingAs($adminFaskes)->put(route('admin.akun.update', $target->id), [
            'role' => 'dokter',
            'status' => 'active',
        ])->assertStatus(403);
        $this->actingAs($adminFaskes)->post(route('admin.akun.toggle-status', $target->id))->assertStatus(403);

        // 2. Akun Nakes (Bidan/Dokter)
        $bidan = User::factory()->create([
            'role' => 'bidan',
            'email' => 'bidan@nutrigrow.id',
        ]);
        $this->actingAs($bidan)->get(route('admin.akun.index'))->assertStatus(403);

        // 3. Belum Login
        auth()->logout();
        $response = $this->get(route('admin.akun.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_dashboard_superadmin_dapat_diakses_oleh_superadmin(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'superadmin.dash@nutrigrow.id',
            'status' => 'active',
        ]);

        $response = $this->actingAs($superadmin)->get(route('superadmin.dashboard'));
        $response->assertStatus(200);

        // Pengguna non-superadmin tidak boleh masuk
        $nakes = User::factory()->create([
            'role' => 'bidan',
            'email' => 'nakes.dash@nutrigrow.id',
            'status' => 'active',
        ]);
        $responseNonSuper = $this->actingAs($nakes)->get(route('superadmin.dashboard'));
        $responseNonSuper->assertStatus(403);
    }
}
