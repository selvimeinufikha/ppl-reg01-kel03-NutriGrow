<?php

namespace App\Http\Controllers;

use App\Models\FasilitasKesehatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminFasilitasKesehatanController extends Controller
{
    /**
     * Tampilkan Halaman Data Layanan Kesehatan (Portal Admin & Faskes).
     * URL: GET /admin/layanan-kesehatan
     */
    public function index(Request $request)
    {
        // Proteksi akses: Pastikan pengguna telah login
        if (!Auth::check()) {
            return redirect()->route('admin.login')->withErrors([
                'login_error' => 'Silakan masuk ke Portal Admin & Tenaga Kesehatan untuk mengakses Data Layanan Kesehatan.',
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        // Validasi peran: Tolak jika akun pengguna biasa/orang tua
        if (method_exists($user, 'isStaffOrAdmin') && !$user->isStaffOrAdmin()) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors([
                'login_error' => 'Akses ditolak. Halaman ini khusus untuk Admin & Petugas Faskes.',
            ]);
        }

        // Data profil nakes yang sedang login
        $adminName = $user->name ?: 'dr. Sarah Nakes (Admin Faskes)';
        $adminEmail = $user->email;
        $adminRole = ($user->role === 'super_admin' || $user->role === 'admin' || str_contains(strtolower($adminName), 'sarah') || str_contains(strtolower($adminName), 'anita') || str_starts_with($adminEmail, 'admin') || str_contains(strtolower($adminEmail), 'anita'))
            ? 'Super Admin'
            : 'Super Admin';
        $faskesName = $user->faskes_name ?: 'Puskesmas Gambir';
        $nipStr = $user->nip_str ?: 'STR-19880412-2023-019';

        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        // Hitung statistik dinamis fasilitas kesehatan
        $totalCount = FasilitasKesehatan::count();
        $posyanduCount = FasilitasKesehatan::where('jenis', 'posyandu')->count();
        $puskesmasCount = FasilitasKesehatan::where('jenis', 'puskesmas')->count();
        $klinikCount = FasilitasKesehatan::where('jenis', 'klinik')->count();
        $rsCount = FasilitasKesehatan::where('jenis', 'rumah_sakit')->count();

        $statistics = [
            'total_fasilitas' => [
                'val' => (string) $totalCount,
                'sub' => "{$posyanduCount} Posyandu • {$puskesmasCount} Puskesmas • {$klinikCount} Klinik • {$rsCount} RS",
                'badge' => '+3 Terverifikasi',
            ],
            'posyandu_aktif' => [
                'val' => (string) $posyanduCount,
                'sub' => 'Binaan Puskesmas Gambir • Skrining Mandiri',
                'badge' => 'Jadwal Timbang',
            ],
            'puskesmas_klinik' => [
                'val' => (string) ($puskesmasCount + $klinikCount),
                'sub' => 'Pelayanan ANC, USG Trimester, & Konsul Gizi',
                'badge' => 'Siaga Poli KIA',
            ],
            'rumah_sakit' => [
                'val' => (string) $rsCount,
                'sub' => 'Penanganan Gizi Buruk & Resep Formula PKMK',
                'badge' => 'NICU & Sp.A',
            ],
        ];

        // Kategori Filter Jenis
        $jenisCategories = [
            ['key' => 'semua', 'label' => 'Semua Jenis', 'count' => $totalCount],
            ['key' => 'puskesmas', 'label' => 'Puskesmas', 'count' => $puskesmasCount],
            ['key' => 'posyandu', 'label' => 'Posyandu', 'count' => $posyanduCount],
            ['key' => 'klinik', 'label' => 'Klinik Pratama', 'count' => $klinikCount],
            ['key' => 'rumah_sakit', 'label' => 'Rumah Sakit', 'count' => $rsCount],
        ];

        // Parameter pencarian & filter dari request (PBI-024)
        $search = $request->input('search', '');
        $selectedJenis = $request->input('jenis', 'semua');
        $selectedStatus = $request->input('status', 'all');
        $selectedSort = $request->input('sort', 'newest');

        // Query pencarian dan filter fasilitas kesehatan (PBI-024)
        $query = FasilitasKesehatan::query();

        // 1. Filter pencarian berdasarkan nama, kode, alamat, atau wilayah
        if ($request->filled('search')) {
            $keyword = trim($request->input('search'));
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_fasilitas', 'like', "%{$keyword}%")
                  ->orWhere('kode_faskes', 'like', "%{$keyword}%")
                  ->orWhere('alamat', 'like', "%{$keyword}%")
                  ->orWhere('wilayah', 'like', "%{$keyword}%")
                  ->orWhere('pic', 'like', "%{$keyword}%");
            });
        }

        // 2. Filter berdasarkan jenis fasilitas (dapat digabung dengan pencarian nama)
        if ($request->filled('jenis') && $request->input('jenis') !== 'semua') {
            $query->where('jenis', $request->input('jenis'));
        }

        // 3. Filter berdasarkan status
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        // 4. Urutan data
        if ($selectedSort === 'name_asc') {
            $query->orderBy('nama_fasilitas', 'asc');
        } elseif ($selectedSort === 'name_desc') {
            $query->orderBy('nama_fasilitas', 'desc');
        } else {
            $query->orderBy('id', 'asc');
        }

        $fasilitas = $query->get();

        return view('DashboardAdmin.layanan-kesehatan', compact(
            'adminName',
            'adminEmail',
            'adminRole',
            'faskesName',
            'nipStr',
            'tanggalHariIni',
            'statistics',
            'jenisCategories',
            'fasilitas',
            'search',
            'selectedJenis',
            'selectedStatus',
            'selectedSort'
        ));
    }

    /**
     * Simpan Data Fasilitas Kesehatan Baru (PBI-022).
     * URL: POST /admin/layanan-kesehatan
     */
    public function store(Request $request)
    {
        // Validasi ketat: Alamat atau koordinat yang tidak valid ditolak sesuai Acceptance Criteria
        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'jenis' => 'required|string|in:puskesmas,posyandu,klinik,rumah_sakit',
            'alamat' => 'required|string|min:10|max:1000',
            'jam_layanan' => 'required|string|max:150',
            'kontak' => ['required', 'string', 'max:50', 'regex:/^[0-9+\-\s()\/Ext\.]+$/i'],
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'kode_faskes' => 'nullable|string|max:50',
            'akreditasi' => 'nullable|string|max:100',
            'wilayah' => 'nullable|string|max:150',
            'layanan_tambahan' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:aktif,tidak_aktif',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas kesehatan wajib diisi.',
            'jenis.required' => 'Jenis fasilitas wajib dipilih.',
            'jenis.in' => 'Jenis fasilitas tidak valid. Pilih antara Puskesmas, Posyandu, Klinik, atau Rumah Sakit.',
            'alamat.required' => 'Alamat fasilitas kesehatan wajib diisi.',
            'alamat.min' => 'Alamat tidak valid. Mohon masukkan nama jalan, nomor, RT/RW atau kelurahan minimal 10 karakter.',
            'jam_layanan.required' => 'Jam operasional layanan fasilitas wajib diisi.',
            'kontak.required' => 'Nomor kontak atau telepon fasilitas wajib diisi.',
            'kontak.regex' => 'Format nomor telepon/kontak tidak valid.',
            'latitude.required' => 'Titik koordinat latitude (garis lintang) wajib diisi.',
            'latitude.numeric' => 'Koordinat latitude tidak valid, harus berupa angka desimal (contoh: -6.1724).',
            'latitude.between' => 'Koordinat latitude tidak valid, harus berada di rentang -90 hingga 90 derajat.',
            'longitude.required' => 'Titik koordinat longitude (garis bujur) wajib diisi.',
            'longitude.numeric' => 'Koordinat longitude tidak valid, harus berupa angka desimal (contoh: 106.8185).',
            'longitude.between' => 'Koordinat longitude tidak valid, harus berada di rentang -180 hingga 180 derajat.',
        ]);

        // Auto-generate kode faskes jika tidak diisi
        if (empty($validated['kode_faskes'])) {
            $prefix = match ($validated['jenis']) {
                'puskesmas' => 'FASKES-',
                'posyandu' => 'POSY-',
                'klinik' => 'KLINIK-',
                'rumah_sakit' => 'RS-',
                default => 'FAS-',
            };
            $validated['kode_faskes'] = $prefix . (317100 + FasilitasKesehatan::count() + 1);
        }

        // Default akreditasi jika kosong
        if (empty($validated['akreditasi'])) {
            $validated['akreditasi'] = match ($validated['jenis']) {
                'puskesmas' => 'Akreditasi Utama',
                'posyandu' => 'Strata Mandiri',
                'klinik' => 'Mitra Faskes Terakreditasi',
                'rumah_sakit' => 'RS Rujukan Tipe B/C',
                default => 'Terverifikasi Faskes',
            };
        }

        // Default status
        $validated['status'] = $validated['status'] ?? 'aktif';

        $faskes = FasilitasKesehatan::create($validated);

        return redirect()->route('admin.fasilitas.index')->with('success', "Fasilitas kesehatan '{$faskes->nama_fasilitas}' berhasil ditambahkan ke direktori rujukan NutriGrow.");
    }

    /**
     * Perbarui Data Fasilitas Kesehatan (PBI-023).
     * URL: PUT /admin/layanan-kesehatan/{id}
     */
    public function update(Request $request, $id)
    {
        $faskes = FasilitasKesehatan::findOrFail($id);

        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'jenis' => 'required|string|in:puskesmas,posyandu,klinik,rumah_sakit',
            'alamat' => 'required|string|min:10|max:1000',
            'jam_layanan' => 'required|string|max:150',
            'kontak' => ['required', 'string', 'max:50', 'regex:/^[0-9+\-\s()\/Ext\.]+$/i'],
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'kode_faskes' => 'nullable|string|max:50',
            'akreditasi' => 'nullable|string|max:100',
            'wilayah' => 'nullable|string|max:150',
            'layanan_tambahan' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:aktif,tidak_aktif',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas kesehatan wajib diisi.',
            'jenis.required' => 'Jenis fasilitas wajib dipilih.',
            'jenis.in' => 'Jenis fasilitas tidak valid.',
            'alamat.required' => 'Alamat fasilitas kesehatan wajib diisi.',
            'alamat.min' => 'Alamat tidak valid. Mohon masukkan nama jalan, nomor, RT/RW atau kelurahan minimal 10 karakter.',
            'jam_layanan.required' => 'Jam operasional layanan fasilitas wajib diisi.',
            'kontak.required' => 'Nomor kontak atau telepon fasilitas wajib diisi.',
            'kontak.regex' => 'Format nomor telepon/kontak tidak valid.',
            'latitude.required' => 'Titik koordinat latitude (garis lintang) wajib diisi.',
            'latitude.numeric' => 'Koordinat latitude tidak valid, harus berupa angka desimal.',
            'latitude.between' => 'Koordinat latitude tidak valid, harus berada di rentang -90 hingga 90 derajat.',
            'longitude.required' => 'Titik koordinat longitude (garis bujur) wajib diisi.',
            'longitude.numeric' => 'Koordinat longitude tidak valid, harus berupa angka desimal.',
            'longitude.between' => 'Koordinat longitude tidak valid, harus berada di rentang -180 hingga 180 derajat.',
        ]);

        $validated['status'] = $validated['status'] ?? 'aktif';

        $faskes->update($validated);

        return redirect()->route('admin.fasilitas.index')->with('success', "Data fasilitas kesehatan '{$faskes->nama_fasilitas}' berhasil diperbarui dan rekomendasi layanan terupdate.");
    }

    /**
     * Hapus Data Fasilitas Kesehatan (PBI-023).
     * URL: DELETE /admin/layanan-kesehatan/{id}
     */
    public function destroy($id)
    {
        $faskes = FasilitasKesehatan::findOrFail($id);
        $nama = $faskes->nama_fasilitas;

        $faskes->delete();

        return redirect()->route('admin.fasilitas.index')->with('success', "Fasilitas kesehatan '{$nama}' berhasil dihapus dari direktori layanan faskes.");
    }
}
