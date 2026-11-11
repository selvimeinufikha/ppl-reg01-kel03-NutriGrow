<!DOCTYPE html>
@php
    $userName       = $user->name ?? 'Keluarga Pratama';
    $userEmail      = $user->email ?? 'pratama@nutrigrow.id';
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
    $faskesInfo     = $faskesInfo ?? 'Posyandu Mawar 1 & Puskesmas Sejahtera';
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Anak & Umur - NutriGrow</title>

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
                            50:  '#fff1f2',
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
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- ========================================== -->
    <!-- LEFT SIDEBAR: NAVIGASI UTAMA               -->
    <!-- ========================================== -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">

        <div class="p-5 overflow-y-auto no-scrollbar flex-1 bg-transparent">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between mb-7 pl-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain transition group-hover:scale-102">
                </a>
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-white/80">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- UTAMA -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">UTAMA</span>
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- DATA KELUARGA & PROFIL -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">DATA KELUARGA &amp; PROFIL</span>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard.pengguna') }}#data-pasangan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Data Pasangan</span>
                    </a>
                    <a href="{{ route('dashboard.pengguna') }}#data-kehamilan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Kehamilan</span>
                    </a>
                    <!-- Active: Data Anak -->
                    <a href="{{ route('data-anak.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-brand-800 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Anak</span>
                    </a>
                </nav>
            </div>

            <!-- REKAM MEDIS -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">REKAM MEDIS</span>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard.pengguna') }}#pemeriksaan-kehamilan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Pemeriksaan Kehamilan</span>
                    </a>
                    <a href="{{ route('dashboard.pengguna') }}#tumbuh-kembang" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>Tumbuh Kembang Anak</span>
                    </a>
                </nav>
            </div>

            <!-- NUTRISI & PANTAUAN -->
            <div class="mb-4">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">NUTRISI &amp; PANTAUAN</span>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard.pengguna') }}#rekomendasi-nutrisi" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Rekomendasi Nutrisi</span>
                    </a>
                    <a href="{{ route('dashboard.pengguna') }}#risiko-stunting" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Risiko Stunting</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Sidebar Bottom -->
        <div class="p-4 border-t border-sky-100/60 bg-transparent space-y-2">
            <div class="px-3 py-2 rounded-xl bg-white/90 border border-sky-200/70 flex items-center justify-between text-[11px] shadow-2xs">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <div class="text-left">
                        <div class="font-bold text-slate-800 leading-tight">Sinkron Faskes</div>
                        <div class="text-[9px] text-slate-400 font-medium leading-tight">Posyandu Mawar 1</div>
                    </div>
                </div>
                <div class="w-6 h-3 bg-blue-600 rounded-full relative cursor-pointer">
                    <div class="w-2.5 h-2.5 bg-white rounded-full absolute right-0.5 top-0.25 shadow"></div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-white/80 transition cursor-pointer">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 hidden lg:hidden"></div>

    <!-- ========================================== -->
    <!-- MAIN CONTENT AREA                          -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- TOP HEADER BAR -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <div class="flex items-center gap-2.5 sm:gap-3 flex-wrap">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 border border-slate-200/90 text-slate-700 text-[11px] sm:text-xs font-medium">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $tanggalHariIni }}</span>
                </div>
                <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200/90 text-sky-700 text-[11px] sm:text-xs font-bold">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Faskes: {{ $faskesInfo }}</span>
                </div>
                <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50/90 border border-pink-200/90 text-brand-800 text-[11px] sm:text-xs font-bold">
                    <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>{{ $namaKeluarga }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <button type="button" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200/80 text-slate-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-600 text-white text-[10px] font-extrabold flex items-center justify-center ring-2 ring-white">3</span>
                </div>
                <div class="w-9 h-9 rounded-full bg-brand-800 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE PAGE CONTAINER -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- Flash Alert -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold">Tutup</button>
                </div>
            @endif

            <!-- BREADCRUMB -->
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-brand-600 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <span>&gt;</span>
                <a href="{{ route('data-anak.index') }}" class="hover:text-brand-600 text-slate-500">Data Anak</a>
                <span>&gt;</span>
                <span class="text-brand-700 font-semibold">Daftar Anak &amp; Umur</span>
            </div>

            <!-- PAGE TITLE BAR -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-pink-100/90 text-brand-700 flex items-center justify-center flex-shrink-0 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Anak &amp; Umur</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Daftar seluruh anak dalam keluarga beserta perhitungan umur otomatis.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('data-anak.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 transition shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Data Anak
                    </a>
                    <a href="{{ route('data-anak.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-900/20 transition transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Anak</span>
                    </a>
                </div>
            </div>

            <!-- STATISTIK RINGKASAN -->
            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-2xl bg-white border border-purple-100 p-4 text-center shadow-xs">
                    <div class="text-3xl font-extrabold text-slate-900">{{ $totalAnak }}</div>
                    <div class="text-xs font-semibold text-slate-500 mt-1">Total Anak</div>
                </div>
                <div class="rounded-2xl bg-sky-50/80 border border-sky-100 p-4 text-center shadow-xs">
                    <div class="text-3xl font-extrabold text-sky-700">{{ $totalLaki }}</div>
                    <div class="text-xs font-semibold text-sky-600 mt-1">Laki-laki</div>
                </div>
                <div class="rounded-2xl bg-pink-50/90 border border-pink-100 p-4 text-center shadow-xs">
                    <div class="text-3xl font-extrabold text-brand-700">{{ $totalPerempuan }}</div>
                    <div class="text-xs font-semibold text-brand-600 mt-1">Perempuan</div>
                </div>
            </div>

            <!-- FILTER & SEARCH -->
            <form action="{{ route('daftar-anak.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="q" value="{{ $filterQ }}" placeholder="Cari nama anak..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-full bg-white border border-slate-200/90 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 shadow-2xs transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <!-- Gender Filter -->
                <div class="relative">
                    <select name="jenis_kelamin" onchange="this.form.submit()"
                            class="appearance-none pl-9 pr-9 py-2.5 rounded-full bg-white border border-slate-200/90 text-xs sm:text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 shadow-2xs cursor-pointer">
                        <option value="" {{ $filterGender == '' ? 'selected' : '' }}>Semua Jenis Kelamin</option>
                        <option value="Laki-laki" {{ $filterGender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $filterGender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute right-3.5 top-4 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <!-- Tombol Cari -->
                <button type="submit" class="px-5 py-2.5 rounded-full bg-brand-800 text-white font-bold text-xs hover:bg-brand-900 transition shadow-sm">
                    Cari
                </button>
                @if($filterQ || $filterGender)
                    <a href="{{ route('daftar-anak.index') }}" class="px-3 py-2 text-xs font-semibold text-slate-500 hover:text-rose-600 transition">
                        Reset
                    </a>
                @endif
                <div class="ml-auto text-xs font-semibold text-slate-500 whitespace-nowrap">
                    Menampilkan <span class="text-slate-800 font-bold">{{ $anaks->count() }}</span> dari <span class="text-slate-800 font-bold">{{ $totalAnak }}</span> anak
                </div>
            </form>

            <!-- TABEL DAFTAR ANAK & UMUR -->
            @if($anaks->count() > 0)
                <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/80">
                                    <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider w-10">#</th>
                                    <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Anak</th>
                                    <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Jenis Kelamin</th>
                                    <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Lahir</th>
                                    <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Umur</th>
                                    <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kategori Usia</th>
                                    <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kehamilan Terkait</th>
                                    <th class="text-center px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($anaks as $index => $anak)
                                    @php $isBoy = $anak->jenis_kelamin === 'Laki-laki'; @endphp
                                    <tr class="hover:bg-slate-50/60 transition-colors group">
                                        <!-- No. Urut -->
                                        <td class="px-5 py-4 text-xs text-slate-400 font-semibold">
                                            {{ $index + 1 }}
                                        </td>

                                        <!-- Nama + Avatar -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full {{ $isBoy ? 'bg-sky-100 text-sky-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-slate-900 text-sm">{{ $anak->nama }}</div>
                                                    @if($anak->anak_ke)
                                                        <div class="text-[10px] text-slate-400 font-medium">Anak ke-{{ $anak->anak_ke }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Jenis Kelamin -->
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full {{ $isBoy ? 'bg-sky-50 text-sky-600' : 'bg-pink-50 text-brand-700' }} text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $isBoy ? 'bg-sky-500' : 'bg-brand-500' }}"></span>
                                                {{ $anak->jenis_kelamin }}
                                            </span>
                                        </td>

                                        <!-- Tanggal Lahir -->
                                        <td class="px-5 py-4">
                                            <div class="text-xs font-bold text-slate-800">{{ $anak->tanggal_lahir_formatted }}</div>
                                        </td>

                                        <!-- Umur (dihitung otomatis dari tanggal lahir) -->
                                        <td class="px-5 py-4">
                                            <div class="inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-xs font-extrabold text-brand-700">{{ $anak->usia_formatted }}</span>
                                            </div>
                                            <div class="text-[10px] text-slate-400 mt-0.5">{{ $anak->usia_bulan }} bulan</div>
                                        </td>

                                        <!-- Kategori Usia -->
                                        <td class="px-5 py-4">
                                            @php
                                                $bulan = $anak->usia_bulan;
                                                $kategoriColor = match(true) {
                                                    $bulan < 1   => 'bg-red-50 text-red-600 border-red-100',
                                                    $bulan < 12  => 'bg-orange-50 text-orange-600 border-orange-100',
                                                    $bulan < 36  => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                                    $bulan < 72  => 'bg-green-50 text-green-700 border-green-100',
                                                    $bulan < 144 => 'bg-blue-50 text-blue-700 border-blue-100',
                                                    default      => 'bg-purple-50 text-purple-700 border-purple-100',
                                                };
                                            @endphp
                                            <span class="inline-flex px-2 py-0.5 rounded-lg border text-[10px] font-bold {{ $kategoriColor }}">
                                                {{ $anak->kategori_usia }}
                                            </span>
                                        </td>

                                        <!-- Kehamilan Terkait -->
                                        <td class="px-5 py-4">
                                            <span class="text-xs {{ $anak->kehamilan ? 'text-slate-800 font-semibold' : 'text-slate-400' }}">
                                                {{ $anak->kehamilan_terkait_label }}
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('data-anak.edit', $anak->id) }}"
                                                   class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition" title="Edit">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('data-anak.destroy', $anak->id) }}" method="POST"
                                                      onsubmit="return confirm('Hapus data {{ $anak->nama }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" title="Hapus">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer Info -->
                    <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/60 flex items-center justify-between">
                        <span class="text-xs text-slate-500">
                            Total <span class="font-bold text-slate-800">{{ $anaks->count() }}</span> anak ditampilkan
                        </span>
                        <span class="text-[10px] text-slate-400">
                            Umur dihitung otomatis dari tanggal lahir · Diperbarui setiap hari
                        </span>
                    </div>
                </div>

                <!-- LEGENDA KATEGORI USIA -->
                <div class="rounded-3xl bg-white border border-slate-100 p-5 shadow-xs">
                    <h3 class="text-sm font-bold text-slate-800 mb-3">Keterangan Kategori Usia</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex px-3 py-1 rounded-lg border text-[11px] font-semibold bg-red-50 text-red-600 border-red-100">Neonatus (0-28 hari)</span>
                        <span class="inline-flex px-3 py-1 rounded-lg border text-[11px] font-semibold bg-orange-50 text-orange-600 border-orange-100">Bayi (&lt; 1 tahun)</span>
                        <span class="inline-flex px-3 py-1 rounded-lg border text-[11px] font-semibold bg-yellow-50 text-yellow-700 border-yellow-100">Batita (1-3 tahun)</span>
                        <span class="inline-flex px-3 py-1 rounded-lg border text-[11px] font-semibold bg-green-50 text-green-700 border-green-100">Balita (3-6 tahun)</span>
                        <span class="inline-flex px-3 py-1 rounded-lg border text-[11px] font-semibold bg-blue-50 text-blue-700 border-blue-100">Anak (6-12 tahun)</span>
                        <span class="inline-flex px-3 py-1 rounded-lg border text-[11px] font-semibold bg-purple-50 text-purple-700 border-purple-100">Remaja (&gt; 12 tahun)</span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2">Referensi: WHO / Kemenkes RI</p>
                </div>

            @else
                <!-- Empty State -->
                <div class="rounded-3xl bg-white border border-dashed border-slate-300 p-10 text-center">
                    <div class="w-16 h-16 rounded-full bg-pink-50 text-brand-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Anak</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mt-1 mb-6">
                        @if($filterQ || $filterGender)
                            Tidak ada anak yang cocok dengan filter. Coba kata kunci lain.
                        @else
                            Tambahkan data anak pertama untuk mulai memantau tumbuh kembangnya.
                        @endif
                    </p>
                    <a href="{{ route('data-anak.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-brand-800 hover:bg-brand-900 text-white font-bold text-sm shadow-md transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Anak Pertama
                    </a>
                </div>
            @endif

        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html>
