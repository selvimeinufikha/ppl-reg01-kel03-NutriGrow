<?php

namespace Tests\Feature;

use App\Models\Kehamilan;
use App\Models\Pasangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatatDataKehamilanTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Pasangan $pasangan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Sarah Rahmawati',
            'email' => 'sarah@nutrigrow.id',
        ]);

        $this->pasangan = Pasangan::create([
            'user_id' => $this->user->id,
            'nama_lengkap' => 'Dimas Prasetyo',
            'hubungan' => 'Calon Ayah',
        ]);
    }

    /**
     * Test: Halaman data kehamilan dapat diakses.
     */
    public function test_halaman_data_kehamilan_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('kehamilan.index'));

        $response->assertStatus(200);
        $response->assertSee('Data Kehamilan');
        $response->assertSee('Tambah Data Kehamilan');
        $response->assertSee('Total Data');
    }

    /**
     * Test: Halaman formulir pencatatan kehamilan dapat diakses.
     */
    public function test_halaman_formulir_pencatatan_kehamilan_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('kehamilan.create'));

        $response->assertStatus(200);
        $response->assertSee('Formulir Pencatatan Kehamilan');
        $response->assertSee('Tanggal HPHT');
        $response->assertSee('Kehamilan Ke- Berapa');
        $response->assertSee('Status Kehamilan');
    }

    /**
     * Test Acceptance Criteria 1: Pengguna mengisi HPHT, kehamilan ke berapa, dan status kehamilan (berhasil disimpan).
     */
    public function test_pengguna_berhasil_mencatat_data_kehamilan(): void
    {
        $hpht = Carbon::today()->subWeeks(10)->format('Y-m-d');

        $response = $this->actingAs($this->user)->post(route('kehamilan.store'), [
            'hpht' => $hpht,
            'kehamilan_ke' => 2,
            'status' => 'berlangsung',
            'pasangan_id' => $this->pasangan->id,
            'tinggi_badan' => 160,
            'berat_badan_pra_hamil' => 54,
            'catatan' => 'Kondisi ibu sehat, tensi stabil.',
        ]);

        $response->assertRedirect(route('kehamilan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kehamilans', [
            'user_id' => $this->user->id,
            'kehamilan_ke' => 2,
            'status' => 'berlangsung',
            'pasangan_id' => $this->pasangan->id,
        ]);

        $kehamilan = Kehamilan::where('user_id', $this->user->id)->first();
        $this->assertNotNull($kehamilan);
        $this->assertEquals(2, $kehamilan->kehamilan_ke);
        $this->assertEquals('berlangsung', $kehamilan->status);
        // HPL terhitung otomatis (+280 hari)
        $expectedHpl = Carbon::parse($hpht)->addDays(280)->format('Y-m-d');
        $this->assertEquals($expectedHpl, $kehamilan->hpl->format('Y-m-d'));
    }

    /**
     * Test Acceptance Criteria 2: HPHT yang melebihi tanggal hari ini ditolak dengan pesan kesalahan.
     */
    public function test_hpht_melebihi_tanggal_hari_ini_ditolak_dengan_pesan_kesalahan(): void
    {
        // Tanggal besok (melebihi hari ini)
        $hphtMasaDepan = Carbon::tomorrow()->format('Y-m-d');

        $response = $this->actingAs($this->user)->post(route('kehamilan.store'), [
            'hpht' => $hphtMasaDepan,
            'kehamilan_ke' => 1,
            'status' => 'berlangsung',
            'pasangan_id' => $this->pasangan->id,
        ]);

        $response->assertSessionHasErrors([
            'hpht' => 'Tanggal HPHT tidak boleh melebihi tanggal hari ini.',
        ]);

        // Pastikan tidak ada data yang tersimpan
        $this->assertDatabaseCount('kehamilans', 0);
    }

    /**
     * Test: Field wajib (HPHT, kehamilan_ke, status) harus diisi.
     */
    public function test_field_wajib_kehamilan_harus_diisi(): void
    {
        $response = $this->actingAs($this->user)->post(route('kehamilan.store'), []);

        $response->assertSessionHasErrors(['hpht', 'kehamilan_ke', 'status']);
    }

    /**
     * Test: Relasi Model Kehamilan ke Pasangan dan User.
     */
    public function test_relasi_model_kehamilan_ke_pasangan_dan_user(): void
    {
        $kehamilan = Kehamilan::create([
            'user_id' => $this->user->id,
            'pasangan_id' => $this->pasangan->id,
            'kehamilan_ke' => 1,
            'hpht' => Carbon::today()->subWeeks(20)->format('Y-m-d'),
            'hpl' => Carbon::today()->subWeeks(20)->addDays(280)->format('Y-m-d'),
            'status' => 'berlangsung',
        ]);

        // Cek relasi belongsTo user
        $this->assertInstanceOf(User::class, $kehamilan->user);
        $this->assertEquals($this->user->id, $kehamilan->user->id);

        // Cek relasi belongsTo pasangan
        $this->assertInstanceOf(Pasangan::class, $kehamilan->pasangan);
        $this->assertEquals($this->pasangan->id, $kehamilan->pasangan->id);

        // Cek relasi user hasMany kehamilans
        $this->assertTrue($this->user->kehamilans->contains($kehamilan));

        // Cek relasi pasangan hasMany kehamilans
        $this->assertTrue($this->pasangan->kehamilans->contains($kehamilan));
    }
}
