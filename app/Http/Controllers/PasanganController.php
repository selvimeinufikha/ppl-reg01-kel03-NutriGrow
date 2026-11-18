<?php

namespace App\Http\Controllers;

use App\Models\Pasangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasanganController extends Controller
{
    /**
     * Tampilkan daftar data pasangan milik pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        $pasangans = Pasangan::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('DataPasangan.index', compact('pasangans'));
    }

    /**
     * Tampilkan form tambah data pasangan.
     */
    public function create()
    {
        return view('DataPasangan.create');
    }

    /**
     * Simpan data pasangan baru.
     * Acceptance Criteria:
     * - Pengguna mengisi nama, tanggal lahir, pekerjaan, golongan darah, dan status pasangan.
     * - Isian wajib yang kosong atau tidak valid ditolak dengan pesan kesalahan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date|before:today',
            'pekerjaan'        => 'nullable|string|max:255',
            'golongan_darah'   => 'nullable|in:A,B,AB,O',
            'status_pasangan'  => 'required|in:suami,istri,calon_suami,calon_istri',
        ], [
            'nama.required'            => 'Nama pasangan wajib diisi.',
            'nama.max'                 => 'Nama pasangan maksimal 255 karakter.',
            'tanggal_lahir.required'   => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'       => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'     => 'Tanggal lahir harus sebelum hari ini.',
            'golongan_darah.in'        => 'Golongan darah harus A, B, AB, atau O.',
            'status_pasangan.required' => 'Status pasangan wajib dipilih.',
            'status_pasangan.in'       => 'Status pasangan tidak valid.',
        ]);

        $validated['user_id'] = Auth::id();

        Pasangan::create($validated);

        return redirect()->route('pasangan.index')
            ->with('success', 'Data pasangan berhasil ditambahkan!');
    }
}
