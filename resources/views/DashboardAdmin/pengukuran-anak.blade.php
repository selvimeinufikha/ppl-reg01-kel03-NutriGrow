<!DOCTYPE html>
@php
    $adminName = $adminName ?? (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
    $adminEmail = $adminEmail ?? (Auth::check() ? Auth::user()->email : 'admin@nutrigrow.id');
    $adminRole = $adminRole ?? (Auth::check() && Auth::user()->role === 'nakes' ? 'Tenaga Kesehatan (Bidan/Dokter)' : 'Administrator Faskes');
    $faskesName = $faskesName ?? (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Posyandu Mawar 1 & Puskesmas Sejahtera');
    $nipStr = $nipStr ?? (Auth::check() && Auth::user()->nip_str ? Auth::user()->nip_str : 'STR-19880412-2023-019');
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag();
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Input Pengukuran Anak - NutriGrow | Portal Admin Tenaga Kesehatan</title>

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
                        medical: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="min-h-screen bg-[#f8fafc] font-sans antialiased text-slate-800">

    <!-- Mobile Top Navigation Bar -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#0284c7] bg-sky-50 px-2 py-0.5 rounded-md">
                PORTAL ADMIN
            </span>
        </div>
        <button
            type="button"
            onclick="toggleAdminSidebar()"
            class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer"
            aria-label="Buka Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Backdrop for Mobile Sidebar -->
    <div id="adminSidebarBackdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden"></div>

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- =============================================================== -->
        <!-- 1. SIDEBAR NAVIGASI (PORTAL ADMIN TENAGA KESEHATAN)             -->
        <!-- =============================================================== -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] xl:w-[275px] bg-white border-r border-slate-200 flex flex-col justify-between py-5 px-4 shrink-0 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand Header -->
                <div class="px-2 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                        <div class="text-[9.5px] font-black uppercase tracking-widest text-[#e11d48] mt-1">
                            PORTAL ADMIN
                            <span class="block text-[8px] tracking-wider text-slate-400 font-semibold">TENAGA KESEHATAN</span>
                        </div>
                    </a>

                    <!-- Verified Badge -->
                    <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-50 border border-sky-100/90 text-[10px] font-bold text-sky-700 tracking-tight w-full">
                        <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>TENAGA KESEHATAN TERVERIFIKASI</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1 text-xs font-semibold">
                    <!-- 1. Dashboard Admin -->
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                        </svg>
                        <span>Dashboard Admin</span>
                    </a>

                    <!-- 2. Data Pengguna -->
                    <a
                        href="{{ route('admin.dashboard') }}#pengguna"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Data Pengguna</span>
                    </a>

                    <!-- 3. Data Pemeriksaan Kehamilan -->
                    <a
                        href="{{ route('admin.dashboard') }}#anc"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Pemeriksaan Kehamilan</span>
                    </a>

                    <!-- 4. Data Tumbuh Kembang Anak (ACTIVE - PBI-016) -->
                    <a
                        href="{{ route('admin.pengukuran.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#0284c7] text-white shadow-xs font-bold transition"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Tumbuh Kembang Anak</span>
                    </a>

                    <!-- 5. Data Edukasi Gizi -->
                    <a
                        href="{{ route('admin.edukasi.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Data Edukasi Gizi</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Bottom: Info Petugas & Logout -->
            <div class="pt-4 border-t border-slate-100">
                <div class="px-2 py-2 rounded-xl bg-slate-50 border border-slate-200/70 mb-3 text-xs">
                    <div class="font-bold text-slate-900 truncate">{{ $adminName }}</div>
                    <div class="text-[10px] text-slate-500 truncate">{{ $faskesName }}</div>
                    <div class="text-[9px] text-sky-600 font-semibold mt-0.5">{{ $nipStr }}</div>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-200 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar Portal</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- =============================================================== -->
        <!-- 2. MAIN CONTENT AREA                                            -->
        <!-- =============================================================== -->
        <main class="flex-1 min-w-0 overflow-y-auto px-4 sm:px-8 py-6 space-y-6">

            <!-- Top Header & Breadcrumbs -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200">
                <div>
                    <!-- Breadcrumbs -->
                    <nav class="flex items-center gap-2 text-xs text-slate-400 font-medium mb-1.5">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Dashboard Admin</a>
                        <span>&gt;</span>
                        <span class="text-slate-800 font-bold">Data Tumbuh Kembang Anak (PBI-016)</span>
                    </nav>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                        <span>Input Pengukuran &amp; Status Gizi Anak</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-pink-100 text-[#be185d] text-xs font-extrabold">
                            PBI-016 / F-06
                        </span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Sebagai tenaga kesehatan, input hasil pengukuran anak (BB, TB, LK, LiLA) agar pertumbuhan anak tercatat akurat.
                    </p>
                </div>

                <!-- Info Tanggal & Faskes Header -->
                <div class="flex items-center gap-2 flex-wrap text-xs">
                    <span class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 font-semibold shadow-2xs">
                        📅 {{ $tanggalHariIni }}
                    </span>
                    <a href="{{ route('tumbuh-kembang.index') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-pink-50 hover:bg-pink-100 text-[#be185d] font-bold transition border border-pink-200 shadow-2xs">
                        <span>Lihat View Orang Tua</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success_message'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-start gap-3 shadow-2xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <div class="font-extrabold text-emerald-800">Berhasil Disimpan &amp; Tersinkronisasi!</div>
                        <div class="mt-0.5 leading-relaxed">{{ session('success_message') }}</div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs flex items-start gap-3 shadow-2xs">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <div>
                        <div class="font-extrabold text-rose-800">Validasi Pengukuran Gagal (Nilai Kosong / Tidak Wajar Ditolak):</div>
                        <ul class="list-disc list-inside mt-1 space-y-0.5 text-rose-700">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- 4 Summary Stat Widgets -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Pengukuran</span>
                    <div class="text-xl font-black text-slate-900 mt-1">{{ $totalPengukuran }} Catatan</div>
                    <span class="text-[11px] text-sky-600 font-semibold mt-1 block">Tersinkron Database MySQL</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Balita Terdaftar</span>
                    <div class="text-xl font-black text-slate-900 mt-1">{{ $totalAnakDipantau }} Anak</div>
                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">Wilayah Posyandu &amp; Puskesmas</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pertumbuhan Normal</span>
                    <div class="text-xl font-black text-emerald-600 mt-1">{{ $statusNormalCount }} Balita</div>
                    <span class="text-[11px] text-emerald-700 font-medium mt-1 block">Bebas Indikasi Stunting</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Perlu Pantauan</span>
                    <div class="text-xl font-black text-amber-600 mt-1">{{ $statusPerluPantauanCount }} Balita</div>
                    <span class="text-[11px] text-amber-700 font-medium mt-1 block">Target Konseling PMT Gizi</span>
                </div>
            </div>

            <!-- =============================================================== -->
            <!-- 3. FORMULIR INPUT PENGUKURAN ANAK (SESUAI ACCEPTANCE CRITERIA)   -->
            <!-- =============================================================== -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-6 bg-gradient-to-r from-sky-50/70 via-blue-50/30 to-indigo-50/40 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#0284c7] text-white flex items-center justify-center font-bold text-lg shadow-sm">
                            ⚖️
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900">Formulir Input Pengukuran &amp; Status Gizi Balita</h2>
                            <p class="text-xs text-slate-500">
                                Tenaga kesehatan memilih pengguna dan anak, lalu mengisi data antropometri yang valid.
                            </p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-[11px] font-extrabold self-start md:self-center">
                        PBI-016 &bull; Form Aktif Nakes
                    </span>
                </div>

                <form action="{{ route('admin.pengukuran.store') }}" method="POST" id="formPengukuran" class="p-5 sm:p-7 space-y-6">
                    @csrf

                    <!-- STEP 1: PEMILIHAN PENGGUNA (ORANG TUA) & ANAK -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-5 h-5 rounded-full bg-[#0284c7] text-white text-[11px] font-bold flex items-center justify-center">1</span>
                            <h3 class="text-xs uppercase font-extrabold tracking-wider text-slate-700">Pilih Pengguna &amp; Anak yang Diukur</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Dropdown Pengguna (Orang Tua / Wali) -->
                            <div>
                                <label for="waliSelect" class="block text-xs font-bold text-slate-700 mb-1">
                                    Pengguna (Orang Tua / Wali) <span class="text-rose-500">*</span>
                                </label>
                                <select id="waliSelect" onchange="filterAnakByWali()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition cursor-pointer">
                                    <option value="all">-- Semua Pengguna Terdaftar --</option>
                                    @foreach($usersWithChildren as $parent)
                                        <option value="{{ $parent->id }}">
                                            {{ $parent->name }} ({{ $parent->email }}) &bull; {{ $parent->anaks->count() }} Anak
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-[10px] text-slate-400 mt-1 block">Admin dapat memfilter anak berdasarkan akun orang tua yang terdaftar.</span>
                            </div>

                            <!-- Dropdown Anak -->
                            <div>
                                <label for="anak_id" class="block text-xs font-bold text-slate-700 mb-1">
                                    Pilih Anak yang Diukur <span class="text-rose-500">*</span>
                                </label>
                                <select name="anak_id" id="anak_id" required onchange="updateChildMetadata()" class="w-full px-3.5 py-2.5 rounded-xl border @error('anak_id') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition cursor-pointer">
                                    <option value="" disabled selected>-- Pilih Anak --</option>
                                    @foreach($allAnaks as $a)
                                        <option value="{{ $a->id }}"
                                                data-user-id="{{ $a->user_id }}"
                                                data-lahir="{{ $a->tanggal_lahir ? $a->tanggal_lahir->format('Y-m-d') : '2022-02-14' }}"
                                                data-gender="{{ $a->jenis_kelamin }}"
                                                data-nik="{{ $a->nik ?? '-' }}"
                                                {{ (old('anak_id') == $a->id || $loop->first) ? 'selected' : '' }}>
                                            👶 {{ $a->nama }} &bull; {{ $a->jenis_kelamin }} (Wali: {{ $a->user ? $a->user->name : 'Sarah Rahmawati' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('anak_id')
                                    <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Card Detail Anak Terpilih -->
                        <div id="childMetaCard" class="mt-3 p-3.5 rounded-2xl bg-sky-50/70 border border-sky-200/70 flex flex-wrap items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-sky-200 text-sky-800 flex items-center justify-center font-bold text-sm">
                                    👶
                                </div>
                                <div>
                                    <span class="font-extrabold text-slate-900" id="mChildName">Aisyah Putri Rahmawati</span>
                                    <div class="text-[11px] text-slate-500">
                                        NIK: <span id="mChildNik">3171056508210002</span> &bull; Lahir: <span id="mChildBirth">14 Februari 2022</span> (<span id="mChildGender">Perempuan</span>)
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Usia Saat Pemeriksaan</span>
                                <span class="text-xs font-black text-blue-700" id="mCalculatedAge">27 Bulan (2 Tahun 3 Bulan)</span>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: HASIL PENGUKURAN ANTROPOMETRI (NILAI TIDAK WAJAR DITOLAK) -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-5 h-5 rounded-full bg-[#0284c7] text-white text-[11px] font-bold flex items-center justify-center">2</span>
                            <h3 class="text-xs uppercase font-extrabold tracking-wider text-slate-700">Hasil Pengukuran Antropometri</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                            <!-- Tanggal Pengukuran -->
                            <div>
                                <label for="tanggal_pemeriksaan" class="block text-xs font-bold text-slate-700 mb-1">
                                    Tanggal Pengukuran <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="tanggal_pemeriksaan"
                                    name="tanggal_pemeriksaan"
                                    required
                                    max="{{ date('Y-m-d') }}"
                                    value="{{ old('tanggal_pemeriksaan', date('Y-m-d')) }}"
                                    onchange="recalculateAge()"
                                    class="w-full px-3.5 py-2.5 rounded-xl border @error('tanggal_pemeriksaan') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"
                                />
                                @error('tanggal_pemeriksaan')
                                    <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Berat Badan (BB) -->
                            <div>
                                <label for="berat_badan" class="block text-xs font-bold text-slate-700 mb-1">
                                    Berat Badan (BB) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="berat_badan"
                                        name="berat_badan"
                                        required
                                        step="0.05"
                                        min="1.5"
                                        max="40.0"
                                        value="{{ old('berat_badan', '12.4') }}"
                                        placeholder="12.4"
                                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border @error('berat_badan') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"
                                    />
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-bold text-slate-400 pointer-events-none">
                                        kg
                                    </span>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Wajar: 1.5 - 40.0 kg</span>
                                @error('berat_badan')
                                    <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tinggi / Panjang Badan (TB) -->
                            <div>
                                <label for="tinggi_badan" class="block text-xs font-bold text-slate-700 mb-1">
                                    Tinggi / Panjang (TB) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="tinggi_badan"
                                        name="tinggi_badan"
                                        required
                                        step="0.1"
                                        min="30.0"
                                        max="150.0"
                                        value="{{ old('tinggi_badan', '88.5') }}"
                                        placeholder="88.5"
                                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border @error('tinggi_badan') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"
                                    />
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-bold text-slate-400 pointer-events-none">
                                        cm
                                    </span>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Wajar: 30.0 - 150.0 cm</span>
                                @error('tinggi_badan')
                                    <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Lingkar Kepala (LK) -->
                            <div>
                                <label for="lingkar_kepala" class="block text-xs font-bold text-slate-700 mb-1">
                                    Lingkar Kepala (LK)
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="lingkar_kepala"
                                        name="lingkar_kepala"
                                        step="0.1"
                                        min="20.0"
                                        max="65.0"
                                        value="{{ old('lingkar_kepala', '47.8') }}"
                                        placeholder="47.8"
                                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border @error('lingkar_kepala') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"
                                    />
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-bold text-slate-400 pointer-events-none">
                                        cm
                                    </span>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Wajar: 20.0 - 65.0 cm</span>
                                @error('lingkar_kepala')
                                    <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Lingkar Lengan Atas (LiLA) -->
                            <div>
                                <label for="lingkar_lengan_atas" class="block text-xs font-bold text-slate-700 mb-1">
                                    LiLA (Lengan Atas)
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="lingkar_lengan_atas"
                                        name="lingkar_lengan_atas"
                                        step="0.1"
                                        min="7.0"
                                        max="30.0"
                                        value="{{ old('lingkar_lengan_atas', '15.6') }}"
                                        placeholder="15.6"
                                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border @error('lingkar_lengan_atas') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"
                                    />
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-bold text-slate-400 pointer-events-none">
                                        cm
                                    </span>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Wajar: 7.0 - 30.0 cm</span>
                                @error('lingkar_lengan_atas')
                                    <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: REKOMENDASI KLINIS, IMUNISASI, & KPSP -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-5 h-5 rounded-full bg-[#0284c7] text-white text-[11px] font-bold flex items-center justify-center">3</span>
                            <h3 class="text-xs uppercase font-extrabold tracking-wider text-slate-700">Skrining Perkembangan, Imunisasi &amp; Edukasi Nakes</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                            <!-- KPSP -->
                            <div>
                                <label for="kpsp_status" class="block text-xs font-bold text-slate-700 mb-1">
                                    Skrining Perkembangan (KPSP)
                                </label>
                                <select id="kpsp_status" name="kpsp_status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 cursor-pointer">
                                    <option value="Sesuai Umur (10 dari 10 indikator terpenuhi)" {{ old('kpsp_status') == 'Sesuai Umur (10 dari 10 indikator terpenuhi)' ? 'selected' : '' }}>Sesuai Umur (Normal)</option>
                                    <option value="Meragukan (Perlu evaluasi ulang 2 minggu)">Meragukan (Evaluasi 2 Minggu)</option>
                                    <option value="Penyimpangan (Rujuk Poli Tumbuh Kembang)">Penyimpangan (Rujuk Faskes Lanjutan)</option>
                                </select>
                            </div>

                            <!-- Imunisasi -->
                            <div>
                                <label for="imunisasi" class="block text-xs font-bold text-slate-700 mb-1">
                                    Imunisasi yang Diberikan
                                </label>
                                <input
                                    type="text"
                                    id="imunisasi"
                                    name="imunisasi"
                                    value="{{ old('imunisasi', 'Lengkap sampai usia 2 tahun + booster PCV') }}"
                                    placeholder="Contoh: DPT-HB-Hib 4 Lanjutan"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                                />
                            </div>

                            <!-- Vitamin A & Obat Cacing -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="vitamin_a" class="block text-xs font-bold text-slate-700 mb-1">
                                        Vitamin A
                                    </label>
                                    <select id="vitamin_a" name="vitamin_a" class="w-full px-2.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 cursor-pointer">
                                        <option value="Kapsul Merah (200.000 IU)">Kapsul Merah</option>
                                        <option value="Kapsul Biru (100.000 IU)">Kapsul Biru</option>
                                        <option value="Belum Periode">Belum Periode</option>
                                        <option value="-">-</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="obat_cacing" class="block text-xs font-bold text-slate-700 mb-1">
                                        Obat Cacing
                                    </label>
                                    <select id="obat_cacing" name="obat_cacing" class="w-full px-2.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 cursor-pointer">
                                        <option value="Telah Diberikan (Albendazole)">Diberikan</option>
                                        <option value="-">-</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Klinis -->
                        <div>
                            <label for="catatan_klinis" class="block text-xs font-bold text-slate-700 mb-1">
                                Catatan Klinis &amp; Rekomendasi Edukasi Gizi untuk Orang Tua
                            </label>
                            <textarea
                                id="catatan_klinis"
                                name="catatan_klinis"
                                rows="3"
                                placeholder="Tuliskan catatan perkembangan motorik kasar/halus, nafsu makan, dan anjuran PMT gizi hewani..."
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"
                            >{{ old('catatan_klinis', 'Perkembangan motorik kasar dan halus sangat baik. Mampu menyusun balok 6 tingkat dan melompat 2 kaki mandiri. Tetap pertahankan asupan protein hewani & serat sayur.') }}</textarea>
                        </div>

                        <!-- Pemeriksa & Faskes -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                            <div>
                                <label for="nama_nakes" class="block text-[11px] font-semibold text-slate-500 mb-1">Nama Tenaga Medis Pemeriksa</label>
                                <input type="text" id="nama_nakes" name="nama_nakes" value="{{ old('nama_nakes', $adminName) }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700">
                            </div>
                            <div>
                                <label for="faskes_pemeriksa" class="block text-[11px] font-semibold text-slate-500 mb-1">Fasilitas Kesehatan / Posyandu</label>
                                <input type="text" id="faskes_pemeriksa" name="faskes_pemeriksa" value="{{ old('faskes_pemeriksa', $faskesName) }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700">
                            </div>
                        </div>
                    </div>

                    <!-- FORM ACTION BUTTONS -->
                    <div class="pt-5 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Terhubung langsung ke tabel MySQL &amp; Kurva WHO SatuSehat Kemenkes RI</span>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button
                                type="reset"
                                class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                            >
                                Reset Isian
                            </button>
                            <button
                                type="submit"
                                class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl bg-[#0284c7] hover:bg-sky-700 text-white font-extrabold text-xs shadow-md shadow-sky-600/20 hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Simpan Hasil Pengukuran</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- =============================================================== -->
            <!-- 4. TABEL DAFTAR REKAM HASIL PENGUKURAN DI DATABASE MYSQL        -->
            <!-- =============================================================== -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Daftar Hasil Pengukuran Terverifikasi di Database</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Seluruh rekaman data antropometri balita yang tersimpan di MySQL database `nutrigrow`.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <input
                            type="text"
                            id="tableSearch"
                            onkeyup="searchTable()"
                            placeholder="Cari nama balita, wali, status..."
                            class="px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 text-slate-800"
                        />
                        <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold whitespace-nowrap">
                            {{ $riwayats->count() }} Data
                        </span>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs" id="riwayatTable">
                        <thead class="bg-slate-50/80 text-[10.5px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4">Tanggal &amp; Usia</th>
                                <th class="py-3 px-4">Anak &amp; Orang Tua</th>
                                <th class="py-3 px-4">Antropometri (BB / TB / LK / LiLA)</th>
                                <th class="py-3 px-4">Status Gizi &amp; Z-Score</th>
                                <th class="py-3 px-4">Pemeriksa &amp; Faskes</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($riwayats as $row)
                                <tr class="hover:bg-sky-50/30 transition">
                                    <!-- Tanggal & Usia -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <div class="font-extrabold text-slate-900">{{ \Carbon\Carbon::parse($row->tanggal_pemeriksaan)->translatedFormat('d M Y') }}</div>
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-bold">
                                            {{ $row->usia_bulan }} Bulan
                                        </span>
                                    </td>

                                    <!-- Anak & Orang Tua -->
                                    <td class="py-3.5 px-4">
                                        <div class="font-extrabold text-slate-900">{{ $row->anak ? $row->anak->nama : 'Aisyah Putri Rahmawati' }}</div>
                                        <div class="text-[11px] text-slate-400">
                                            Wali: {{ ($row->anak && $row->anak->user) ? $row->anak->user->name : 'Sarah Rahmawati' }}
                                        </div>
                                    </td>

                                    <!-- Antropometri -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="px-2 py-0.5 rounded bg-pink-50 text-pink-700 text-[11px] font-bold border border-pink-200/60">
                                                BB: {{ $row->berat_badan }} kg
                                            </span>
                                            <span class="px-2 py-0.5 rounded bg-sky-50 text-sky-700 text-[11px] font-bold border border-sky-200/60">
                                                TB: {{ $row->tinggi_badan }} cm
                                            </span>
                                            @if($row->lingkar_kepala)
                                                <span class="px-2 py-0.5 rounded bg-purple-50 text-purple-700 text-[11px] font-bold border border-purple-200/60">
                                                    LK: {{ $row->lingkar_kepala }} cm
                                                </span>
                                            @endif
                                            @if($row->lingkar_lengan_atas)
                                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px] font-bold border border-slate-200">
                                                    LiLA: {{ $row->lingkar_lengan_atas }} cm
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Status Gizi -->
                                    <td class="py-3.5 px-4">
                                        @if($row->status_type === 'normal')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10.5px] font-bold border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                {{ $row->status_pertumbuhan }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 text-[10.5px] font-bold border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                {{ $row->status_pertumbuhan }}
                                            </span>
                                        @endif
                                        <div class="text-[10px] text-slate-400 mt-1">
                                            {{ $row->z_score_bb_u }} &bull; {{ $row->z_score_tb_u }}
                                        </div>
                                    </td>

                                    <!-- Pemeriksa & Faskes -->
                                    <td class="py-3.5 px-4">
                                        <div class="font-semibold text-slate-800">{{ $row->nama_nakes }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $row->faskes_pemeriksa }}</div>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <form action="{{ route('admin.pengukuran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pengukuran ini dari rekam medis?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                        Belum ada riwayat hasil pengukuran. Silakan gunakan formulir di atas untuk menginput data pertama.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- JAVASCRIPT: LOGIKA FILTER WALI & KALKULATOR ANTROPOMETRI -->
    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            if (!sidebar || !backdrop) return;

            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        // Filter Dropdown Anak berdasarkan Wali
        function filterAnakByWali() {
            const waliId = document.getElementById('waliSelect').value;
            const anakSelect = document.getElementById('anak_id');
            const options = anakSelect.querySelectorAll('option');

            let firstVisible = null;
            options.forEach(opt => {
                if (opt.value === "") return;
                const userOwner = opt.getAttribute('data-user-id');
                if (waliId === 'all' || userOwner === waliId) {
                    opt.style.display = '';
                    if (!firstVisible) firstVisible = opt;
                } else {
                    opt.style.display = 'none';
                }
            });

            if (firstVisible) {
                anakSelect.value = firstVisible.value;
                updateChildMetadata();
            }
        }

        // Perbarui Metadata Kartu Anak Terpilih
        function updateChildMetadata() {
            const anakSelect = document.getElementById('anak_id');
            const selectedOpt = anakSelect.options[anakSelect.selectedIndex];
            if (!selectedOpt) return;

            const name = selectedOpt.text.split('•')[0].replace('👶', '').trim();
            const nik = selectedOpt.getAttribute('data-nik') || '-';
            const gender = selectedOpt.getAttribute('data-gender') || 'Perempuan';
            const lahir = selectedOpt.getAttribute('data-lahir') || '2022-02-14';

            document.getElementById('mChildName').innerText = name;
            document.getElementById('mChildNik').innerText = nik;
            document.getElementById('mChildGender').innerText = gender;
            document.getElementById('mChildBirth').innerText = lahir;

            recalculateAge();
        }

        // Hitung Usia dalam Bulan secara Real-time berdasarkan Tanggal Pengukuran
        function recalculateAge() {
            const anakSelect = document.getElementById('anak_id');
            const selectedOpt = anakSelect.options[anakSelect.selectedIndex];
            if (!selectedOpt) return;

            const birthStr = selectedOpt.getAttribute('data-lahir') || '2022-02-14';
            const examStr = document.getElementById('tanggal_pemeriksaan').value || new Date().toISOString().split('T')[0];

            const birthDate = new Date(birthStr);
            const examDate = new Date(examStr);

            let months = (examDate.getFullYear() - birthDate.getFullYear()) * 12 + (examDate.getMonth() - birthDate.getMonth());
            if (examDate.getDate() < birthDate.getDate()) {
                months--;
            }
            months = Math.max(0, months);

            const years = Math.floor(months / 12);
            const remMonths = months % 12;

            document.getElementById('mCalculatedAge').innerText = months + ' Bulan (' + years + ' Tahun ' + remMonths + ' Bulan)';
        }

        // Live Search Tabel
        function searchTable() {
            const input = document.getElementById('tableSearch');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('riwayatTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const tdText = tr[i].innerText.toLowerCase();
                if (tdText.indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            updateChildMetadata();
        });
    </script>
</body>
</html>
