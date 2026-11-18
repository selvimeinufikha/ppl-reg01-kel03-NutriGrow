<?php

namespace Tests\Feature;

use App\Models\Pasangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HapusDataPasanganTest extends TestCase
{
    use RefreshDatabase;

    public function test_berhasil_menghapus_data_pasangan_milik_sendiri(): void
    {
        $user = User::factory()->create();
        $pasangan = Pasangan::create([
            'user_id'         => $user->id,
            'nama'            => 'Budi Hapus',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        $response = $this->actingAs($user)->delete(route('pasangan.destroy', $pasangan->id));

        $response->assertRedirect(route('pasangan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('pasangans', [
            'id' => $pasangan->id,
        ]);
    }

    public function test_jika_konfirmasi_dibatalkan_data_tidak_berubah(): void
    {
        $user = User::factory()->create();
        $pasangan = Pasangan::create([
            'user_id'         => $user->id,
            'nama'            => 'Budi Aman Tidak Dihapus',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        // Pengguna hanya mengakses halaman daftar tanpa mengirim DELETE request (pembatalan dialog)
        $response = $this->actingAs($user)->get(route('pasangan.index'));

        $response->assertStatus(200);
        $response->assertSee('Budi Aman Tidak Dihapus');

        // Pastikan data tetap utuh di database
        $this->assertDatabaseHas('pasangans', [
            'id'   => $pasangan->id,
            'nama' => 'Budi Aman Tidak Dihapus',
        ]);
    }

    public function test_user_tidak_dapat_menghapus_data_pasangan_milik_user_lain(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $pasanganB = Pasangan::create([
            'user_id'         => $userB->id,
            'nama'            => 'Pasangan Milik Akun B',
            'tanggal_lahir'   => '1990-01-01',
            'status_pasangan' => 'suami',
        ]);

        $response = $this->actingAs($userA)->delete(route('pasangan.destroy', $pasanganB->id));

        $response->assertStatus(404);

        $this->assertDatabaseHas('pasangans', [
            'id'   => $pasanganB->id,
            'nama' => 'Pasangan Milik Akun B',
        ]);
    }
}
