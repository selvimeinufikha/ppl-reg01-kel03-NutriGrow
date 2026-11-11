<!DOCTYPE html>
@php
    $userName = $user->name ?? 'Keluarga Pratama';
    $userEmail = $user->email ?? 'pratama@nutrigrow.id';
    $userId = 'NGW-' . str_pad($user->id ?? 1, 5, '0', STR_PAD_LEFT) . '-JKT';
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
    $faskesInfo = $faskesInfo ?? 'Posyandu Mawar 1 & Puskesmas Sejahtera';
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Anak - NutriGrow | Pemantauan Kesehatan Ibu & Anak</title>

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
    <!-- LEFT SIDEBAR: NAVIGASI UTAMA               -->
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
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
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
                    <!-- Active Item: Data Anak -->
                    <a href="{{ route('data-anak.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-brand-800 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
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
                    <a href="{{ route('dashboard.pengguna') }}#reminder-pemeriksaan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Reminder Pemeriksaan</span>
                    </a>
                    <a href="{{ route('dashboard.pengguna') }}#layanan-kesehatan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
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
                    <a href="{{ route('dashboard.pengguna') }}#edukasi-gizi" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
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
            <!-- Sync Pill -->
            <div class="px-3 py-2 rounded-xl bg-white/90 backdrop-blur-xs border border-sky-200/70 flex items-center justify-between text-[11px] shadow-2xs">
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

                <!-- Pill 1: Tanggal Real-Time -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 border border-slate-200/90 text-slate-700 text-[11px] sm:text-xs font-medium">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $tanggalHariIni }}</span>
                </div>

                <!-- Pill 2: Faskes Rujukan -->
                <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200/90 text-sky-700 text-[11px] sm:text-xs font-bold">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Faskes: {{ $faskesInfo }}</span>
                </div>

                <!-- Pill 3: Pengguna / Keluarga -->
                <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50/90 border border-pink-200/90 text-brand-800 text-[11px] sm:text-xs font-bold">
                    <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>{{ $namaKeluarga }}</span>
                </div>
            </div>

            <!-- Right Controls: Notifikasi & Avatar -->
            <div class="flex items-center gap-3">
                <div class="relative">
                    <button type="button" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200/80 text-slate-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-600 text-white text-[10px] font-extrabold flex items-center justify-center ring-2 ring-white">
                        3
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-brand-800 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE PAGE CONTAINER -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- Flash Alert (Success / Error) -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-sm flex items-center justify-between shadow-xs animate-fade-in">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold">Tutup</button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-sm shadow-xs">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <div class="font-bold">Terdapat beberapa kesalahan:</div>
                            <ul class="list-disc list-inside mt-1 text-xs space-y-1">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
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
                <span class="text-slate-500">Data Keluarga &amp; Profil</span>
                <span>&gt;</span>
                <span class="text-brand-700 font-semibold">Data Anak</span>
            </div>

            <!-- PAGE TITLE BAR -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-pink-100/90 text-brand-700 flex items-center justify-center flex-shrink-0 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Data Anak</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola identitas anak dan pantau data setiap anak dalam keluarga.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="openModalTambah()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-900/20 transition transform hover:-translate-y-0.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Anak</span>
                    </button>
                    <a href="{{ route('data-anak.create') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-pink-50 border border-pink-200 text-brand-700 hover:bg-pink-100 transition" title="Buka Halaman Formulir Penuh">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- RINGKASAN KELUARGA BANNER CARD -->
            <div class="rounded-3xl bg-white border border-pink-100/90 p-5 sm:p-6 shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- Left Info -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-brand-800 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-brand-900/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-pink-100/70 text-brand-700 text-[11px] font-bold mb-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                            <span>Ringkasan Keluarga</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 max-w-xl leading-relaxed">
                            Kelola informasi anak dan akses pemantauan tumbuh kembang keluarga dengan mudah serta terhubung ke faskes rujukan.
                        </p>
                    </div>
                </div>

                <!-- Right Overlapping Metric Pills -->
                <div class="flex items-center self-center lg:self-auto gap-2 sm:gap-3 bg-slate-50/70 p-2 sm:p-2.5 rounded-3xl border border-slate-100">
                    <!-- Total Anak -->
                    <div class="flex flex-col items-center justify-center px-4 sm:px-6 py-2.5 rounded-2xl bg-purple-50/80 border border-purple-100 min-w-[90px]">
                        <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">{{ $totalAnak }}</span>
                        <span class="text-[10px] text-slate-500 font-semibold">Total Anak</span>
                    </div>

                    <!-- Laki-laki -->
                    <div class="flex flex-col items-center justify-center px-4 sm:px-6 py-2.5 rounded-2xl bg-sky-50/90 border border-sky-100 min-w-[90px]">
                        <div class="w-6 h-6 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center mb-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">{{ $totalLaki }}</span>
                        <span class="text-[10px] text-sky-700 font-semibold">Laki-laki</span>
                    </div>

                    <!-- Perempuan -->
                    <div class="flex flex-col items-center justify-center px-4 sm:px-6 py-2.5 rounded-2xl bg-pink-50/90 border border-pink-100 min-w-[90px]">
                        <div class="w-6 h-6 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mb-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">{{ $totalPerempuan }}</span>
                        <span class="text-[10px] text-brand-700 font-semibold">Perempuan</span>
                    </div>
                </div>
            </div>

            <!-- SEARCH & FILTER TOOLBAR -->
            <form action="{{ route('data-anak.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex flex-1 items-center gap-3">
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <input type="text" name="q" value="{{ $filterQ }}" placeholder="Cari nama anak..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-white border border-slate-200/90 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 shadow-2xs transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <!-- Dropdown Gender Filter -->
                    <div class="relative">
                        <select name="jenis_kelamin" onchange="this.form.submit()" class="appearance-none pl-9 pr-9 py-2.5 rounded-full bg-white border border-slate-200/90 text-xs sm:text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 shadow-2xs transition cursor-pointer">
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

                    @if($filterQ || $filterGender)
                        <a href="{{ route('data-anak.index') }}" class="px-3 py-2 text-xs font-semibold text-slate-500 hover:text-rose-600 transition">
                            Reset Filter
                        </a>
                    @endif
                </div>

                <!-- Showing Count -->
                <div class="text-xs font-semibold text-slate-500 text-right">
                    Menampilkan <span class="text-slate-800 font-bold">{{ $anaks->count() }}</span> dari <span class="text-slate-800 font-bold">{{ $totalAnak }}</span> anak
                </div>
            </form>

            <!-- CHILD CARDS GRID -->
            @if($anaks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($anaks as $anak)
                        @php
                            $isBoy = $anak->jenis_kelamin === 'Laki-laki';
                        @endphp
                        <div class="rounded-3xl bg-white border border-slate-200/80 p-5 sm:p-6 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
                            <!-- Card Header: Avatar & Info -->
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-3.5">
                                        <!-- Avatar Circle -->
                                        <div class="w-12 h-12 rounded-full {{ $isBoy ? 'bg-sky-100 text-sky-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-extrabold text-slate-900 leading-tight">{{ $anak->nama }}</h3>
                                            <!-- Gender Pill -->
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full {{ $isBoy ? 'bg-sky-50 text-sky-600' : 'bg-pink-50 text-brand-700' }} text-[11px] font-bold mt-1">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $isBoy ? 'bg-sky-500' : 'bg-brand-500' }}"></span>
                                                <span>{{ $anak->jenis_kelamin }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($anak->anak_ke)
                                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-500">
                                            Anak ke-{{ $anak->anak_ke }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Card Metadata Grid -->
                                <div class="grid grid-cols-2 gap-3 py-3 border-y border-slate-100 text-xs">
                                    <div>
                                        <span class="text-slate-400 block text-[11px] font-medium mb-0.5">Tanggal Lahir</span>
                                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $anak->tanggal_lahir_formatted }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px] font-medium mb-0.5">Umur</span>
                                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-brand-700 font-extrabold">{{ $anak->usia_formatted }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Kehamilan Terkait -->
                                <div class="mt-3 text-xs">
                                    <span class="text-slate-400 block text-[11px] font-medium mb-1">Data Kehamilan Terkait</span>
                                    <div class="font-semibold text-slate-700 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-rose-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span class="{{ $anak->kehamilan ? 'text-slate-800' : 'text-slate-400' }}">
                                            {{ $anak->kehamilan_terkait_label }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Bottom Action Buttons -->
                            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100">
                                <div class="flex items-center gap-2">
                                    <!-- Button Detail -->
                                    <button type="button" onclick="showDetailAnak({{ $anak->id }})" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Detail</span>
                                    </button>

                                    <!-- Button Edit -->
                                    <a href="{{ route('data-anak.edit', $anak->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                </div>

                                <!-- Button Delete (Modal Konfirmasi) -->
                                <button type="button" onclick="confirmDeleteAnak({{ $anak->id }}, '{{ addslashes($anak->nama) }}')" class="p-2 rounded-xl text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition cursor-pointer" title="Hapus Data Anak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="rounded-3xl bg-white border border-dashed border-slate-300 p-10 text-center">
                    <div class="w-16 h-16 rounded-full bg-pink-50 text-brand-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Anak</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mt-1 mb-6">
                        @if($filterQ || $filterGender)
                            Tidak ada data anak yang sesuai dengan pencarian. Silakan coba kata kunci lain.
                        @else
                            Mulai catat identitas buah hati Anda untuk memantau grafik tumbuh kembang, imunisasi, dan asupan nutrisinya.
                        @endif
                    </p>
                    <button type="button" onclick="openModalTambah()" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-900/20 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Anak Sekarang</span>
                    </button>
                </div>
            @endif

        </main>
    </div>

    <!-- ========================================== -->
    <!-- MODAL: TAMBAH DATA ANAK (FRONTEND FORM)    -->
    <!-- ========================================== -->
    <div id="modalTambahAnak" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" onclick="closeModalTambah()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-pink-100">
                
                <!-- Modal Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-pink-50 via-rose-50 to-white border-b border-pink-100/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-brand-800 text-white flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900" id="modal-title">Formulir Tambah Data Anak</h3>
                            <p class="text-xs text-slate-500">Lengkapi data identitas anak di bawah ini.</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModalTambah()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-white/80 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Form Body -->
                <form id="formTambahAnak" action="{{ route('data-anak.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    <!-- Nama Lengkap Anak (Required) -->
                    <div>
                        <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Lengkap Anak <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: Kinan Pratama" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('nama') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                        @error('nama')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid: Jenis Kelamin & Tanggal Lahir (Acceptance Criteria) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Jenis Kelamin (Required) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2.5">
                                <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-sky-50/50 cursor-pointer transition has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" required {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} class="text-sky-600 focus:ring-sky-500">
                                    <span class="text-xs font-bold text-slate-800">Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-pink-50/50 cursor-pointer transition has-[:checked]:border-brand-500 has-[:checked]:bg-pink-50">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" required {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500">
                                    <span class="text-xs font-bold text-slate-800">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir (Required, Max Today - Acceptance Criteria) -->
                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tanggal Lahir <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required max="{{ date('Y-m-d') }}" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('tanggal_lahir') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            <p class="text-[10px] text-slate-400 mt-1">Tanggal tidak boleh melebihi hari ini ({{ date('d/m/Y') }}).</p>
                            @error('tanggal_lahir')
                                <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Data Kehamilan Terkait (Acceptance Criteria) -->
                    <div>
                        <label for="kehamilan_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Hubungkan ke Data Kehamilan (Opsional)
                        </label>
                        <select id="kehamilan_id" name="kehamilan_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition cursor-pointer">
                            <option value="">-- Tidak Terhubung / Tanpa Data Kehamilan --</option>
                            @foreach($kehamilans as $khm)
                                <option value="{{ $khm->id }}" {{ old('kehamilan_id') == $khm->id ? 'selected' : '' }}>
                                    {{ $khm->label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Hubungkan anak ini dengan catatan kehamilan untuk integrasi rekam medis ANC.</p>
                    </div>

                    <!-- Informasi Kelahiran Tambahan (Accordion / Optional) -->
                    <div class="border-t border-slate-100 pt-3">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Informasi Tambahan (Opsional)
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label for="nik" class="block text-[11px] font-semibold text-slate-600 mb-1">NIK Anak</label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="30" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="anak_ke" class="block text-[11px] font-semibold text-slate-600 mb-1">Anak Ke-</label>
                                <input type="number" id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" min="1" max="20" placeholder="Contoh: 1" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="golongan_darah" class="block text-[11px] font-semibold text-slate-600 mb-1">Golongan Darah</label>
                                <select id="golongan_darah" name="golongan_darah" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                                    <option value="">Pilih</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3">
                            <div>
                                <label for="berat_lahir" class="block text-[11px] font-semibold text-slate-600 mb-1">Berat Lahir (kg)</label>
                                <input type="number" step="0.01" id="berat_lahir" name="berat_lahir" value="{{ old('berat_lahir') }}" placeholder="Contoh: 3.20" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="panjang_lahir" class="block text-[11px] font-semibold text-slate-600 mb-1">Panjang Lahir (cm)</label>
                                <input type="number" step="0.1" id="panjang_lahir" name="panjang_lahir" value="{{ old('panjang_lahir') }}" placeholder="Contoh: 49.0" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="lingkar_kepala_lahir" class="block text-[11px] font-semibold text-slate-600 mb-1">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" id="lingkar_kepala_lahir" name="lingkar_kepala_lahir" value="{{ old('lingkar_kepala_lahir') }}" placeholder="Contoh: 33.5" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer Actions -->
                    <div class="border-t border-slate-100 pt-4 flex items-center justify-end gap-2.5">
                        <button type="button" onclick="closeModalTambah()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-900/20 transition cursor-pointer">
                            Simpan Data Anak
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL: DETAIL DATA ANAK                    -->
    <!-- ========================================== -->
    <div id="modalDetailAnak" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="detail-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" onclick="closeModalDetail()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-pink-100">
                <div class="px-6 py-5 bg-gradient-to-r from-pink-50 to-white border-b border-pink-100/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div id="detailAvatar" class="w-10 h-10 rounded-2xl bg-brand-800 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900" id="detailNama">-</h3>
                            <span id="detailGenderPill" class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">-</span>
                        </div>
                    </div>
                    <button type="button" onclick="closeModalDetail()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-white/80 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-3.5 text-xs">
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Tanggal Lahir</span>
                        <span id="detailTglLahir" class="font-bold text-slate-800">-</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Usia Saat Ini</span>
                        <span id="detailUmur" class="font-extrabold text-brand-700">-</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Data Kehamilan Terkait</span>
                        <span id="detailKehamilan" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">NIK Anak</span>
                        <span id="detailNik" class="font-medium text-slate-700">-</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Anak Ke-</span>
                        <span id="detailAnakKe" class="font-medium text-slate-700">-</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 text-center">
                        <div class="p-2 rounded-xl bg-slate-50">
                            <span class="text-[10px] text-slate-400 block font-medium">Berat Lahir</span>
                            <span id="detailBerat" class="font-bold text-slate-800">-</span>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-50">
                            <span class="text-[10px] text-slate-400 block font-medium">Panjang Lahir</span>
                            <span id="detailPanjang" class="font-bold text-slate-800">-</span>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-50">
                            <span class="text-[10px] text-slate-400 block font-medium">Lingkar Kepala</span>
                            <span id="detailLingkar" class="font-bold text-slate-800">-</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <span class="text-slate-400 font-medium block mb-1">Catatan Khusus:</span>
                        <p id="detailCatatan" class="text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 text-[11px] leading-relaxed">-</p>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex justify-end">
                    <button type="button" onclick="closeModalDetail()" class="px-5 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL: DIALOG KONFIRMASI PENGHAPUSAN ANAK  -->
    <!-- ========================================== -->
    <div id="modalHapusAnak" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-delete-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" onclick="closeModalHapus()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-rose-100 p-6 sm:p-7">
                <!-- Icon Warning Bulat -->
                <div class="flex items-center justify-center w-14 h-14 mx-auto rounded-full bg-rose-100 text-rose-600 mb-4 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                
                <h3 class="text-lg sm:text-xl font-extrabold text-center text-slate-900 mb-2" id="modal-delete-title">
                    Hapus Data Anak?
                </h3>
                
                <p class="text-xs sm:text-sm text-center text-slate-500 mb-6 leading-relaxed">
                    Apakah Anda yakin ingin menghapus data anak <span id="namaAnakDihapus" class="font-extrabold text-slate-900"></span>?
                    <span class="text-rose-600 text-xs mt-1.5 block font-medium">Tindakan ini permanen dan seluruh riwayat tumbuh kembang terkait anak ini akan ikut terhapus.</span>
                </p>

                <!-- Form Eksekusi Hapus -->
                <form id="formHapusAnak" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" onclick="closeModalHapus()" class="w-1/2 px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="w-1/2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-rose-600/20 transition cursor-pointer">
                            Ya, Hapus Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function openModalTambah() {
            document.getElementById('modalTambahAnak').classList.remove('hidden');
        }

        function closeModalTambah() {
            document.getElementById('modalTambahAnak').classList.add('hidden');
        }

        function openModalDetail() {
            document.getElementById('modalDetailAnak').classList.remove('hidden');
        }

        function closeModalDetail() {
            document.getElementById('modalDetailAnak').classList.add('hidden');
        }

        function confirmDeleteAnak(id, name) {
            document.getElementById('namaAnakDihapus').innerText = `"${name}"`;
            document.getElementById('formHapusAnak').action = `/data-anak/${id}`;
            document.getElementById('modalHapusAnak').classList.remove('hidden');
        }

        function closeModalHapus() {
            document.getElementById('modalHapusAnak').classList.add('hidden');
        }

        function showDetailAnak(id) {
            fetch(`/data-anak/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    const d = res.data;
                    document.getElementById('detailNama').innerText = d.nama;
                    document.getElementById('detailTglLahir').innerText = d.tanggal_lahir;
                    document.getElementById('detailUmur').innerText = d.umur;
                    document.getElementById('detailKehamilan').innerText = d.kehamilan_terkait;
                    document.getElementById('detailNik').innerText = d.nik;
                    document.getElementById('detailAnakKe').innerText = d.anak_ke;
                    document.getElementById('detailBerat').innerText = d.berat_lahir;
                    document.getElementById('detailPanjang').innerText = d.panjang_lahir;
                    document.getElementById('detailLingkar').innerText = d.lingkar_kepala_lahir;
                    document.getElementById('detailCatatan').innerText = d.catatan;

                    const genderPill = document.getElementById('detailGenderPill');
                    const avatar = document.getElementById('detailAvatar');
                    genderPill.innerText = d.jenis_kelamin;

                    if (d.jenis_kelamin === 'Laki-laki') {
                        genderPill.className = 'text-[11px] font-bold px-2 py-0.5 rounded-full bg-sky-100 text-sky-700';
                        avatar.className = 'w-10 h-10 rounded-2xl bg-sky-600 text-white flex items-center justify-center';
                    } else {
                        genderPill.className = 'text-[11px] font-bold px-2 py-0.5 rounded-full bg-pink-100 text-brand-700';
                        avatar.className = 'w-10 h-10 rounded-2xl bg-brand-800 text-white flex items-center justify-center';
                    }

                    openModalDetail();
                }
            })
            .catch(err => {
                console.error(err);
                alert('Gagal memuat detail anak.');
            });
        }

        // Tanggal Lahir Validation (Acceptance Criteria): tanggal tidak boleh melebihi hari ini
        const tglInput = document.getElementById('tanggal_lahir');
        if (tglInput) {
            tglInput.addEventListener('change', function() {
                if (!this.value) return;
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const todayStr = `${year}-${month}-${day}`;

                if (this.value > todayStr) {
                    alert('Tanggal lahir yang melebihi hari ini ditolak! Silakan masukkan tanggal yang valid.');
                    this.value = '';
                }
            });
        }

        // Jika terdapat error validasi dari backend, otomatis buka kembali modal agar pengguna dapat memperbaikinya
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openModalTambah();
            });
        @endif
    </script>
</body>
</html>
