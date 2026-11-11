<?php

namespace App\Http\Controllers;

use App\Models\Kehamilan;
use App\Models\Pasangan;
use App\Models\User;
use App\Services\PregnancyCalculatorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehamilanController extends Controller
{
    /**
     * Dapatkan user yang sedang aktif atau fallback ke user demo.
     */
    protected function getActiveUser(): User
    {
        if (Auth::check()) {
            return Auth::user();
        }

        // Cari atau buat user demo untuk kenyamanan testing & eksplorasi
        return User::firstOrCreate(
            ['email' => 'sarah@nutrigrow.id'],
            [
                'name' => 'Sarah Rahmawati',
                'password' => bcrypt('password123'),
            ]
        );
    }

    /**
     * Tampilkan halaman utama Data Kehamilan (Daftar & Rekapitulasi).
     */
    public function index(Request $request)
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        $query = Kehamilan::with('pasangan')
            ->where('user_id', $user->id);

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Pencarian teks (catatan, nama anak, atau kehamilan ke-)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('catatan', 'like', "%{$search}%")
                  ->orWhere('nama_anak', 'like', "%{$search}%")
                  ->orWhere('kehamilan_ke', 'like', "%{$search}%");
            });
        }

        $kehamilans = $query->orderBy('kehamilan_ke', 'desc')->get();

        // Hitung statistik untuk summary card
        $totalData = Kehamilan::where('user_id', $user->id)->count();
        $kehamilanAktif = Kehamilan::where('user_id', $user->id)
            ->where('status', 'berlangsung')
            ->count();

        $kehamilanAktifData = Kehamilan::where('user_id', $user->id)
            ->where('status', 'berlangsung')
            ->whereNotNull('hpl')
            ->orderBy('hpl', 'asc')
            ->first();

        $hplTerdekat = $kehamilanAktifData ? $kehamilanAktifData->hpl_formatted : '-';

        // Daftar pasangan untuk pilihan di form
        $pasangans = Pasangan::where('user_id', $user->id)->get();
        if ($pasangans->isEmpty()) {
            $defaultPasangan = Pasangan::firstOrCreate(
                ['user_id' => $user->id, 'nama_lengkap' => 'Dimas Prasetyo'],
                ['hubungan' => 'Calon Ayah', 'pekerjaan' => 'Karyawan Swasta']
            );
            $pasangans = collect([$defaultPasangan]);
        }

        $tanggalHariIni = Carbon::now()->locale('id')->translatedFormat('l, j F Y');

        return view('DataKehamilan.index', [
            'user' => $user,
            'userName' => $user->name,
            'userId' => 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT',
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Mawar 1 & Puskesmas Sejahtera',
            'keluargaName' => 'Keluarga Pratama',
            'kehamilans' => $kehamilans,
            'totalData' => $totalData,
            'kehamilanAktif' => $kehamilanAktif,
            'hplTerdekat' => $hplTerdekat,
            'pasangans' => $pasangans,
            'filterStatus' => $request->get('status', 'all'),
            'searchQuery' => $request->get('search', ''),
        ]);
    }

    /**
     * Tampilkan formulir pencatatan data kehamilan baru.
     */
    public function create()
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        // Rekomendasi kehamilan ke berapa berdasarkan data sebelumnya
        $lastKehamilan = Kehamilan::where('user_id', $user->id)->max('kehamilan_ke');
        $saranKehamilanKe = ($lastKehamilan ?? 0) + 1;

        $pasangans = Pasangan::where('user_id', $user->id)->get();
        if ($pasangans->isEmpty()) {
            $defaultPasangan = Pasangan::firstOrCreate(
                ['user_id' => $user->id, 'nama_lengkap' => 'Dimas Prasetyo'],
                ['hubungan' => 'Calon Ayah', 'pekerjaan' => 'Karyawan Swasta']
            );
            $pasangans = collect([$defaultPasangan]);
        }

        $tanggalHariIni = Carbon::now()->locale('id')->translatedFormat('l, j F Y');

        return view('DataKehamilan.create', [
            'user' => $user,
            'userName' => $user->name,
            'userId' => 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT',
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Mawar 1 & Puskesmas Sejahtera',
            'keluargaName' => 'Keluarga Pratama',
            'saranKehamilanKe' => $saranKehamilanKe,
            'pasangans' => $pasangans,
        ]);
    }

    /**
     * Simpan data kehamilan baru dengan validasi HPHT & field terkait.
     */
    public function store(Request $request)
    {
        $user = $this->getActiveUser();

        // Validasi sesuai Acceptance Criteria
        $validated = $request->validate([
            'hpht' => ['required', 'date', 'before_or_equal:today'],
            'kehamilan_ke' => ['required', 'integer', 'min:1', 'max:20'],
            'status' => ['required', 'in:berlangsung,melahirkan,keguguran'],
            'pasangan_id' => ['nullable', 'exists:pasangans,id'],
            'nama_pasangan_baru' => ['nullable', 'string', 'max:255'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:50', 'max:250'],
            'berat_badan_pra_hamil' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'tanggal_persalinan' => ['nullable', 'date', 'after_or_equal:hpht'],
            'status_persalinan' => ['nullable', 'string', 'max:100'],
            'nama_anak' => ['nullable', 'string', 'max:255'],
        ], [
            'hpht.required' => 'Tanggal HPHT (Hari Pertama Haid Terakhir) wajib diisi.',
            'hpht.date' => 'Format tanggal HPHT tidak valid.',
            'hpht.before_or_equal' => 'Tanggal HPHT tidak boleh melebihi tanggal hari ini.',
            'kehamilan_ke.required' => 'Kehamilan ke berapa wajib diisi.',
            'kehamilan_ke.integer' => 'Kehamilan ke berapa harus berupa bilangan bulat positif.',
            'kehamilan_ke.min' => 'Kehamilan ke berapa minimal 1.',
            'status.required' => 'Status kehamilan wajib dipilih.',
            'status.in' => 'Status kehamilan harus bernilai berlangsung, melahirkan, atau keguguran.',
            'tanggal_persalinan.after_or_equal' => 'Tanggal persalinan tidak boleh mendahului tanggal HPHT.',
        ]);

        // Tangani pemilihan / pembuatan pasangan
        $pasanganId = $request->pasangan_id;
        if ($request->filled('nama_pasangan_baru')) {
            $pasangan = Pasangan::firstOrCreate(
                ['user_id' => $user->id, 'nama_lengkap' => trim($request->nama_pasangan_baru)],
                ['hubungan' => 'Calon Ayah']
            );
            $pasanganId = $pasangan->id;
        } elseif (!$pasanganId) {
            $defaultPasangan = Pasangan::where('user_id', $user->id)->first();
            $pasanganId = $defaultPasangan?->id;
        }

        // Hitung HPL otomatis dengan rumus Naegele: HPHT + 280 hari
        $hpl = PregnancyCalculatorService::hitungHpl($validated['hpht']);

        // Generate kode gravida sederhana (misal: G2P1A0)
        $gravida = 'G' . $validated['kehamilan_ke'] . 'P' . max(0, $validated['kehamilan_ke'] - 1) . 'A0';

        $kehamilan = Kehamilan::create([
            'user_id' => $user->id,
            'pasangan_id' => $pasanganId,
            'kehamilan_ke' => $validated['kehamilan_ke'],
            'hpht' => $validated['hpht'],
            'hpl' => $hpl->format('Y-m-d'),
            'status' => $validated['status'],
            'gravida' => $gravida,
            'tanggal_persalinan' => $validated['tanggal_persalinan'] ?? null,
            'status_persalinan' => $validated['status_persalinan'] ?? ($validated['status'] === 'melahirkan' ? 'Aterm (Cukup Bulan)' : null),
            'nama_anak' => $validated['nama_anak'] ?? null,
            'tinggi_badan' => $validated['tinggi_badan'] ?? null,
            'berat_badan_pra_hamil' => $validated['berat_badan_pra_hamil'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('kehamilan.index')->with('success', "Data Kehamilan Ke-{$kehamilan->kehamilan_ke} berhasil dicatat!");
    }

    /**
     * Tampilkan detail data kehamilan dan hasil kalkulasi usia & trimester.
     */
    public function show(Request $request, $id)
    {
        $user = $this->getActiveUser();
        $kehamilan = Kehamilan::with('pasangan')
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $calc = PregnancyCalculatorService::hitungLengkap($kehamilan->hpht, $kehamilan->getTanggalAcuan());

        // Jika request via AJAX / API
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $kehamilan,
                'usia_kehamilan' => $kehamilan->usia_kehamilan,
                'usia_minggu' => $kehamilan->usia_minggu,
                'usia_hari' => $kehamilan->usia_hari,
                'trimester' => $kehamilan->trimester,
                'trimester_nomor' => $kehamilan->trimester_nomor,
                'trimester_badge' => $kehamilan->trimester_badge,
                'hpl_formatted' => $kehamilan->hpl_formatted,
                'hpht_formatted' => $kehamilan->hpht_formatted,
                'kalkulasi' => $calc,
            ]);
        }

        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        return view('DataKehamilan.detail', [
            'kehamilan' => $kehamilan,
            'calc' => $calc,
            'user' => $user,
            'userName' => $user->name,
            'userId' => 'NGW-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-JKT',
            'tanggalHariIni' => $tanggalHariIni,
            'faskesName' => 'Posyandu Mawar 1 & Puskesmas Sejahtera',
            'keluargaName' => 'Keluarga Pratama',
        ]);
    }

    /**
     * Endpoint API kalkulator kehamilan (hitung HPL, usia kehamilan, dan trimester dari HPHT).
     */
    public function kalkulator(Request $request)
    {
        $validated = $request->validate([
            'hpht' => ['required', 'date', 'before_or_equal:today'],
        ], [
            'hpht.required' => 'Tanggal HPHT wajib diisi.',
            'hpht.date' => 'Format tanggal HPHT tidak valid.',
            'hpht.before_or_equal' => 'Tanggal HPHT tidak boleh melebihi tanggal hari ini.',
        ]);

        $hasil = PregnancyCalculatorService::hitungLengkap($validated['hpht']);

        return response()->json([
            'status' => 'success',
            'data' => $hasil,
        ]);
    }

    /**
     * Hapus data kehamilan.
     */
    public function destroy($id)
    {
        $user = $this->getActiveUser();
        $kehamilan = Kehamilan::where('user_id', $user->id)->findOrFail($id);
        $kehamilanKe = $kehamilan->kehamilan_ke;
        $kehamilan->delete();

        return redirect()->route('kehamilan.index')->with('success', "Data Kehamilan Ke-{$kehamilanKe} berhasil dihapus.");
    }
}
