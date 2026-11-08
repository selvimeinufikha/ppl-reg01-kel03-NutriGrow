<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Tumbuh Kembang Anak - NutriGrow | Pemantauan Kesehatan Ibu &amp; Anak</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js for smooth interactive growth curve -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        },
                        activemenu: '#be185d',
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
    <!-- LEFT SIDEBAR: NAVIGASI UTAMA              -->
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
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                    <a href="#data-pasangan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Data Pasangan</span>
                    </a>
                    <a href="#data-kehamilan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Kehamilan</span>
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
                    <!-- MENU AKTIF: Tumbuh Kembang Anak (Background Solid Wine / Rose Red) -->
                    <a href="{{ route('tumbuh-kembang.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-[#be185d] text-white font-bold text-xs shadow-md shadow-pink-900/15 transition">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
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

        <!-- Sidebar Bottom: Sync Status & Logout (Sesuai Screenshot 2) -->
        <div class="p-4 border-t border-sky-100/60 bg-transparent space-y-2">
            <!-- Sync Card: Sinkron Faskes -->
            <div class="px-3.5 py-2.5 rounded-2xl bg-white/90 backdrop-blur-xs border border-sky-200/70 flex items-center justify-between text-[11px] shadow-2xs">
                <div class="flex items-start gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-sky-50 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5 animate-spin-slow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 leading-tight">Sinkron Faskes</div>
                        <div class="text-[10px] text-slate-500 font-medium leading-tight mt-0.5">Terhubung ke Posyandu Mawar 1 &amp; Puskesmas Sejahtera</div>
                    </div>
                </div>
                <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0 self-center"></span>
            </div>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-white/80 transition cursor-pointer">
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
    <!-- MAIN CONTENT AREA (SCROLLABLE)            -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- TOP HEADER BAR (Sesuai Screenshot 1) -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Pill 1: Tanggal Realtime / Sesuai Mockup -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-semibold">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $tanggalHariIni }}</span>
                </div>

                <!-- Pill 2: Faskes Terhubung -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-sky-50/80 border border-sky-200/70 text-sky-800 text-xs font-semibold">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Faskes: Posyandu Mawar 1 &amp; Puskesmas Sejahtera</span>
                </div>

                <!-- Pill 3: Keluarga Pengguna -->
                <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-rose-50/80 border border-rose-200/70 text-rose-800 text-xs font-semibold">
                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Keluarga Sarah Rahmawati</span>
                </div>
            </div>

            <!-- Header Right: Notifikasi & Avatar -->
            <div class="flex items-center gap-3">
                <!-- Notification Bell with Badge "3" -->
                <div class="relative">
                    <button type="button" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200/80 text-slate-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-[10px] font-bold text-white flex items-center justify-center ring-2 ring-white">
                        3
                    </span>
                </div>

                <!-- User Profile Avatar Circle -->
                <div class="w-9 h-9 rounded-full bg-rose-700 text-white flex items-center justify-center font-bold text-sm shadow-xs overflow-hidden">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE PAGE CONTAINER -->
        <main class="flex-1 overflow-y-auto px-4 sm:px-8 py-6 space-y-6">

            <!-- ========================================== -->
            <!-- 1. NOTICE BANNER (Sesuai Screenshot 1)    -->
            <!-- ========================================== -->
            <div class="rounded-2xl bg-[#eff6ff] border border-blue-200/80 p-4 sm:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-2xs">
                <div class="flex items-start gap-3.5">
                    <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-sm text-slate-900">Mode Pengguna: Akses Baca (Read-Only)</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider">
                                Tersinkronisasi
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Catatan pertumbuhan diverifikasi langsung oleh Tenaga Kesehatan Puskesmas &amp; Posyandu wilayah Anda.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-start md:self-center shrink-0 text-xs text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="font-medium">Data Terakhir Sinkron: <strong>Hari ini, 09:15 WIB</strong></span>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 2. BREADCRUMB & HEADER JUDUL              -->
            <!-- ========================================== -->
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs text-slate-400 font-medium mb-2">
                    <a href="{{ route('dashboard.pengguna') }}" class="hover:text-slate-600 transition">Dashboard</a>
                    <span>&gt;</span>
                    <a href="#data-anak" class="hover:text-slate-600 transition">Data Anak</a>
                    <span>&gt;</span>
                    <span class="text-slate-800 font-bold">Riwayat Tumbuh Kembang</span>
                </nav>

                <!-- Title & Child Selector in a Row -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-1">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Riwayat Tumbuh Kembang Anak
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                            Pantau grafik kenaikan berat badan, tinggi badan, lingkar kepala, serta capaian tonggak motorik buah hati Anda sesuai standar antropometri WHO dan Kemenkes RI.
                        </p>
                    </div>

                    <!-- Dropdown: Pilih Anak yang Dipantau -->
                    <div class="relative shrink-0">
                        <div class="flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs hover:border-pink-300 transition cursor-pointer" onclick="toggleChildDropdown()">
                            <div class="w-8 h-8 rounded-full bg-pink-100 text-brand-600 flex items-center justify-center text-sm font-bold shrink-0">
                                👶
                            </div>
                            <div class="text-left">
                                <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider block">Pilih Anak yang Dipantau</span>
                                <span class="text-xs font-extrabold text-slate-900 block" id="selectedChildLabel">
                                    {{ $selectedAnak['nama'] }} ({{ $selectedAnak['usia_bulan'] }} Bln)
                                </span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 ml-1 transition" id="childChevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        <!-- Dropdown Menu -->
                        <div id="childDropdownMenu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-30">
                            <span class="px-3 py-1.5 text-[10px] uppercase font-bold text-slate-400 block tracking-wider">
                                Daftar Buah Hati
                            </span>
                            @foreach($anakList as $anak)
                                <a href="?anak_id={{ $anak['id'] }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-pink-50/70 transition {{ $anak['id'] == $selectedAnak['id'] ? 'bg-pink-50/90 font-bold text-brand-700' : 'text-slate-700' }}">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center text-xs">
                                            👶
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold leading-tight">{{ $anak['nama'] }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $anak['usia'] }} &bull; {{ $anak['jenis_kelamin'] }}</div>
                                        </div>
                                    </div>
                                    @if($anak['id'] == $selectedAnak['id'])
                                        <span class="text-brand-600 text-xs font-bold">&check;</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 3. RINGKASAN 4 KARTU METRIK UTAMA         -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: Usia Terkini -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-slate-500">Usia Terkini</span>
                        <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-xs font-bold">
                            👶
                        </div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $ringkasanMetrik['usia_terkini']['nilai'] }}
                        </div>
                        <div class="flex items-center gap-1.5 mt-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span class="text-xs font-bold text-rose-600">
                                {{ $ringkasanMetrik['usia_terkini']['status'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Pemeriksaan Terakhir -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-slate-500">Pemeriksaan Terakhir</span>
                        <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $ringkasanMetrik['pemeriksaan_terakhir']['nilai'] }}
                        </div>
                        <div class="text-xs font-bold text-sky-600 mt-2">
                            {{ $ringkasanMetrik['pemeriksaan_terakhir']['faskes'] }}
                        </div>
                    </div>
                </div>

                <!-- Card 3: Berat Badan (BB) -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-slate-500">Berat Badan (BB)</span>
                        <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <div class="text-2xl font-black text-slate-900 tracking-tight">
                                {{ $ringkasanMetrik['berat_badan']['nilai'] }} <span class="text-lg font-bold">kg</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 font-extrabold text-[11px] border border-emerald-200/60">
                                {{ $ringkasanMetrik['berat_badan']['z_score'] }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-500 mt-2 font-medium">
                            {{ $ringkasanMetrik['berat_badan']['keterangan'] }}
                        </div>
                    </div>
                </div>

                <!-- Card 4: Tinggi Badan (TB) -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-slate-500">Tinggi Badan (TB)</span>
                        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 4v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <div class="text-2xl font-black text-slate-900 tracking-tight">
                                {{ $ringkasanMetrik['tinggi_badan']['nilai'] }} <span class="text-lg font-bold">cm</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 font-extrabold text-[11px] border border-emerald-200/60">
                                {{ $ringkasanMetrik['tinggi_badan']['z_score'] }}
                            </span>
                        </div>
                        <div class="text-xs font-bold text-emerald-600 mt-2">
                            {{ $ringkasanMetrik['tinggi_badan']['keterangan'] }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- 4. GRAFIK PERTUMBUHAN ANAK BERKALA         -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/80 shadow-2xs">
                
                <!-- Section Header with Legend (Sesuai Screenshot 2) -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-rose-50 text-[#be185d] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900">Grafik Pertumbuhan Anak Berkala</h2>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Perbandingan titik pengukuran aktual dengan standar kurva persentil median WHO &amp; Kemenkes RI.
                            </p>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex items-center gap-4 text-xs font-semibold self-start md:self-center">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-[#be185d]"></span>
                            <span class="text-slate-700">Hasil Anak</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-5 h-1 bg-sky-400 rounded-full"></span>
                            <span class="text-slate-500">Median WHO (0 SD)</span>
                        </div>
                    </div>
                </div>

                <!-- Dua Grafik Berdampingan (Side by Side) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-6">
                    
                    <!-- Grafik 1: Berat Badan menurut Umur (BB/U) -->
                    <div class="bg-[#fafbfc] rounded-2xl p-4 sm:p-5 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 4v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                                <span class="font-bold text-xs sm:text-sm text-slate-800">Berat Badan menurut Umur (BB/U)</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-pink-50 text-[#be185d] text-[10px] font-bold">
                                Satuan: Kilogram (kg)
                            </span>
                        </div>

                        <!-- Canvas Chart BB -->
                        <div class="relative w-full h-56 sm:h-64">
                            <canvas id="chartBeratBadan"></canvas>
                        </div>
                    </div>

                    <!-- Grafik 2: Tinggi/Panjang Badan menurut Umur (TB/U) -->
                    <div class="bg-[#fafbfc] rounded-2xl p-4 sm:p-5 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                <span class="font-bold text-xs sm:text-sm text-slate-800">Tinggi/Panjang Badan menurut Umur (TB/U)</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-sky-50 text-sky-700 text-[10px] font-bold">
                                Satuan: Sentimeter (cm)
                            </span>
                        </div>

                        <!-- Canvas Chart TB -->
                        <div class="relative w-full h-56 sm:h-64">
                            <canvas id="chartTinggiBadan"></canvas>
                        </div>
                    </div>

                </div>

                <!-- Footer Note Info -->
                <div class="flex items-center gap-2 mt-5 text-[11px] text-slate-500">
                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Data grafik diperbarui otomatis setiap kali anak melakukan penimbangan dan pengukuran di Posyandu atau Puskesmas jejaring.</span>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- 5. FILTER BAR PENCARIAN & PERIODE         -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-2xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                
                <!-- Input Cari Catatan -->
                <div class="relative flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        id="filterSearch"
                        oninput="applyFilter()"
                        placeholder="Cari catatan, faskes, atau hasil pemantauan..."
                        class="w-full pl-11 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition"
                    />
                </div>

                <!-- Filter Periode -->
                <div class="w-full md:w-48">
                    <select id="filterPeriode" onchange="applyFilter()" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 cursor-pointer">
                        <option value="semua">Semua Periode</option>
                        <option value="2024">Tahun 2024</option>
                        <option value="2023">Tahun 2023</option>
                        <option value="6bulan">6 Bulan Terakhir</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="w-full md:w-48">
                    <select id="filterStatus" onchange="applyFilter()" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 cursor-pointer">
                        <option value="semua">Semua Status</option>
                        <option value="normal">Pertumbuhan Baik &amp; Normal</option>
                        <option value="warning">Perlu Pantauan Berat (Kuning)</option>
                    </select>
                </div>

                <!-- Tombol Reset Filter -->
                <button type="button" onclick="resetFilter()" class="flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-2xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200/80 transition cursor-pointer shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Reset Filter</span>
                </button>

            </div>

            <!-- ========================================== -->
            <!-- 6. DAFTAR CATATAN PEMANTAUAN BERKALA      -->
            <!-- ========================================== -->
            <div class="space-y-4">
                
                <!-- Section Header List (Sesuai Screenshot 3) -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Daftar Catatan Pemantauan Berkala</h3>
                        <span class="px-2.5 py-0.5 rounded-full bg-pink-100 text-brand-700 text-xs font-extrabold" id="badgeTotalCatatan">
                            {{ count($catatanPemantauan) }} Catatan
                        </span>
                    </div>

                    <!-- Verified Badge Kemenkes -->
                    <div class="hidden sm:flex items-center gap-1.5 text-xs text-emerald-600 font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Data terverifikasi resmi oleh Kemenkes RI</span>
                    </div>
                </div>

                <!-- Empty State jika hasil filter kosong -->
                <div id="emptyFilterState" class="hidden bg-white rounded-3xl p-10 border border-slate-200/80 text-center">
                    <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto mb-3">
                        🔍
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Tidak ada catatan yang sesuai filter</h4>
                    <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian lain atau klik tombol reset filter.</p>
                    <button type="button" onclick="resetFilter()" class="mt-4 px-4 py-2 rounded-xl bg-pink-500 text-white font-bold text-xs shadow-xs hover:bg-pink-600 transition">
                        Reset Filter
                    </button>
                </div>

                <!-- LIST RECORD CARDS -->
                <div class="space-y-4" id="catatanContainer">
                    @foreach($catatanPemantauan as $item)
                        <div class="catatan-card bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-2xs hover:shadow-md transition relative flex flex-col justify-between"
                             data-tanggal="{{ $item['tanggal'] }}"
                             data-raw-date="{{ $item['raw_date'] }}"
                             data-status="{{ $item['status_type'] }}"
                             data-search="{{ strtolower($item['tanggal'] . ' ' . $item['catatan'] . ' ' . $item['tenaga_kesehatan'] . ' ' . $item['faskes'] . ' ' . $item['status_badge']) }}">
                            
                            <div>
                                <!-- Top Row: Tanggal, Usia, Status Badge -->
                                <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <span class="font-extrabold text-base text-slate-900">{{ $item['tanggal'] }}</span>
                                        <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200/60">
                                            Usia: {{ $item['usia'] }}
                                        </span>
                                        @if($item['status_type'] === 'normal')
                                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/60 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                {{ $item['status_badge'] }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200/60 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                {{ $item['status_badge'] }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Tombol Lihat Detail di Kanan Atas Desktop -->
                                    <button type="button" onclick="showDetailModal({{ json_encode($item) }})" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-sky-50/80 hover:bg-sky-100 text-sky-700 font-bold text-xs transition border border-sky-200/60 cursor-pointer">
                                        <span>Lihat Detail</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Metric Pills: BB, TB, LK, LiLA (Sesuai Mockup) -->
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <!-- BB Pill -->
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-pink-50/70 border border-pink-200/60 text-slate-800 text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                        </svg>
                                        <span>BB: <strong>{{ $item['bb'] }}</strong></span>
                                    </div>

                                    <!-- TB Pill -->
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-sky-50/70 border border-sky-200/60 text-slate-800 text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 4v12m0 0l4-4m-4 4l-4-4"/>
                                        </svg>
                                        <span>TB: <strong>{{ $item['tb'] }}</strong></span>
                                    </div>

                                    <!-- LK Pill -->
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-purple-50/70 border border-purple-200/60 text-slate-800 text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>LK: <strong>{{ $item['lk'] }}</strong></span>
                                    </div>

                                    <!-- LiLA Pill -->
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-100/80 border border-slate-200 text-slate-800 text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>LiLA: <strong>{{ $item['lila'] }}</strong></span>
                                    </div>
                                </div>

                                <!-- Paragraf Catatan Tumbuh Kembang -->
                                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                    {{ $item['catatan'] }}
                                </p>
                            </div>

                            <!-- Footer Row: Tenaga Medis & Faskes -->
                            <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                                <div class="flex items-center gap-4 flex-wrap">
                                    <!-- Nakes -->
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="font-medium text-slate-700">{{ $item['tenaga_kesehatan'] }}</span>
                                    </div>

                                    <!-- Faskes -->
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="font-medium text-slate-500">{{ $item['faskes'] }}</span>
                                    </div>
                                </div>

                                <!-- Tombol Lihat Detail di Mobile -->
                                <button type="button" onclick="showDetailModal({{ json_encode($item) }})" class="sm:hidden flex items-center justify-center gap-1.5 px-4 py-2 rounded-2xl bg-sky-50 text-sky-700 font-bold text-xs border border-sky-200">
                                    <span>Lihat Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>

        </main>

    </div>

    <!-- ========================================== -->
    <!-- 7. MODAL DETAIL CATATAN PEMANTAUAN        -->
    <!-- ========================================== -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeDetailModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-100">
                
                <!-- Modal Header -->
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-rose-50/60 via-pink-50/30 to-sky-50/40">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#be185d] text-white flex items-center justify-center font-bold">
                            📋
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900" id="modalTitle">Detail Rekam Medis Tumbuh Kembang</h3>
                            <p class="text-xs text-slate-500" id="modalSubtitle">Pemeriksaan Antropometri Terverifikasi</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-white hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                        &times;
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-5 space-y-5 max-h-[70vh] overflow-y-auto no-scrollbar">
                    
                    <!-- Meta Header Info -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-3.5 bg-slate-50 rounded-2xl border border-slate-200/70 text-xs">
                        <div>
                            <span class="text-slate-400 text-[10px] uppercase font-bold block">Tanggal</span>
                            <span class="font-extrabold text-slate-800" id="mTanggal">-</span>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] uppercase font-bold block">Usia Anak</span>
                            <span class="font-extrabold text-blue-600" id="mUsia">-</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-slate-400 text-[10px] uppercase font-bold block">Tenaga Kesehatan</span>
                            <span class="font-extrabold text-slate-800" id="mNakes">-</span>
                        </div>
                    </div>

                    <!-- 4 Parameter Antropometri & Z-Score -->
                    <div>
                        <h4 class="text-xs uppercase font-extrabold text-slate-400 tracking-wider mb-2">Parameter Antropometri &amp; Z-Score</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="p-3 rounded-2xl bg-pink-50/70 border border-pink-200/80">
                                <span class="text-[10px] font-bold text-pink-700 block">Berat Badan</span>
                                <div class="text-lg font-black text-slate-900 mt-0.5" id="mBB">-</div>
                                <span class="text-[10px] font-semibold text-emerald-600 block mt-1" id="mZScoreBB">-</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-sky-50/70 border border-sky-200/80">
                                <span class="text-[10px] font-bold text-sky-700 block">Tinggi Badan</span>
                                <div class="text-lg font-black text-slate-900 mt-0.5" id="mTB">-</div>
                                <span class="text-[10px] font-semibold text-emerald-600 block mt-1" id="mZScoreTB">-</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-purple-50/70 border border-purple-200/80">
                                <span class="text-[10px] font-bold text-purple-700 block">Lingkar Kepala</span>
                                <div class="text-lg font-black text-slate-900 mt-0.5" id="mLK">-</div>
                                <span class="text-[10px] font-semibold text-purple-700 block mt-1">Normal (Mesosefali)</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-100/80 border border-slate-200">
                                <span class="text-[10px] font-bold text-slate-700 block">Lingkar Lengan (LiLA)</span>
                                <div class="text-lg font-black text-slate-900 mt-0.5" id="mLiLA">-</div>
                                <span class="text-[10px] font-semibold text-emerald-600 block mt-1">Bebas KEP</span>
                            </div>
                        </div>
                    </div>

                    <!-- Perkembangan KPSP & Imunisasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Skrining Perkembangan (KPSP)</span>
                            <div class="font-bold text-slate-800" id="mKPSP">-</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Riwayat Imunisasi &amp; Suplementasi</span>
                            <div class="font-bold text-slate-800" id="mImunisasi">-</div>
                        </div>
                    </div>

                    <!-- Catatan Klinis & Rekomendasi Nutrisi -->
                    <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200/60 text-xs">
                        <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block mb-1">Catatan &amp; Edukasi Nutrisi Nakes</span>
                        <p class="text-slate-700 leading-relaxed" id="mCatatan">-</p>
                    </div>

                    <!-- Verifikasi SatuSehat Kemenkes -->
                    <div class="p-3 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 flex items-center justify-between text-xs text-emerald-800">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="font-bold">Terverifikasi Terintegrasi dengan Platform SatuSehat Kemenkes RI</span>
                        </div>
                        <span class="text-[10px] font-semibold text-emerald-600">ID: NGW-ANT-88291</span>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-100 transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        <span>Cetak Ringkasan</span>
                    </button>

                    <button type="button" onclick="closeDetailModal()" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-slate-800 hover:bg-slate-900 transition cursor-pointer">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- JAVASCRIPT: LOGIKA GRAFIK & INTERAKTIVITAS-->
    <!-- ========================================== -->
    <script>
        // Toggle Sidebar Mobile
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

        // Dropdown Pilih Anak
        function toggleChildDropdown() {
            const menu = document.getElementById('childDropdownMenu');
            const chevron = document.getElementById('childChevron');
            if (!menu) return;
            menu.classList.toggle('hidden');
            if (chevron) {
                chevron.classList.toggle('rotate-180');
            }
        }

        // Close dropdown when clicked outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('childDropdownMenu');
            const toggle = e.target.closest('[onclick="toggleChildDropdown()"]');
            if (!toggle && dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
                const chevron = document.getElementById('childChevron');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        });

        // ==========================================
        // INISIALISASI CHART.JS (KURVA PERTUMBUHAN)
        // ==========================================
        document.addEventListener('DOMContentLoaded', function () {
            const labels = {!! json_encode($grafikPertumbuhan['labels']) !!};
            const dataBBAnak = {!! json_encode($grafikPertumbuhan['berat_badan']['anak']) !!};
            const dataBBWHO = {!! json_encode($grafikPertumbuhan['berat_badan']['who_median']) !!};

            const dataTBAnak = {!! json_encode($grafikPertumbuhan['tinggi_badan']['anak']) !!};
            const dataTBWHO = {!! json_encode($grafikPertumbuhan['tinggi_badan']['who_median']) !!};

            // 1. Chart Berat Badan menurut Umur (BB/U)
            const ctxBB = document.getElementById('chartBeratBadan');
            if (ctxBB) {
                const gradientBB = ctxBB.getContext('2d').createLinearGradient(0, 0, 0, 220);
                gradientBB.addColorStop(0, 'rgba(190, 24, 93, 0.22)');
                gradientBB.addColorStop(1, 'rgba(255, 255, 255, 0.0)');

                new Chart(ctxBB, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Hasil Anak',
                                data: dataBBAnak,
                                borderColor: '#be185d',
                                backgroundColor: gradientBB,
                                borderWidth: 3,
                                fill: true,
                                tension: 0.35,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#be185d',
                                pointBorderWidth: 3,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                            },
                            {
                                label: 'Median WHO (0 SD)',
                                data: dataBBWHO,
                                borderColor: '#38bdf8',
                                borderDash: [5, 5],
                                borderWidth: 2,
                                fill: false,
                                tension: 0.35,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                                padding: 10,
                                cornerRadius: 10,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y + ' kg';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                min: 5,
                                max: 15,
                                ticks: {
                                    stepSize: 3,
                                    callback: function(value) { return value + 'kg'; },
                                    font: { family: 'Plus Jakarta Sans', size: 10 }
                                },
                                grid: { color: '#f1f5f9' }
                            },
                            x: {
                                ticks: {
                                    font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' }
                                },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // 2. Chart Tinggi Badan menurut Umur (TB/U)
            const ctxTB = document.getElementById('chartTinggiBadan');
            if (ctxTB) {
                const gradientTB = ctxTB.getContext('2d').createLinearGradient(0, 0, 0, 220);
                gradientTB.addColorStop(0, 'rgba(37, 99, 235, 0.20)');
                gradientTB.addColorStop(1, 'rgba(255, 255, 255, 0.0)');

                new Chart(ctxTB, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Hasil Anak',
                                data: dataTBAnak,
                                borderColor: '#2563eb',
                                backgroundColor: gradientTB,
                                borderWidth: 3,
                                fill: true,
                                tension: 0.35,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#2563eb',
                                pointBorderWidth: 3,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                            },
                            {
                                label: 'Median WHO (0 SD)',
                                data: dataTBWHO,
                                borderColor: '#93c5fd',
                                borderDash: [5, 5],
                                borderWidth: 2,
                                fill: false,
                                tension: 0.35,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                                padding: 10,
                                cornerRadius: 10,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y + ' cm';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                min: 60,
                                max: 100,
                                ticks: {
                                    stepSize: 10,
                                    callback: function(value) { return value + 'cm'; },
                                    font: { family: 'Plus Jakarta Sans', size: 10 }
                                },
                                grid: { color: '#f1f5f9' }
                            },
                            x: {
                                ticks: {
                                    font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' }
                                },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });

        // ==========================================
        // FILTER & SEARCH CATATAN BERKALA
        // ==========================================
        function applyFilter() {
            const query = (document.getElementById('filterSearch').value || '').toLowerCase().trim();
            const periode = document.getElementById('filterPeriode').value;
            const status = document.getElementById('filterStatus').value;

            const cards = document.querySelectorAll('.catatan-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const searchData = card.getAttribute('data-search') || '';
                const cardStatus = card.getAttribute('data-status') || '';
                const rawDate = card.getAttribute('data-raw-date') || '';

                // Cek Query Search
                const matchSearch = query === '' || searchData.includes(query);

                // Cek Status
                const matchStatus = status === 'semua' || cardStatus === status;

                // Cek Periode
                let matchPeriode = true;
                if (periode === '2024') {
                    matchPeriode = rawDate.startsWith('2024');
                } else if (periode === '2023') {
                    matchPeriode = rawDate.startsWith('2023');
                } else if (periode === '6bulan') {
                    // 6 bulan terakhir dari Mei 2024 (November 2023 - Mei 2024)
                    matchPeriode = rawDate >= '2023-11-01';
                }

                if (matchSearch && matchStatus && matchPeriode) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update badge hitungan catatan
            const badge = document.getElementById('badgeTotalCatatan');
            if (badge) {
                badge.innerText = visibleCount + ' Catatan';
            }

            // Tampilkan Empty State bila 0
            const emptyState = document.getElementById('emptyFilterState');
            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }

        function resetFilter() {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterPeriode').value = 'semua';
            document.getElementById('filterStatus').value = 'semua';
            applyFilter();
        }

        // ==========================================
        // MODAL DETAIL DETAIL CATATAN
        // ==========================================
        function showDetailModal(item) {
            document.getElementById('mTanggal').innerText = item.tanggal;
            document.getElementById('mUsia').innerText = item.usia;
            document.getElementById('mNakes').innerText = item.tenaga_kesehatan + ' (' + item.faskes + ')';
            document.getElementById('mBB').innerText = item.bb;
            document.getElementById('mTB').innerText = item.tb;
            document.getElementById('mLK').innerText = item.lk;
            document.getElementById('mLiLA').innerText = item.lila;
            document.getElementById('mZScoreBB').innerText = item.z_score_bb_u || 'Z-Score Normal';
            document.getElementById('mZScoreTB').innerText = item.z_score_tb_u || 'Z-Score Normal';
            document.getElementById('mKPSP').innerText = item.kpsp_status || 'Sesuai Umur';
            document.getElementById('mImunisasi').innerText = (item.imunisasi || '-') + ' | Vit. A: ' + (item.vit_a || '-') + ' | Obat Cacing: ' + (item.obat_cacing || '-');
            document.getElementById('mCatatan').innerText = item.catatan;

            const modal = document.getElementById('detailModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
