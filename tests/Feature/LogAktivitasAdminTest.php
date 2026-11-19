<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogAktivitasAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * AC 1: Log mencatat penambahan akun beserta waktu dan pelakunya.
     */
    public function test_log_mencatat_penambahan_akun_administrator_baru_beserta_waktu_dan_pelakunya(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'name' => 'dr. Super Admin Utama',
            'email' => 'superadmin@nutrigrow.id',
            'status' => 'active',
        ]);

        $postData = [
            'name' => 'dr. Hendra Pratama, Sp.A',
            'email' => 'hendra.pratama@nutrigrow.id',
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
            'role' => 'dokter',
            'faskes_name' => 'RSUD Tarakan Jakarta',
            'nip_str' => 'STR-19900101-2023-999',
            'jabatan' => 'Dokter Spesialis Anak',
            'phone' => '081298765432',
            'status' => 'active',
        ];

        $response = $this->actingAs($superadmin)->post(route('admin.akun.store'), $postData);
        $response->assertSessionHas('success');

        // Pastikan akun tersimpan di database
        $this->assertDatabaseHas('users', [
            'email' => 'hendra.pratama@nutrigrow.id',
            'role' => 'dokter',
        ]);

        // Verifikasi AC 1: Log mencatat penambahan akun beserta waktu dan pelakunya
        $this->assertDatabaseHas('admin_activity_logs', [
            'action' => 'TAMBAH_AKUN',
            'actor_name' => 'dr. Super Admin Utama',
            'actor_email' => 'superadmin@nutrigrow.id',
            'actor_role' => 'superadmin',
            'target_name' => 'dr. Hendra Pratama, Sp.A',
            'target_email' => 'hendra.pratama@nutrigrow.id',
        ]);

        $log = AdminActivityLog::where('action', 'TAMBAH_AKUN')
            ->where('target_email', 'hendra.pratama@nutrigrow.id')
            ->first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->created_at);
        $this->assertStringContainsString('dr. Hendra Pratama, Sp.A', $log->description);
        $this->assertStringContainsString('Dokter Spesialis', $log->description);
    }

    /**
     * AC 1: Log mencatat perubahan hak akses dan status beserta waktu dan pelakunya.
     */
    public function test_log_mencatat_perubahan_hak_akses_dan_status_beserta_waktu_dan_pelakunya(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'name' => 'dr. Super Admin Pusat',
            'email' => 'superadmin.pusat@nutrigrow.id',
            'status' => 'active',
        ]);

        $targetUser = User::factory()->create([
            'name' => 'Bdn. Rina Marlina, S.Tr.Keb',
            'email' => 'rina.marlina@nutrigrow.id',
            'role' => 'bidan',
            'status' => 'active',
            'faskes_name' => 'Puskesmas Gambir',
            'nip_str' => 'STR-19920101-2022-111',
            'jabatan' => 'Bidan Pelaksana',
        ]);

        // 1. Uji Ubah Hak Akses (Role diubah ke 'nakes')
        $updateData = [
            'name' => 'Bdn. Rina Marlina, S.Tr.Keb',
            'role' => 'nakes',
            'status' => 'active',
            'faskes_name' => 'Puskesmas Kebayoran Baru',
            'jabatan' => 'Tenaga Kesehatan Koordinator',
            'nip_str' => 'STR-19920101-2022-111',
        ];

        $response = $this->actingAs($superadmin)->put(route('admin.akun.update', $targetUser->id), $updateData);
        $response->assertSessionHas('success');

        // Pastikan perubahan hak akses tercatat di log audit
        $this->assertDatabaseHas('admin_activity_logs', [
            'action' => 'UBAH_HAK_AKSES',
            'actor_name' => 'dr. Super Admin Pusat',
            'actor_email' => 'superadmin.pusat@nutrigrow.id',
            'target_name' => 'Bdn. Rina Marlina, S.Tr.Keb',
            'target_email' => 'rina.marlina@nutrigrow.id',
        ]);

        // 2. Uji Ubah Status Keaktifan Akun (Toggle Status)
        $toggleResponse = $this->actingAs($superadmin)->post(route('admin.akun.toggle-status', $targetUser->id));
        $toggleResponse->assertSessionHas('success');

        // Pastikan perubahan status tercatat di log audit
        $this->assertDatabaseHas('admin_activity_logs', [
            'action' => 'TOGGLE_STATUS',
            'actor_name' => 'dr. Super Admin Pusat',
            'target_name' => 'Bdn. Rina Marlina, S.Tr.Keb',
        ]);
    }

    /**
     * AC 2: Log hanya dapat dilihat oleh Super Admin.
     */
    public function test_log_hanya_dapat_dilihat_oleh_super_admin(): void
    {
        // 1. Pengguna belum login -> Ditolak / diarahkan ke login admin
        $responseGuest = $this->get(route('admin.log.index'));
        $responseGuest->assertRedirect(route('admin.login'));

        // 2. Pengguna umum / Orang tua (role: user) -> Ditolak (403 Forbidden)
        $userOrangTua = User::factory()->create([
            'role' => 'user',
            'email' => 'orangtua@gmail.com',
        ]);
        $responseUser = $this->actingAs($userOrangTua)->get(route('admin.log.index'));
        $responseUser->assertStatus(403);

        // 3. Pegawai faskes / Nakes biasa (role: nakes, dokter, bidan, admin faskes) -> Ditolak (403 Forbidden)
        $nakes = User::factory()->create([
            'role' => 'bidan',
            'email' => 'bidan.puskesmas@nutrigrow.id',
            'status' => 'active',
        ]);
        $responseNakes = $this->actingAs($nakes)->get(route('admin.log.index'));
        $responseNakes->assertStatus(403);

        $adminFaskes = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin.faskes@nutrigrow.id',
            'status' => 'active',
        ]);
        $responseAdminFaskes = $this->actingAs($adminFaskes)->get(route('admin.log.index'));
        $responseAdminFaskes->assertStatus(403);

        // 4. Super Admin resmi (role: superadmin) -> Diizinkan (200 OK)
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'superadmin.resmi@nutrigrow.id',
            'status' => 'active',
        ]);
        $responseSuperAdmin = $this->actingAs($superadmin)->get(route('admin.log.index'));
        $responseSuperAdmin->assertStatus(200);
        $responseSuperAdmin->assertSee('Log Aktivitas & Audit Keamanan Administrator');
    }

    /**
     * Query menampilkan waktu dan pelaku aktivitas serta mendukung pencarian dan filter.
     */
    public function test_halaman_log_dapat_melakukan_pencarian_dan_filter_aktivitas(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'name' => 'dr. Super Admin Audit',
            'email' => 'superadmin.audit@nutrigrow.id',
            'status' => 'active',
        ]);

        // Buat beberapa log aktivitas khusus
        AdminActivityLog::create([
            'user_id' => $superadmin->id,
            'actor_name' => 'dr. Super Admin Audit',
            'actor_email' => 'superadmin.audit@nutrigrow.id',
            'actor_role' => 'superadmin',
            'action' => 'TAMBAH_AKUN',
            'description' => 'Mendaftarkan akun nakes baru Ahli Gizi Budi',
            'target_name' => 'Budi Gizi',
            'target_email' => 'budi.gizi@nutrigrow.id',
            'created_at' => Carbon::now(),
        ]);

        AdminActivityLog::create([
            'user_id' => $superadmin->id,
            'actor_name' => 'dr. Super Admin Audit',
            'actor_email' => 'superadmin.audit@nutrigrow.id',
            'actor_role' => 'superadmin',
            'action' => 'UBAH_HAK_AKSES',
            'description' => 'Mengubah hak akses akun Dokter Siti',
            'target_name' => 'dr. Siti Rahma',
            'target_email' => 'siti.rahma@nutrigrow.id',
            'created_at' => Carbon::now(),
        ]);

        // 1. Akses halaman log utama
        $response = $this->actingAs($superadmin)->get(route('admin.log.index'));
        $response->assertStatus(200);
        $response->assertSee('Budi Gizi');
        $response->assertSee('dr. Siti Rahma');
        $response->assertSee('dr. Super Admin Audit');

        // 2. Pencarian kata kunci target
        $searchResponse = $this->actingAs($superadmin)->get(route('admin.log.index', ['search' => 'Budi Gizi']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Budi Gizi');
        $searchResponse->assertDontSee('dr. Siti Rahma');

        // 3. Filter jenis aksi TAMBAH_AKUN
        $filterActionResponse = $this->actingAs($superadmin)->get(route('admin.log.index', ['action' => 'TAMBAH_AKUN']));
        $filterActionResponse->assertStatus(200);
        $filterActionResponse->assertSee('Budi Gizi');
        $filterActionResponse->assertDontSee('dr. Siti Rahma');

        // 4. Filter jenis aksi UBAH_HAK_AKSES
        $filterAksesResponse = $this->actingAs($superadmin)->get(route('admin.log.index', ['action' => 'UBAH_HAK_AKSES']));
        $filterAksesResponse->assertStatus(200);
        $filterAksesResponse->assertSee('dr. Siti Rahma');
        $filterAksesResponse->assertDontSee('Budi Gizi');
    }
}
