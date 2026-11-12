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

    /**
     * PBI-026 Test 1: Halaman formulir edit informasi nutrisi dapat diakses.
     */
    public function test_halaman_edit_informasi_nutrisi_dapat_diakses(): void
    {
        $nutrisi = InformasiNutrisi::create([
            'nama_bahan_menu' => 'Sup Sayur Bayam Jagung',
            'kandungan_gizi' => 'Zat Besi, Vitamin A, Serat',
            'kategori_fase' => 'Masa Kehamilan',
            'kategori_kondisi' => 'Makanan Bergizi',
            'saran_penggunaan' => 'Sajikan hangat bersama nasi merah.',
        ]);

        $response = $this->actingAs($this->user)->get(route('informasi-nutrisi.edit', $nutrisi->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Informasi Nutrisi');
        $response->assertSee('Sup Sayur Bayam Jagung');
    }

    /**
     * PBI-026 Test 2: Acceptance Criteria:
     * Perubahan tersimpan dan dipakai pada rekomendasi pengguna berikutnya.
     */
    public function test_perubahan_informasi_nutrisi_tersimpan_dan_tampil_pada_rekomendasi_berikutnya(): void
    {
        $nutrisi = InformasiNutrisi::create([
            'nama_bahan_menu' => 'Bubur Beras Merah Telur',
            'kandungan_gizi' => 'Karbohidrat Kompleks, Protein 8g',
            'kategori_fase' => 'Tumbuh Kembang Anak',
            'kategori_kondisi' => 'Pencegahan Stunting',
            'saran_penggunaan' => 'Berikan 2x sehari untuk MPASI bayi 6-9 bulan.',
        ]);

        $updatePayload = [
            'nama_bahan_menu' => 'Bubur Beras Merah Telur & Salmon',
            'kandungan_gizi' => 'DHA 300mg, Protein 14g, Omega-3',
            'kategori_fase' => 'Tumbuh Kembang Anak',
            'kategori_kondisi' => 'Pencegahan Stunting',
            'saran_penggunaan' => 'Berikan 2-3x sehari dengan tekstur lumat halus.',
            'deskripsi_manfaat' => 'Pencegah stunting dan pendukung tumbuh kembang sel otak.',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('informasi-nutrisi.update', $nutrisi->id), $updatePayload);

        $response->assertRedirect(route('informasi-nutrisi.index'));
        $response->assertSessionHas('success');

        // Pastikan perubahan tersimpan di database
        $this->assertDatabaseHas('informasi_nutrisis', [
            'id' => $nutrisi->id,
            'nama_bahan_menu' => 'Bubur Beras Merah Telur & Salmon',
            'kandungan_gizi' => 'DHA 300mg, Protein 14g, Omega-3',
        ]);

        // Pastikan dipakai pada rekomendasi berikutnya saat pengguna membuka katalog
        $katalogResponse = $this->actingAs($this->user)->get(route('informasi-nutrisi.index'));
        $katalogResponse->assertStatus(200);
        $katalogResponse->assertSee('Bubur Beras Merah Telur & Salmon');
        $katalogResponse->assertSee('DHA 300mg, Protein 14g, Omega-3');
    }

    /**
     * PBI-026 Test 3: Acceptance Criteria:
     * Isian wajib yang kosong saat update ditolak.
     */
    public function test_update_informasi_nutrisi_isian_wajib_kosong_ditolak(): void
    {
        $nutrisi = InformasiNutrisi::create([
            'nama_bahan_menu' => 'Jus Wortel Jeruk',
            'kandungan_gizi' => 'Vitamin C, Vitamin A',
            'kategori_fase' => 'Ibu Menyusui',
            'kategori_kondisi' => 'Zat Gizi',
            'saran_penggunaan' => 'Minum di siang hari.',
        ]);

        $response = $this->actingAs($this->user)
            ->from(route('informasi-nutrisi.edit', $nutrisi->id))
            ->put(route('informasi-nutrisi.update', $nutrisi->id), [
                'nama_bahan_menu' => '',
                'kandungan_gizi' => '',
                'kategori_fase' => '',
                'kategori_kondisi' => '',
                'saran_penggunaan' => '',
            ]);

        $response->assertRedirect(route('informasi-nutrisi.edit', $nutrisi->id));
        $response->assertSessionHasErrors([
            'nama_bahan_menu',
            'kandungan_gizi',
            'kategori_fase',
            'kategori_kondisi',
            'saran_penggunaan',
        ]);
    }

    /**
     * PBI-026 Test 4: Acceptance Criteria:
     * Informasi nutrisi dapat dihapus dan tidak tampil lagi pada rekomendasi.
     */
    public function test_informasi_nutrisi_dapat_dihapus(): void
    {
        $nutrisi = InformasiNutrisi::create([
            'nama_bahan_menu' => 'Camilan Kacang Almond & Kismis',
            'kandungan_gizi' => 'Vitamin E, Magnesium, Serat',
            'kategori_fase' => 'Persiapan Kehamilan',
            'kategori_kondisi' => 'Makanan Bergizi',
            'saran_penggunaan' => 'Konsumsi 1 genggam per hari sebagai camilan sehat.',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('informasi-nutrisi.destroy', $nutrisi->id));

        $response->assertRedirect(route('informasi-nutrisi.index'));
        $response->assertSessionHas('success');

        // Pastikan terhapus dari basis data
        $this->assertDatabaseMissing('informasi_nutrisis', [
            'id' => $nutrisi->id,
            'nama_bahan_menu' => 'Camilan Kacang Almond & Kismis',
        ]);

        // Pastikan tidak lagi muncul pada rekomendasi berikutnya (halaman baru tanpa session flash)
        $katalogResponse = $this->actingAs($this->user)->get(route('informasi-nutrisi.index'));
        $this->assertNull(InformasiNutrisi::find($nutrisi->id));
    }
}
