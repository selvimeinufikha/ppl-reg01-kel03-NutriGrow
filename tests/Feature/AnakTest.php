<?php

namespace Tests\Feature;

use App\Models\Anak;
use App\Models\Kehamilan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnakTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Keluarga Pratama',
            'email' => 'pratama@nutrigrow.id',
        ]);
    }

    /**
     * Test 1: Halaman Data Anak dapat diakses oleh pengguna.
     */
    public function test_halaman_data_anak_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('data-anak.index'));

        $response->assertStatus(200);
        $response->assertSee('Data Anak');
        $response->assertSee('Ringkasan Keluarga');
        $response->assertSee('Tambah Anak');
    }

    /**
     * Test 2: Halaman formulir tambah anak dapat diakses.
     */
    public function test_halaman_formulir_tambah_anak_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('data-anak.create'));

        $response->assertStatus(200);
        $response->assertSee('Formulir Tambah Data Anak');
        $response->assertSee('Simpan Data Anak');
    }

    /**
     * Acceptance Criterion 1:
     * Pengguna mengisi nama, tanggal lahir, dan jenis kelamin, serta dapat menghubungkannya dengan data kehamilan.
     */
    public function test_pengguna_dapat_menambah_anak_dan_menghubungkannya_dengan_kehamilan(): void
    {
        $kehamilan = Kehamilan::create([
            'user_id' => $this->user->id,
            'gravida' => 'Kehamilan Ke-1',
            'hpht' => '2022-03-10',
            'status' => 'melahirkan',
        ]);

        $dataAnak = [
            'nama' => 'Kinan Pratama',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2022-12-22',
            'kehamilan_id' => $kehamilan->id,
            'anak_ke' => 1,
            'berat_lahir' => 3.25,
            'panjang_lahir' => 49.0,
            'golongan_darah' => 'O',
        ];

        $response = $this->actingAs($this->user)->post(route('data-anak.store'), $dataAnak);

        $response->assertRedirect(route('data-anak.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('anaks', [
            'nama' => 'Kinan Pratama',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2022-12-22 00:00:00',
            'kehamilan_id' => $kehamilan->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Pengguna dapat menambah anak tanpa menghubungkan ke data kehamilan (opsional).
     */
    public function test_pengguna_dapat_menambah_anak_tanpa_data_kehamilan(): void
    {
        $dataAnak = [
            'nama' => 'Alya Putri Pratama',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2024-01-10',
            'kehamilan_id' => null,
            'anak_ke' => 2,
        ];

        $response = $this->actingAs($this->user)->post(route('data-anak.store'), $dataAnak);

        $response->assertRedirect(route('data-anak.index'));
        $this->assertDatabaseHas('anaks', [
            'nama' => 'Alya Putri Pratama',
            'jenis_kelamin' => 'Perempuan',
            'kehamilan_id' => null,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Acceptance Criterion 2:
     * Tanggal lahir yang melebihi hari ini DITOLAK.
     */
    public function test_tanggal_lahir_yang_melebihi_hari_ini_ditolak(): void
    {
        $tanggalMasaDepan = Carbon::tomorrow()->format('Y-m-d');

        $dataAnak = [
            'nama' => 'Bayi Masa Depan',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => $tanggalMasaDepan,
        ];

        $response = $this->actingAs($this->user)->post(route('data-anak.store'), $dataAnak);

        // Harus gagal validasi pada field tanggal_lahir
        $response->assertSessionHasErrors(['tanggal_lahir']);
        $this->assertDatabaseMissing('anaks', [
            'nama' => 'Bayi Masa Depan',
        ]);
    }

    /**
     * Acceptance Criterion 2 (Boundary check):
     * Tanggal lahir hari ini DITERIMA.
     */
    public function test_tanggal_lahir_hari_ini_diterima(): void
    {
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        $dataAnak = [
            'nama' => 'Bayi Baru Lahir Hari Ini',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => $tanggalHariIni,
        ];

        $response = $this->actingAs($this->user)->post(route('data-anak.store'), $dataAnak);

        $response->assertRedirect(route('data-anak.index'));
        $this->assertDatabaseHas('anaks', [
            'nama' => 'Bayi Baru Lahir Hari Ini',
            'jenis_kelamin' => 'Perempuan',
        ]);
    }

    /**
     * Validasi field wajib: Nama, Tanggal Lahir, Jenis Kelamin.
     */
    public function test_validasi_bidang_wajib_nama_tanggal_lahir_dan_jenis_kelamin(): void
    {
        $response = $this->actingAs($this->user)->post(route('data-anak.store'), []);

        $response->assertSessionHasErrors(['nama', 'tanggal_lahir', 'jenis_kelamin']);
    }

    /**
     * Pengguna dapat mengubah (edit) data anak yang ada.
     */
    public function test_pengguna_dapat_mengubah_data_anak(): void
    {
        $anak = Anak::create([
            'user_id' => $this->user->id,
            'nama' => 'Kinan Awal',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2022-12-22',
        ]);

        $response = $this->actingAs($this->user)->put(route('data-anak.update', $anak->id), [
            'nama' => 'Kinan Pratama Terupdate',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2022-12-22',
            'catatan' => 'Catatan diupdate',
        ]);

        $response->assertRedirect(route('data-anak.index'));
        $this->assertDatabaseHas('anaks', [
            'id' => $anak->id,
            'nama' => 'Kinan Pratama Terupdate',
            'catatan' => 'Catatan diupdate',
        ]);
    }

    /**
     * Pengguna dapat menghapus data anak.
     */
    public function test_pengguna_dapat_menghapus_data_anak(): void
    {
        $anak = Anak::create([
            'user_id' => $this->user->id,
            'nama' => 'Anak Dihapus',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2023-01-01',
        ]);

        $response = $this->actingAs($this->user)->delete(route('data-anak.destroy', $anak->id));

        $response->assertRedirect(route('data-anak.index'));
        $this->assertDatabaseMissing('anaks', [
            'id' => $anak->id,
        ]);
    }
}
