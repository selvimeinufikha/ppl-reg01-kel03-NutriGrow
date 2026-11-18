<?php

namespace Tests\Feature;

use App\Models\Pasangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TambahDataPasanganTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_tambah_pasangan_dapat_diakses(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pasangan.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Data Pasangan');
    }

    public function test_berhasil_menambahkan_data_pasangan_dengan_data_valid(): void
    {
        $user = User::factory()->create();

        $payload = [
            'nama'            => 'Budi Santoso',
            'tanggal_lahir'   => '1995-08-17',
            'pekerjaan'       => 'Wiraswasta',
            'golongan_darah'  => 'O',
            'status_pasangan' => 'suami',
        ];

        $response = $this->actingAs($user)->post(route('pasangan.store'), $payload);

        $response->assertRedirect(route('pasangan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pasangans', [
            'user_id'         => $user->id,
            'nama'            => 'Budi Santoso',
            'tanggal_lahir'   => '1995-08-17',
            'pekerjaan'       => 'Wiraswasta',
            'golongan_darah'  => 'O',
            'status_pasangan' => 'suami',
        ]);
    }

    public function test_isian_wajib_kosong_ditolak_dengan_pesan_kesalahan(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pasangan.store'), [
            'nama'            => '',
            'tanggal_lahir'   => '',
            'status_pasangan' => '',
        ]);

        $response->assertSessionHasErrors(['nama', 'tanggal_lahir', 'status_pasangan']);
    }

    public function test_tanggal_lahir_tidak_boleh_hari_ini_atau_masa_depan(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pasangan.store'), [
            'nama'            => 'Budi Santoso',
            'tanggal_lahir'   => now()->addDay()->format('Y-m-d'),
            'status_pasangan' => 'suami',
        ]);

        $response->assertSessionHasErrors(['tanggal_lahir']);
    }
}
