<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadFotoProfilTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan fake storage public agar tes tidak mengotori disk asli
        Storage::fake('public');

        $this->user = User::factory()->create([
            'name' => 'Sarah Rahmawati',
            'email' => 'sarah@nutrigrow.id',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Cempaka Putih Tengah No. 12',
            'foto_profil' => null,
        ]);
    }

    /**
     * Helper untuk membuat fake image valid (JPEG / PNG / WEBP) tanpa dependensi ekstensi GD.
     */
    protected function createFakeImage(string $filename, int $sizeKilobytes = 10, string $format = 'jpg'): UploadedFile
    {
        if ($format === 'png') {
            $binary = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
            $mime = 'image/png';
        } else {
            // Valid minimal 1x1 JPEG
            $binary = base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=');
            $mime = 'image/jpeg';
        }

        $targetBytes = $sizeKilobytes * 1024;
        if (strlen($binary) < $targetBytes) {
            $binary .= str_repeat('A', $targetBytes - strlen($binary));
        }

        return UploadedFile::fake()->createWithContent($filename, $binary);
    }

    /**
     * Test 1: Frontend komponen unggah foto profil tersedia pada halaman edit profil.
     */
    public function test_halaman_edit_profil_menampilkan_komponen_unggah_foto(): void
    {
        $response = $this->actingAs($this->user)->get(route('profil.edit'));

        $response->assertStatus(200);
        $response->assertSee('Foto Profil Pengguna');
        $response->assertSee('Maks. 2 MB (JPG, PNG, WEBP)');
        $response->assertSee('Pilih Foto');
        $response->assertSee('foto_profil');
        $response->assertSee('avatar-preview-img');
        $response->assertSee('Format: <strong>JPG, JPEG, PNG, WEBP</strong>', false);
        $response->assertSee('Ukuran Maksimum: <strong>2 MB</strong>', false);
    }

    /**
     * Test 2 (Acceptance Criteria 1 & 2): Berhasil mengunggah foto profil berformat valid (JPG)
     * dan berukuran <= 2MB, lalu menghubungkannya ke akun pengguna.
     */
    public function test_berhasil_mengunggah_foto_profil_format_jpg_dan_terhubung_ke_akun(): void
    {
        $file = $this->createFakeImage('sarah_avatar.jpg', 500, 'jpg'); // 500 KB (valid)

        $response = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah Rahmawati',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Cempaka Putih Tengah No. 12',
            'foto_profil' => $file,
        ]);

        $response->assertRedirect(route('profil.index'));
        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertNotNull($this->user->foto_profil);
        $this->assertTrue(str_starts_with($this->user->foto_profil, 'profile-photos/'));

        // Pastikan file benar-benar tersimpan di storage disk public
        Storage::disk('public')->assertExists($this->user->foto_profil);

        // Pastikan accessor getFotoProfilUrlAttribute menghasilkan link yang benar
        $this->assertStringContainsString('storage/' . $this->user->foto_profil, $this->user->foto_profil_url);
    }

    /**
     * Test 3: Berhasil mengunggah foto profil melalui endpoint khusus POST /profil/foto.
     */
    public function test_berhasil_mengunggah_foto_via_endpoint_upload_foto(): void
    {
        $file = $this->createFakeImage('sarah_avatar.png', 800, 'png'); // 800 KB (valid)

        $response = $this->actingAs($this->user)->post(route('profil.foto.upload'), [
            'foto_profil' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Foto profil berhasil diperbarui!');

        $this->user->refresh();
        $this->assertNotNull($this->user->foto_profil);
        Storage::disk('public')->assertExists($this->user->foto_profil);
    }

    /**
     * Test 4 (Acceptance Criteria 2): Format file yang tidak sesuai ditolak dengan pesan kesalahan.
     */
    public function test_format_file_tidak_sesuai_ditolak_dengan_pesan_kesalahan(): void
    {
        // Unggah file berformat PDF (.pdf)
        $invalidFile = UploadedFile::fake()->create('dokumen_rahasia.pdf', 300, 'application/pdf');

        $response = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah Rahmawati',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Cempaka Putih Tengah No. 12',
            'foto_profil' => $invalidFile,
        ]);

        $response->assertSessionHasErrors('foto_profil');
        $errorMessage = session('errors')->first('foto_profil');

        $this->assertTrue(
            str_contains($errorMessage, 'Format foto profil harus berupa JPG') ||
            str_contains($errorMessage, 'File yang diunggah harus berupa gambar')
        );

        $this->user->refresh();
        $this->assertNull($this->user->foto_profil);
    }

    /**
     * Test 5 (Acceptance Criteria 2): Format tidak sesuai pada endpoint mandiri juga ditolak dengan pesan kesalahan.
     */
    public function test_format_file_tidak_sesuai_pada_endpoint_upload_ditolak(): void
    {
        $invalidFile = UploadedFile::fake()->create('dokumen.txt', 100, 'text/plain');

        $response = $this->actingAs($this->user)->post(route('profil.foto.upload'), [
            'foto_profil' => $invalidFile,
        ]);

        $response->assertSessionHasErrors('foto_profil');
        $errorMessage = session('errors')->first('foto_profil');

        $this->assertTrue(
            str_contains($errorMessage, 'Format foto profil harus berupa JPG') ||
            str_contains($errorMessage, 'File yang diunggah harus berupa gambar')
        );

        $this->user->refresh();
        $this->assertNull($this->user->foto_profil);
    }

    /**
     * Test 6 (Acceptance Criteria 2): Ukuran file melebihi 2 MB ditolak dengan pesan kesalahan.
     */
    public function test_ukuran_file_melebihi_2mb_ditolak_dengan_pesan_kesalahan(): void
    {
        // 3072 KB = 3 MB (melebihi batas 2048 KB / 2 MB)
        $largeFile = $this->createFakeImage('gambar_raksasa.jpg', 3072, 'jpg');

        $response = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah Rahmawati',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Cempaka Putih Tengah No. 12',
            'foto_profil' => $largeFile,
        ]);

        $response->assertSessionHasErrors('foto_profil');
        $this->assertEquals(
            'Ukuran file foto profil tidak boleh melebihi 2 MB.',
            session('errors')->first('foto_profil')
        );

        $this->user->refresh();
        $this->assertNull($this->user->foto_profil);
    }

    /**
     * Test 7: Mengunggah foto profil baru menghapus foto profil lama dari storage (mencegah penumpukan file).
     */
    public function test_mengunggah_foto_baru_menghapus_foto_lama_dari_penyimpanan(): void
    {
        // Simpan foto awal
        $oldFile = $this->createFakeImage('foto_pertama.jpg', 400, 'jpg');
        $oldPath = $oldFile->store('profile-photos', 'public');
        $this->user->update(['foto_profil' => $oldPath]);

        Storage::disk('public')->assertExists($oldPath);

        // Unggah foto kedua
        $newFile = $this->createFakeImage('foto_kedua.jpg', 400, 'jpg');
        $response = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah Rahmawati',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Cempaka Putih Tengah No. 12',
            'foto_profil' => $newFile,
        ]);

        $response->assertRedirect(route('profil.index'));

        $this->user->refresh();
        $this->assertNotEquals($oldPath, $this->user->foto_profil);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($this->user->foto_profil);
    }

    /**
     * Test 8: Pengguna dapat menghapus foto profil dan mengembalikan avatar ke inisial nama.
     */
    public function test_pengguna_dapat_menghapus_foto_profil_dan_kembali_ke_inisial(): void
    {
        $file = $this->createFakeImage('foto_hapus.jpg', 400, 'jpg');
        $path = $file->store('profile-photos', 'public');
        $this->user->update(['foto_profil' => $path]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($this->user)->delete(route('profil.foto.destroy'));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Foto profil berhasil dihapus.');

        $this->user->refresh();
        $this->assertNull($this->user->foto_profil);
        Storage::disk('public')->assertMissing($path);
    }

    /**
     * Test 9: Pengguna dapat menghapus foto profil melalui form update dengan flag hapus_foto.
     */
    public function test_pengguna_dapat_menghapus_foto_profil_via_form_update(): void
    {
        $file = $this->createFakeImage('foto_hapus2.jpg', 400, 'jpg');
        $path = $file->store('profile-photos', 'public');
        $this->user->update(['foto_profil' => $path]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($this->user)->put(route('profil.update'), [
            'name' => 'Sarah Rahmawati',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Cempaka Putih Tengah No. 12',
            'hapus_foto' => 1,
        ]);

        $response->assertRedirect(route('profil.index'));

        $this->user->refresh();
        $this->assertNull($this->user->foto_profil);
        Storage::disk('public')->assertMissing($path);
    }

    /**
     * Test 10: Foto profil terhubung dan tampil di halaman profil dan dashboard.
     */
    public function test_foto_profil_ditampilkan_di_halaman_profil_dan_dashboard(): void
    {
        $file = $this->createFakeImage('foto_sarah.jpg', 400, 'jpg');
        $path = $file->store('profile-photos', 'public');
        $this->user->update(['foto_profil' => $path]);

        // Halaman Profil
        $responseProfil = $this->actingAs($this->user)->get(route('profil.index'));
        $responseProfil->assertStatus(200);
        $responseProfil->assertSee($this->user->foto_profil);

        // Halaman Dashboard
        $responseDashboard = $this->actingAs($this->user)->get(route('dashboard.pengguna'));
        $responseDashboard->assertStatus(200);
        $responseDashboard->assertSee($this->user->foto_profil);
    }
}
