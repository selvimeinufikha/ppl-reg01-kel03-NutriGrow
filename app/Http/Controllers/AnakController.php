<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Kehamilan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnakController extends Controller
{
    /**
     * Helper untuk mendapatkan objek User aktif (atau user pertama/dummy untuk kemudahan pengujian).
     */
    protected function getActiveUser()
    {
        $user = Auth::user();
        if (!$user) {
            $user = User::first();
            if (!$user) {
                $user = User::create([
                    'name' => 'Keluarga Pratama',
                    'email' => 'pratama@nutrigrow.id',
                    'password' => bcrypt('password123'),
                ]);
            }
        }
        return $user;
    }

    /**
     * Tampilkan daftar data anak keluarga (Halaman Utama Data Anak).
     * Acceptance Criteria:
     * - Satu akun dapat memiliki lebih dari satu anak.
     * - Umur dihitung otomatis dari tanggal lahir.
     */
    public function index(Request $request)
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        // Query data anak milik user (mendukung multi-anak)
        $query = Anak::with('kehamilan')->where('user_id', $user->id);

        // Filter pencarian nama anak
        if ($request->filled('q')) {
            $searchTerm = trim($request->q);
            $query->where('nama', 'like', "%{$searchTerm}%");
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin') && in_array($request->jenis_kelamin, ['Laki-laki', 'Perempuan'])) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Urutkan: termuda (lahir paling baru) dulu
        $anaks = $query->orderBy('tanggal_lahir', 'desc')->get();

        // Hitung metrik ringkasan keluarga
        $allChildren    = Anak::where('user_id', $user->id)->get();
        $totalAnak      = $allChildren->count();
        $totalLaki      = $allChildren->where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = $allChildren->where('jenis_kelamin', 'Perempuan')->count();

        // Daftar kehamilan user untuk opsi dropdown tambah/edit anak
        $kehamilans = Kehamilan::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');
        $namaKeluarga   = $user->name ?: 'Keluarga Pratama';
        $faskesInfo     = 'Posyandu Mawar 1 & Puskesmas Sejahtera';

        return view('DashboardPengguna.data-anak.index', [
            'anaks'          => $anaks,
            'totalAnak'      => $totalAnak,
            'totalLaki'      => $totalLaki,
            'totalPerempuan' => $totalPerempuan,
            'kehamilans'     => $kehamilans,
            'user'           => $user,
            'namaKeluarga'   => $namaKeluarga,
            'tanggalHariIni' => $tanggalHariIni,
            'faskesInfo'     => $faskesInfo,
            'filterQ'        => $request->q ?? '',
            'filterGender'   => $request->jenis_kelamin ?? '',
        ]);
    }

    /**
     * Tampilkan halaman daftar anak dalam format tabel (view alternatif / sub-halaman).
     * Umur dihitung otomatis dari tanggal lahir melalui model accessor.
     */
    public function daftarAnak(Request $request)
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        // Query semua anak milik user — mendukung lebih dari satu anak per akun
        $query = Anak::with('kehamilan')->where('user_id', $user->id);

        // Filter nama
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . trim($request->q) . '%');
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin') && in_array($request->jenis_kelamin, ['Laki-laki', 'Perempuan'])) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Urutkan berdasarkan tanggal lahir termuda
        $anaks = $query->orderBy('tanggal_lahir', 'desc')->get();

        // Statistik ringkasan
        $allChildren    = Anak::where('user_id', $user->id)->get();
        $totalAnak      = $allChildren->count();
        $totalLaki      = $allChildren->where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = $allChildren->where('jenis_kelamin', 'Perempuan')->count();

        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');
        $namaKeluarga   = $user->name ?: 'Keluarga Pratama';
        $faskesInfo     = 'Posyandu Mawar 1 & Puskesmas Sejahtera';

        return view('DashboardPengguna.data-anak.daftar', [
            'anaks'          => $anaks,
            'totalAnak'      => $totalAnak,
            'totalLaki'      => $totalLaki,
            'totalPerempuan' => $totalPerempuan,
            'user'           => $user,
            'namaKeluarga'   => $namaKeluarga,
            'tanggalHariIni' => $tanggalHariIni,
            'faskesInfo'     => $faskesInfo,
            'filterQ'        => $request->q ?? '',
            'filterGender'   => $request->jenis_kelamin ?? '',
        ]);
    }

    /**
     * Tampilkan formulir untuk menambah data anak baru.
     */
    public function create()
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        $kehamilans = Kehamilan::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');
        $namaKeluarga = $user->name ?: 'Keluarga Pratama';
        $faskesInfo = 'Posyandu Mawar 1 & Puskesmas Sejahtera';

        return view('DashboardPengguna.data-anak.create', [
            'kehamilans' => $kehamilans,
            'user' => $user,
            'namaKeluarga' => $namaKeluarga,
            'tanggalHariIni' => $tanggalHariIni,
            'faskesInfo' => $faskesInfo,
            'maxDate' => Carbon::now()->format('Y-m-d'),
        ]);
    }

    /**
     * Simpan data anak baru ke basis data.
     * Acceptance Criteria:
     * 1. Pengguna mengisi nama, tanggal lahir, dan jenis kelamin, serta dapat menghubungkannya dengan data kehamilan.
     * 2. Tanggal lahir yang melebihi hari ini DITOLAK.
     */
    public function store(Request $request)
    {
        Carbon::setLocale('id');

        // Preprocessing: Normalisasi input desimal & berat badan jika diisi dalam gram
        $input = $request->all();
        foreach (['berat_lahir', 'panjang_lahir', 'lingkar_kepala_lahir'] as $numField) {
            if (isset($input[$numField]) && is_string($input[$numField])) {
                $cleaned = trim(str_replace(',', '.', $input[$numField]));
                $input[$numField] = $cleaned !== '' ? $cleaned : null;
            }
        }
        if (isset($input['berat_lahir']) && is_numeric($input['berat_lahir']) && (float) $input['berat_lahir'] > 20) {
            $input['berat_lahir'] = round(((float) $input['berat_lahir']) / 1000, 2);
        }
        foreach (['kehamilan_id', 'nik', 'tempat_lahir', 'anak_ke', 'golongan_darah', 'catatan'] as $optField) {
            if (isset($input[$optField]) && trim((string) $input[$optField]) === '') {
                $input[$optField] = null;
            }
        }
        $request->merge($input);

        $maxDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:' . $maxDate],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kehamilan_id' => ['nullable', 'exists:kehamilans,id'],
            'nik' => ['nullable', 'string', 'max:30'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'anak_ke' => ['nullable', 'integer', 'min:1', 'max:20'],
            'berat_lahir' => ['nullable', 'numeric', 'min:0.5', 'max:15'],
            'panjang_lahir' => ['nullable', 'numeric', 'min:20', 'max:100'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:15', 'max:70'],
            'golongan_darah' => ['nullable', 'string', 'max:10'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'nama.required' => 'Nama lengkap anak wajib diisi.',
            'nama.string' => 'Nama anak harus berupa karakter teks valid.',
            'nama.max' => 'Nama anak tidak boleh lebih dari 150 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir anak wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini (' . Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') . ').',
            'jenis_kelamin.required' => 'Pilih jenis kelamin anak.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin harus Laki-laki atau Perempuan.',
            'kehamilan_id.exists' => 'Data kehamilan yang dipilih tidak ditemukan dalam sistem.',
            'anak_ke.integer' => 'Urutan anak harus berupa angka bulat positif.',
            'anak_ke.min' => 'Urutan anak minimal ke-1.',
            'berat_lahir.numeric' => 'Berat lahir harus berupa angka desimal dalam kilogram (contoh: 3.2 kg).',
            'panjang_lahir.numeric' => 'Panjang lahir harus berupa angka desimal dalam sentimeter (contoh: 49.5 cm).',
            'lingkar_kepala_lahir.numeric' => 'Lingkar kepala lahir harus berupa angka desimal (contoh: 33.5 cm).',
        ]);

        // Sanitasi nilai nullable agar tidak melempar SQL error pada MySQL strict mode
        foreach (['kehamilan_id', 'nik', 'tempat_lahir', 'anak_ke', 'berat_lahir', 'panjang_lahir', 'lingkar_kepala_lahir', 'golongan_darah', 'catatan'] as $col) {
            if (!isset($validated[$col]) || $validated[$col] === '') {
                $validated[$col] = null;
            }
        }

        $user = $this->getActiveUser();
        $validated['user_id'] = $user->id;

        $anak = Anak::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data anak berhasil ditambahkan!',
                'data' => $anak,
            ], 201);
        }

        return redirect()->route('data-anak.index')
            ->with('success', "Data anak '{$anak->nama}' berhasil ditambahkan ke catatan keluarga!");
    }

    /**
     * Tampilkan detail lengkap profil anak.
     */
    public function show($id)
    {
        $user = $this->getActiveUser();
        $anak = Anak::with('kehamilan')->where('user_id', $user->id)->findOrFail($id);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $anak->id,
                    'nama' => $anak->nama,
                    'nik' => $anak->nik ?: '-',
                    'jenis_kelamin' => $anak->jenis_kelamin,
                    'tanggal_lahir' => $anak->tanggal_lahir_formatted,
                    'tanggal_lahir_raw' => $anak->tanggal_lahir ? $anak->tanggal_lahir->format('Y-m-d') : null,
                    'umur' => $anak->usia_formatted,
                    'tempat_lahir' => $anak->tempat_lahir ?: '-',
                    'anak_ke' => $anak->anak_ke ?: '-',
                    'berat_lahir' => $anak->berat_lahir ? "{$anak->berat_lahir} kg" : '-',
                    'panjang_lahir' => $anak->panjang_lahir ? "{$anak->panjang_lahir} cm" : '-',
                    'lingkar_kepala_lahir' => $anak->lingkar_kepala_lahir ? "{$anak->lingkar_kepala_lahir} cm" : '-',
                    'golongan_darah' => $anak->golongan_darah ?: '-',
                    'kehamilan_terkait' => $anak->kehamilan_terkait_label,
                    'catatan' => $anak->catatan ?: 'Tidak ada catatan khusus.',
                ]
            ]);
        }

        return redirect()->route('data-anak.index');
    }

    /**
     * Tampilkan formulir untuk mengedit data anak.
     */
    public function edit($id)
    {
        $user = $this->getActiveUser();
        Carbon::setLocale('id');

        $anak = Anak::where('user_id', $user->id)->findOrFail($id);
        $kehamilans = Kehamilan::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');
        $namaKeluarga = $user->name ?: 'Keluarga Pratama';
        $faskesInfo = 'Posyandu Mawar 1 & Puskesmas Sejahtera';

        return view('DashboardPengguna.data-anak.edit', [
            'anak' => $anak,
            'kehamilans' => $kehamilans,
            'user' => $user,
            'namaKeluarga' => $namaKeluarga,
            'tanggalHariIni' => $tanggalHariIni,
            'faskesInfo' => $faskesInfo,
            'maxDate' => Carbon::now()->format('Y-m-d'),
        ]);
    }

    /**
     * Perbarui data anak yang ada.
     */
    public function update(Request $request, $id)
    {
        Carbon::setLocale('id');
        $user = $this->getActiveUser();
        $anak = Anak::where('user_id', $user->id)->findOrFail($id);

        $input = $request->all();
        foreach (['berat_lahir', 'panjang_lahir', 'lingkar_kepala_lahir'] as $numField) {
            if (isset($input[$numField]) && is_string($input[$numField])) {
                $cleaned = trim(str_replace(',', '.', $input[$numField]));
                $input[$numField] = $cleaned !== '' ? $cleaned : null;
            }
        }
        if (isset($input['berat_lahir']) && is_numeric($input['berat_lahir']) && (float) $input['berat_lahir'] > 20) {
            $input['berat_lahir'] = round(((float) $input['berat_lahir']) / 1000, 2);
        }
        foreach (['kehamilan_id', 'nik', 'tempat_lahir', 'anak_ke', 'golongan_darah', 'catatan'] as $optField) {
            if (isset($input[$optField]) && trim((string) $input[$optField]) === '') {
                $input[$optField] = null;
            }
        }
        $request->merge($input);

        $maxDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:' . $maxDate],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kehamilan_id' => ['nullable', 'exists:kehamilans,id'],
            'nik' => ['nullable', 'string', 'max:30'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'anak_ke' => ['nullable', 'integer', 'min:1', 'max:20'],
            'berat_lahir' => ['nullable', 'numeric', 'min:0.5', 'max:15'],
            'panjang_lahir' => ['nullable', 'numeric', 'min:20', 'max:100'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:15', 'max:70'],
            'golongan_darah' => ['nullable', 'string', 'max:10'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'nama.required' => 'Nama lengkap anak wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir anak wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin anak.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin harus Laki-laki atau Perempuan.',
            'kehamilan_id.exists' => 'Data kehamilan yang dipilih tidak ditemukan dalam sistem.',
        ]);

        foreach (['kehamilan_id', 'nik', 'tempat_lahir', 'anak_ke', 'berat_lahir', 'panjang_lahir', 'lingkar_kepala_lahir', 'golongan_darah', 'catatan'] as $col) {
            if (!isset($validated[$col]) || $validated[$col] === '') {
                $validated[$col] = null;
            }
        }

        $anak->update($validated);

        return redirect()->route('data-anak.index')
            ->with('success', "Data anak '{$anak->nama}' berhasil diperbarui!");
    }

    /**
     * Hapus data anak dari catatan keluarga.
     */
    public function destroy($id)
    {
        $user = $this->getActiveUser();
        $anak = Anak::where('user_id', $user->id)->findOrFail($id);
        $namaAnak = $anak->nama;

        $anak->delete();

        return redirect()->route('data-anak.index')
            ->with('success', "Data anak '{$namaAnak}' berhasil dihapus dari sistem.");
    }
}
