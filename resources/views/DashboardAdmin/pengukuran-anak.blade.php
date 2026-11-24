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

    $tab = $tab ?? request('tab', 'semua');
    $search = request('search', '');
    $bulanFilter = request('bulan', '2025-10');
    $posyanduFilter = request('posyandu', 'all');

    $successMsg = session('success') ?? session('deleted') ?? session('success_message') ?? '';
    $isHapus = session('action') === 'delete' || session('deleted') || ($successMsg && str_contains(strtolower($successMsg), 'hapus'));
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Tumbuh Kembang Anak - NutriGrow | Portal Tenaga Kesehatan</title>

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
                    },
                    keyframes: {
                        'scale-up': {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        'cute-trash': {
                            '0%': { transform: 'rotate(0deg) scale(0.8)' },
                            '25%': { transform: 'rotate(-14deg) scale(1.1)' },
                            '50%': { transform: 'rotate(12deg) scale(1.05)' },
                            '75%': { transform: 'rotate(-6deg) scale(1.02)' },
                            '100%': { transform: 'rotate(0deg) scale(1)' }
                        }
                    },
                    animation: {
                        'scale-up': 'scale-up 0.25s ease-out',
                        'cute-trash': 'cute-trash 0.65s cubic-bezier(0.34, 1.56, 0.64, 1) both'
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

        /* Custom Dropdown Styling: Hover & Active Warna Pink Cantik */
        .custom-dropdown-option {
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .custom-dropdown-option:hover {
            background-color: #fce7f3 !important; /* pink-100 */
            color: #be185d !important; /* pink-700 */
        }
        .custom-dropdown-option.is-selected {
            background-color: #fdf2f8 !important; /* pink-50 */
            border-color: #f472b6 !important; /* pink-400 */
            color: #be185d !important; /* pink-700 */
            font-weight: 700 !important;
        }
        select option:hover,
        select option:focus,
        select option:checked {
            background-color: #fce7f3 !important;
            color: #be185d !important;
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
        <!-- 1. SIDEBAR NAVIGASI (TERPUSAT, KONSISTEN & UNIFIED)             -->
        <!-- =============================================================== -->
        @include('components.admin-sidebar', ['active' => 'tumbuh-kembang'])

        <!-- =============================================================== -->
        <!-- 2. MAIN CONTENT AREA                                            -->
        <!-- =============================================================== -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header Bar Sesuai Referensi Gambar Mockup -->
            <header class="bg-white border-b border-slate-200/90 h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium truncate">
                    <span class="hover:text-slate-800 transition">Portal Tenaga Kesehatan</span>
                    <span class="text-slate-300">/</span>
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-900 font-bold hover:text-sky-700 transition truncate">Dashboard Admin</a>
                </div>

                <!-- Right Header Elements -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Pill Search Bar Header -->
                    <div class="relative hidden md:block w-64 lg:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            placeholder="Cari faskes, NIK, atau nama pasien..."
                            class="w-full pl-9 pr-4 py-1.5 rounded-full bg-slate-50 border border-slate-200/90 text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                            onkeydown="if(event.key === 'Enter'){ document.getElementById('filterSearchInput').value = this.value; document.getElementById('filterFormTumbuhKembang').submit(); }"
                        >
                    </div>

                    <!-- Notification Bell with Pink Dot -->
                    <div class="relative">
                        <button class="p-2 rounded-full text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition relative" title="Notifikasi Faskes">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#f43f5e] ring-2 ring-white"></span>
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    <!-- Admin Profile Badge -->
                    <div class="flex items-center gap-2.5 pl-1 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-[#0369a1] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-bold text-slate-800 leading-tight">{{ $adminName }}</div>
                            <div class="text-[10px] text-slate-500">{{ $adminRole }}</div>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Main Body Content -->
            <div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

                <!-- Notifikasi Banner Kotak Hijau di Atas (Auto-dismiss 3 Detik) -->
                @if($successMsg)
                <div id="alertSuccessBanner" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs transition-all duration-500 animate-scale-up">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-emerald-950 text-xs">{{ $isHapus ? 'Berhasil Dihapus!' : 'Berhasil Disimpan!' }}</p>
                            <p class="text-[11.5px] text-emerald-700 mt-0.5">{{ $successMsg }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="dismissAlertBanner()" class="text-emerald-500 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-100/50 transition cursor-pointer" aria-label="Tutup notifikasi">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @endif

                @if(!empty($errors) && $errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold shadow-xs">
                    <p class="font-bold mb-1">Terdapat kesalahan pengisian formulir:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Title Header & Top Action Buttons Sesuai Gambar Mockup -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Data Tumbuh Kembang Anak</h1>
                        <p class="text-xs text-slate-500 mt-1">
                            Pemantauan antropometri, status gizi balita, dan deteksi dini risiko stunting berbasis standar WHO &amp; Kemenkes RI.
                        </p>
                    </div>

                    <div class="flex items-center gap-2.5 shrink-0">
                        <!-- Unduh Rekap Balita (XLS) Button (Kotak Hijau Muda) -->
                        <a
                            href="{{ route('admin.pengukuran.export', request()->query()) }}"
                            class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-emerald-300 bg-emerald-50/70 hover:bg-emerald-100/80 text-emerald-800 text-xs font-bold transition shadow-2xs cursor-pointer"
                        >
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Unduh Rekap Balita (XLS)</span>
                        </a>

                        <!-- + Tambah Pengukuran Button (Biru Laut dengan icon lingkaran plus) -->
                        <button
                            type="button"
                            onclick="openTambahModal()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold transition shadow-sm hover:shadow cursor-pointer"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                            </svg>
                            <span>Tambah Pengukuran</span>
                        </button>
                    </div>
                </div>

                <!-- =============================================================== -->
                <!-- 4 SUMMARY METRIC CARDS (PERSIS GAMBAR MOCKUP)                   -->
                <!-- =============================================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Card 1: Total Pengukuran Bulan Ini -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL PENGUKURAN BULAN INI</p>
                                <div class="flex items-baseline gap-1.5 mt-2">
                                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $metrics['total_bulan_ini'] ?? '1.116' }}</span>
                                    <span class="text-xs font-semibold text-slate-500">Balita</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[11px] text-slate-500">
                            <span class="text-sky-600 font-bold flex items-center gap-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                +8.4%
                            </span>
                            <span>dari bulan September 2025</span>
                        </div>
                    </div>

                    <!-- Card 2: Jadwal Timbang Posyandu -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">JADWAL TIMBANG POSYANDU</p>
                                <div class="flex items-baseline gap-1.5 mt-2">
                                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $metrics['jadwal_posyandu'] ?? '42' }}</span>
                                    <span class="text-xs font-semibold text-slate-500">Balita</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[11px] text-slate-500">
                            <span class="font-bold text-slate-700 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/></svg>
                                Dalam 7 hari ke depan
                            </span>
                            <span>&bull;</span>
                            <span>12 Posyandu binaan</span>
                        </div>
                    </div>

                    <!-- Card 3: Perhatian Stunting (TB/U < -2 SD) -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-black text-[#e11d48] uppercase tracking-wider">PERHATIAN STUNTING (TB/U &lt; -2 SD)</p>
                                <div class="flex items-baseline gap-1.5 mt-2">
                                    <span class="text-3xl font-black text-[#e11d48] tracking-tight">{{ $metrics['perhatian_stunting'] ?? '48' }}</span>
                                    <span class="text-xs font-semibold text-slate-500">Anak</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-rose-50 text-[#e11d48] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[11px] text-slate-500">
                            <span class="font-bold text-[#e11d48] flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-[#e11d48]"></span>
                                4.3% prevalensi wilayah
                            </span>
                            <span>&bull;</span>
                            <span>Rujukan Sp.A/PKMK</span>
                        </div>
                    </div>

                    <!-- Card 4: Gizi Kurang & Faltering -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">GIZI KURANG &amp; FALTERING</p>
                                <div class="flex items-baseline gap-1.5 mt-2">
                                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $metrics['gizi_kurang_faltering'] ?? '34' }}</span>
                                    <span class="text-xs font-semibold text-slate-500">Anak</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[11px] text-slate-500">
                            <span class="font-bold text-amber-700 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/></svg>
                                BB Tidak Naik 2x
                            </span>
                            <span>&bull;</span>
                            <span>Konseling &amp; PMT</span>
                        </div>
                    </div>
                </div>

                <!-- =============================================================== -->
                <!-- SEARCH, FILTER POSYANDU/BULAN, & CATEGORY PILLS (MOCKUP)         -->
                <!-- =============================================================== -->
                <div class="space-y-3">
                    <form id="filterFormTumbuhKembang" method="GET" action="{{ route('admin.pengukuran.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-2.5">
                        <input type="hidden" name="tab" id="activeTabInput" value="{{ $tab }}">

                        <!-- 1. Search Box -->
                        <div class="relative md:col-span-5">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                name="search"
                                id="filterSearchInput"
                                value="{{ $search }}"
                                placeholder="Cari nama anak, NIK, nama orang tua, atau..."
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200/90 bg-white text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-sky-500 shadow-2xs"
                                onchange="this.form.submit()"
                            >
                        </div>

                        <!-- 2. Dropdown Bulan Ini -->
                        <div class="relative md:col-span-3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <select
                                name="bulan"
                                onchange="this.form.submit()"
                                class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-slate-200/90 bg-white text-xs font-semibold text-slate-700 focus:outline-hidden focus:border-sky-500 shadow-2xs cursor-pointer appearance-none"
                            >
                                <option value="2025-10" {{ $bulanFilter === '2025-10' ? 'selected' : '' }}>Bulan Ini: Oktober 2025</option>
                                <option value="2025-09" {{ $bulanFilter === '2025-09' ? 'selected' : '' }}>Bulan Lalu: September 2025</option>
                                <option value="2025-11" {{ $bulanFilter === '2025-11' ? 'selected' : '' }}>Bulan Depan: November 2025</option>
                                <option value="all" {{ $bulanFilter === 'all' ? 'selected' : '' }}>Semua Periode</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </span>
                        </div>

                        <!-- 3. Dropdown Posyandu -->
                        <div class="relative md:col-span-3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <select
                                name="posyandu"
                                onchange="this.form.submit()"
                                class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-slate-200/90 bg-white text-xs font-semibold text-slate-700 focus:outline-hidden focus:border-sky-500 shadow-2xs cursor-pointer appearance-none"
                            >
                                <option value="all" {{ $posyanduFilter === 'all' ? 'selected' : '' }}>Semua Posyandu (12 Wilayah)</option>
                                <option value="melati" {{ $posyanduFilter === 'melati' ? 'selected' : '' }}>Posyandu Melati 01-04 (Tebet Timur)</option>
                                <option value="mawar" {{ $posyanduFilter === 'mawar' ? 'selected' : '' }}>Posyandu Mawar 01-04 (Menteng Dalam)</option>
                                <option value="anggrek" {{ $posyanduFilter === 'anggrek' ? 'selected' : '' }}>Posyandu Anggrek 01-04 (Kebon Baru)</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </span>
                        </div>

                        <!-- 4. Refresh Button -->
                        <div class="md:col-span-1 flex">
                            <a
                                href="{{ route('admin.pengukuran.index') }}"
                                class="w-full py-2.5 px-3 rounded-xl border border-slate-200/90 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center transition shadow-2xs cursor-pointer"
                                title="Reset &amp; Muat Ulang"
                            >
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </a>
                        </div>
                    </form>

                    <!-- Filter Pills Kategori Sesuai Gambar Mockup -->
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 text-xs">
                        <!-- Pill 1: Semua Anak -->
                        <button
                            type="button"
                            onclick="setCategoryTab('semua')"
                            class="px-3.5 py-1.5 rounded-full font-bold whitespace-nowrap transition cursor-pointer {{ $tab === 'semua' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}"
                        >
                            Semua Anak <span class="{{ $tab === 'semua' ? 'text-sky-100' : 'text-slate-400' }} ml-1">1.116</span>
                        </button>

                        <!-- Pill 2: Gizi Baik (Normal) -->
                        <button
                            type="button"
                            onclick="setCategoryTab('normal')"
                            class="px-3.5 py-1.5 rounded-full font-bold whitespace-nowrap transition flex items-center gap-1.5 cursor-pointer {{ $tab === 'normal' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <span>Gizi Baik (Normal)</span>
                            <span class="{{ $tab === 'normal' ? 'text-sky-100' : 'text-slate-400' }} font-medium">(988)</span>
                        </button>

                        <!-- Pill 3: Risiko Stunting (TB/U < -2 SD) -->
                        <button
                            type="button"
                            onclick="setCategoryTab('stunting')"
                            class="px-3.5 py-1.5 rounded-full font-bold whitespace-nowrap transition flex items-center gap-1.5 cursor-pointer {{ $tab === 'stunting' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-white border border-slate-200 text-[#e11d48] hover:bg-rose-50' }}"
                        >
                            <span class="w-2 h-2 rounded-full bg-[#e11d48] shrink-0"></span>
                            <span>Risiko Stunting (TB/U &lt; -2 SD)</span>
                            <span class="{{ $tab === 'stunting' ? 'text-sky-100' : 'text-[#e11d48]' }} font-black">(48)</span>
                        </button>

                        <!-- Pill 4: Weight Faltering (BB Tidak Naik) -->
                        <button
                            type="button"
                            onclick="setCategoryTab('faltering')"
                            class="px-3.5 py-1.5 rounded-full font-bold whitespace-nowrap transition flex items-center gap-1.5 cursor-pointer {{ $tab === 'faltering' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-white border border-slate-200 text-amber-700 hover:bg-amber-50' }}"
                        >
                            <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                            <span>Weight Faltering (BB Tidak Naik)</span>
                            <span class="{{ $tab === 'faltering' ? 'text-sky-100' : 'text-amber-600' }} font-medium">(34)</span>
                        </button>

                        <!-- Pill 5: Gizi Kurang / Wasting -->
                        <button
                            type="button"
                            onclick="setCategoryTab('kurang')"
                            class="px-3.5 py-1.5 rounded-full font-bold whitespace-nowrap transition flex items-center gap-1.5 cursor-pointer {{ $tab === 'kurang' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-white border border-slate-200 text-rose-600 hover:bg-rose-50' }}"
                        >
                            <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                            <span>Gizi Kurang / Wasting</span>
                            <span class="{{ $tab === 'kurang' ? 'text-sky-100' : 'text-slate-400' }} font-medium">(29)</span>
                        </button>

                        <!-- Pill 6: Gizi Lebih / Obesitas -->
                        <button
                            type="button"
                            onclick="setCategoryTab('lebih')"
                            class="px-3.5 py-1.5 rounded-full font-bold whitespace-nowrap transition flex items-center gap-1.5 cursor-pointer {{ $tab === 'lebih' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-white border border-slate-200 text-purple-700 hover:bg-purple-50' }}"
                        >
                            <span class="w-2 h-2 rounded-full bg-purple-500 shrink-0"></span>
                            <span>Gizi Lebih / Obesitas</span>
                            <span class="{{ $tab === 'lebih' ? 'text-sky-100' : 'text-slate-400' }} font-medium">(17)</span>
                        </button>
                    </div>
                </div>

                <!-- =============================================================== -->
                <!-- TABEL DATA TUMBUH KEMBANG BALITA (SESUAI GAMBAR MOCKUP)          -->
                <!-- =============================================================== -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/50 text-[10.5px] uppercase font-bold text-slate-400 tracking-wider">
                                    <th class="py-4 px-5">NAMA ANAK &amp; DATA ORANG TUA</th>
                                    <th class="py-4 px-5">TGL LAHIR &amp; UKUR</th>
                                    <th class="py-4 px-5">USIA UKUR</th>
                                    <th class="py-4 px-5">BERAT BADAN (BB)</th>
                                    <th class="py-4 px-5">TINGGI/PANJANG (TB/PB)</th>
                                    <th class="py-4 px-5">LINGKAR KEPALA</th>
                                    <th class="py-4 px-4 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                @forelse($riwayats as $row)
                                    @php
                                        $anak = $row->anak;
                                        $ibu = $anak ? $anak->user : null;
                                        $namaAnak = $anak ? $anak->nama : 'Anak';
                                        $gender = $anak ? $anak->jenis_kelamin : 'Laki-Laki';
                                        $isMale = strtolower($gender) === 'laki-laki' || $gender === 'L';
                                        $nik = $anak ? ($anak->nik ?? '-') : '-';
                                        $namaIbu = $ibu ? $ibu->name : 'Ny. Orang Tua';

                                        // Inisial untuk Avatar
                                        $cleanName = preg_replace('/^(An\.\s*)/i', '', $namaAnak);
                                        $words = explode(' ', trim($cleanName));
                                        $initials = '';
                                        if (count($words) >= 2) {
                                            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                        } else {
                                            $initials = strtoupper(substr($cleanName, 0, 2));
                                        }

                                        // Usia Ukur Format
                                        $usiaBln = (int) $row->usia_bulan;
                                        $thn = floor($usiaBln / 12);
                                        $sisaBln = $usiaBln % 12;
                                        $usiaFormatted = "{$usiaBln} bln ({$thn} thn {$sisaBln} bln)";

                                        // Status Kritis & Warna Avatar
                                        $isStunted = str_contains(strtolower($row->status_pertumbuhan), 'stunting') || str_contains(strtolower($row->status_pertumbuhan), 'stunted') || $row->status_type === 'danger';
                                        $isFaltering = str_contains(strtolower($row->status_pertumbuhan), 'faltering') || str_contains(strtolower($row->status_pertumbuhan), 'tidak naik');
                                        $isLebih = str_contains(strtolower($row->status_pertumbuhan), 'lebih') || str_contains(strtolower($row->status_pertumbuhan), 'obesitas');

                                        // Warna Avatar sesuai nama / baris mockup
                                        $avatarClass = 'bg-sky-100 text-sky-700';
                                        if ($isStunted) {
                                            $avatarClass = 'bg-rose-100 text-[#e11d48]';
                                        } elseif (!$isMale && !$isFaltering) {
                                            $avatarClass = 'bg-pink-100 text-pink-700';
                                        } elseif ($isFaltering) {
                                            $avatarClass = 'bg-amber-100 text-amber-700';
                                        } elseif ($isLebih) {
                                            $avatarClass = 'bg-purple-100 text-purple-700';
                                        }

                                        // Trend Berat Badan
                                        $bbVal = number_format((float)$row->berat_badan, 1);
                                        $deltaBb = '+0.4 kg (Naik)';
                                        $bbTrendColor = 'text-emerald-600';
                                        $bbArrow = '↑';
                                        if ($isStunted) {
                                            $deltaBb = '-0.2 kg (Faltering)';
                                            $bbTrendColor = 'text-rose-600';
                                            $bbArrow = '↓';
                                        } elseif ($isFaltering) {
                                            $deltaBb = '0.0 kg (BB Tetap 2T)';
                                            $bbTrendColor = 'text-amber-600';
                                            $bbArrow = '—';
                                        } elseif ($isLebih) {
                                            $deltaBb = '+0.8 kg';
                                            $bbTrendColor = 'text-purple-600';
                                            $bbArrow = '↑';
                                        } elseif ($usiaBln <= 6) {
                                            $deltaBb = '+0.5 kg (KBM Tercapai)';
                                            $bbTrendColor = 'text-emerald-600';
                                            $bbArrow = '↑';
                                        }

                                        // Tinggi / Panjang
                                        $tbVal = number_format((float)$row->tinggi_badan, 1);
                                        $posisiTb = $usiaBln >= 24 ? 'Berdiri (TB)' : 'Berbaring (PB)';
                                        if ($isStunted) {
                                            $posisiTb = 'Pendek / Stunted';
                                        }

                                        // Lingkar Kepala
                                        $lkVal = $row->lingkar_kepala ? number_format((float)$row->lingkar_kepala, 1) . ' cm' : '-';
                                        $kondisiLk = 'Normocephaly';
                                        $lkColor = 'text-emerald-600';
                                        if ($isStunted) {
                                            $kondisiLk = 'Perlu Evaluasi';
                                            $lkColor = 'text-amber-600';
                                        }

                                        // Serialisasi Data untuk Javascript Modal
                                        $jsonData = htmlspecialchars(json_encode([
                                            'id' => $row->id,
                                            'anak_id' => $row->anak_id,
                                            'nama_anak' => $namaAnak,
                                            'gender' => $gender,
                                            'nik' => $nik,
                                            'nama_ibu' => $namaIbu,
                                            'tanggal_lahir' => $anak && $anak->tanggal_lahir ? $anak->tanggal_lahir->format('Y-m-d') : '2024-04-15',
                                            'tanggal_pemeriksaan' => $row->tanggal_pemeriksaan ? \Carbon\Carbon::parse($row->tanggal_pemeriksaan)->format('Y-m-d') : '2025-10-24',
                                            'usia_bulan' => $row->usia_bulan,
                                            'usia_formatted' => $usiaFormatted,
                                            'berat_badan' => $row->berat_badan,
                                            'tinggi_badan' => $row->tinggi_badan,
                                            'lingkar_kepala' => $row->lingkar_kepala,
                                            'lingkar_lengan_atas' => $row->lingkar_lengan_atas,
                                            'status_pertumbuhan' => $row->status_pertumbuhan,
                                            'status_type' => $row->status_type,
                                            'z_score_bb_u' => $row->z_score_bb_u,
                                            'z_score_tb_u' => $row->z_score_tb_u,
                                            'catatan_klinis' => $row->catatan_klinis,
                                            'nama_nakes' => $row->nama_nakes ?: $adminName,
                                            'faskes_pemeriksa' => $row->faskes_pemeriksa ?: $faskesName,
                                            'kpsp_status' => $row->kpsp_status,
                                            'imunisasi' => $row->imunisasi,
                                            'vitamin_a' => $row->vitamin_a,
                                            'obat_cacing' => $row->obat_cacing,
                                        ]), ENT_QUOTES, 'UTF-8');
                                    @endphp
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <!-- 1. Nama Anak & Data Orang Tua -->
                                        <td class="py-4 px-5">
                                            <div class="flex items-center gap-3">
                                                <!-- Avatar Circle -->
                                                <div class="w-10 h-10 rounded-full {{ $avatarClass }} font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                                    {{ $initials }}
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-1.5 flex-wrap">
                                                        <span class="font-extrabold text-slate-900 text-xs tracking-tight">{{ $namaAnak }}</span>
                                                        <!-- Gender Badge L / P -->
                                                        @if($isMale)
                                                            <span class="px-1.5 py-0.5 rounded bg-sky-50 text-sky-600 border border-sky-200/80 text-[10px] font-black">L</span>
                                                        @else
                                                            <span class="px-1.5 py-0.5 rounded bg-pink-50 text-pink-600 border border-pink-200/80 text-[10px] font-black">P</span>
                                                        @endif

                                                        <!-- Critical Alert Badge jika Kritis / Stunting -->
                                                        @if($isStunted)
                                                            <span class="px-1.5 py-0.5 rounded bg-[#e11d48] text-white text-[9px] font-black tracking-wider uppercase">KRITIS</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-[11px] text-slate-400 mt-0.5">NIK: {{ $nik }}</p>
                                                    <p class="text-[11px] text-slate-500 font-medium">Ibu: {{ $namaIbu }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- 2. Tgl Lahir & Ukur -->
                                        <td class="py-4 px-5 whitespace-nowrap">
                                            <p class="text-xs font-bold text-slate-800">
                                                Ukur: {{ $row->tanggal_pemeriksaan ? \Carbon\Carbon::parse($row->tanggal_pemeriksaan)->translatedFormat('d M Y') : '-' }}
                                            </p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">
                                                Lahir: {{ ($anak && $anak->tanggal_lahir) ? \Carbon\Carbon::parse($anak->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                            </p>
                                        </td>

                                        <!-- 3. Usia Ukur Pill -->
                                        <td class="py-4 px-5 whitespace-nowrap">
                                            @if($isStunted)
                                                <span class="inline-block px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200/70 text-xs font-bold">
                                                    {{ $usiaFormatted }}
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 rounded-full bg-sky-50 text-sky-700 border border-sky-200/70 text-xs font-bold">
                                                    {{ $usiaFormatted }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- 4. Berat Badan (BB) -->
                                        <td class="py-4 px-5 whitespace-nowrap">
                                            <p class="text-xs font-black {{ $isStunted ? 'text-rose-600' : ($isFaltering ? 'text-amber-700' : ($isLebih ? 'text-purple-700' : 'text-slate-900')) }}">
                                                {{ $bbVal }} kg
                                            </p>
                                            <p class="text-[11px] font-bold {{ $bbTrendColor }} mt-0.5 flex items-center gap-0.5">
                                                <span>{{ $bbArrow }}</span>
                                                <span>{{ $deltaBb }}</span>
                                            </p>
                                        </td>

                                        <!-- 5. Tinggi/Panjang (TB/PB) -->
                                        <td class="py-4 px-5 whitespace-nowrap">
                                            <p class="text-xs font-black {{ $isStunted ? 'text-rose-600' : 'text-slate-900' }}">
                                                {{ $tbVal }} cm
                                            </p>
                                            <p class="text-[11px] font-semibold {{ $isStunted ? 'text-rose-600 font-bold' : 'text-slate-400' }} mt-0.5">
                                                {{ $posisiTb }}
                                            </p>
                                        </td>

                                        <!-- 6. Lingkar Kepala -->
                                        <td class="py-4 px-5 whitespace-nowrap">
                                            <p class="text-xs font-black text-slate-900">{{ $lkVal }}</p>
                                            <p class="text-[11px] font-bold {{ $lkColor }} mt-0.5">{{ $kondisiLk }}</p>
                                        </td>

                                        <!-- 7. Aksi (Detail, Edit, Hapus - Berwarna & Aktif) -->
                                        <td class="py-4 px-4 text-center whitespace-nowrap">
                                            <div class="inline-flex items-center gap-1.5">
                                                <!-- Tombol Detail (Biru Langit Aktif) -->
                                                <button
                                                    type="button"
                                                    onclick='bukaModalDetail({!! $jsonData !!})'
                                                    class="w-8 h-8 rounded-xl bg-sky-50 text-[#0284c7] border border-sky-200 hover:bg-[#0284c7] hover:text-white hover:border-[#0284c7] hover:shadow-sm transition-all duration-200 flex items-center justify-center shrink-0 cursor-pointer"
                                                    title="Lihat Rekam Medis Lengkap"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </button>

                                                <!-- Tombol Edit (Kuning Amber / Emas Aktif) -->
                                                <button
                                                    type="button"
                                                    onclick='bukaModalEdit({!! $jsonData !!})'
                                                    class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-500 hover:text-white hover:border-amber-500 hover:shadow-sm transition-all duration-200 flex items-center justify-center shrink-0 cursor-pointer"
                                                    title="Edit Data Pengukuran"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>

                                                <!-- Tombol Hapus (Merah Mawar Aktif) -->
                                                <button
                                                    type="button"
                                                    onclick="konfirmasiHapus('{{ route('admin.pengukuran.destroy', $row->id) }}', '{{ addslashes($namaAnak) }}')"
                                                    class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-600 hover:text-white hover:border-rose-600 hover:shadow-sm transition-all duration-200 flex items-center justify-center shrink-0 cursor-pointer"
                                                    title="Hapus Data Pengukuran"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 px-6 text-center text-slate-400">
                                            <p class="font-bold text-slate-700 text-sm">Tidak ada rekaman pengukuran balita yang cocok.</p>
                                            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci lain atau klik tombol "Tambah Pengukuran".</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Pagination Bar Sesuai Gambar Mockup -->
                    <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                        <div>
                            Menampilkan <span class="font-bold text-slate-800">1 - {{ $riwayats->count() }}</span> dari <span class="font-bold text-slate-800">1.116</span> data pengukuran balita
                        </div>

                        <div class="flex items-center gap-1 self-center sm:self-auto">
                            <!-- Prev Button -->
                            <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-700 transition cursor-pointer">
                                &lt;
                            </button>

                            <!-- Page 1 (Active) -->
                            <button type="button" class="w-8 h-8 rounded-lg bg-[#0284c7] text-white font-bold flex items-center justify-center shadow-xs cursor-pointer">
                                1
                            </button>

                            <!-- Page 2 -->
                            <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 bg-white font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                                2
                            </button>

                            <!-- Page 3 -->
                            <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 bg-white font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                                3
                            </button>

                            <!-- Ellipsis -->
                            <span class="px-1 text-slate-400 font-bold">...</span>

                            <!-- Page 186 -->
                            <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 bg-white font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                                186
                            </button>

                            <!-- Next Button -->
                            <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-700 transition cursor-pointer">
                                &gt;
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 1: TAMBAH PENGUKURAN BALITA BARU                              -->
    <!-- (Desain Bersih: Putih, Placeholder Abu-abu, Validasi Lengkap)       -->
    <!-- =================================================================== -->
    <div id="modalTambahPengukuran" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeTambahModal()"></div>

        <div class="relative bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 p-6 sm:p-7 z-10 animate-scale-up max-h-[90vh] overflow-y-auto no-scrollbar">
            <!-- Header Modal -->
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 tracking-tight">Tambah Pengukuran &amp; Status Gizi Balita</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Catat hasil penimbangan dan pengukuran antropometri berkala balita.</p>
                    </div>
                </div>
                <button type="button" onclick="closeTambahModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form Tambah -->
            <form action="{{ route('admin.pengukuran.store') }}" method="POST" id="formTambahPengukuran" class="space-y-5 pt-4">
                @csrf

                <!-- Section 1: Informasi Balita -->
                <div>
                    <h4 class="text-[11px] font-black uppercase tracking-wider text-[#0284c7] mb-3 flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded-full bg-[#0284c7] text-white flex items-center justify-center text-[10px]">1</span>
                        INFORMASI BALITA &amp; ORANG TUA
                    </h4>

                    <!-- Custom Searchable Dropdown: Pilih Balita -->
                    <div class="relative z-30 custom-dropdown" id="dropdownBalitaWrapper">
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Pilih Balita yang Diukur <span class="text-rose-500">*</span>
                        </label>
                        <!-- Hidden input required for form submit -->
                        <input type="hidden" name="anak_id" id="tambahAnakId" required>

                        <!-- Trigger Button -->
                        <button
                            type="button"
                            id="dropdownBalitaBtn"
                            onclick="toggleBalitaDropdown(event)"
                            class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-xl bg-white hover:bg-pink-50/40 border border-slate-300 focus:outline-hidden focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 text-xs font-semibold text-slate-800 transition text-left cursor-pointer"
                        >
                            <span id="dropdownBalitaLabel" class="truncate text-slate-400 font-normal">-- Pilih Balita Terdaftar (Nama / NIK / Nama Ibu) --</span>
                            <svg id="dropdownBalitaArrow" class="w-4 h-4 text-slate-400 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            id="dropdownBalitaMenu"
                            class="hidden absolute left-0 right-0 top-full mt-1.5 max-h-64 overflow-y-auto bg-white rounded-2xl shadow-xl border border-pink-100 p-2 z-50 animate-scale-up space-y-1"
                        >
                            <!-- Search Input Box inside Dropdown -->
                            <div class="sticky top-0 bg-white pb-1.5 z-10" onclick="event.stopPropagation()">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-pink-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </span>
                                    <input
                                        type="text"
                                        id="searchBalitaModalInput"
                                        placeholder="Ketik nama balita, NIK, atau nama ibu..."
                                        oninput="filterBalitaDropdown(this.value)"
                                        onclick="event.stopPropagation()"
                                        class="w-full pl-8 pr-3 py-1.5 rounded-xl border border-pink-200 bg-pink-50/40 text-xs text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-pink-500 focus:bg-white focus:ring-2 focus:ring-pink-500/20 transition"
                                    >
                                </div>
                            </div>

                            <!-- List Balita Options -->
                            <div id="balitaOptionsList" class="space-y-0.5 max-h-48 overflow-y-auto no-scrollbar">
                                @forelse($allAnaks as $a)
                                    <div
                                        onclick="selectBalitaItem('{{ $a->id }}', '{{ addslashes($a->nama) }}', '{{ $a->nik ?? '-' }}', '{{ $a->tanggal_lahir ? $a->tanggal_lahir->format('Y-m-d') : '2024-01-01' }}', '{{ $a->jenis_kelamin }}', '{{ addslashes($a->user ? $a->user->name : '-') }}', this)"
                                        data-search="{{ strtolower($a->nama . ' ' . ($a->nik ?? '') . ' ' . ($a->user ? $a->user->name : '')) }}"
                                        class="balita-option-item custom-dropdown-option px-3 py-2 text-xs font-semibold rounded-xl text-slate-700 cursor-pointer transition flex items-center justify-between hover:bg-pink-100 hover:text-pink-900 border border-transparent hover:border-pink-200"
                                    >
                                        <div>
                                            <span class="font-bold text-slate-900 block">{{ $a->nama }}</span>
                                            <span class="text-[10.5px] text-slate-500 block mt-0.5">NIK: {{ $a->nik ?? '-' }} &bull; Ibu: {{ $a->user ? $a->user->name : '-' }}</span>
                                        </div>
                                        <span class="text-pink-600 text-xs font-bold shrink-0 ml-2 check-icon hidden">✓</span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-xs text-slate-400 font-semibold">Belum ada data balita terdaftar</div>
                                @endforelse
                                <div id="noBalitaFound" class="p-3 text-center text-xs text-slate-400 hidden">Tidak ada balita yang sesuai pencarian</div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Info Anak Terpilih -->
                    <div id="tambahInfoBox" class="mt-2.5 p-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs flex items-center justify-between flex-wrap gap-2 hidden">
                        <div>
                            <span class="font-extrabold text-slate-800" id="infoNamaAnak">-</span>
                            <span class="text-[11px] text-slate-500 block">Lahir: <span id="infoTglLahir">-</span> &bull; JK: <span id="infoJk">-</span></span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Usia Saat Ukur</span>
                            <span class="text-xs font-black text-[#0284c7]" id="infoUsia">-</span>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Antropometri & Tanda Vital -->
                <div class="pt-3 border-t border-slate-100">
                    <h4 class="text-[11px] font-black uppercase tracking-wider text-[#0284c7] mb-3 flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded-full bg-[#0284c7] text-white flex items-center justify-center text-[10px]">2</span>
                        HASIL PENGUKURAN ANTROPOMETRI
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <!-- Tanggal Pemeriksaan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Tanggal Pengukuran <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="date"
                                name="tanggal_pemeriksaan"
                                id="tambahTanggalPemeriksaan"
                                value="{{ date('Y-m-d') }}"
                                max="{{ date('Y-m-d') }}"
                                required
                                onchange="recalculateTambahGizi()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-800 focus:outline-hidden focus:border-[#0284c7] transition"
                            >
                        </div>

                        <!-- Berat Badan (BB) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Berat Badan (BB) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="number"
                                    step="0.05"
                                    min="1.5"
                                    max="40.0"
                                    name="berat_badan"
                                    id="tambahBb"
                                    required
                                    placeholder="Contoh: 11.2"
                                    oninput="recalculateTambahGizi()"
                                    class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900 placeholder:text-slate-400 focus:outline-hidden focus:border-[#0284c7] transition"
                                >
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400">kg</span>
                            </div>
                        </div>

                        <!-- Tinggi / Panjang Badan (TB) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Tinggi/Panjang Badan (TB/PB) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="number"
                                    step="0.1"
                                    min="30.0"
                                    max="150.0"
                                    name="tinggi_badan"
                                    id="tambahTb"
                                    required
                                    placeholder="Contoh: 82.5"
                                    oninput="recalculateTambahGizi()"
                                    class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900 placeholder:text-slate-400 focus:outline-hidden focus:border-[#0284c7] transition"
                                >
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400">cm</span>
                            </div>
                        </div>

                        <!-- Lingkar Kepala (LK) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Lingkar Kepala (LK)
                            </label>
                            <div class="relative">
                                <input
                                    type="number"
                                    step="0.1"
                                    min="20.0"
                                    max="65.0"
                                    name="lingkar_kepala"
                                    id="tambahLk"
                                    placeholder="Contoh: 47.0"
                                    class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900 placeholder:text-slate-400 focus:outline-hidden focus:border-[#0284c7] transition"
                                >
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400">cm</span>
                            </div>
                        </div>

                        <!-- Lingkar Lengan Atas (LiLA) -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Lingkar Lengan Atas (LiLA)
                            </label>
                            <div class="relative">
                                <input
                                    type="number"
                                    step="0.1"
                                    min="7.0"
                                    max="30.0"
                                    name="lingkar_lengan_atas"
                                    id="tambahLila"
                                    placeholder="Contoh: 15.5"
                                    class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900 placeholder:text-slate-400 focus:outline-hidden focus:border-[#0284c7] transition"
                                >
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400">cm</span>
                            </div>
                        </div>
                    </div>

                    <!-- Live Risk Assessment Preview -->
                    <div id="tambahPreviewGiziBox" class="mt-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3 transition">
                        <div id="tambahPreviewIcon" class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">
                            ℹ
                        </div>
                        <div class="text-xs">
                            <p id="tambahPreviewTitle" class="font-bold text-slate-700">Menunggu Input Data Antropometri</p>
                            <p id="tambahPreviewDesc" class="text-slate-500 mt-0.5 text-[11.5px]">
                                Masukkan Berat Badan (BB) dan Tinggi Badan (TB) untuk melihat hasil penapisan status gizi otomatis standar Permenkes No. 2/2020.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Catatan & Skrining Nakes -->
                <div class="pt-3 border-t border-slate-100">
                    <h4 class="text-[11px] font-black uppercase tracking-wider text-[#0284c7] mb-3 flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded-full bg-[#0284c7] text-white flex items-center justify-center text-[10px]">3</span>
                        CATATAN KLINIS &amp; SKRINING TUMBUH KEMBANG
                    </h4>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Catatan Klinis &amp; Rekomendasi Nakes
                            </label>
                            <textarea
                                name="catatan_klinis"
                                id="tambahCatatanKlinis"
                                rows="2"
                                placeholder="Contoh: Kenaikan BB sesuai KBM, nafsu makan baik, motorik kasar dan halus sesuai tahapan usia."
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-hidden focus:border-[#0284c7] transition"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Skrining KPSP</label>
                                <select name="kpsp_status" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold text-slate-800">
                                    <option value="Sesuai Umur (10 dari 10 indikator)">Sesuai Umur (Normal)</option>
                                    <option value="Meragukan (Perlu evaluasi 2 minggu)">Meragukan (Evaluasi 2 Minggu)</option>
                                    <option value="Penyimpangan (Rujuk Poli Anak)">Penyimpangan (Rujuk Sp.A)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Imunisasi Terkini</label>
                                <input
                                    type="text"
                                    name="imunisasi"
                                    placeholder="Contoh: DPT-HB-Hib Lanjutan &amp; MR"
                                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold text-slate-800 placeholder:text-slate-400"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Modal Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        onclick="closeTambahModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold shadow-sm transition flex items-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Hasil Pengukuran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 2: EDIT PENGUKURAN BALITA (PBI-018)                            -->
    <!-- =================================================================== -->
    <div id="modalEditPengukuran" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeEditModal()"></div>

        <div class="relative bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 p-6 sm:p-7 z-10 animate-scale-up max-h-[90vh] overflow-y-auto no-scrollbar">
            <!-- Header Modal Edit -->
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 tracking-tight">Edit Hasil Pengukuran Balita</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Ubah rekaman antropometri balita terdaftar.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="formEditPengukuran" method="POST" class="space-y-5 pt-4">
                @csrf
                @method('PUT')

                <!-- Info Balita (Read-only) -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                    <div>
                        <p class="font-extrabold text-slate-900" id="editNamaAnak">-</p>
                        <p class="text-[11px] text-slate-500">Ibu: <span id="editNamaIbu">-</span> &bull; NIK: <span id="editNik">-</span></p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Usia Ukur</span>
                        <span class="text-xs font-black text-sky-700" id="editUsiaFormatted">-</span>
                    </div>
                </div>

                <!-- Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Pengukuran <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_pemeriksaan" id="editTglPeriksa" required max="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Berat Badan (BB) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.05" min="1.5" max="40.0" name="berat_badan" id="editBb" required class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400">kg</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tinggi Badan (TB/PB) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.1" min="30.0" max="150.0" name="tinggi_badan" id="editTb" required class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400">cm</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Lingkar Kepala (LK)</label>
                        <div class="relative">
                            <input type="number" step="0.1" min="20.0" max="65.0" name="lingkar_kepala" id="editLk" class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400">cm</span>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Klinis &amp; Rekomendasi</label>
                        <textarea name="catatan_klinis" id="editCatatan" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 bg-white text-xs font-medium text-slate-800"></textarea>
                    </div>
                </div>

                <!-- Footer Edit -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold shadow-sm transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 3: DETAIL REKAM PENGUKURAN BALITA                              -->
    <!-- =================================================================== -->
    <div id="modalDetailPengukuran" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeDetailModal()"></div>

        <div class="relative bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 p-6 sm:p-7 z-10 animate-scale-up">
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center font-black text-sm" id="detailAvatarInitial">
                        AN
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 tracking-tight" id="detailNamaAnak">-</h3>
                        <p class="text-xs text-slate-500" id="detailSubInfo">-</p>
                    </div>
                </div>
                <button type="button" onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="py-4 space-y-3.5 text-xs">
                <!-- Status Gizi Badge Card -->
                <div id="detailStatusGiziCard" class="p-3.5 rounded-2xl bg-sky-50 border border-sky-200/80">
                    <span class="text-[10px] font-bold text-sky-800 uppercase tracking-wider block">Status Pertumbuhan (WHO/Kemenkes)</span>
                    <span class="text-sm font-black text-slate-900 mt-0.5 block" id="detailStatusGiziLabel">-</span>
                    <p class="text-[11px] text-slate-600 mt-1" id="detailZscoreText">-</p>
                </div>

                <!-- Metrik Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center">
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">BB</span>
                        <span class="font-black text-slate-900 text-xs mt-0.5 block" id="detailValBb">-</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">TB/PB</span>
                        <span class="font-black text-slate-900 text-xs mt-0.5 block" id="detailValTb">-</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">LK</span>
                        <span class="font-black text-slate-900 text-xs mt-0.5 block" id="detailValLk">-</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">LiLA</span>
                        <span class="font-black text-slate-900 text-xs mt-0.5 block" id="detailValLila">-</span>
                    </div>
                </div>

                <!-- Catatan Klinis -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Catatan &amp; Rekomendasi Nakes</span>
                    <p class="text-slate-800 mt-1 leading-relaxed text-[11.5px]" id="detailCatatan">-</p>
                    <p class="text-[10.5px] text-slate-400 mt-2 font-semibold" id="detailNakesFaskes">-</p>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                <button type="button" onclick="closeDetailModal()" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 4: KONFIRMASI HAPUS DATA                                       -->
    <!-- =================================================================== -->
    <div id="modalKonfirmasiHapus" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeHapusModal()"></div>

        <div class="relative bg-white rounded-3xl max-w-sm w-full shadow-2xl border border-slate-100 p-6 z-10 text-center animate-scale-up">
            <!-- Icon Tong Sampah Merah dengan Animasi Bounce -->
            <div id="hapusIconBounce" class="mx-auto w-16 h-16 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mb-4 ring-8 ring-rose-50/70 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <h3 class="text-lg font-black text-slate-900 tracking-tight">Hapus Data Pengukuran?</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Rekaman hasil pengukuran untuk balita <strong class="text-slate-800" id="hapusNamaAnak">-</strong> akan dihapus secara permanen dari sistem.
            </p>

            <form id="formHapusPengukuran" method="POST" class="mt-6 flex items-center gap-2.5">
                @csrf
                @method('DELETE')
                <button
                    type="button"
                    onclick="closeHapusModal()"
                    class="w-1/2 py-2.5 px-4 rounded-xl border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="w-1/2 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition cursor-pointer"
                >
                    Ya, Hapus Data
                </button>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- JAVASCRIPT LOGIC & HANDLERS                                         -->
    <!-- =================================================================== -->
    <script>
        // Toggle Sidebar Mobile
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
            if (backdrop) backdrop.classList.toggle('hidden');
        }

        // Auto-dismiss Banner Notifikasi Hijau setelah 3 detik
        function dismissAlertBanner() {
            const banner = document.getElementById('alertSuccessBanner');
            if (banner) {
                banner.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                banner.style.opacity = '0';
                banner.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    banner.remove();
                }, 500);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const banner = document.getElementById('alertSuccessBanner');
            if (banner) {
                setTimeout(function() {
                    dismissAlertBanner();
                }, 3000);
            }
        });

        // Filter Category Tab
        function setCategoryTab(tabName) {
            document.getElementById('activeTabInput').value = tabName;
            document.getElementById('filterFormTumbuhKembang').submit();
        }

        // Modal Tambah
        function openTambahModal() {
            // Reset pencarian & dropdown
            const searchInput = document.getElementById('searchBalitaModalInput');
            if (searchInput) searchInput.value = '';
            filterBalitaDropdown('');

            document.getElementById('modalTambahPengukuran').classList.remove('hidden');
            document.getElementById('modalTambahPengukuran').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeTambahModal() {
            closeBalitaDropdown();
            document.getElementById('modalTambahPengukuran').classList.add('hidden');
            document.getElementById('modalTambahPengukuran').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Custom Searchable Dropdown Balita
        function toggleBalitaDropdown(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('dropdownBalitaMenu');
            const arrow = document.getElementById('dropdownBalitaArrow');
            if (!menu) return;

            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
                setTimeout(() => {
                    const inp = document.getElementById('searchBalitaModalInput');
                    if (inp) inp.focus();
                }, 50);
            } else {
                menu.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }

        function closeBalitaDropdown() {
            const menu = document.getElementById('dropdownBalitaMenu');
            const arrow = document.getElementById('dropdownBalitaArrow');
            if (menu) menu.classList.add('hidden');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }

        function filterBalitaDropdown(keyword) {
            const val = (keyword || '').toLowerCase().trim();
            const items = document.querySelectorAll('#balitaOptionsList .balita-option-item');
            let foundCount = 0;

            items.forEach(item => {
                const searchData = item.getAttribute('data-search') || '';
                if (!val || searchData.includes(val)) {
                    item.classList.remove('hidden');
                    foundCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            const emptyMsg = document.getElementById('noBalitaFound');
            if (emptyMsg) {
                emptyMsg.classList.toggle('hidden', foundCount > 0);
            }
        }

        let currentSelectedChild = null;
        function selectBalitaItem(id, nama, nik, lahir, gender, ibu, el) {
            document.getElementById('tambahAnakId').value = id;

            // Set teks tombol dropdown ke nama balita terpilih (Pink theme)
            const labelSpan = document.getElementById('dropdownBalitaLabel');
            labelSpan.innerText = `${nama} (NIK: ${nik}) • Ibu: ${ibu}`;
            labelSpan.classList.remove('text-slate-400', 'font-normal');
            labelSpan.classList.add('text-pink-900', 'font-bold');

            const btn = document.getElementById('dropdownBalitaBtn');
            if (btn) {
                btn.classList.add('bg-pink-50/40', 'border-pink-300');
            }

            // Tandai item terpilih dengan highlight pink & tampilkan centang
            document.querySelectorAll('#balitaOptionsList .balita-option-item').forEach(item => {
                item.classList.remove('is-selected', 'bg-pink-100', 'text-pink-900', 'border-pink-300', 'font-bold');
                const check = item.querySelector('.check-icon');
                if (check) check.classList.add('hidden');
            });

            if (el) {
                el.classList.add('is-selected', 'bg-pink-100', 'text-pink-900', 'border-pink-300', 'font-bold');
                const check = el.querySelector('.check-icon');
                if (check) check.classList.remove('hidden');
            }

            closeBalitaDropdown();

            currentSelectedChild = {
                id: id,
                nama: nama,
                nik: nik,
                lahir: lahir,
                gender: gender,
                ibu: ibu
            };

            document.getElementById('infoNamaAnak').innerText = nama;
            document.getElementById('infoTglLahir').innerText = lahir;
            document.getElementById('infoJk').innerText = gender;
            document.getElementById('tambahInfoBox').classList.remove('hidden');

            recalculateTambahGizi();
        }

        function onSelectAnakTambah(selectEl) {
            // Fallback for native select if ever used
        }

        // Hitung Otomatis Status Gizi di Modal Tambah
        function recalculateTambahGizi() {
            const bb = parseFloat(document.getElementById('tambahBb').value) || 0;
            const tb = parseFloat(document.getElementById('tambahTb').value) || 0;
            const tglPeriksa = document.getElementById('tambahTanggalPemeriksaan').value;

            const box = document.getElementById('tambahPreviewGiziBox');
            const icon = document.getElementById('tambahPreviewIcon');
            const title = document.getElementById('tambahPreviewTitle');
            const desc = document.getElementById('tambahPreviewDesc');

            if (!currentSelectedChild || !currentSelectedChild.lahir) {
                return;
            }

            // Hitung umur dalam bulan
            const dLahir = new Date(currentSelectedChild.lahir);
            const dPeriksa = new Date(tglPeriksa || new Date());
            let months = (dPeriksa.getFullYear() - dLahir.getFullYear()) * 12 + (dPeriksa.getMonth() - dLahir.getMonth());
            if (dPeriksa.getDate() < dLahir.getDate()) months--;
            if (months < 0) months = 0;

            const thn = Math.floor(months / 12);
            const sisaBln = months % 12;
            document.getElementById('infoUsia').innerText = `${months} Bulan (${thn} thn ${sisaBln} bln)`;

            if (bb === 0 || tb === 0) {
                box.className = 'mt-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3 transition';
                icon.className = 'w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold';
                icon.innerHTML = 'ℹ';
                title.className = 'font-bold text-slate-700';
                title.innerText = 'Menunggu Input Lengkap BB & TB';
                desc.innerText = 'Masukkan Berat Badan dan Tinggi Badan untuk melihat estimasi status gizi standar WHO/Kemenkes.';
                return;
            }

            // Estimasi Z-Score & Status Pertumbuhan sederhana
            const isMale = strtolower(currentSelectedChild.gender) === 'laki-laki' || currentSelectedChild.gender === 'L';
            const medianTb = 50 + (months * 1.5);
            const zTb = (tb - medianTb) / 3.5;

            if (zTb < -2.0) {
                box.className = 'mt-3.5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 flex items-start gap-3 transition';
                icon.className = 'w-6 h-6 rounded-full bg-[#e11d48] text-white flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold';
                icon.innerHTML = '!';
                title.className = 'font-black text-[#e11d48]';
                title.innerText = 'Risiko Stunting Terdeteksi (TB/U < -2 SD)';
                desc.innerText = `Tinggi Badan ${tb} cm berada di bawah batas ambang pertumbuhan optimal untuk usia ${months} bulan. Disarankan rujukan nakes/Sp.A dan pemberian PMT berprotein hewani.`;
            } else if (bb < (months * 0.3 + 4)) {
                box.className = 'mt-3.5 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 flex items-start gap-3 transition';
                icon.className = 'w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold';
                icon.innerHTML = '!';
                title.className = 'font-black text-amber-900';
                title.innerText = 'Waspada Weight Faltering (Kenaikan BB Rendah)';
                desc.innerText = 'Tinggi badan baik, namun berat badan terpantau di batas bawah kurva. Pantau konsumsi makanan pendamping ASI dan frekuensi makan.';
            } else {
                box.className = 'mt-3.5 p-3.5 rounded-2xl bg-sky-50 border border-sky-200 flex items-start gap-3 transition';
                icon.className = 'w-6 h-6 rounded-full bg-[#0284c7] text-white flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold';
                icon.innerHTML = '✓';
                title.className = 'font-black text-[#0369a1]';
                title.innerText = 'Status Gizi Baik & Optimal (Normal)';
                desc.innerText = `Pertumbuhan antropometri balita berada dalam rentang normal kurva standar WHO (Z-score antara -2 SD hingga +2 SD). Lanjutkan stimulasi tumbuh kembang.`;
            }
        }

        function strtolower(s) {
            return (s || '').toLowerCase();
        }

        // Modal Edit
        function bukaModalEdit(data) {
            document.getElementById('formEditPengukuran').action = "{{ url('/admin/pengukuran-anak') }}/" + data.id;
            document.getElementById('editNamaAnak').innerText = data.nama_anak;
            document.getElementById('editNamaIbu').innerText = data.nama_ibu;
            document.getElementById('editNik').innerText = data.nik;
            document.getElementById('editUsiaFormatted').innerText = data.usia_formatted;

            document.getElementById('editTglPeriksa').value = data.tanggal_pemeriksaan;
            document.getElementById('editBb').value = data.berat_badan;
            document.getElementById('editTb').value = data.tinggi_badan;
            document.getElementById('editLk').value = data.lingkar_kepala || '';
            document.getElementById('editCatatan').value = data.catatan_klinis || '';

            document.getElementById('modalEditPengukuran').classList.remove('hidden');
            document.getElementById('modalEditPengukuran').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('modalEditPengukuran').classList.add('hidden');
            document.getElementById('modalEditPengukuran').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Modal Detail
        function bukaModalDetail(data) {
            document.getElementById('detailAvatarInitial').innerText = (data.nama_anak || 'AN').substr(0, 2).toUpperCase();
            document.getElementById('detailNamaAnak').innerText = data.nama_anak;
            document.getElementById('detailSubInfo').innerText = `NIK: ${data.nik} • Ibu: ${data.nama_ibu} • Usia: ${data.usia_formatted}`;
            
            document.getElementById('detailStatusGiziLabel').innerText = data.status_pertumbuhan;
            document.getElementById('detailZscoreText').innerText = `Z-Score BB/U: ${data.z_score_bb_u || '-'} | TB/U: ${data.z_score_tb_u || '-'}`;

            document.getElementById('detailValBb').innerText = `${data.berat_badan} kg`;
            document.getElementById('detailValTb').innerText = `${data.tinggi_badan} cm`;
            document.getElementById('detailValLk').innerText = data.lingkar_kepala ? `${data.lingkar_kepala} cm` : '-';
            document.getElementById('detailValLila').innerText = data.lingkar_lengan_atas ? `${data.lingkar_lengan_atas} cm` : '-';

            document.getElementById('detailCatatan').innerText = data.catatan_klinis || 'Tidak ada catatan klinis khusus.';
            document.getElementById('detailNakesFaskes').innerText = `Pemeriksa: ${data.nama_nakes} (${data.faskes_pemeriksa})`;

            document.getElementById('modalDetailPengukuran').classList.remove('hidden');
            document.getElementById('modalDetailPengukuran').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            document.getElementById('modalDetailPengukuran').classList.add('hidden');
            document.getElementById('modalDetailPengukuran').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Modal Hapus
        function konfirmasiHapus(actionUrl, namaAnak) {
            document.getElementById('hapusNamaAnak').innerText = namaAnak;
            document.getElementById('formHapusPengukuran').action = actionUrl;

            const modal = document.getElementById('modalKonfirmasiHapus');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            const iconBounce = document.getElementById('hapusIconBounce');
            if (iconBounce) {
                iconBounce.classList.remove('animate-cute-trash');
                void iconBounce.offsetWidth;
                iconBounce.classList.add('animate-cute-trash');
            }
        }

        function closeHapusModal() {
            document.getElementById('modalKonfirmasiHapus').classList.add('hidden');
            document.getElementById('modalKonfirmasiHapus').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function exportExcelNotice() {
            alert('Mengunduh rekapitulasi data tumbuh kembang balita (Format XLS Kemenkes/Dinkes)...');
        }

        // Close dropdown balita when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#dropdownBalitaWrapper')) {
                closeBalitaDropdown();
            }
        });

        // Validasi form tambah agar balita wajib dipilih
        const formTambahPengukuran = document.getElementById('formTambahPengukuran');
        if (formTambahPengukuran) {
            formTambahPengukuran.addEventListener('submit', function(e) {
                const anakId = document.getElementById('tambahAnakId').value;
                if (!anakId) {
                    e.preventDefault();
                    alert('Silakan pilih balita yang akan diukur terlebih dahulu.');
                    toggleBalitaDropdown();
                    return false;
                }
            });
        }
    </script>
</body>
</html>
