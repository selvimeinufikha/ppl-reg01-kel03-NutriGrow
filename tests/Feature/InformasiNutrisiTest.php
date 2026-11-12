<?php

namespace Tests\Feature;

use App\Models\InformasiNutrisi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InformasiNutrisiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Administrator NutriGrow',
            'email' => 'admin@nutrigrow.id',
        ]);
    }

    /**
     * Pastikan halaman daftar/rekomendasi nutrisi dapat diakses.
     */
    public function test_halaman_rekomendasi_nutrisi_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('informasi-nutrisi.index'));
        $response->assertStatus(200);
        $response->assertSee('Rekomendasi Nutrisi');
        $response->assertSee('Pilih Tahap Kehidupan');
    }

    /**
     * Pastikan halaman formulir tambah informasi nutrisi dapat diakses.
     */
    public function test_halaman_formulir_tambah_informasi_nutrisi_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.informasi-nutrisi.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Informasi &amp; Rekomendasi Nutrisi', false);
        $response->assertSee('Nama Bahan / Menu Makanan', false);
        $response->assertSee('Kandungan Gizi', false);
        $response->assertSee('Kategori Fase', false);
        $response->assertSee('Kategori Kondisi', false);
        $response->assertSee('Saran Penggunaan', false);
    }

    /**
     * Acceptance Criteria:
     * Admin mengisi nama bahan/menu, kandungan gizi, kategori fase dan kondisi, serta saran penggunaan.
     * Data berhasil disimpan dan dialihkan ke katalog.
     */
    public function test_admin_berhasil_menambahkan_informasi_nutrisi_dengan_field_lengkap(): void
    {
        $payload = [
            'nama_bahan_menu' => 'Ikan Kembung & Telur Ayam',
            'kandungan_gizi' => 'DHA, Protein 18g, Omega-3, Zat Besi',
            'kategori_fase' => 'Masa Kehamilan',
            'kategori_kondisi' => 'Makanan Bergizi',
            'saran_penggunaan' => 'Konsumsi 2-3 kali seminggu dikukus atau dipanggang matang sempurna.',
            'deskripsi_manfaat' => 'Membantu perkembangan sel otak janin dan mencegah anemia maternal.',
        ];

        $response = $this->actingAs($this->user)->post(route('admin.informasi-nutrisi.store'), $payload);

        $response->assertRedirect(route('informasi-nutrisi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('informasi_nutrisis', [
            'nama_bahan_menu' => 'Ikan Kembung & Telur Ayam',
            'kategori_fase' => 'Masa Kehamilan',
            'kategori_kondisi' => 'Makanan Bergizi',
        ]);
    }

    /**
     * Acceptance Criteria:
     * Isian wajib yang kosong ditolak (validasi gagal jika nama bahan/menu, kandungan gizi,
     * kategori fase, kategori kondisi, atau saran penggunaan tidak diisi).
     */
    public function test_isian_wajib_yang_kosong_ditolak(): void
    {
        $payload = [
            'nama_bahan_menu' => '',
            'kandungan_gizi' => '',
            'kategori_fase' => '',
            'kategori_kondisi' => '',
            'saran_penggunaan' => '',
        ];

        $response = $this->actingAs($this->user)
            ->from(route('admin.informasi-nutrisi.create'))
            ->post(route('admin.informasi-nutrisi.store'), $payload);

        $response->assertRedirect(route('admin.informasi-nutrisi.create'));
        $response->assertSessionHasErrors([
            'nama_bahan_menu',
            'kandungan_gizi',
            'kategori_fase',
            'kategori_kondisi',
            'saran_penggunaan',
        ]);
    }

    /**
     * Pastikan filter fase dan pencarian berfungsi dengan baik.
     */
    public function test_filter_katalog_rekomendasi_nutrisi(): void
    {
        InformasiNutrisi::create([
            'nama_bahan_menu' => 'Alpukat & Susu Segar',
            'kandungan_gizi' => 'Asam Folat, Kalsium 300mg',
            'kategori_fase' => 'Persiapan Kehamilan',
            'kategori_kondisi' => 'Zat Gizi',
            'saran_penggunaan' => 'Minum di pagi hari.',
        ]);

        $response = $this->actingAs($this->user)->get(route('informasi-nutrisi.index', ['fase' => 'Persiapan Kehamilan']));
        $response->assertStatus(200);
        $response->assertSee('Alpukat & Susu Segar');
    }
}
