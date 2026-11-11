<!DOCTYPE html>
@php
    $userName = $userName ?? (Auth::check() ? Auth::user()->name : 'Ibu Sarah Rahmawati');
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
    <title>Dashboard Keluarga - NutriGrow | Pemantauan Kesehatan Ibu &amp; Anak</title>

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
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- ========================================== -->
    <!-- LEFT SIDEBAR: NAVIGASI UTAMA (GRADASI PINK KE BIRU) -->
    <!-- ========================================== -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
        
        <!-- Sidebar Top: Brand & Menu -->
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

            <!-- Group: UTAMA -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                    UTAMA
                </span>
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Group: DATA KELUARGA & PROFIL -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                    DATA KELUARGA &amp; PROFIL
                </span>
                <nav class="space-y-1">
                    <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Profil Pengguna</span>
                    </a>
                    <a href="{{ route('kehamilan.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Kehamilan</span>
                    </a>
                    <a href="#data-pasangan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Data Pasangan</span>
                    </a>
                    <a href="#data-anak" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Anak</span>
                    </a>
                </nav>
            </div>

            <!-- Group: REKAM MEDIS -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                    REKAM MEDIS
                </span>
                <nav class="space-y-1">
                    <a href="#pemeriksaan-kehamilan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Pemeriksaan Kehamilan</span>
                    </a>
                    <a href="#tumbuh-kembang" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>Tumbuh Kembang Anak</span>
                    </a>
                    <a href="#reminder-pemeriksaan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Reminder Pemeriksaan</span>
                    </a>
                    <a href="#layanan-kesehatan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Layanan Kesehatan</span>
                    </a>
                </nav>
            </div>

            <!-- Group: NUTRISI & PANTAUAN -->
            <div class="mb-4">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                    NUTRISI &amp; PANTAUAN
                </span>
                <nav class="space-y-1">
                    <a href="#rekomendasi-nutrisi" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Rekomendasi Nutrisi</span>
                    </a>
                    <a href="#risiko-stunting" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Risiko Stunting</span>
                    </a>
                    <a href="#edukasi-gizi" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Edukasi Gizi</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Sidebar Bottom: Sync Status & Logout -->
        <div class="p-4 border-t border-sky-100/60 bg-transparent space-y-2">
            <!-- Sync Pill: Posyandu Melati II -->
            <div class="px-3 py-2 rounded-xl bg-white/90 backdrop-blur-xs border border-sky-200/70 flex items-center justify-between text-[11px] shadow-2xs">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <div class="text-left">
                        <div class="font-bold text-slate-800 leading-tight">Posyandu Melati II</div>
                        <div class="text-[9px] text-slate-400 font-medium leading-tight">Tersinkronisasi</div>
                    </div>
                </div>
                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>

            <!-- Logout Button -->
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

    <!-- Overlay backdrop for mobile sidebar -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 hidden lg:hidden"></div>

    <!-- ========================================== -->
    <!-- MAIN CONTENT AREA (SCROLLABLE DOWNWARDS)   -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- STICKY TOP HEADER BAR -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Pill 1: Faskes Aktif -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200/90 text-sky-700 text-[11px] sm:text-xs font-bold">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Faskes Aktif &bull;</span>
                </div>

                <!-- Pill 2: Pengguna Keluarga -->
                <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50/80 border border-pink-200/80 text-slate-700 text-[11px] sm:text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                    <span>{{ $userName }} <span class="text-slate-400 font-normal">(Pengguna Keluarga)</span></span>
                </div>
            </div>

            <!-- Right Profile & Notification Controls -->
            <div class="flex items-center gap-3">
                <!-- Notification Bell -->
                <div class="relative">
                    <button type="button" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200/80 text-slate-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-brand-600 text-white text-[10px] font-extrabold flex items-center justify-center ring-2 ring-white">
                        3
                    </span>
                </div>

                <!-- Profile Avatar -->
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-brand-600 to-pink-500 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        {{ strtoupper(substr($userName, 4, 1) ?: 'S') }}
                    </div>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE DASHBOARD VIEW CONTAINER -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- ======================================================== -->
            <!-- SECTION 1: HEADER GREETING & BIG PREGNANCY HERO CARD    -->
            <!-- ======================================================== -->
            <div>
                <!-- Top Meta: Akun Terverifikasi & ID -->
                <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-pink-100/80 border border-pink-200/90 text-brand-700 text-[11px] font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                            Akun Terverifikasi
                        </span>
                        <span class="text-xs font-semibold text-slate-400 font-mono">
                            &bull; ID: {{ $userId }}
                        </span>
                    </div>

                    <!-- Top Action Buttons -->
                    <div class="flex items-center gap-2.5">
                        <button type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-pink-200/90 text-brand-600 hover:bg-pink-50/80 font-bold text-xs shadow-2xs transition cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Faskes Saya</span>
                        </button>
                        <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-brand-600 to-rose-600 hover:from-brand-700 hover:to-rose-700 text-white font-bold text-xs shadow-md shadow-pink-500/20 hover:shadow-lg transition cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Jadwal Baru</span>
                        </button>
                    </div>
                </div>

                <!-- Big Greeting -->
                <h1 class="text-2xl sm:text-3xl lg:text-[32px] font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Halo, {{ $userName }}</span>
                    <span>👋</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                    Pantau kesehatan kehamilan dan tumbuh kembang buah hati secara terpadu hari ini, <strong class="text-slate-700">{{ $tanggalHariIni }}</strong>.
                </p>
            </div>

            <!-- BIG HERO CARD: MINGGU KE-24 & VISUALISASI JANIN -->
            <div class="rounded-[28px] bg-white border border-pink-100 shadow-xl shadow-pink-900/5 p-5 sm:p-7 relative overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    
                    <!-- Left Column: Kehamilan Progress & Info -->
                    <div class="lg:col-span-7 xl:col-span-8 space-y-4">
                        <!-- Badges Row -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-100/80 border border-pink-200/90 text-brand-600 text-xs font-bold">
                                <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                                Trimester 2 (Masa Emas Perkembangan Organ)
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100/90 border border-slate-200/80 text-slate-600 text-xs font-semibold">
                                HPL: 18 Februari 2026 (~112 Hari Lagi)
                            </span>
                        </div>

                        <!-- Big Gestational Age Title -->
                        <div class="pt-1">
                            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                                Minggu ke-24 Hari ke-3
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                                Janin sekarang seukuran <strong class="text-brand-600 font-bold">Jagung Manis (&plusmn;30 cm, 600 gram)</strong>. Pendengaran janin semakin peka terhadap suara Ibu dan detak jantung telah terdengar mantap.
                            </p>
                        </div>

                        <!-- Progress Bar Section -->
                        <div class="pt-2">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="font-bold text-slate-700">Progres Kehamilan</span>
                                <span class="font-extrabold text-brand-600">60% Tercapai (24/40 Minggu)</span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-100">
                                <div class="h-full bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 rounded-full transition-all duration-1000" style="width: 60%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-400 font-medium mt-1.5">
                                <span>Trimester 1 (Mg 1&ndash;13)</span>
                                <span class="font-bold text-brand-600">Trimester 2 (Mg 14&ndash;27)</span>
                                <span>Trimester 3 (Mg 28&ndash;40)</span>
                            </div>
                        </div>

                        <!-- 3 Action Buttons -->
                        <div class="flex flex-wrap items-center gap-2.5 pt-3">
                            <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-rose-600 hover:from-brand-700 hover:to-rose-700 text-white font-bold text-xs shadow-md shadow-pink-500/20 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Catat Keluhan/Gejala</span>
                            </button>
                            <button type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-brand-600 hover:bg-slate-50 font-bold text-xs shadow-2xs transition cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span>Input Hasil USG</span>
                            </button>
                            <button type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-brand-600 hover:bg-slate-50 font-bold text-xs shadow-2xs transition cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span>Konsultasi Bidan</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Visualisasi Janin 3D Card -->
                    <div class="lg:col-span-5 xl:col-span-4">
                        <div class="relative rounded-2xl bg-slate-900 border border-slate-800 shadow-xl overflow-hidden p-3 group">
                            <!-- Header Text -->
                            <div class="flex items-center justify-between text-[11px] text-slate-400 mb-2 px-1">
                                <span class="font-semibold text-slate-300">Perkembangan Janin &bull; Minggu 24</span>
                                <span class="text-[10px] text-emerald-400 font-bold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Terintegrasi
                                </span>
                            </div>

                            <!-- 3D Fetus Image -->
                            <div class="relative w-full h-44 sm:h-48 rounded-xl overflow-hidden bg-black flex items-center justify-center">
                                <img
                                    src="{{ asset('images/fetus-24-weeks.jpg') }}"
                                    alt="Visualisasi Janin Minggu 24"
                                    class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.onerror=null; this.src='{{ asset('images/register-mother-child.jpg') }}';"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-2 left-2 right-2 flex items-center justify-between text-[10px] text-white/90 font-semibold px-1">
                                    <span>Est. Berat: 600g</span>
                                    <span>Panjang: 30 cm</span>
                                    <span class="text-emerald-300 font-bold">&check; Sehat</span>
                                </div>
                            </div>

                            <!-- Bottom Caption Badge -->
                            <div class="mt-2 text-center">
                                <span class="inline-block text-[11px] font-bold text-slate-300">
                                    Visualisasi Janin Minggu ke-24
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 3 METRIC SUMMARY CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Card 1: Kenaikan Berat Badan -->
                <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-2xs hover:shadow-xs transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-8 h-8 rounded-xl bg-pink-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[11px] font-bold border border-sky-200/60">
                                Normal
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 font-medium">Kenaikan Berat Badan</div>
                        <div class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                            +6.5 kg <span class="text-xs text-slate-400 font-normal">/ Target 11.5 &ndash; 16 kg</span>
                        </div>
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium mt-3 pt-2.5 border-t border-slate-100">
                        Laju kenaikan 0.4 kg/minggu sesuai kurva IOM.
                    </div>
                </div>

                <!-- Card 2: Tekanan Darah Terakhir -->
                <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-2xs hover:shadow-xs transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[11px] font-bold border border-sky-200/60">
                                Optimal
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 font-medium">Tekanan Darah Terakhir</div>
                        <div class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                            115 / 75 <span class="text-xs text-slate-400 font-normal">mmHg</span>
                        </div>
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium mt-3 pt-2.5 border-t border-slate-100">
                        Bebas risiko preeklamsia (Evaluasi Posyandu).
                    </div>
                </div>

                <!-- Card 3: Kepatuhan TTD (Tablet Darah) -->
                <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-2xs hover:shadow-xs transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-8 h-8 rounded-xl bg-pink-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-pink-100/80 text-brand-700 text-[11px] font-bold border border-pink-200/60">
                                Bulan Ini
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 font-medium">Kepatuhan TTD (Tablet Darah)</div>
                        <div class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                            21 / 30 <span class="text-xs text-slate-400 font-normal">Hari Tercatat</span>
                        </div>
                    </div>
                    <!-- Progress mini -->
                    <div class="mt-3 pt-2.5 border-t border-slate-100">
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-brand-600 to-rose-500 rounded-full" style="width: 70%"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ======================================================== -->
            <!-- SECTION 2: JADWAL PEMERIKSAAN & FOKUS GIZI TRIMESTER 2  -->
            <!-- ======================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                
                <!-- Left: Jadwal Pemeriksaan Terdekat -->
                <div class="lg:col-span-7 xl:col-span-8 rounded-3xl bg-white border border-slate-200/80 p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-pink-50 text-brand-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="font-extrabold text-sm sm:text-base text-slate-900">
                                    Jadwal Pemeriksaan Terdekat
                                </h3>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 border border-rose-200/70 text-xs font-bold">
                                4 Hari Lagi
                            </span>
                        </div>

                        <!-- Card Detail Pemeriksaan -->
                        <div class="rounded-2xl bg-slate-50/70 border border-slate-200/70 p-4 mb-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                <h4 class="font-extrabold text-sm sm:text-[15px] text-slate-900">
                                    Antenatal Care (ANC Ke-4) &amp; USG Rutin
                                </h4>
                                <span class="self-start sm:self-auto px-2 py-0.5 rounded-md bg-sky-100/80 text-sky-700 text-[10px] font-bold">
                                    Terkonfirmasi
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 font-medium mb-3">
                                dr. Linda Sp.OG &mdash; RSIA Bunda Sehat Jakarta
                            </p>

                            <!-- Date & Time Row -->
                            <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-700 pt-2 border-t border-slate-200/60">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Sabtu, 28 Oktober 2025
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    09:30 &ndash; 10:15 WIB (Sesi Pagi)
                                </span>
                            </div>
                        </div>

                        <!-- Action Button & Nomor Antrean -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                            <button type="button" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-600 to-rose-600 hover:from-brand-700 hover:to-rose-700 text-white font-bold text-xs shadow-md shadow-pink-500/20 transition cursor-pointer">
                                <span>Lihat Detail Jadwal &amp; Rujukan</span>
                            </button>
                            <span class="text-xs font-bold text-slate-600">
                                Nomor Antrean: <span class="text-brand-600 font-extrabold text-sm">B-08</span>
                            </span>
                        </div>
                    </div>

                    <!-- 3 Lab Indicators Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-3 border-t border-slate-100">
                        <div class="px-3 py-2 rounded-xl bg-sky-50/70 border border-sky-100 text-center">
                            <div class="text-[10px] text-slate-400 font-medium">Protein Urin</div>
                            <div class="text-xs font-bold text-sky-800">Negatif (-)</div>
                        </div>
                        <div class="px-3 py-2 rounded-xl bg-sky-50/70 border border-sky-100 text-center">
                            <div class="text-[10px] text-slate-400 font-medium">Glukosa Puasa</div>
                            <div class="text-xs font-bold text-sky-800">88 mg/dL</div>
                        </div>
                        <div class="px-3 py-2 rounded-xl bg-sky-50/70 border border-sky-100 text-center">
                            <div class="text-[10px] text-slate-400 font-medium">Detak Jantung Janin</div>
                            <div class="text-xs font-bold text-sky-800">142 bpm</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Fokus Gizi Trimester 2 -->
                <div class="lg:col-span-5 xl:col-span-4 rounded-3xl bg-white border border-slate-200/80 p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-900">
                                Fokus Gizi Trimester 2
                            </h3>
                            <a href="#edukasi-gizi" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition">
                                Semua Menu
                            </a>
                        </div>

                        <!-- List Gizi -->
                        <div class="space-y-3">
                            <!-- Item 1: Protein Hewani Ganda -->
                            <div class="p-3.5 rounded-2xl bg-rose-50/50 border border-rose-100 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-pink-100 text-brand-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900 leading-tight">
                                        Protein Hewani Ganda
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                        Tambahkan 1 porsi ikan kembung segar &amp; 1 butir telur rebus setiap hari untuk neurogenesis otak janin.
                                    </p>
                                </div>
                            </div>

                            <!-- Item 2: Kalsium 1200 mg / Hari -->
                            <div class="p-3.5 rounded-2xl bg-sky-50/50 border border-sky-100 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900 leading-tight">
                                        Kalsium 1200 mg / Hari
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                        Dua gelas susu pasteurisasi atau yoghurt probiotik demi kepadatan pembentukan tulang belulang janin.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3: Camilan Sehat -->
                    <a href="#camilan" class="mt-3 p-3 rounded-xl bg-slate-50 hover:bg-pink-50/60 border border-slate-200/80 flex items-center justify-between text-xs font-semibold text-slate-700 hover:text-brand-600 transition group">
                        <span class="flex items-center gap-2">
                            <span>🍎</span>
                            <span>Camilan Sehat: Buah Naga &amp; Biji Bunga Matahari</span>
                        </span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

            </div>

            <!-- ======================================================== -->
            <!-- SECTION 3: AKSI CEPAT LAYANAN NUTRIGROW                 -->
            <!-- ======================================================== -->
            <div>
                <div class="mb-3.5">
                    <h3 class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                        Aksi Cepat Layanan NutriGrow
                    </h3>
                    <p class="text-xs text-slate-500">
                        Akses instan fitur operasional kesehatan harian keluarga Anda.
                    </p>
                </div>

                <!-- 4 Action Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Action 1: Tambah Catatan -->
                    <a href="#catatan" class="p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-pink-300 shadow-2xs hover:shadow-md transition group">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-brand-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-brand-600 transition-colors">Tambah Catatan</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Input data klinis &amp; lab</p>
                    </a>

                    <!-- Action 2: Cari Faskes / Posyandu -->
                    <a href="#faskes" class="p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-sky-300 shadow-2xs hover:shadow-md transition group">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-sky-600 transition-colors">Cari Faskes / Posyandu</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Lokasi &amp; rujukan terdekat</p>
                    </a>

                    <!-- Action 3: Tanya Ahli Gizi -->
                    <a href="#tanya-gizi" class="p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-pink-300 shadow-2xs hover:shadow-md transition group">
                        <div class="w-10 h-10 rounded-xl bg-pink-50 text-brand-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-brand-600 transition-colors">Tanya Ahli Gizi</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Konsultasi diet spesifik</p>
                    </a>

                    <!-- Action 4: Edukasi Stunting -->
                    <a href="#edukasi" class="p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-purple-300 shadow-2xs hover:shadow-md transition group">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-purple-600 transition-colors">Edukasi Stunting</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Modul resmi Kemenkes RI</p>
                    </a>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- SECTION 4: NOTIFIKASI KESEHATAN & INTEGRASI SATUSEHAT    -->
            <!-- ======================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 pb-6">
                
                <!-- Left: Notifikasi Kesehatan Terkini -->
                <div class="lg:col-span-7 xl:col-span-8 rounded-3xl bg-white border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-pink-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-900">
                                Notifikasi Kesehatan Terkini
                            </h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-brand-600 text-white font-bold text-[10px]">
                                3 Baru
                            </span>
                            <a href="#semua-notif" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>

                    <!-- Notif 1: Hasil Pemeriksaan ANC Tersedia -->
                    <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-100 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-pink-100 text-brand-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="px-2 py-0.5 rounded-md bg-rose-100/80 text-brand-700 font-bold">Baru</span>
                                <span class="text-slate-400">15 menit lalu</span>
                            </div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Hasil Pemeriksaan ANC Tersedia</h4>
                            <p class="text-[11px] text-slate-600 mt-0.5 leading-relaxed">
                                Dokumen hasil skrining lab antenatal dan rekap USG ke-4 telah disahkan oleh dr. Linda Sp.OG dari RSIA Bunda Sehat.
                            </p>
                            <a href="#unduh-rekam" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:text-brand-700 mt-2">
                                <span>Unduh / Lihat Rekam Medis</span> &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Notif 2: Waktunya Minum Tablet Tambah Darah (TTD) -->
                    <div class="p-4 rounded-2xl bg-sky-50/50 border border-sky-100 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="px-2 py-0.5 rounded-md bg-sky-100/80 text-sky-700 font-bold">Hari ini</span>
                                <span class="text-slate-400">19:00</span>
                            </div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Waktunya Minum Tablet Tambah Darah (TTD)</h4>
                            <p class="text-[11px] text-slate-600 mt-0.5 leading-relaxed">
                                Jangan lupa konsumsi 1 tablet TTD malam ini pukul 20:00 WIB bersama air putih atau jus jeruk untuk memaksimalkan penyerapan hemoglobin.
                            </p>
                            <a href="#sudah-minum" class="inline-flex items-center gap-1 text-xs font-bold text-sky-600 hover:text-sky-700 mt-2">
                                <span>Tandai Sudah Minum</span> &check;
                            </a>
                        </div>
                    </div>

                    <!-- Notif 3: Pembaruan Kurva Pertumbuhan WHO 2025 Telah Aktif -->
                    <div class="p-4 rounded-2xl bg-purple-50/50 border border-purple-100 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="px-2 py-0.5 rounded-md bg-purple-100/80 text-purple-700 font-bold">Sistem Klinis</span>
                                <span class="text-slate-400">Kemarin</span>
                            </div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Pembaruan Kurva Pertumbuhan WHO 2025 Telah Aktif</h4>
                            <p class="text-[11px] text-slate-600 mt-0.5 leading-relaxed">
                                Algoritma kalkulasi Z-Score Balita kini telah diselaraskan dengan standar nasional pencegahan stunting Kemenkes RI revisi terbaru.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right: Integrasi SatuSehat & Konsultasi Prioritas -->
                <div class="lg:col-span-5 xl:col-span-4 space-y-5">
                    
                    <!-- Card Top: Integrasi SatuSehat Kemenkes -->
                    <div class="rounded-3xl bg-white border border-slate-200/80 p-5 sm:p-6 shadow-2xs">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">
                                Integrasi SatuSehat Kemenkes
                            </h4>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            Data pemeriksaan terhubung aman secara bidirectional dengan Puskesmas Melati dan Posyandu terdaftar.
                        </p>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 font-medium pt-3 border-t border-slate-100">
                            <span>Sinkronisasi Terakhir: 10 mnt lalu</span>
                            <span class="text-emerald-500 font-bold">&check;</span>
                        </div>
                    </div>

                    <!-- Card Bottom: Konsultasi Prioritas Image Card -->
                    <div class="relative rounded-3xl overflow-hidden shadow-xl p-5 sm:p-6 text-white min-h-[220px] flex flex-col justify-between">
                        <!-- Background Image -->
                        <img
                            src="{{ asset('images/konsultasi-bidan-anak.jpg') }}"
                            alt="Konsultasi Bidan NutriGrow"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                            onerror="this.onerror=null; this.src='{{ asset('images/register-mother-child.jpg') }}';"
                        />
                        <!-- Gradient Dark Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/75 to-slate-900/40"></div>

                        <!-- Top Tag -->
                        <div class="relative z-10">
                            <span class="inline-block px-3 py-1 rounded-full bg-brand-600 text-white text-[10px] font-bold uppercase tracking-wider mb-2 shadow-xs">
                                Konsultasi Prioritas
                            </span>
                            <h4 class="text-lg sm:text-xl font-extrabold text-white leading-snug">
                                Punya Pertanyaan Seputar MPASI?
                            </h4>
                            <p class="text-xs text-white/80 mt-1 leading-relaxed">
                                Bidan dan ahli gizi NutriGrow siap mendampingi panduan tekstur makanan...
                            </p>
                        </div>

                        <!-- Bottom Button -->
                        <div class="relative z-10 pt-4">
                            <a href="#konsultasi" class="inline-block px-5 py-2.5 rounded-full bg-white text-slate-900 hover:bg-pink-50 font-bold text-xs shadow-md transition transform hover:-translate-y-0.5">
                                Hubungi Sekarang
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </main>

    </div>

    <!-- JAVASCRIPT: TOGGLE SIDEBAR MOBILE -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (!sidebar || !backdrop) return;

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>

</body>
</html>

