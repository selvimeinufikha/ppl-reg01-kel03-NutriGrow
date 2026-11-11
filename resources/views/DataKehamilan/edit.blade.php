<!DOCTYPE html>
@php
    $userName = $userName ?? (Auth::check() ? Auth::user()->name : 'Sarah Rahmawati');
    $userId = $userId ?? 'NGW-88291-JKT';
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Data Kehamilan - NutriGrow</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- LEFT SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
        <div class="p-5 overflow-y-auto flex-1 bg-transparent">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between mb-7 pl-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain transition group-hover:scale-102">
                </a>
            </div>

            <!-- Group: UTAMA -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">UTAMA</span>
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Group: DATA KELUARGA & PROFIL -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">DATA KELUARGA &amp; PROFIL</span>
                <nav class="space-y-1">
                    <a href="#data-pasangan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Data Pasangan</span>
                    </a>
                    
                    <a href="{{ route('kehamilan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-gradient-to-r from-brand-800 to-brand-700 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4 text-rose-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Data Kehamilan</span>
                    </a>

                    <a href="#data-anak" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Data Anak</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="p-4 border-t border-pink-100/60 bg-white/40 backdrop-blur-sm">
            <a href="{{ route('kehamilan.index') }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-slate-600 hover:text-brand-700 bg-white rounded-xl border border-pink-100 shadow-xs transition">
                <span>&larr; Kembali ke Daftar</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- TOP HEADER -->
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-20 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200/80 text-[11px] font-medium text-slate-600">
                    <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $tanggalHariIni }}</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50/80 border border-blue-200/70 text-[11px] font-semibold text-blue-700">
                    <span>Faskes: {{ $faskesName }}</span>
                </div>
            </div>
            <div class="text-xs font-bold text-slate-600">{{ $userName }}</div>
        </header>

        <!-- MAIN CONTAINER -->
        <main class="p-4 sm:p-6 lg:p-8 max-w-4xl w-full mx-auto space-y-6">
            
            <!-- Breadcrumb -->
            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-slate-600">Dashboard</a>
                <span>&rsaquo;</span>
                <a href="{{ route('kehamilan.index') }}" class="hover:text-slate-600">Data Kehamilan</a>
                <span>&rsaquo;</span>
                <span class="text-brand-700 font-bold">Edit Kehamilan Ke-{{ $kehamilan->kehamilan_ke }}</span>
            </div>

            <!-- Page Title -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Edit Data &amp; Status Kehamilan</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Perbarui informasi siklus, HPHT, atau ubah status kehamilan (berlangsung, melahirkan, keguguran).</p>
                </div>
                <a href="{{ route('kehamilan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-700">
                    <span>&larr; Batal &amp; Kembali</span>
                </a>
            </div>

            <!-- Error Alerts if any -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl shadow-xs">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs font-bold">Gagal Menyimpan Perubahan</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm">
                <form action="{{ route('kehamilan.update', $kehamilan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Section 1: Acceptance Criteria - Edit Status Kehamilan -->
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider text-brand-700 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                            <span>Status &amp; Informasi Pokok (Acceptance Criteria)</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            
                            <!-- Field: Status Kehamilan (berlangsung, melahirkan, keguguran) -->
                            <div class="sm:col-span-2 bg-gradient-to-r from-pink-50/60 to-rose-50/60 p-4 rounded-2xl border border-pink-100">
                                <label for="status" class="block text-xs font-bold text-slate-800 mb-1.5">
                                    Status Kehamilan Saat Ini <span class="text-rose-500">*</span>
                                </label>
                                <select id="status" name="status" required onchange="toggleStatusFields()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-pink-200 bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-bold text-slate-800 transition">
                                    <option value="berlangsung" {{ old('status', $kehamilan->status) === 'berlangsung' ? 'selected' : '' }}>
                                        🤰 Berlangsung (Sedang Hamil Aktif)
                                    </option>
                                    <option value="melahirkan" {{ old('status', $kehamilan->status) === 'melahirkan' ? 'selected' : '' }}>
                                        👶 Melahirkan (Riwayat Selesai)
                                    </option>
                                    <option value="keguguran" {{ old('status', $kehamilan->status) === 'keguguran' ? 'selected' : '' }}>
                                        🥀 Keguguran
                                    </option>
                                </select>
                                <span class="text-[11px] text-slate-500 mt-1.5 block">
                                    Pilih <strong>Melahirkan</strong> bila persalinan telah selesai, atau <strong>Berlangsung</strong> untuk pemantauan janin aktif.
                                </span>
                            </div>

                            <!-- HPHT -->
                            <div>
                                <label for="hpht" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Hari Pertama Haid Terakhir (HPHT) <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" id="hpht" name="hpht" value="{{ old('hpht', $kehamilan->hpht ? $kehamilan->hpht->format('Y-m-d') : '') }}" max="{{ date('Y-m-d') }}" required onchange="hitungEstimasi()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                                <span class="text-[11px] text-slate-400 mt-1 block">Tidak boleh melebihi tanggal hari ini.</span>
                            </div>

                            <!-- Kehamilan Ke- -->
                            <div>
                                <label for="kehamilan_ke" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Kehamilan Ke- Berapa <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" id="kehamilan_ke" name="kehamilan_ke" value="{{ old('kehamilan_ke', $kehamilan->kehamilan_ke) }}" min="1" max="20" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                            </div>

                            <!-- Pasangan -->
                            <div class="sm:col-span-2">
                                <label for="pasangan_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Data Pasangan (Calon Ayah)
                                </label>
                                <select id="pasangan_id" name="pasangan_id" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                                    @foreach ($pasangans as $pasangan)
                                        <option value="{{ $pasangan->id }}" {{ old('pasangan_id', $kehamilan->pasangan_id) == $pasangan->id ? 'selected' : '' }}>
                                            {{ $pasangan->nama_lengkap }} ({{ $pasangan->hubungan ?? 'Suami' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Dinamis: Bidang Khusus Status Melahirkan -->
                    <div id="sectionMelahirkan" class="{{ old('status', $kehamilan->status) === 'melahirkan' ? '' : 'hidden' }} bg-blue-50/60 p-5 rounded-2xl border border-blue-100 space-y-4">
                        <div class="flex items-center gap-2 text-xs font-bold text-blue-900">
                            <span>👶</span>
                            <span>Informasi Kelahiran &amp; Data Persalinan</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_persalinan" class="block text-xs font-bold text-slate-700 mb-1">Tanggal Persalinan</label>
                                <input type="date" id="tanggal_persalinan" name="tanggal_persalinan" value="{{ old('tanggal_persalinan', $kehamilan->tanggal_persalinan ? $kehamilan->tanggal_persalinan->format('Y-m-d') : '') }}" max="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label for="status_persalinan" class="block text-xs font-bold text-slate-700 mb-1">Status Persalinan</label>
                                <select id="status_persalinan" name="status_persalinan" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                    <option value="Aterm (Cukup Bulan)" {{ old('status_persalinan', $kehamilan->status_persalinan) === 'Aterm (Cukup Bulan)' ? 'selected' : '' }}>Aterm (Cukup Bulan)</option>
                                    <option value="Prematur" {{ old('status_persalinan', $kehamilan->status_persalinan) === 'Prematur' ? 'selected' : '' }}>Prematur (< 37 Minggu)</option>
                                    <option value="Postmatur" {{ old('status_persalinan', $kehamilan->status_persalinan) === 'Postmatur' ? 'selected' : '' }}>Postmatur (> 42 Minggu)</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="nama_anak" class="block text-xs font-bold text-slate-700 mb-1">Nama Anak yang Dilahirkan</label>
                                <input type="text" id="nama_anak" name="nama_anak" value="{{ old('nama_anak', $kehamilan->nama_anak) }}" placeholder="Contoh: Kinan Pratama" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <span class="text-[10px] text-blue-600 mt-1 block">Data nama anak ini akan terhubung ke menu Data Anak.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Live Calculation Preview -->
                    <div id="livePreviewBox" class="bg-gradient-to-r from-pink-50 via-rose-50 to-pink-50 border border-pink-200 rounded-2xl p-4">
                        <div class="text-xs font-bold text-brand-900 mb-2 flex items-center gap-2">
                            <span>✨</span>
                            <span>Kalkulasi Otomatis dari HPHT:</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-center">
                            <div class="bg-white p-3 rounded-xl shadow-xs">
                                <div class="text-[10px] font-bold uppercase text-slate-400">Hari Perkiraan Lahir (HPL)</div>
                                <div id="liveHpl" class="text-sm font-extrabold text-brand-700 mt-1">{{ $kehamilan->hpl_formatted }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-xl shadow-xs">
                                <div class="text-[10px] font-bold uppercase text-slate-400">Usia Gestasi</div>
                                <div id="liveUsia" class="text-sm font-extrabold text-slate-800 mt-1">{{ $kehamilan->usia_kehamilan }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-xl shadow-xs">
                                <div class="text-[10px] font-bold uppercase text-slate-400">Trimester</div>
                                <div id="liveTrimester" class="text-sm font-extrabold text-blue-700 mt-1">{{ $kehamilan->trimester }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Fisik & Catatan -->
                    <div class="pt-4 border-t border-slate-100">
                        <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                            <span>Data Fisik &amp; Catatan Perkembangan</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="tinggi_badan" class="block text-xs font-bold text-slate-700 mb-1.5">Tinggi Badan Ibu (cm)</label>
                                <input type="number" step="0.1" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan', $kehamilan->tinggi_badan) }}" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="berat_badan_pra_hamil" class="block text-xs font-bold text-slate-700 mb-1.5">Berat Badan Pra-Hamil (kg)</label>
                                <input type="number" step="0.1" id="berat_badan_pra_hamil" name="berat_badan_pra_hamil" value="{{ old('berat_badan_pra_hamil', $kehamilan->berat_badan_pra_hamil) }}" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="catatan" class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Kondisi / Persalinan</label>
                            <textarea id="catatan" name="catatan" rows="3" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('catatan', $kehamilan->catatan) }}</textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 flex-wrap gap-3">
                        <!-- Tombol Hapus dengan Dialog Konfirmasi (Acceptance Criteria 2) -->
                        <button type="button" onclick="bukaDialogKonfirmasiHapus({{ $kehamilan->id }}, {{ $kehamilan->kehamilan_ke }})" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-xs transition border border-rose-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Hapus Data Kehamilan Ini</span>
                        </button>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('kehamilan.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-800 to-rose-700 hover:from-brand-900 hover:to-rose-800 text-white font-bold text-xs shadow-md shadow-brand-900/20 hover:shadow-lg transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </main>
    </div>

    <!-- ========================================== -->
    <!-- DIALOG KONFIRMASI PENGHAPUSAN (ACCEPTANCE CRITERIA 2) -->
    <!-- ========================================== -->
    <div id="modalKonfirmasiHapus" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in duration-200">
            <!-- Icon Warning -->
            <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <!-- Content -->
            <div class="text-center space-y-2 mb-6">
                <h3 class="text-base font-extrabold text-slate-900">Konfirmasi Penghapusan Data</h3>
                <p id="pesanKonfirmasiHapus" class="text-xs text-slate-600 leading-relaxed">
                    Apakah Anda yakin ingin menghapus data <strong>Kehamilan Ke-{{ $kehamilan->kehamilan_ke }}</strong>? Seluruh catatan terkait akan dihapus permanen.
                </p>
            </div>

            <!-- Actions -->
            <form id="formHapusKehamilan" action="{{ route('kehamilan.destroy', $kehamilan->id) }}" method="POST" class="flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="tutupDialogKonfirmasiHapus()" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition">
                    Ya, Hapus Data
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleStatusFields() {
            const status = document.getElementById('status').value;
            const section = document.getElementById('sectionMelahirkan');
            if (status === 'melahirkan') {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        }

        function hitungEstimasi() {
            const hphtVal = document.getElementById('hpht').value;
            if (!hphtVal) return;

            const hphtDate = new Date(hphtVal);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (hphtDate > today) {
                alert("Tanggal HPHT tidak boleh melebihi tanggal hari ini.");
                return;
            }

            const hplDate = new Date(hphtDate);
            hplDate.setDate(hplDate.getDate() + 280);

            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            const hplFormatted = hplDate.toLocaleDateString('id-ID', options);

            const diffTime = Math.abs(today - hphtDate);
            const totalDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            const weeks = Math.floor(totalDays / 7);
            const days = totalDays % 7;

            let trimester = "Trimester 1 (1–13 Mg)";
            if (weeks >= 14 && weeks <= 27) {
                trimester = "Trimester 2 (14–27 Mg)";
            } else if (weeks > 27) {
                trimester = "Trimester 3 (28–40 Mg)";
            }

            document.getElementById('liveHpl').textContent = hplFormatted;
            document.getElementById('liveUsia').textContent = `${weeks} Minggu ${days} Hari`;
            document.getElementById('liveTrimester').textContent = trimester;
        }

        function bukaDialogKonfirmasiHapus(id, nomor) {
            document.getElementById('formHapusKehamilan').action = `/data-kehamilan/${id}`;
            document.getElementById('pesanKonfirmasiHapus').innerHTML = `Apakah Anda yakin ingin menghapus data <strong>Kehamilan Ke-${nomor}</strong>? Tindakan ini tidak dapat dibatalkan.`;
            document.getElementById('modalKonfirmasiHapus').classList.remove('hidden');
        }

        function tutupDialogKonfirmasiHapus() {
            document.getElementById('modalKonfirmasiHapus').classList.add('hidden');
        }
    </script>
</body>
</html>
