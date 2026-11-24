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
        $response->assertSee('Tambah Informasi Nutrisi');
    }

    /**
     * Acceptance Criteria:
     * Admin mengisi nama bahan/menu, kandungan gizi, kategori fase dan kondisi, serta saran penggunaan.
     */
    public function test_admin_berhasil_menambahkan_informasi_nutrisi_dengan_field_lengkap(): void
    {
        $payload = [
            'nama_bahan_menu' => 'Ikan Kembung & Telur Ayam',
            'kandungan_gizi'  => 'DHA, Protein 18g, Omega-3, Zat Besi',
            'kategori_fase'   => 'Masa Kehamilan',
            'kategori_kondisi'=> 'Makanan Bergizi',
            'saran_penggunaan'=> 'Konsumsi 2-3 kali seminggu dikukus atau dipanggang matang sempurna.',
            'deskripsi_manfaat'=> 'Membantu perkembangan sel otak janin dan mencegah anemia maternal.',
        ];

        $response = $this->actingAs($this->user)->post(route('admin.informasi-nutrisi.store'), $payload);

        $response->assertRedirect(route('informasi-nutrisi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('informasi_nutrisis', [
            'nama_bahan_menu' => 'Ikan Kembung & Telur Ayam',
            'kategori_fase'   => 'Masa Kehamilan',
            'kategori_kondisi'=> 'Makanan Bergizi',
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
            'kandungan_gizi'  => '',
            'kategori_fase'   => '',
            'kategori_kondisi'=> '',
            'saran_penggunaan'=> '',
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
            'kandungan_gizi'  => 'Asam Folat, Kalsium 300mg',
            'kategori_fase'   => 'Persiapan Kehamilan',
            'kategori_kondisi'=> 'Zat Gizi',
            'saran_penggunaan'=> 'Minum di pagi hari.',
        ]);

        $response = $this->actingAs($this->user)->get(route('informasi-nutrisi.index', ['fase' => 'Persiapan Kehamilan']));
        $response->assertStatus(200);
        $response->assertSee('Alpukat & Susu Segar');
    }

    // ─── PBI-026: Ubah & Hapus ───────────────────────────────────────────────

    /**
     * PBI-026 Test 1: Halaman formulir edit informasi nutrisi dapat diakses.
     */
    public function test_halaman_edit_informasi_nutrisi_dapat_diakses(): void
    {
        $nutrisi = InformasiNutrisi::create([
            'nama_bahan_menu' => 'Sup Sayur Bayam Jagung',
            'kandungan_gizi'  => 'Zat Besi, Vitamin A, Serat',
            'kategori_fase'   => 'Masa Kehamilan',
            'kategori_kondisi'=> 'Makanan Bergizi',
            'saran_penggunaan'=> 'Sajikan hangat bersama nasi merah.',
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
            'kandungan_gizi'  => 'Karbohidrat Kompleks, Protein 8g',
            'kategori_fase'   => 'Tumbuh Kembang Anak',
            'kategori_kondisi'=> 'Pencegahan Stunting',
            'saran_penggunaan'=> 'Berikan 2x sehari untuk MPASI bayi 6-9 bulan.',
        ]);

        $updatePayload = [
            'nama_bahan_menu'  => 'Bubur Beras Merah Telur & Salmon',
            'kandungan_gizi'   => 'DHA 300mg, Protein 14g, Omega-3',
            'kategori_fase'    => 'Tumbuh Kembang Anak',
            'kategori_kondisi' => 'Pencegahan Stunting',
            'saran_penggunaan' => 'Berikan 2-3x sehari dengan tekstur lumat halus.',
            'deskripsi_manfaat'=> 'Pencegah stunting dan pendukung tumbuh kembang sel otak.',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('informasi-nutrisi.update', $nutrisi->id), $updatePayload);

        $response->assertRedirect(route('informasi-nutrisi.index'));
        $response->assertSessionHas('success');

        // Pastikan perubahan tersimpan di database
        $this->assertDatabaseHas('informasi_nutrisis', [
            'id'              => $nutrisi->id,
            'nama_bahan_menu' => 'Bubur Beras Merah Telur & Salmon',
            'kandungan_gizi'  => 'DHA 300mg, Protein 14g, Omega-3',
        ]);
    }

    /**
     * PBI-026 Test 3: Isian wajib update yang kosong ditolak.
     */
    public function test_update_informasi_nutrisi_isian_wajib_kosong_ditolak(): void
    {
        $nutrisi = InformasiNutrisi::create([
            'nama_bahan_menu' => 'Tahu Tempe Kukus',
            'kandungan_gizi'  => 'Protein Nabati, Isoflavon',
            'kategori_fase'   => 'Ibu Menyusui',
            'kategori_kondisi'=> 'Makanan Bergizi',
            'saran_penggunaan'=> 'Sajikan sebagai lauk protein.',
        ]);

        $response = $this->actingAs($this->user)
            ->from(route('informasi-nutrisi.edit', $nutrisi->id))
            ->put(route('informasi-nutrisi.update', $nutrisi->id), [
                'nama_bahan_menu' => '',
                'kandungan_gizi'  => '',
                'kategori_fase'   => '',
                'kategori_kondisi'=> '',
                'saran_penggunaan'=> '',
            ]);

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
            'kandungan_gizi'  => 'Vitamin E, Magnesium, Serat',
            'kategori_fase'   => 'Persiapan Kehamilan',
            'kategori_kondisi'=> 'Makanan Bergizi',
            'saran_penggunaan'=> 'Konsumsi 1 genggam per hari sebagai camilan sehat.',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('informasi-nutrisi.destroy', $nutrisi->id));

        $response->assertRedirect(route('informasi-nutrisi.index'));
        $response->assertSessionHas('success');

        // Pastikan terhapus dari basis data
        $this->assertDatabaseMissing('informasi_nutrisis', [
            'id'              => $nutrisi->id,
            'nama_bahan_menu' => 'Camilan Kacang Almond & Kismis',
        ]);

        // Pastikan tidak lagi muncul pada rekomendasi berikutnya (halaman baru tanpa session flash)
        $this->actingAs($this->user)->get(route('informasi-nutrisi.index'));
        $this->assertNull(InformasiNutrisi::find($nutrisi->id));
    }

    // ─── PBI-027: Cari & Filter Informasi Nutrisi ───────────────────────────

    /**
     * PBI-027 Test 1: Acceptance Criteria:
     * Pencarian nama dan filter kategori fase/kondisi dapat digabung.
     */
    public function test_pencarian_dan_filter_fase_kondisi_dapat_digabung(): void
    {
        // Data yang akan ditemukan (cocok semua: nama, fase, kondisi)
        InformasiNutrisi::create([
            'nama_bahan_menu' => 'Telur Rebus Bayam',
            'kandungan_gizi'  => 'Protein 13g, Zat Besi, Vitamin A',
            'kategori_fase'   => 'Ibu Menyusui',
            'kategori_kondisi'=> 'Makanan Bergizi',
            'saran_penggunaan'=> 'Konsumsi setiap pagi.',
        ]);

        // Data yang TIDAK seharusnya muncul (fase berbeda)
        InformasiNutrisi::create([
            'nama_bahan_menu' => 'Telur Rebus Wortel',
            'kandungan_gizi'  => 'Vitamin A, Beta-Karoten',
            'kategori_fase'   => 'Tumbuh Kembang Anak',
            'kategori_kondisi'=> 'Makanan Bergizi',
            'saran_penggunaan'=> 'Sajikan untuk MPASI.',
        ]);

        // Cari dengan q=Telur Rebus, fase=Ibu Menyusui, kondisi=Makanan Bergizi
        $response = $this->actingAs($this->user)->get(
            route('informasi-nutrisi.index', [
                'q'      => 'Telur Rebus',
                'fase'   => 'Ibu Menyusui',
                'kondisi'=> 'Makanan Bergizi',
            ])
        );

        $response->assertStatus(200);
        $response->assertSee('Telur Rebus Bayam');
        $response->assertDontSee('Telur Rebus Wortel');
    }

    /**
     * PBI-027 Test 2: Acceptance Criteria:
     * Hasil kosong menampilkan pesan data tidak ditemukan.
     */
    public function test_hasil_pencarian_kosong_menampilkan_pesan_tidak_ditemukan(): void
    {
        // Tidak ada data yang cocok

        $response = $this->actingAs($this->user)->get(
            route('informasi-nutrisi.index', [
                'q'    => 'Makanan yang sangat tidak ada',
                'fase' => 'Persiapan Kehamilan',
            ])
        );

        $response->assertStatus(200);
        $response->assertSee('Data Tidak Ditemukan');
        $response->assertSee('Makanan yang sangat tidak ada');
    }

    /**
     * PBI-027 Test 3: Filter hanya fase menampilkan data yang sesuai.
     */
    public function test_filter_hanya_fase_menampilkan_data_sesuai(): void
    {
        InformasiNutrisi::create([
            'nama_bahan_menu' => 'Kacang Merah Rebus',
            'kandungan_gizi'  => 'Protein Nabati, Zat Besi, Folat',
            'kategori_fase'   => 'Persiapan Kehamilan',
            'kategori_kondisi'=> 'Zat Gizi',
            'saran_penggunaan'=> 'Rebus dan sajikan sebagai lauk.',
        ]);

        InformasiNutrisi::create([
            'nama_bahan_menu' => 'Ikan Gabus Kukus',
            'kandungan_gizi'  => 'Protein 24g, Albumin',
            'kategori_fase'   => 'Tumbuh Kembang Anak',
            'kategori_kondisi'=> 'Pencegahan Stunting',
            'saran_penggunaan'=> 'Kukus matang sempurna.',
        ]);

        $response = $this->actingAs($this->user)->get(
            route('informasi-nutrisi.index', ['fase' => 'Persiapan Kehamilan'])
        );

        $response->assertStatus(200);
        $response->assertSee('Kacang Merah Rebus');
        $response->assertDontSee('Ikan Gabus Kukus');
    }

    /**
     * PBI-027 Test 4: Filter hanya kondisi menampilkan data yang sesuai.
     */
    public function test_filter_hanya_kondisi_menampilkan_data_sesuai(): void
    {
        InformasiNutrisi::create([
            'nama_bahan_menu' => 'Hati Sapi Tumis',
            'kandungan_gizi'  => 'Zat Besi Heme, Vitamin B12',
            'kategori_fase'   => 'Masa Kehamilan',
            'kategori_kondisi'=> 'Anemia',
            'saran_penggunaan'=> 'Konsumsi 2x seminggu.',
        ]);

        InformasiNutrisi::create([
            'nama_bahan_menu' => 'Pisang Kepok Rebus',
            'kandungan_gizi'  => 'Kalium, Karbohidrat',
            'kategori_fase'   => 'Ibu Menyusui',
            'kategori_kondisi'=> 'Makanan Bergizi',
            'saran_penggunaan'=> 'Makan 1-2 buah per hari.',
        ]);

        $response = $this->actingAs($this->user)->get(
            route('informasi-nutrisi.index', ['kondisi' => 'Anemia'])
        );

        $response->assertStatus(200);
        $response->assertSee('Hati Sapi Tumis');
        $response->assertDontSee('Pisang Kepok Rebus');
    }
}
