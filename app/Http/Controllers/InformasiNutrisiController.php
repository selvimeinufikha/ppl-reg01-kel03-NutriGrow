<?php

namespace App\Http\Controllers;

use App\Models\InformasiNutrisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformasiNutrisiController extends Controller
{
    /**
     * Dapatkan user admin aktif atau fallback untuk kemudahan dev.
     */
    protected function getActiveAdmin()
    {
        $user = Auth::user();
        if (!$user) {
            $user = User::first();
        }
        return $user;
    }

    /**
     * Tampilkan halaman katalog/rekomendasi informasi nutrisi (sesuai desain).
     */
    public function index(Request $request)
    {
        $query = InformasiNutrisi::query();

        // Filter pencarian nama bahan/menu atau kandungan gizi
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_bahan_menu', 'like', "%{$q}%")
                    ->orWhere('kandungan_gizi', 'like', "%{$q}%")
                    ->orWhere('deskripsi_manfaat', 'like', "%{$q}%");
            });
        }

        // Filter kategori fase
        if ($request->filled('fase')) {
            $query->where('kategori_fase', $request->fase);
        }

        // Filter kategori kondisi
        if ($request->filled('kondisi')) {
            $query->where('kategori_kondisi', $request->kondisi);
        }

        $nutrisis = $query->orderBy('created_at', 'desc')->get();

        $activeFase = $request->fase ?? '';
        $activeKondisi = $request->kondisi ?? '';
        $searchTerm = $request->q ?? '';

        $viewName = $request->is('admin*') 
            ? 'DashboardAdmin.informasi-nutrisi' 
            : 'DashboardPengguna.informasi-nutrisi.index';

        return view($viewName, [
            'nutrisis' => $nutrisis,
            'daftarFase' => InformasiNutrisi::DAFTAR_FASE,
            'daftarKondisi' => InformasiNutrisi::DAFTAR_KONDISI,
            'activeFase' => $activeFase,
            'activeKondisi' => $activeKondisi,
            'searchTerm' => $searchTerm,
        ]);
    }

    /**
     * Tampilkan formulir tambah informasi nutrisi (Admin).
     */
    public function create()
    {
        return view('DashboardPengguna.informasi-nutrisi.create', [
            'daftarFase' => InformasiNutrisi::DAFTAR_FASE,
            'daftarKondisi' => InformasiNutrisi::DAFTAR_KONDISI,
        ]);
    }

    /**
     * Simpan informasi nutrisi baru ke basis data.
     * Acceptance Criteria:
     * - Admin mengisi nama bahan/menu, kandungan gizi, kategori fase dan kondisi, serta saran penggunaan.
     * - Isian wajib yang kosong ditolak.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bahan_menu' => ['required', 'string', 'max:255'],
            'kandungan_gizi' => ['required', 'string'],
            'kategori_fase' => ['required', 'string', 'in:' . implode(',', array_keys(InformasiNutrisi::DAFTAR_FASE))],
            'kategori_kondisi' => ['required', 'string', 'in:' . implode(',', array_keys(InformasiNutrisi::DAFTAR_KONDISI))],
            'saran_penggunaan' => ['required', 'string'],
            'deskripsi_manfaat' => ['nullable', 'string'],
            'foto' => ['nullable', 'string', 'max:500'],
        ], [
            'nama_bahan_menu.required' => 'Nama bahan atau menu makanan/gizi wajib diisi.',
            'nama_bahan_menu.string' => 'Nama bahan atau menu harus berupa teks valid.',
            'nama_bahan_menu.max' => 'Nama bahan atau menu tidak boleh melebihi 255 karakter.',
            'kandungan_gizi.required' => 'Kandungan gizi (misal: protein, vitamin, kalsium, zat besi) wajib diisi.',
            'kategori_fase.required' => 'Kategori fase kehidupan wajib dipilih.',
            'kategori_fase.in' => 'Kategori fase yang dipilih tidak valid.',
            'kategori_kondisi.required' => 'Kategori kondisi atau tujuan nutrisi wajib dipilih.',
            'kategori_kondisi.in' => 'Kategori kondisi yang dipilih tidak valid.',
            'saran_penggunaan.required' => 'Saran penggunaan atau anjuran konsumsi wajib diisi.',
        ]);

        $admin = $this->getActiveAdmin();
        $validated['created_by'] = $admin ? $admin->id : null;

        $nutrisi = InformasiNutrisi::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Informasi nutrisi berhasil ditambahkan!',
                'data' => $nutrisi,
            ], 201);
        }

        return redirect()->route('informasi-nutrisi.index')
            ->with('success', "Informasi nutrisi '{$nutrisi->nama_bahan_menu}' berhasil ditambahkan ke katalog!");
    }

    /**
     * Tampilkan detail informasi nutrisi.
     */
    public function show($id)
    {
        $nutrisi = InformasiNutrisi::findOrFail($id);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $nutrisi,
            ]);
        }

        return redirect()->route('informasi-nutrisi.index');
    }

    /**
     * Tampilkan halaman formulir edit informasi nutrisi (PBI-026).
     */
    public function edit($id)
    {
        $nutrisi = InformasiNutrisi::findOrFail($id);

        $viewName = request()->is('admin*')
            ? 'DashboardAdmin.informasi-nutrisi-edit'
            : 'DashboardPengguna.informasi-nutrisi.edit';

        // Fallback jika salah satu view belum dibuat
        if (!view()->exists($viewName)) {
            $viewName = 'DashboardPengguna.informasi-nutrisi.edit';
        }

        return view($viewName, [
            'nutrisi' => $nutrisi,
            'daftarFase' => InformasiNutrisi::DAFTAR_FASE,
            'daftarKondisi' => InformasiNutrisi::DAFTAR_KONDISI,
        ]);
    }

    /**
     * Perbarui data informasi nutrisi di basis data (PBI-026).
     * Acceptance Criteria:
     * - Perubahan tersimpan dan dipakai pada rekomendasi pengguna berikutnya.
     */
    public function update(Request $request, $id)
    {
        $nutrisi = InformasiNutrisi::findOrFail($id);

        $validated = $request->validate([
            'nama_bahan_menu' => ['required', 'string', 'max:255'],
            'kandungan_gizi' => ['required', 'string'],
            'kategori_fase' => ['required', 'string', 'in:' . implode(',', array_keys(InformasiNutrisi::DAFTAR_FASE))],
            'kategori_kondisi' => ['required', 'string', 'in:' . implode(',', array_keys(InformasiNutrisi::DAFTAR_KONDISI))],
            'saran_penggunaan' => ['required', 'string'],
            'deskripsi_manfaat' => ['nullable', 'string'],
            'foto' => ['nullable', 'string', 'max:500'],
        ], [
            'nama_bahan_menu.required' => 'Nama bahan atau menu makanan/gizi wajib diisi.',
            'nama_bahan_menu.string' => 'Nama bahan atau menu harus berupa teks valid.',
            'nama_bahan_menu.max' => 'Nama bahan atau menu tidak boleh melebihi 255 karakter.',
            'kandungan_gizi.required' => 'Kandungan gizi (misal: protein, vitamin, kalsium, zat besi) wajib diisi.',
            'kategori_fase.required' => 'Kategori fase kehidupan wajib dipilih.',
            'kategori_fase.in' => 'Kategori fase yang dipilih tidak valid.',
            'kategori_kondisi.required' => 'Kategori kondisi atau tujuan nutrisi wajib dipilih.',
            'kategori_kondisi.in' => 'Kategori kondisi yang dipilih tidak valid.',
            'saran_penggunaan.required' => 'Saran penggunaan atau anjuran konsumsi wajib diisi.',
        ]);

        $nutrisi->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Informasi nutrisi '{$nutrisi->nama_bahan_menu}' berhasil diperbarui!",
                'data' => $nutrisi,
            ]);
        }

        $redirectRoute = $request->is('admin*')
            ? route('admin.informasi-nutrisi.index')
            : route('informasi-nutrisi.index');

        return redirect($redirectRoute)
            ->with('success', "Informasi nutrisi '{$nutrisi->nama_bahan_menu}' berhasil diperbarui dan diterapkan pada rekomendasi!");
    }

    /**
     * Hapus informasi nutrisi dari basis data (PBI-026).
     * Acceptance Criteria:
     * - Penghapusan meminta konfirmasi (melalui dialog konfirmasi frontend).
     */
    public function destroy(Request $request, $id)
    {
        $nutrisi = InformasiNutrisi::findOrFail($id);
        $nama = $nutrisi->nama_bahan_menu;
        $nutrisi->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Informasi nutrisi '{$nama}' berhasil dihapus dari sistem.",
            ]);
        }

        $redirectRoute = $request->is('admin*')
            ? route('admin.informasi-nutrisi.index')
            : route('informasi-nutrisi.index');

        return redirect($redirectRoute)
            ->with('success', "Informasi nutrisi '{$nama}' berhasil dihapus!");
    }
}
