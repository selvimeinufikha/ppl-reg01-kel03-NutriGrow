<?php

namespace App\Http\Controllers;

use App\Models\Kehamilan;
use App\Models\Pasangan;
use App\Models\User;
use App\Services\HealthFacilityRecommendationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Dapatkan user yang sedang aktif atau fallback ke user demo.
     */
    protected function getActiveUser(): User
    {
        if (Auth::check()) {
            return Auth::user();
        }

        return User::firstOrCreate(
            ['email' => 'sarah@nutrigrow.id'],
            [
                'name' => 'Sarah Rahmawati',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Cempaka Putih Tengah No. 12, RT 04/RW 02',
                'kota' => 'Jakarta Pusat',
                'kecamatan' => 'Cempaka Putih',
                'password' => bcrypt('password123'),
            ]
        );
    }

    /**
     * Tampilkan halaman profil pengguna dan rekomendasi layanan kesehatan berdasarkan alamat.
     */
    public function index()
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        // Pastikan ada nilai default demo jika field profil masih kosong
        if (empty($user->no_telepon)) {
            $user->no_telepon = '081234567890';
        }
        if (empty($user->alamat)) {
            $user->alamat = 'Jl. Cempaka Putih Tengah No. 12, RT 04/RW 02';
            $user->kota = 'Jakarta Pusat';
            $user->kecamatan = 'Cempaka Putih';
            $user->save();
        }

        // Acceptance Criteria: Alamat profil dipakai sebagai acuan lokasi rekomendasi layanan kesehatan
        $rekomendasiFaskes = HealthFacilityRecommendationService::getRekomendasi(
            $user->alamat,
            $user->kota,
            $user->kecamatan
        );

        $pasangan = Pasangan::where('user_id', $user->id)->first();
        $totalKehamilan = Kehamilan::where('user_id', $user->id)->count();
        $kehamilanAktif = Kehamilan::where('user_id', $user->id)->where('status', 'berlangsung')->first();

        $tanggalHariIni = Carbon::now()->locale('id')->translatedFormat('l, j F Y');

        return view('ProfilPengguna.index', [
            'user' => $user,
            'userName' => $user->name,
            'userId' => 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT',
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Mawar 1 & Puskesmas Sejahtera',
            'keluargaName' => 'Keluarga Pratama',
            'rekomendasiFaskes' => $rekomendasiFaskes,
            'pasangan' => $pasangan,
            'totalKehamilan' => $totalKehamilan,
            'kehamilanAktif' => $kehamilanAktif,
        ]);
    }

    /**
     * Tampilkan formulir edit profil (nama, nomor kontak, dan alamat).
     */
    public function edit()
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        $tanggalHariIni = Carbon::now()->locale('id')->translatedFormat('l, j F Y');

        return view('ProfilPengguna.edit', [
            'user' => $user,
            'userName' => $user->name,
            'userId' => 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT',
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Mawar 1 & Puskesmas Sejahtera',
            'keluargaName' => 'Keluarga Pratama',
        ]);
    }

    /**
     * Simpan file foto profil ke disk public dan hapus file lama jika ada.
     */
    protected function simpanFotoProfil($file, ?string $oldPath = null): string
    {
        if ($oldPath && !str_starts_with($oldPath, 'http') && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $file->store('profile-photos', 'public');
    }

    /**
     * Simpan pembaruan profil pengguna (nama, kontak, alamat, foto profil).
     */
    public function update(Request $request)
    {
        $user = $this->getActiveUser();

        // Validasi ketat sesuai Acceptance Criteria
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'no_telepon' => [
                'required',
                'string',
                'min:10',
                'max:16',
                'regex:/^(\+62|62|0)8[0-9]{7,13}$/',
            ],
            'alamat' => ['required', 'string', 'min:5', 'max:500'],
            'kota' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'nik' => ['nullable', 'string', 'max:20'],
            'foto_profil' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'no_telepon.required' => 'Nomor kontak / telepon wajib diisi.',
            'no_telepon.min' => 'Nomor kontak minimal 10 digit.',
            'no_telepon.regex' => 'Format nomor kontak tidak valid. Gunakan format nomor ponsel Indonesia yang benar (contoh: 081234567890).',
            'alamat.required' => 'Alamat tempat tinggal / domisili wajib diisi.',
            'alamat.min' => 'Alamat minimal 5 karakter agar acuan rekomendasi faskes akurat.',
            'foto_profil.file' => 'File foto profil tidak valid.',
            'foto_profil.image' => 'File yang diunggah harus berupa gambar.',
            'foto_profil.mimes' => 'Format foto profil harus berupa JPG, JPEG, PNG, atau WEBP.',
            'foto_profil.max' => 'Ukuran file foto profil tidak boleh melebihi 2 MB.',
        ]);

        // Tangani hapus foto profil jika diminta
        if ($request->boolean('hapus_foto') && $user->foto_profil) {
            if (!str_starts_with($user->foto_profil, 'http') && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = null;
        }

        // Tangani unggah foto profil jika ada file
        if ($request->hasFile('foto_profil')) {
            $path = $this->simpanFotoProfil($request->file('foto_profil'), $user->foto_profil);
            $user->foto_profil = $path;
        }

        $user->name = trim($validated['name']);
        $user->no_telepon = trim($validated['no_telepon']);
        $user->alamat = trim($validated['alamat']);
        $user->kota = $validated['kota'] ?? $user->kota;
        $user->kecamatan = $validated['kecamatan'] ?? $user->kecamatan;
        $user->kelurahan = $validated['kelurahan'] ?? $user->kelurahan;
        $user->nik = $validated['nik'] ?? $user->nik;
        $user->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profil dan acuan alamat layanan kesehatan berhasil diperbarui!',
                'data' => $user,
                'foto_url' => $user->foto_profil_url,
                'rekomendasi_faskes' => $user->rekomendasi_faskes,
            ]);
        }

        return redirect()->route('profil.index')->with('success', 'Profil Anda dan acuan lokasi rekomendasi layanan kesehatan berhasil diperbarui!');
    }

    /**
     * Upload dan simpan foto profil pengguna secara mandiri.
     * Acceptance Criteria:
     * - Foto yang diunggah harus berformat dan berukuran sesuai ketentuan (JPG/JPEG/PNG/WEBP, max 2MB).
     * - Format atau ukuran yang tidak sesuai ditolak dengan pesan kesalahan.
     */
    public function uploadFoto(Request $request)
    {
        $user = $this->getActiveUser();

        $request->validate([
            'foto_profil' => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'foto_profil.required' => 'Silakan pilih file foto profil terlebih dahulu.',
            'foto_profil.file' => 'File foto profil tidak valid.',
            'foto_profil.image' => 'File yang diunggah harus berupa gambar.',
            'foto_profil.mimes' => 'Format foto profil harus berupa JPG, JPEG, PNG, atau WEBP.',
            'foto_profil.max' => 'Ukuran file foto profil tidak boleh melebihi 2 MB.',
        ]);

        $path = $this->simpanFotoProfil($request->file('foto_profil'), $user->foto_profil);
        $user->foto_profil = $path;
        $user->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Foto profil berhasil diperbarui!',
                'foto_url' => $user->foto_profil_url,
                'user' => $user,
            ]);
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Hapus foto profil pengguna dan kembalikan ke inisial nama.
     */
    public function hapusFoto(Request $request)
    {
        $user = $this->getActiveUser();

        if ($user->foto_profil) {
            if (!str_starts_with($user->foto_profil, 'http') && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = null;
            $user->save();
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Foto profil berhasil dihapus.',
                'user' => $user,
            ]);
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Tampilkan formulir ganti kata sandi pengguna (PBI-012).
     */
    public function editPassword()
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        $tanggalHariIni = Carbon::now()->locale('id')->translatedFormat('l, j F Y');

        return view('ProfilPengguna.ganti-password', [
            'user' => $user,
            'userName' => $user->name,
            'userId' => 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT',
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Mawar 1 & Puskesmas Sejahtera',
            'keluargaName' => 'Keluarga Pratama',
        ]);
    }

    /**
     * Proses verifikasi kata sandi lama, validasi, dan penyimpanan kata sandi baru (PBI-012).
     * Acceptance Criteria:
     * - Kata sandi baru minimal 8 karakter dan disimpan terenkripsi.
     * - Penggantian meminta kata sandi lama yang benar.
     */
    public function updatePassword(Request $request)
    {
        $user = $this->getActiveUser();

        // Normalisasi alias field input jika menggunakan bahasa Indonesia
        if ($request->has('password_lama') && !$request->has('current_password')) {
            $request->merge(['current_password' => $request->input('password_lama')]);
        }
        if ($request->has('password_baru') && !$request->has('password')) {
            $request->merge(['password' => $request->input('password_baru')]);
        }
        if ($request->has('konfirmasi_password') && !$request->has('password_confirmation')) {
            $request->merge(['password_confirmation' => $request->input('konfirmasi_password')]);
        } elseif ($request->has('password_baru_confirmation') && !$request->has('password_confirmation')) {
            $request->merge(['password_confirmation' => $request->input('password_baru_confirmation')]);
        }

        // 1. Validasi kata sandi lama dan baru
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ], [
            'current_password.required' => 'Kata sandi saat ini (lama) wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.different' => 'Kata sandi baru tidak boleh sama dengan kata sandi saat ini.',
        ]);

        // 2. Verifikasi kata sandi lama dengan hash di database (Acceptance Criteria 2)
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini (lama) yang Anda masukkan tidak sesuai.',
                'password_lama' => 'Kata sandi saat ini (lama) yang Anda masukkan tidak sesuai.',
            ])->withInput($request->except(['current_password', 'password', 'password_confirmation', 'password_lama', 'password_baru', 'konfirmasi_password']));
        }

        // 3. Hash dan simpan kata sandi baru (Acceptance Criteria 1)
        $user->password = Hash::make($validated['password']);
        $user->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Kata sandi Anda berhasil diperbarui!',
            ]);
        }

        return redirect()->route('profil.index')->with('success', 'Kata sandi akun Anda berhasil diperbarui!');
    }
}
