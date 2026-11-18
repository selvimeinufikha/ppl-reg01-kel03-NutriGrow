<?php

namespace Tests\Feature;

use App\Models\Pasangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerbaruiDataPasanganTest extends TestCase
{
    use RefreshDatabase;

    public function test_daftar_hanya_menampilkan_data_pasangan_milik_akun_sendiri(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $pasanganA = Pasangan::create([
            'user_id'         => $userA->id,
            'nama'            => 'Budi Suami A',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        $pasanganB = Pasangan::create([
            'user_id'         => $userB->id,
            'nama'            => 'Doni Suami B',
            'tanggal_lahir'   => '1992-02-02',
            'status_pasangan' => 'suami',
        ]);

        $response = $this->actingAs($userA)->get(route('pasangan.index'));

        $response->assertStatus(200);
        $response->assertSee('Budi Suami A');
        $response->assertDontSee('Doni Suami B');
    }

    public function test_user_dapat_melihat_detail_data_pasangan_milik_sendiri(): void
    {
        $user = User::factory()->create();
        $pasangan = Pasangan::create([
            'user_id'         => $user->id,
            'nama'            => 'Rudi Hartono',
            'tanggal_lahir'   => '1991-05-15',
            'status_pasangan' => 'suami',
            'pekerjaan'       => 'PNS',
            'golongan_darah'  => 'AB',
        ]);

        $response = $this->actingAs($user)->get(route('pasangan.show', $pasangan->id));

        $response->assertStatus(200);
        $response->assertSee('Rudi Hartono');
        $response->assertSee('PNS');
    }

    public function test_user_tidak_dapat_melihat_detail_pasangan_milik_user_lain(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $pasanganB = Pasangan::create([
            'user_id'         => $userB->id,
            'nama'            => 'Pasangan Milik B',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        $response = $this->actingAs($userA)->get(route('pasangan.show', $pasanganB->id));

        $response->assertStatus(404);
    }

    public function test_perubahan_yang_disimpan_langsung_tampil_pada_daftar(): void
    {
        $user = User::factory()->create();

        $pasangan = Pasangan::create([
            'user_id'         => $user->id,
            'nama'            => 'Nama Awal',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        $updatePayload = [
            'nama'            => 'Nama Baru Terkini',
            'tanggal_lahir'   => '1991-03-03',
            'pekerjaan'       => 'Arsitek',
            'golongan_darah'  => 'A',
            'status_pasangan' => 'suami',
        ];

        $response = $this->actingAs($user)->put(route('pasangan.update', $pasangan->id), $updatePayload);

        $response->assertRedirect(route('pasangan.index'));
        $response->assertSessionHas('success');

        // Pastikan database terupdate
        $this->assertDatabaseHas('pasangans', [
            'id'   => $pasangan->id,
            'nama' => 'Nama Baru Terkini',
        ]);

        // Pastikan langsung tampil di halaman daftar
        $responseIndex = $this->actingAs($user)->get(route('pasangan.index'));
        $responseIndex->assertSee('Nama Baru Terkini');
    }

    public function test_user_tidak_dapat_memperbarui_data_pasangan_milik_user_lain(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $pasanganB = Pasangan::create([
            'user_id'         => $userB->id,
            'nama'            => 'Pasangan B Asli',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        $response = $this->actingAs($userA)->put(route('pasangan.update', $pasanganB->id), [
            'nama'            => 'Upaya Pembajakan Nama',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        $response->assertStatus(404);

        $this->assertDatabaseHas('pasangans', [
            'id'   => $pasanganB->id,
            'nama' => 'Pasangan B Asli',
        ]);
    }
}
