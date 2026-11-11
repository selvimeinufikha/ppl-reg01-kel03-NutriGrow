<?php

namespace App\Http\Controllers;

use App\Models\Kehamilan;
use App\Models\Pasangan;
use App\Models\User;
use App\Services\HealthFacilityRecommendationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Simpan pembaruan profil pengguna (nama, kontak, alamat).
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
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'no_telepon.required' => 'Nomor kontak / telepon wajib diisi.',
            'no_telepon.min' => 'Nomor kontak minimal 10 digit.',
            'no_telepon.regex' => 'Format nomor kontak tidak valid. Gunakan format nomor ponsel Indonesia yang benar (contoh: 081234567890).',
            'alamat.required' => 'Alamat tempat tinggal / domisili wajib diisi.',
            'alamat.min' => 'Alamat minimal 5 karakter agar acuan rekomendasi faskes akurat.',
        ]);

        $user->update([
            'name' => trim($validated['name']),
            'no_telepon' => trim($validated['no_telepon']),
            'alamat' => trim($validated['alamat']),
            'kota' => $validated['kota'] ?? $user->kota,
            'kecamatan' => $validated['kecamatan'] ?? $user->kecamatan,
            'kelurahan' => $validated['kelurahan'] ?? $user->kelurahan,
            'nik' => $validated['nik'] ?? $user->nik,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profil dan acuan alamat layanan kesehatan berhasil diperbarui!',
                'data' => $user,
                'rekomendasi_faskes' => $user->rekomendasi_faskes,
            ]);
        }

        return redirect()->route('profil.index')->with('success', 'Profil Anda dan acuan lokasi rekomendasi layanan kesehatan berhasil diperbarui!');
    }
}
