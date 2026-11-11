<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\HealthFacilityRecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelolaProfilPenggunaTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Sarah Rahmawati',
            'email' => 'sarah@nutrigrow.id',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Cempaka Putih Tengah No. 12, RT 04/RW 02',
            'kota' => 'Jakarta Pusat',
            'kecamatan' => 'Cempaka Putih',
        ]);
    }

    /**
     * Test: Halaman profil pengguna dapat diakses dan menampilkan data profil serta faskes terdekat.
     */
    public function test_halaman_profil_pengguna_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('profil.index'));

        $response->assertStatus(200);
        $response->assertSee('Profil Pengguna &amp; Keluarga', false);
        $response->assertSee('Sarah Rahmawati');
        $response->assertSee('081234567890');
        $response->assertSee('Jl. Cempaka Putih Tengah No. 12');
        $response->assertSee('Rekomendasi Layanan Kesehatan Terdekat');
        $response->assertSee('Acuan Lokasi Aktif');
    }

    /**
     * Test: Halaman formulir edit profil dapat diakses.
     */
    public function test_halaman_edit_profil_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('profil.edit'));

        $response->assertStatus(200);
        $response->assertSee('Formulir Edit Profil Pengguna');
        $response->assertSee('Nama Lengkap Pengguna');
        $response->assertSee('Nomor Kontak / Telepon');
        $response->assertSee('Alamat Lengkap Domisili');
    }

    /**
     * Test Acceptance Criteria 1: Pengguna dapat mengubah nama, nomor kontak, dan alamat lalu menyimpannya.
     */
    public function test_pengguna_dapat_mengubah_nama_kontak_dan_alamat_lalu_menyimpannya(): void
    {
        $payload = [
            'name' => 'Sarah Rahmawati Pratama',
            'no_telepon' => '081399887766',
            'alamat' => 'Jl. Tebet Barat Dalam VII No. 15, RT 02/RW 03',
            'kota' => 'Jakarta Selatan',
            'kecamatan' => 'Tebet',
        ];

        $response = $this->actingAs($this->user)->put(route('profil.update'), $payload);

        $response->assertRedirect(route('profil.index'));
        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertEquals('Sarah Rahmawati Pratama', $this->user->name);
        $this->assertEquals('081399887766', $this->user->no_telepon);
        $this->assertEquals('Jl. Tebet Barat Dalam VII No. 15, RT 02/RW 03', $this->user->alamat);
        $this->assertEquals('Jakarta Selatan', $this->user->kota);
        $this->assertEquals('Tebet', $this->user->kecamatan);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Sarah Rahmawati Pratama',
            'no_telepon' => '081399887766',
            'alamat' => 'Jl. Tebet Barat Dalam VII No. 15, RT 02/RW 03',
        ]);
    }

    /**
     * Test Validasi: Nomor kontak dan alamat wajib diisi dan sesuai ketentuan.
     */
    public function test_validasi_nomor_kontak_dan_alamat_ditegakkan(): void
    {
        // 1. Uji field kosong
        $responseEmpty = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => '',
            'no_telepon' => '',
            'alamat' => '',
        ]);

        $responseEmpty->assertSessionHasErrors(['name', 'no_telepon', 'alamat']);

        // 2. Uji format nomor telepon tidak valid (kurang dari 10 digit atau huruf)
        $responseInvalidPhone = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah',
            'no_telepon' => '12345',
            'alamat' => 'Jl. Cempaka Putih No 1',
        ]);

        $responseInvalidPhone->assertSessionHasErrors([
            'no_telepon' => 'Format nomor kontak tidak valid. Gunakan format nomor ponsel Indonesia yang benar (contoh: 081234567890).',
        ]);

        // 3. Uji alamat terlalu pendek (< 5 karakter)
        $responseShortAddress = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah Rahmawati',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl.',
        ]);

        $responseShortAddress->assertSessionHasErrors([
            'alamat' => 'Alamat minimal 5 karakter agar acuan rekomendasi faskes akurat.',
        ]);
    }

    /**
     * Test Acceptance Criteria 2: Alamat profil dipakai sebagai acuan lokasi rekomendasi layanan kesehatan.
     */
    public function test_alamat_profil_dipakai_sebagai_acuan_lokasi_rekomendasi_layanan_kesehatan(): void
    {
        // 1. Pengguna berdomisili di Cempaka Putih, Jakarta Pusat
        $this->user->update([
            'alamat' => 'Jl. Cempaka Putih Timur No. 8',
            'kota' => 'Jakarta Pusat',
            'kecamatan' => 'Cempaka Putih',
        ]);

        $rekomendasiPusat = HealthFacilityRecommendationService::getRekomendasi(
            $this->user->alamat,
            $this->user->kota,
            $this->user->kecamatan
        );

        $this->assertStringContainsString('Cempaka Putih', $rekomendasiPusat['wilayah']);
        $this->assertEquals('Posyandu Mawar 1', $rekomendasiPusat['fasilitas'][0]['nama']);
        $this->assertEquals('Puskesmas Kecamatan Cempaka Putih', $rekomendasiPusat['fasilitas'][1]['nama']);

        // Pastikan tampil pada response halaman profil
        $responseView = $this->actingAs($this->user)->get(route('profil.index'));
        $responseView->assertSee('Posyandu Mawar 1');
        $responseView->assertSee('Puskesmas Kecamatan Cempaka Putih');

        // 2. Pengguna memperbarui alamat ke Tebet, Jakarta Selatan
        $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah Rahmawati',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Tebet Timur Dalam Raya No. 40',
            'kota' => 'Jakarta Selatan',
            'kecamatan' => 'Tebet',
        ]);

        $this->user->refresh();

        $rekomendasiSelatan = $this->user->rekomendasi_faskes;
        $this->assertStringContainsString('Tebet', $rekomendasiSelatan['wilayah']);
        $this->assertEquals('Posyandu Melati II', $rekomendasiSelatan['fasilitas'][0]['nama']);
        $this->assertEquals('Puskesmas Kecamatan Tebet', $rekomendasiSelatan['fasilitas'][1]['nama']);

        // Pastikan tampilan halaman profil diperbarui mencerminkan acuan faskes Tebet
        $responseUpdated = $this->actingAs($this->user)->get(route('profil.index'));
        $responseUpdated->assertSee('Posyandu Melati II');
        $responseUpdated->assertSee('Puskesmas Kecamatan Tebet');
        $responseUpdated->assertSee('RSUD Pasar Minggu');
    }
}
