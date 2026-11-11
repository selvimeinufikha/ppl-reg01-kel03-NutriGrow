<?php

namespace Tests\Feature;

use App\Models\Kehamilan;
use App\Models\Pasangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LihatUsiaKehamilanTrimesterTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Pasangan $pasangan;
    protected Kehamilan $kehamilan;

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

        // Kehamilan dengan HPHT 20 minggu lalu
        $hpht = Carbon::today()->subWeeks(20)->format('Y-m-d');
        $hpl = Carbon::parse($hpht)->addDays(280)->format('Y-m-d');

        $this->kehamilan = Kehamilan::create([
            'user_id' => $this->user->id,
            'pasangan_id' => $this->pasangan->id,
            'kehamilan_ke' => 2,
            'hpht' => $hpht,
            'hpl' => $hpl,
            'status' => 'berlangsung',
            'catatan' => 'Kondisi janin baik.',
        ]);
    }

    /**
     * Test: Halaman detail informasi usia kehamilan dan trimester dapat diakses.
     */
    public function test_halaman_detail_informasi_usia_dan_trimester_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('kehamilan.show', $this->kehamilan->id));

        $response->assertStatus(200);
        $response->assertSee('Informasi Usia &amp; Trimester', false);
        $response->assertSee('Hari Perkiraan Lahir (HPL)');
        $response->assertSee('Usia Gestasi Saat Ini');
        $response->assertSee('Kategori Trimester');
        $response->assertSee('Garis Waktu &amp; Perkembangan Trimester', false);
        $response->assertSee('Fokus Nutrisi');
    }

    /**
     * Test Acceptance Criteria via AJAX / API: Sistem menghitung HPL, usia kehamilan, dan trimester dari HPHT.
     */
    public function test_api_detail_kehamilan_mengembalikan_hpl_usia_dan_trimester(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson(route('kehamilan.show', $this->kehamilan->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data',
            'usia_kehamilan',
            'usia_minggu',
            'usia_hari',
            'trimester',
            'trimester_nomor',
            'trimester_badge',
            'hpl_formatted',
            'hpht_formatted',
            'kalkulasi' => [
                'hpl',
                'usia_kehamilan',
                'usia_minggu',
                'trimester' => [
                    'nomor',
                    'nama',
                    'label',
                    'badge',
                ],
                'milestone',
            ],
        ]);

        $json = $response->json();
        $this->assertEquals(20, $json['usia_minggu']);
        $this->assertEquals(2, $json['trimester_nomor']);
        $this->assertEquals('T2 Aktif', $json['trimester_badge']);
    }

    /**
     * Test Endpoint Kalkulator Independen: Menghitung HPL, usia gestasi, dan trimester dari HPHT apa pun.
     */
    public function test_endpoint_kalkulator_menghitung_akurat_dari_hpht(): void
    {
        // Contoh HPHT 10 minggu lalu (Trimester 1)
        $hpht = Carbon::today()->subWeeks(10)->format('Y-m-d');

        $response = $this->actingAs($this->user)->postJson(route('kehamilan.kalkulator'), [
            'hpht' => $hpht,
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');

        $this->assertEquals(10, $data['usia_minggu']);
        $this->assertEquals(1, $data['trimester']['nomor']);
        $this->assertEquals('Trimester 1 (1–13 Mg)', $data['trimester']['label']);
        $this->assertEquals(Carbon::parse($hpht)->addDays(280)->format('Y-m-d'), $data['hpl']);
    }

    /**
     * Test: Dashboard Pengguna menampilkan usia kehamilan dan trimester yang terintegrasi.
     */
    public function test_dashboard_pengguna_terintegrasi_dengan_kalkulasi_kehamilan_aktif(): void
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.pengguna'));

        $response->assertStatus(200);
        $response->assertSee('20'); // usia minggu
        $response->assertSee('Trimester 2');
    }
}
