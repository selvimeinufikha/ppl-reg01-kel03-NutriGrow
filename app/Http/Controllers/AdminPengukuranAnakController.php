<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\RiwayatTumbuhKembang;
use App\Models\User;
use App\Services\StatusGiziCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPengukuranAnakController extends Controller
{
    /**
     * Menampilkan halaman input dan daftar hasil pengukuran anak (PBI-016 / F-06).
     * Aktor: Tenaga Kesehatan (Admin)
     */
    public function index(Request $request)
    {
        // Data Tenaga Kesehatan / Admin yang login
        $user = Auth::user();
        $adminName = $user ? $user->name : 'dr. Siti Nurhaliza, Sp.A';
        $adminEmail = $user ? $user->email : 'admin@nutrigrow.id';
        $adminRole = ($user && $user->role === 'nakes') ? 'Tenaga Kesehatan (Bidan/Dokter)' : 'Administrator Faskes';
        $faskesName = ($user && $user->faskes_name) ? $user->faskes_name : 'Posyandu Mawar 1 & Puskesmas Sejahtera';
        $nipStr = ($user && $user->nip_str) ? $user->nip_str : 'STR-19880412-2023-019';

        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        // 1. Ambil seluruh data pengguna (orang tua / wali) dan anak-anaknya
        $usersWithChildren = User::where('role', 'user')
            ->with('anaks')
            ->get();

        // 2. Ambil seluruh daftar anak untuk dropdown
        $allAnaks = Anak::with('user')->orderBy('nama', 'asc')->get();

        // Jika tabel anak masih kosong, buat fallback dari database seeder
        if ($allAnaks->isEmpty()) {
            $defaultUser = User::first() ?? User::create([
                'name' => 'Ibu Anita Rahmawati',
                'email' => 'ibu.anita@nutrigrow.id',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);

            $allAnaks = collect([
                Anak::create([
                    'user_id' => $defaultUser->id,
                    'nama' => 'Aisyah Putri Rahmawati',
                    'nik' => '3171056508210002',
                    'jenis_kelamin' => 'Perempuan',
                    'tanggal_lahir' => '2022-02-14',
                    'status_gizi' => 'Batita Aktif & Sehat',
                ])
            ]);
        }

        // 3. PBI-018: Filter daftar riwayat berdasarkan anak (Acceptance Criteria #1)
        $filterAnakId = $request->query('filter_anak');
        $riwayatQuery = RiwayatTumbuhKembang::with('anak.user')
            ->orderBy('tanggal_pemeriksaan', 'desc');
        if ($filterAnakId) {
            $riwayatQuery->where('anak_id', $filterAnakId);
        }
        $riwayats = $riwayatQuery->get();

        // 4. Statistik ringkas untuk widget Tenaga Kesehatan
        $totalPengukuran = $riwayats->count();
        $totalAnakDipantau = $allAnaks->count();
        $statusNormalCount = $riwayats->where('status_type', 'normal')->count();
        $statusPerluPantauanCount = $riwayats->where('status_type', '!=', 'normal')->count();

        return view('DashboardAdmin.pengukuran-anak', compact(
            'adminName',
            'adminEmail',
            'adminRole',
            'faskesName',
            'nipStr',
            'tanggalHariIni',
            'usersWithChildren',
            'allAnaks',
            'riwayats',
            'totalPengukuran',
            'totalAnakDipantau',
            'statusNormalCount',
            'statusPerluPantauanCount',
            'filterAnakId'
        ));
    }

    /**
     * PBI-018: Ambil data riwayat pengukuran untuk modal edit (JSON).
     */
    public function edit($id)
    {
        $riwayat = RiwayatTumbuhKembang::with('anak')->findOrFail($id);
        return response()->json($riwayat);
    }

    /**
     * PBI-018: Simpan perubahan hasil pengukuran yang diedit.
     * Acceptance Criteria #2: Setelah diubah, status gizi, grafik, dan penilaian risiko ikut terbaru.
     */
    public function update(Request $request, $id)
    {
        $riwayat = RiwayatTumbuhKembang::findOrFail($id);
        $anak    = $riwayat->anak;

        // Validasi — sama dengan store()
        $validated = $request->validate([
            'tanggal_pemeriksaan' => ['required', 'date', 'before_or_equal:today'],
            'berat_badan'         => ['required', 'numeric', 'min:1.5', 'max:40.0'],
            'tinggi_badan'        => ['required', 'numeric', 'min:30.0', 'max:150.0'],
            'lingkar_kepala'      => ['nullable', 'numeric', 'min:20.0', 'max:65.0'],
            'lingkar_lengan_atas' => ['nullable', 'numeric', 'min:7.0', 'max:30.0'],
            'kpsp_status'         => ['nullable', 'string', 'max:255'],
            'imunisasi'           => ['nullable', 'string', 'max:255'],
            'vitamin_a'           => ['nullable', 'string', 'max:255'],
            'obat_cacing'         => ['nullable', 'string', 'max:255'],
            'catatan_klinis'      => ['nullable', 'string', 'max:1000'],
            'nama_nakes'          => ['nullable', 'string', 'max:255'],
            'faskes_pemeriksa'    => ['nullable', 'string', 'max:255'],
        ], [
            'tanggal_pemeriksaan.required'    => 'Tanggal pengukuran wajib diisi.',
            'tanggal_pemeriksaan.before_or_equal' => 'Tanggal pengukuran tidak boleh melebihi hari ini.',
            'berat_badan.required' => 'Berat badan (BB) wajib diisi.',
            'berat_badan.min'      => 'Nilai tidak wajar: Berat badan balita tidak boleh kurang dari 1.5 kg.',
            'berat_badan.max'      => 'Nilai tidak wajar: Berat badan balita tidak boleh melebihi 40.0 kg.',
            'tinggi_badan.required'=> 'Tinggi/panjang badan (TB) wajib diisi.',
            'tinggi_badan.min'     => 'Nilai tidak wajar: Tinggi badan balita tidak boleh kurang dari 30.0 cm.',
            'tinggi_badan.max'     => 'Nilai tidak wajar: Tinggi badan balita tidak boleh melebihi 150.0 cm.',
        ]);

        // Hitung ulang umur & status gizi (PBI-017 / PBI-018 AC #2)
        $umurData  = StatusGiziCalculator::hitungUmur(
            $anak->tanggal_lahir->format('Y-m-d'),
            $validated['tanggal_pemeriksaan']
        );
        $usiaBulan = $umurData['bulan'];

        $bb = (float) $validated['berat_badan'];
        $tb = (float) $validated['tinggi_badan'];

        $giziData = StatusGiziCalculator::hitungStatusGizi(
            $usiaBulan,
            $bb,
            $tb,
            $anak->jenis_kelamin
        );

        $zScoreBBU         = $giziData['z_score_bb_u'] . ' (' . $giziData['status_bb_u'] . ')';
        $zScoreTBU         = $giziData['z_score_tb_u'] . ' (' . $giziData['status_tb_u'] . ')';
        $zScoreBBTB        = $giziData['z_score_bb_u'];
        $statusPertumbuhan = $giziData['status_pertumbuhan'];
        $statusType        = $giziData['status_type'];

        $namaNakes = !empty($validated['nama_nakes']) ? $validated['nama_nakes'] : (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
        $faskes    = !empty($validated['faskes_pemeriksa']) ? $validated['faskes_pemeriksa'] : (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Posyandu Mawar 1 & Puskesmas Sejahtera');

        // Update rekam medis
        $riwayat->update([
            'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
            'usia_bulan'          => $usiaBulan,
            'berat_badan'         => $bb,
            'tinggi_badan'        => $tb,
            'lingkar_kepala'      => $validated['lingkar_kepala'] ?? null,
            'lingkar_lengan_atas' => $validated['lingkar_lengan_atas'] ?? null,
            'z_score_bb_u'        => $zScoreBBU,
            'z_score_tb_u'        => $zScoreTBU,
            'z_score_bb_tb'       => $zScoreBBTB,
            'status_pertumbuhan'  => $statusPertumbuhan,
            'status_type'         => $statusType,
            'catatan_klinis'      => $validated['catatan_klinis'] ?? $giziData['rekomendasi'],
            'nama_nakes'          => $namaNakes,
            'faskes_pemeriksa'    => $faskes,
            'kpsp_status'         => $validated['kpsp_status'] ?? 'Sesuai Umur',
            'imunisasi'           => $validated['imunisasi'] ?? 'Sesuai Jadwal Usia',
            'vitamin_a'           => $validated['vitamin_a'] ?? '-',
            'obat_cacing'         => $validated['obat_cacing'] ?? '-',
        ]);

        // PBI-018 AC #2: Perbarui status gizi anak dari catatan terbaru
        $latestRiwayat = RiwayatTumbuhKembang::where('anak_id', $anak->id)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->first();
        if ($latestRiwayat) {
            $anak->update(['status_gizi' => $latestRiwayat->status_pertumbuhan]);
        }

        $umurLabel = $umurData['label'];
        return redirect()->route('admin.pengukuran.index')
            ->with('success_message', "✅ Catatan pengukuran {$anak->nama} (Usia: {$umurLabel}) tanggal "
                . Carbon::parse($validated['tanggal_pemeriksaan'])->translatedFormat('d F Y')
                . " berhasil diperbarui. Status Gizi: {$statusPertumbuhan}. [Dihitung ulang sesuai Permenkes No.2 Tahun 2020]");
    }

    /**
     * Memproses penyimpanan hasil pengukuran anak dari formulir Nakes (PBI-016).
     * Menerapkan Acceptance Criteria:
     * 1. Admin memilih pengguna dan anak, lalu mengisi hasil pengukuran dan tanggal pengukuran.
     * 2. Nilai kosong atau tidak wajar ditolak.
     */
    public function store(Request $request)
    {
        // Validasi input: Nilai kosong atau tidak wajar DITOLAK
        $validated = $request->validate([
            'anak_id' => ['required', 'exists:anaks,id'],
            'tanggal_pemeriksaan' => ['required', 'date', 'before_or_equal:today'],
            'berat_badan' => ['required', 'numeric', 'min:1.5', 'max:40.0'],
            'tinggi_badan' => ['required', 'numeric', 'min:30.0', 'max:150.0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:20.0', 'max:65.0'],
            'lingkar_lengan_atas' => ['nullable', 'numeric', 'min:7.0', 'max:30.0'],
            'kpsp_status' => ['nullable', 'string', 'max:255'],
            'imunisasi' => ['nullable', 'string', 'max:255'],
            'vitamin_a' => ['nullable', 'string', 'max:255'],
            'obat_cacing' => ['nullable', 'string', 'max:255'],
            'catatan_klinis' => ['nullable', 'string', 'max:1000'],
            'nama_nakes' => ['nullable', 'string', 'max:255'],
            'faskes_pemeriksa' => ['nullable', 'string', 'max:255'],
        ], [
            'anak_id.required' => 'Pilihan anak wajib dipilih.',
            'anak_id.exists' => 'Data anak yang dipilih tidak ditemukan dalam sistem.',
            'tanggal_pemeriksaan.required' => 'Tanggal pengukuran wajib diisi.',
            'tanggal_pemeriksaan.before_or_equal' => 'Tanggal pengukuran tidak boleh melebihi hari ini.',
            'berat_badan.required' => 'Berat badan (BB) wajib diisi.',
            'berat_badan.numeric' => 'Berat badan harus berupa angka.',
            'berat_badan.min' => 'Nilai tidak wajar: Berat badan balita tidak boleh kurang dari 1.5 kg.',
            'berat_badan.max' => 'Nilai tidak wajar: Berat badan balita tidak boleh melebihi 40.0 kg.',
            'tinggi_badan.required' => 'Tinggi/panjang badan (TB) wajib diisi.',
            'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
            'tinggi_badan.min' => 'Nilai tidak wajar: Tinggi badan balita tidak boleh kurang dari 30.0 cm.',
            'tinggi_badan.max' => 'Nilai tidak wajar: Tinggi badan balita tidak boleh melebihi 150.0 cm.',
            'lingkar_kepala.numeric' => 'Lingkar kepala harus berupa angka.',
            'lingkar_kepala.min' => 'Nilai tidak wajar: Lingkar kepala tidak boleh kurang dari 20.0 cm.',
            'lingkar_kepala.max' => 'Nilai tidak wajar: Lingkar kepala tidak boleh melebihi 65.0 cm.',
            'lingkar_lengan_atas.numeric' => 'Lingkar lengan atas harus berupa angka.',
            'lingkar_lengan_atas.min' => 'Nilai tidak wajar: Lingkar lengan atas tidak boleh kurang dari 7.0 cm.',
            'lingkar_lengan_atas.max' => 'Nilai tidak wajar: Lingkar lengan atas tidak boleh melebihi 30.0 cm.',
        ]);

        $anak = Anak::findOrFail($validated['anak_id']);

        // ============================================================
        // PBI-017: Hitung Umur Otomatis dari Tanggal Lahir & Tanggal Ukur
        // Acceptance Criteria #1: Sistem menghitung umur saat pengukuran
        // ============================================================
        $umurData  = StatusGiziCalculator::hitungUmur(
            $anak->tanggal_lahir->format('Y-m-d'),
            $validated['tanggal_pemeriksaan']
        );
        $usiaBulan = $umurData['bulan'];

        // ============================================================
        // PBI-017: Hitung Status Gizi Otomatis sesuai Permenkes No. 2/2020
        // Acceptance Criteria #2: Status gizi ditentukan otomatis
        // ============================================================
        $bb = (float) $validated['berat_badan'];
        $tb = (float) $validated['tinggi_badan'];

        $giziData = StatusGiziCalculator::hitungStatusGizi(
            $usiaBulan,
            $bb,
            $tb,
            $anak->jenis_kelamin
        );

        $zScoreBBU          = $giziData['z_score_bb_u'] . ' (' . $giziData['status_bb_u'] . ')';
        $zScoreTBU          = $giziData['z_score_tb_u'] . ' (' . $giziData['status_tb_u'] . ')';
        $zScoreBBTB         = $giziData['z_score_bb_u']; // BB/TB menggunakan BB/U sebagai pendekatan
        $statusPertumbuhan  = $giziData['status_pertumbuhan'];
        $statusType         = $giziData['status_type'];

        // Default nama nakes & faskes dari user yang sedang login jika kosong
        $namaNakes = !empty($validated['nama_nakes']) ? $validated['nama_nakes'] : (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
        $faskes = !empty($validated['faskes_pemeriksa']) ? $validated['faskes_pemeriksa'] : (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Posyandu Mawar 1 & Puskesmas Sejahtera');

        // Simpan ke database MySQL
        $riwayat = RiwayatTumbuhKembang::create([
            'anak_id'            => $anak->id,
            'tanggal_pemeriksaan'=> $validated['tanggal_pemeriksaan'],
            'usia_bulan'         => $usiaBulan,
            'berat_badan'        => $bb,
            'tinggi_badan'       => $tb,
            'lingkar_kepala'     => $validated['lingkar_kepala'] ?? null,
            'lingkar_lengan_atas'=> $validated['lingkar_lengan_atas'] ?? null,
            'z_score_bb_u'       => $zScoreBBU,
            'z_score_tb_u'       => $zScoreTBU,
            'z_score_bb_tb'      => $zScoreBBTB,
            'status_pertumbuhan' => $statusPertumbuhan,
            'status_type'        => $statusType,
            'catatan_klinis'     => $validated['catatan_klinis'] ?? $giziData['rekomendasi'],
            'nama_nakes'         => $namaNakes,
            'faskes_pemeriksa'   => $faskes,
            'kpsp_status'        => $validated['kpsp_status'] ?? 'Sesuai Umur',
            'imunisasi'          => $validated['imunisasi'] ?? 'Sesuai Jadwal Usia',
            'vitamin_a'          => $validated['vitamin_a'] ?? '-',
            'obat_cacing'        => $validated['obat_cacing'] ?? '-',
        ]);

        // Perbarui status gizi anak
        $anak->update([
            'status_gizi' => $statusPertumbuhan,
        ]);

        $umurLabel = $umurData['label'];

        return redirect()->route('admin.pengukuran.index')
            ->with('success_message', "✅ Hasil pengukuran {$anak->nama} (Usia: {$umurLabel}) tanggal "
                . Carbon::parse($validated['tanggal_pemeriksaan'])->translatedFormat('d F Y')
                . " berhasil disimpan. Status Gizi: {$statusPertumbuhan}. [Dihitung otomatis sesuai Permenkes No.2 Tahun 2020]");
    }

    /**
     * PBI-018: Menghapus riwayat hasil pengukuran & memperbarui status gizi anak.
     * Acceptance Criteria #2: Setelah dihapus, status gizi ikut terbaru.
     */
    public function destroy($id)
    {
        $riwayat  = RiwayatTumbuhKembang::findOrFail($id);
        $anak     = $riwayat->anak;
        $namaAnak = $anak ? $anak->nama : 'Anak';
        $tgl      = Carbon::parse($riwayat->tanggal_pemeriksaan)->translatedFormat('d F Y');

        $riwayat->delete();

        // PBI-018 AC #2: Perbarui status gizi dari catatan terbaru yang tersisa
        if ($anak) {
            $latestRiwayat = RiwayatTumbuhKembang::where('anak_id', $anak->id)
                ->orderBy('tanggal_pemeriksaan', 'desc')
                ->first();
            if ($latestRiwayat) {
                $anak->update(['status_gizi' => $latestRiwayat->status_pertumbuhan]);
            }
        }

        return redirect()->route('admin.pengukuran.index')
            ->with('success_message', "🗑️ Catatan pengukuran {$namaAnak} ({$tgl}) berhasil dihapus. Status gizi anak telah diperbarui.");
    }
}
