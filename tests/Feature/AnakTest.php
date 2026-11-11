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
     * Acceptance Criteria:
     * Perubahan tersimpan dan langsung tampil pada daftar.
     */
    public function test_perubahan_data_anak_tersimpan_dan_langsung_tampil_pada_daftar(): void
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

        // Verifikasi perubahan langsung tampil pada halaman daftar
        $responseDaftar = $this->actingAs($this->user)->get(route('data-anak.index'));
        $responseDaftar->assertStatus(200);
        $responseDaftar->assertSee('Kinan Pratama Terupdate');
    }

    /**
     * Acceptance Criteria:
     * Pengelolaan data hanya untuk anak milik akun sendiri (Pengguna lain tidak dapat mengubah data).
     */
    public function test_pengguna_tidak_dapat_mengubah_data_anak_milik_orang_lain(): void
    {
        $otherUser = User::factory()->create([
            'name' => 'Keluarga Lain',
            'email' => 'other@nutrigrow.id',
        ]);

        $anakOtherUser = Anak::create([
            'user_id' => $otherUser->id,
            'nama' => 'Anak Orang Lain',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2023-05-10',
        ]);

        // User mencoba mengubah data anak milik otherUser
        $response = $this->actingAs($this->user)->put(route('data-anak.update', $anakOtherUser->id), [
            'nama' => 'Mencoba Bajak Nama',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2023-05-10',
        ]);

        // Harus ditolak dengan status 403 Forbidden
        $response->assertStatus(403);

        // Data di basis data tidak boleh berubah
        $this->assertDatabaseHas('anaks', [
            'id' => $anakOtherUser->id,
            'nama' => 'Anak Orang Lain',
        ]);
    }

    /**
     * Acceptance Criteria:
     * Penghapusan meminta konfirmasi dan hanya berlaku untuk anak milik akun sendiri.
     */
    public function test_pengguna_dapat_menghapus_data_anak_milik_sendiri(): void
    {
        $anak = Anak::create([
            'user_id' => $this->user->id,
            'nama' => 'Anak Dihapus',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2023-01-01',
        ]);

        $response = $this->actingAs($this->user)->delete(route('data-anak.destroy', $anak->id));

        $response->assertRedirect(route('data-anak.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('anaks', [
            'id' => $anak->id,
        ]);

        // Verifikasi tidak lagi ada di dalam koleksi daftar anak
        $responseDaftar = $this->actingAs($this->user)->get(route('data-anak.index'));
        $responseDaftar->assertViewHas('anaks', function ($anaks) use ($anak) {
            return !$anaks->contains('id', $anak->id);
        });
    }

    /**
     * Acceptance Criteria:
     * Penghapusan hanya berlaku untuk anak milik akun sendiri (User tidak dapat menghapus anak user lain).
     */
    public function test_pengguna_tidak_dapat_menghapus_data_anak_milik_orang_lain(): void
    {
        $otherUser = User::factory()->create([
            'name' => 'Keluarga Tetangga',
            'email' => 'tetangga@nutrigrow.id',
        ]);

        $anakOtherUser = Anak::create([
            'user_id' => $otherUser->id,
            'nama' => 'Anak Tetangga Aman',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2023-08-20',
        ]);

        // User mencoba menghapus anak milik otherUser
        $response = $this->actingAs($this->user)->delete(route('data-anak.destroy', $anakOtherUser->id));

        // Harus ditolak dengan status 403 Forbidden
        $response->assertStatus(403);

        // Data anak tetap ada di basis data
        $this->assertDatabaseHas('anaks', [
            'id' => $anakOtherUser->id,
            'nama' => 'Anak Tetangga Aman',
        ]);
    }
}
