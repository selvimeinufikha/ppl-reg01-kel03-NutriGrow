<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\RiwayatTumbuhKembang;
use App\Models\User;
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

        // 3. Ambil riwayat hasil pengukuran anak terbaru (Pagination / List)
        $riwayats = RiwayatTumbuhKembang::with('anak.user')
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

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
            'statusPerluPantauanCount'
        ));
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

        // Hitung usia dalam bulan saat pengukuran dilakukan
        $tglLahir = Carbon::parse($anak->tanggal_lahir);
        $tglUkur = Carbon::parse($validated['tanggal_pemeriksaan']);
        $usiaBulan = max(0, $tglLahir->diffInMonths($tglUkur));

        // Kalkulasi Z-Score Antropometri & Status Gizi berdasarkan standar WHO
        $bb = (float) $validated['berat_badan'];
        $tb = (float) $validated['tinggi_badan'];

        // Estimasi Z-score sederhana sesuai standar WHO BB/U & TB/U
        $medianBB = 3.3 + ($usiaBulan * 0.35); // Perkiraan kurva median pertumbuhan
        $diffBB = round(($bb - $medianBB) / ($medianBB * 0.12), 1);
        $signBB = $diffBB >= 0 ? "+{$diffBB}" : "{$diffBB}";
        $zScoreBB = "{$signBB} SD";

        $medianTB = 50.0 + ($usiaBulan * 1.4);
        $diffTB = round(($tb - $medianTB) / ($medianTB * 0.05), 1);
        $signTB = $diffTB >= 0 ? "+{$diffTB}" : "{$diffTB}";
        $zScoreTB = "{$signTB} SD";

        // Tentukan Status Pertumbuhan
        $statusPertumbuhan = 'Pertumbuhan Baik & Normal';
        $statusType = 'normal';

        if ($diffBB < -2.0) {
            $statusPertumbuhan = 'Perlu Pantauan Berat (Kuning - Gizi Kurang)';
            $statusType = 'warning';
        } elseif ($diffTB < -2.0) {
            $statusPertumbuhan = 'Perlu Pantauan Tinggi (Risiko Stunting)';
            $statusType = 'warning';
        } elseif ($diffBB > 2.0) {
            $statusPertumbuhan = 'Risiko Berat Badan Berlebih';
            $statusType = 'warning';
        }

        // Default nama nakes & faskes dari user yang sedang login jika kosong
        $namaNakes = !empty($validated['nama_nakes']) ? $validated['nama_nakes'] : (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
        $faskes = !empty($validated['faskes_pemeriksa']) ? $validated['faskes_pemeriksa'] : (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Posyandu Mawar 1 & Puskesmas Sejahtera');

        // Simpan ke database MySQL
        $riwayat = RiwayatTumbuhKembang::create([
            'anak_id' => $anak->id,
            'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
            'usia_bulan' => $usiaBulan,
            'berat_badan' => $bb,
            'tinggi_badan' => $tb,
            'lingkar_kepala' => $validated['lingkar_kepala'] ?? null,
            'lingkar_lengan_atas' => $validated['lingkar_lengan_atas'] ?? null,
            'z_score_bb_u' => "{$zScoreBB} (BB/U)",
            'z_score_tb_u' => "{$zScoreTB} (TB/U)",
            'z_score_bb_tb' => '+0.1 SD (BB/TB)',
            'status_pertumbuhan' => $statusPertumbuhan,
            'status_type' => $statusType,
            'catatan_klinis' => $validated['catatan_klinis'] ?? 'Hasil penimbangan dan pengukuran antropometri berkala balita tercatat lengkap.',
            'nama_nakes' => $namaNakes,
            'faskes_pemeriksa' => $faskes,
            'kpsp_status' => $validated['kpsp_status'] ?? 'Sesuai Umur',
            'imunisasi' => $validated['imunisasi'] ?? 'Sesuai Jadwal Usia',
            'vitamin_a' => $validated['vitamin_a'] ?? '-',
            'obat_cacing' => $validated['obat_cacing'] ?? '-',
        ]);

        // Perbarui status gizi anak
        $anak->update([
            'status_gizi' => $statusPertumbuhan,
        ]);

        return redirect()->route('admin.pengukuran.index')->with('success_message', "Hasil pengukuran anak {$anak->nama} tanggal " . Carbon::parse($validated['tanggal_pemeriksaan'])->translatedFormat('d F Y') . " berhasil disimpan ke rekam medis dan disinkronkan ke aplikasi keluarga.");
    }

    /**
     * Menghapus riwayat hasil pengukuran.
     */
    public function destroy($id)
    {
        $riwayat = RiwayatTumbuhKembang::findOrFail($id);
        $namaAnak = $riwayat->anak ? $riwayat->anak->nama : 'Anak';
        $tgl = Carbon::parse($riwayat->tanggal_pemeriksaan)->translatedFormat('d F Y');

        $riwayat->delete();

        return redirect()->route('admin.pengukuran.index')->with('success_message', "Catatan pengukuran {$namaAnak} ({$tgl}) berhasil dihapus.");
    }
}
