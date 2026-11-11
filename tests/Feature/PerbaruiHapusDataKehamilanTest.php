<?php

namespace Tests\Feature;

use App\Models\Kehamilan;
use App\Models\Pasangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerbaruiHapusDataKehamilanTest extends TestCase
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

        $hpht = Carbon::today()->subWeeks(24)->format('Y-m-d');
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
     * Test: Halaman edit data kehamilan dapat diakses dan memuat data eksisting.
     */
    public function test_halaman_edit_kehamilan_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('kehamilan.edit', $this->kehamilan->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Data &amp; Status Kehamilan', false);
        $response->assertSee('Kehamilan Ke-2');
        $response->assertSee('Status Kehamilan Saat Ini');
        $response->assertSee('Berlangsung (Sedang Hamil Aktif)');
        $response->assertSee('Melahirkan (Riwayat Selesai)');
        $response->assertSee('Keguguran');
        // Dialog konfirmasi penghapusan tersedia di halaman
        $response->assertSee('Konfirmasi Penghapusan Data');
    }

    /**
     * Test Acceptance Criteria 1: Status dapat diubah menjadi berlangsung.
     */
    public function test_status_kehamilan_dapat_diubah_menjadi_berlangsung(): void
    {
        $response = $this->actingAs($this->user)->put(route('kehamilan.update', $this->kehamilan->id), [
            'status' => 'berlangsung',
            'hpht' => $this->kehamilan->hpht->format('Y-m-d'),
            'kehamilan_ke' => $this->kehamilan->kehamilan_ke,
            'pasangan_id' => $this->pasangan->id,
            'catatan' => 'Pemeriksaan rutin trimester 2.',
        ]);

        $response->assertRedirect(route('kehamilan.index'));
        $response->assertSessionHas('success');

        $this->kehamilan->refresh();
        $this->assertEquals('berlangsung', $this->kehamilan->status);
        $this->assertEquals('Pemeriksaan rutin trimester 2.', $this->kehamilan->catatan);
    }

    /**
     * Test Acceptance Criteria 1: Status dapat diubah menjadi melahirkan.
     */
    public function test_status_kehamilan_dapat_diubah_menjadi_melahirkan(): void
    {
        $tglPersalinan = Carbon::today()->format('Y-m-d');

        $response = $this->actingAs($this->user)->put(route('kehamilan.update', $this->kehamilan->id), [
            'status' => 'melahirkan',
            'hpht' => $this->kehamilan->hpht->format('Y-m-d'),
            'kehamilan_ke' => $this->kehamilan->kehamilan_ke,
            'pasangan_id' => $this->pasangan->id,
            'tanggal_persalinan' => $tglPersalinan,
            'status_persalinan' => 'Aterm (Cukup Bulan)',
            'nama_anak' => 'Kinan Pratama',
            'catatan' => 'Lahir selamat dan sehat.',
        ]);

        $response->assertRedirect(route('kehamilan.index'));
        $response->assertSessionHas('success');

        $this->kehamilan->refresh();
        $this->assertEquals('melahirkan', $this->kehamilan->status);
        $this->assertEquals('Kinan Pratama', $this->kehamilan->nama_anak);
        $this->assertEquals('Aterm (Cukup Bulan)', $this->kehamilan->status_persalinan);
        $this->assertEquals($tglPersalinan, $this->kehamilan->tanggal_persalinan->format('Y-m-d'));
    }

    /**
     * Test Acceptance Criteria 1: Status dapat diubah menjadi keguguran.
     */
    public function test_status_kehamilan_dapat_diubah_menjadi_keguguran(): void
    {
        $response = $this->actingAs($this->user)->put(route('kehamilan.update', $this->kehamilan->id), [
            'status' => 'keguguran',
            'hpht' => $this->kehamilan->hpht->format('Y-m-d'),
            'kehamilan_ke' => $this->kehamilan->kehamilan_ke,
            'pasangan_id' => $this->pasangan->id,
            'catatan' => 'Keguguran pada usia 8 minggu.',
        ]);

        $response->assertRedirect(route('kehamilan.index'));
        $response->assertSessionHas('success');

        $this->kehamilan->refresh();
        $this->assertEquals('keguguran', $this->kehamilan->status);
    }

    /**
     * Test Validasi: Status kehamilan selain berlangsung, melahirkan, keguguran ditolak.
     */
    public function test_status_kehamilan_tidak_valid_ditolak(): void
    {
        $response = $this->actingAs($this->user)->put(route('kehamilan.update', $this->kehamilan->id), [
            'status' => 'status_palsu',
            'hpht' => $this->kehamilan->hpht->format('Y-m-d'),
            'kehamilan_ke' => 1,
        ]);

        $response->assertSessionHasErrors([
            'status' => 'Status kehamilan harus dipilih antara Berlangsung, Melahirkan, atau Keguguran.',
        ]);

        // Status asli tidak berubah di database
        $this->kehamilan->refresh();
        $this->assertEquals('berlangsung', $this->kehamilan->status);
    }

    /**
     * Test Acceptance Criteria 2: Dialog konfirmasi penghapusan dan eksekusi delete data kehamilan.
     */
    public function test_penghapusan_data_kehamilan_berhasil_menghapus_record(): void
    {
        // 1. Pastikan view index dan edit memiliki dialog konfirmasi penghapusan
        $viewIndex = $this->actingAs($this->user)->get(route('kehamilan.index'));
        $viewIndex->assertStatus(200);
        $viewIndex->assertSee('modalKonfirmasiHapus');
        $viewIndex->assertSee('Konfirmasi Penghapusan Data');
        $viewIndex->assertSee('Ya, Hapus Data');

        // 2. Eksekusi request DELETE setelah konfirmasi disetujui
        $response = $this->actingAs($this->user)->delete(route('kehamilan.destroy', $this->kehamilan->id));

        $response->assertRedirect(route('kehamilan.index'));
        $response->assertSessionHas('success');

        // Pastikan record telah terhapus dari database
        $this->assertDatabaseMissing('kehamilans', [
            'id' => $this->kehamilan->id,
        ]);
        $this->assertDatabaseCount('kehamilans', 0);
    }
}
