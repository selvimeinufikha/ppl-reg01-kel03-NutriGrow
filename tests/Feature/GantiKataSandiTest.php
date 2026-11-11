<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GantiKataSandiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $oldPasswordRaw = 'password123';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Sarah Rahmawati',
            'email' => 'sarah@nutrigrow.id',
            'password' => Hash::make($this->oldPasswordRaw),
        ]);
    }

    /**
     * Test 1: Halaman formulir ganti kata sandi dapat diakses (frontend).
     */
    public function test_halaman_formulir_ganti_kata_sandi_dapat_diakses(): void
    {
        $response = $this->actingAs($this->user)->get(route('profil.password.edit'));

        $response->assertStatus(200);
        $response->assertSee('Ganti Kata Sandi Akun');
        $response->assertSee('Kata Sandi Saat Ini (Lama)');
        $response->assertSee('Kata Sandi Baru');
        $response->assertSee('Konfirmasi Kata Sandi Baru');
        $response->assertSee('Minimal 8 karakter (Acceptance Criteria)', false);
        $response->assertSee('Perbarui Kata Sandi');
    }

    /**
     * Test 2 (Acceptance Criteria 1 & 2): Pengguna berhasil mengganti kata sandi dengan kata sandi lama yang benar,
     * kata sandi baru minimal 8 karakter dan disimpan terenkripsi (hashed) di database.
     */
    public function test_pengguna_berhasil_mengganti_kata_sandi_dan_disimpan_terenkripsi(): void
    {
        $newPasswordRaw = 'RahasiaBaru2026!';

        $response = $this->actingAs($this->user)->put(route('profil.password.update'), [
            'current_password' => $this->oldPasswordRaw,
            'password' => $newPasswordRaw,
            'password_confirmation' => $newPasswordRaw,
        ]);

        $response->assertRedirect(route('profil.index'));
        $response->assertSessionHas('success', 'Kata sandi akun Anda berhasil diperbarui!');

        $this->user->refresh();

        // Acceptance Criteria 1: Disimpan terenkripsi di database (bukan plain text)
        $this->assertNotEquals($newPasswordRaw, $this->user->password);
        $this->assertTrue(Hash::check($newPasswordRaw, $this->user->password));

        // Kata sandi lama tidak lagi dapat digunakan
        $this->assertFalse(Hash::check($this->oldPasswordRaw, $this->user->password));
    }

    /**
     * Test 3 (Acceptance Criteria 2): Penggantian meminta kata sandi lama yang benar.
     * Jika kata sandi lama salah, proses ditolak dengan pesan kesalahan.
     */
    public function test_penggantian_kata_sandi_gagal_jika_kata_sandi_lama_salah(): void
    {
        $response = $this->actingAs($this->user)->put(route('profil.password.update'), [
            'current_password' => 'kataSandiSalahTotal123',
            'password' => 'passwordBaruValid8',
            'password_confirmation' => 'passwordBaruValid8',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertEquals(
            'Kata sandi saat ini (lama) yang Anda masukkan tidak sesuai.',
            session('errors')->first('current_password')
        );

        $this->user->refresh();
        // Kata sandi lama tetap aktif & tidak berubah
        $this->assertTrue(Hash::check($this->oldPasswordRaw, $this->user->password));
    }

    /**
     * Test 4 (Acceptance Criteria 1): Kata sandi baru kurang dari 8 karakter ditolak dengan pesan kesalahan.
     */
    public function test_kata_sandi_baru_kurang_dari_8_karakter_ditolak_dengan_pesan_kesalahan(): void
    {
        $response = $this->actingAs($this->user)->put(route('profil.password.update'), [
            'current_password' => $this->oldPasswordRaw,
            'password' => 'pendek', // 6 karakter (< 8 karakter)
            'password_confirmation' => 'pendek',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertEquals(
            'Kata sandi baru minimal 8 karakter.',
            session('errors')->first('password')
        );

        $this->user->refresh();
        $this->assertTrue(Hash::check($this->oldPasswordRaw, $this->user->password));
    }

    /**
     * Test 5: Konfirmasi kata sandi baru tidak cocok ditolak dengan pesan kesalahan.
     */
    public function test_konfirmasi_kata_sandi_baru_tidak_cocok_ditolak(): void
    {
        $response = $this->actingAs($this->user)->put(route('profil.password.update'), [
            'current_password' => $this->oldPasswordRaw,
            'password' => 'passwordBaru123',
            'password_confirmation' => 'passwordBedaLainnya456',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertEquals(
            'Konfirmasi kata sandi baru tidak cocok.',
            session('errors')->first('password')
        );
    }

    /**
     * Test 6: Kata sandi baru tidak boleh sama dengan kata sandi lama.
     */
    public function test_kata_sandi_baru_tidak_boleh_sama_dengan_kata_sandi_lama(): void
    {
        $response = $this->actingAs($this->user)->put(route('profil.password.update'), [
            'current_password' => $this->oldPasswordRaw,
            'password' => $this->oldPasswordRaw,
            'password_confirmation' => $this->oldPasswordRaw,
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertEquals(
            'Kata sandi baru tidak boleh sama dengan kata sandi saat ini.',
            session('errors')->first('password')
        );
    }

    /**
     * Test 7: Dukungan nama alias field input berbahasa Indonesia (password_lama, password_baru, konfirmasi_password).
     */
    public function test_dukungan_alias_input_bahasa_indonesia(): void
    {
        $newPasswordRaw = 'KombinasiAman88!';

        $response = $this->actingAs($this->user)->put(route('profil.password.update'), [
            'password_lama' => $this->oldPasswordRaw,
            'password_baru' => $newPasswordRaw,
            'konfirmasi_password' => $newPasswordRaw,
        ]);

        $response->assertRedirect(route('profil.index'));
        $this->user->refresh();
        $this->assertTrue(Hash::check($newPasswordRaw, $this->user->password));
    }

    /**
     * Test 8: Dukungan request AJAX / JSON.
     */
    public function test_dukungan_request_json_ajax(): void
    {
        $newPasswordRaw = 'PasswordAjax2026!';

        $response = $this->actingAs($this->user)->putJson(route('profil.password.update'), [
            'current_password' => $this->oldPasswordRaw,
            'password' => $newPasswordRaw,
            'password_confirmation' => $newPasswordRaw,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Kata sandi Anda berhasil diperbarui!',
        ]);

        $this->user->refresh();
        $this->assertTrue(Hash::check($newPasswordRaw, $this->user->password));
    }

    /**
     * Test 9: Navigasi dan link ke halaman ganti kata sandi tersedia di profil pengguna.
     */
    public function test_link_ganti_kata_sandi_tersedia_di_halaman_profil_pengguna(): void
    {
        $response = $this->actingAs($this->user)->get(route('profil.index'));

        $response->assertStatus(200);
        $response->assertSee(route('profil.password.edit'));
        $response->assertSee('Ganti Kata Sandi');
        $response->assertSee('Keamanan &amp; Kata Sandi Akun', false);
    }
}
