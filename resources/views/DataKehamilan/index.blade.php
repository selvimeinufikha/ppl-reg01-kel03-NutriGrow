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
    <title>Data Kehamilan - NutriGrow | Pemantauan Kesehatan Ibu &amp; Anak</title>

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
    <!-- LEFT SIDEBAR: NAVIGASI UTAMA -->
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
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
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
                    <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Profil Pengguna</span>
                    </a>
                    
                    <!-- DATA KEHAMILAN - ACTIVE MENU -->
                    <a href="{{ route('kehamilan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-gradient-to-r from-brand-800 to-brand-700 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4 text-rose-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <span>Rekomendasi Nutrisi</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Sidebar Bottom: Status Faskes & Logout -->
        <div class="p-4 border-t border-pink-100/60 bg-white/40 backdrop-blur-sm space-y-2">
            <!-- Sinkron Faskes Card -->
            <div class="bg-white/90 border border-pink-100 rounded-xl p-3 shadow-xs flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center text-brand-600">
                        <svg class="w-4 h-4 animate-spin-slow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-800">Sinkron Faskes</div>
                        <div class="text-[10px] text-slate-500 truncate max-w-[110px]">Posyandu Mawar 1</div>
                    </div>
                </div>
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 ring-4 ring-blue-100"></span>
            </div>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="pt-1">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-500 hover:text-rose-600 hover:bg-rose-50/60 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay Mobile -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 z-30 lg:hidden hidden backdrop-blur-xs"></div>

    <!-- ========================================== -->
    <!-- MAIN CONTENT WRAPPER -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- ========================================== -->
        <!-- TOP HEADER BAR -->
        <!-- ========================================== -->
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-20 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <!-- Mobile Menu Toggle & Title -->
            <div class="flex items-center gap-3">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                    <!-- Tanggal Real-Time -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200/80 text-[11px] font-medium text-slate-600">
                        <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $tanggalHariIni }}</span>
                    </div>

                    <!-- Faskes Info Pill -->
                    <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50/80 border border-blue-200/70 text-[11px] font-semibold text-blue-700">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Faskes: {{ $faskesName }}</span>
                    </div>

                    <!-- Keluarga Pill -->
                    <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-pink-50 border border-pink-200 text-[11px] font-bold text-brand-700">
                        <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>{{ $keluargaName }}</span>
                    </div>
                </div>
            </div>

            <!-- Profile & Notification Controls -->
            <div class="flex items-center gap-3">
                <button type="button" class="relative p-2 text-slate-500 hover:text-brand-600 hover:bg-slate-100 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-4 h-4 bg-brand-600 text-white text-[9px] font-bold rounded-full flex items-center justify-center ring-2 ring-white">3</span>
                </button>

                <div class="w-8 h-8 rounded-full bg-brand-800 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </header>

        <!-- ========================================== -->
        <!-- PAGE BODY -->
        <!-- ========================================== -->
        <main class="p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

            <!-- Flash Notification Success / Error -->
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl shadow-xs">
                    <div class="flex items-center gap-2.5 mb-1.5">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-bold">Gagal Menyimpan Data Kehamilan</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 pl-1 text-rose-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- BREADCRUMB & PAGE TITLE BAR -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <!-- Breadcrumbs -->
                    <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400 mb-1">
                        <a href="{{ route('dashboard.pengguna') }}" class="hover:text-slate-600 transition">Dashboard</a>
                        <span>&rsaquo;</span>
                        <span>Data Keluarga &amp; Profil</span>
                        <span>&rsaquo;</span>
                        <span class="text-brand-700 font-bold">Data Kehamilan</span>
                    </div>

                    <!-- Title & Subtitle -->
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-brand-50 border border-brand-200 flex items-center justify-center text-brand-700 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Data Kehamilan</h1>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola dan pantau informasi kehamilan untuk membantu memantau perkembangan janin &amp; kesehatan ibu.</p>
                        </div>
                    </div>
                </div>

                <!-- Primary Action Button: Tambah Data Kehamilan -->
                <div class="flex items-center gap-2">
                    <button type="button" onclick="openModalTambah()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-800 via-brand-700 to-rose-700 hover:from-brand-900 hover:to-rose-800 text-white font-bold text-xs shadow-md shadow-brand-900/25 hover:shadow-lg transition transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Data Kehamilan</span>
                    </button>
                    <a href="{{ route('kehamilan.create') }}" class="hidden sm:inline-flex p-2.5 rounded-full border border-slate-200 hover:bg-slate-50 text-slate-500 hover:text-slate-800" title="Buka Formulir Penuh">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- HERO BANNER SECTION (SESUAI MOCKUP) -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-pink-100/70 shadow-sm relative overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    
                    <!-- Left Photo Frame with Arch Styling -->
                    <div class="lg:col-span-4 flex justify-center">
                        <div class="relative w-full max-w-[280px] h-[220px] rounded-3xl overflow-hidden border-4 border-pink-50 shadow-md">
                            <img src="{{ asset('images/fetus-24-weeks.jpg') }}" alt="Pemantauan Kehamilan" class="w-full h-full object-cover">
                            <!-- Overlay Gradient & Badge -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-[10px] font-extrabold text-brand-800 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                                    <span>Pemantauan Kehamilan</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Hero Info & Stats -->
                    <div class="lg:col-span-8 space-y-4">
                        <!-- Badges -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200 text-[11px] font-bold text-brand-700">
                                <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                                <span>Pemantauan Kehamilan Aktif</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[11px] font-bold text-blue-700">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span>Terhubung Buku KIA &amp; Posyandu</span>
                            </span>
                        </div>

                        <!-- Subheading Paragraph -->
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                            Pantau usia kehamilan, trimester, dan perkiraan hari lahir dalam satu tempat secara terpadu untuk mencegah stunting sejak <strong>1.000 Hari Pertama Kehidupan (HPK)</strong>.
                        </p>

                        <!-- 3 Summary Stat Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <!-- Card 1: Total Data -->
                            <div class="bg-rose-50/70 border border-rose-100 rounded-2xl p-3.5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white text-brand-700 flex items-center justify-center shadow-xs flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Total Data</div>
                                    <div class="text-base font-extrabold text-slate-900 leading-tight">
                                        {{ $totalData }} <span class="text-xs font-semibold text-slate-500">Rekam</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Kehamilan Aktif -->
                            <div class="bg-pink-50/70 border border-pink-100 rounded-2xl p-3.5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white text-rose-600 flex items-center justify-center shadow-xs flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Kehamilan Aktif</div>
                                    <div class="text-base font-extrabold text-brand-700 leading-tight">
                                        {{ $kehamilanAktif }} <span class="text-xs font-semibold text-brand-600">Berjalan</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: HPL Terdekat -->
                            <div class="bg-blue-50/70 border border-blue-100 rounded-2xl p-3.5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white text-blue-600 flex items-center justify-center shadow-xs flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">HPL Terdekat</div>
                                    <div class="text-xs sm:text-sm font-extrabold text-blue-800 leading-tight">
                                        {{ $hplTerdekat }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- SEARCH & FILTER BAR -->
            <!-- ========================================== -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white p-3.5 rounded-2xl border border-slate-100 shadow-xs">
                <form action="{{ route('kehamilan.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto flex-1">
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-80">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Cari data kehamilan..." class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    </div>

                    <!-- Status Filter Dropdown -->
                    <div class="w-full sm:w-48">
                        <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-700 transition">
                            <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="berlangsung" {{ $filterStatus === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="melahirkan" {{ $filterStatus === 'melahirkan' ? 'selected' : '' }}>Melahirkan</option>
                            <option value="keguguran" {{ $filterStatus === 'keguguran' ? 'selected' : '' }}>Keguguran</option>
                        </select>
                    </div>

                    @if ($searchQuery || $filterStatus !== 'all')
                        <a href="{{ route('kehamilan.index') }}" class="text-xs text-rose-600 hover:underline font-semibold">Reset</a>
                    @endif
                </form>

                <!-- Count Info -->
                <div class="text-[11px] font-semibold text-slate-500 whitespace-nowrap">
                    Menampilkan <span class="text-slate-800 font-bold">{{ $kehamilans->count() }}</span> dari {{ $totalData }} data kehamilan
                </div>
            </div>

            <!-- ========================================== -->
            <!-- CARD LIST: DAFTAR DATA KEHAMILAN -->
            <!-- ========================================== -->
            <div class="space-y-5">
                @forelse ($kehamilans as $item)
                    @php
                        $isAktif = $item->status === 'berlangsung';
                        $isMelahirkan = $item->status === 'melahirkan';
                    @endphp

                    <div class="bg-white rounded-3xl border {{ $isAktif ? 'border-brand-200 shadow-sm' : 'border-slate-100 shadow-xs' }} overflow-hidden transition hover:shadow-md">
                        <!-- Top Accent Bar -->
                        <div class="h-1.5 w-full {{ $isAktif ? 'bg-gradient-to-r from-brand-700 via-rose-500 to-pink-500' : 'bg-gradient-to-r from-blue-600 to-indigo-500' }}"></div>

                        <div class="p-5 sm:p-6 space-y-4">
                            <!-- Card Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl {{ $isAktif ? 'bg-rose-50 text-brand-700' : 'bg-blue-50 text-blue-700' }} flex items-center justify-center font-bold text-sm shadow-xs flex-shrink-0">
                                        @if ($isAktif)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="text-base font-extrabold text-slate-900">Kehamilan Ke-{{ $item->kehamilan_ke }}</h3>
                                            
                                            <!-- Trimester / Tag Badge -->
                                            @if ($isAktif)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-50 text-brand-700 border border-rose-200">
                                                    {{ $item->trimester_badge }}
                                                </span>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-pink-100 text-brand-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                                                    <span>Berlangsung</span>
                                                </span>
                                            @elseif ($isMelahirkan)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200">
                                                    {{ $item->kehamilan_ke == 1 ? 'Anak Pertama' : 'Anak Ke-' . $item->kehamilan_ke }}
                                                </span>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                                    <span>Melahirkan</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-700">
                                                    <span>{{ ucfirst($item->status) }}</span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] font-medium text-slate-500 mt-0.5">
                                            @if ($isAktif)
                                                Calon Ibu: <strong class="text-slate-700">{{ $item->user?->name ?? $userName }}</strong>
                                            @elseif ($item->nama_anak)
                                                Lahir: <strong class="text-slate-700">{{ $item->nama_anak }}</strong>
                                            @else
                                                Ibu: <strong class="text-slate-700">{{ $item->user?->name ?? $userName }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons (Detail, Edit, Hapus) -->
                                <div class="flex items-center gap-2 self-end sm:self-center">
                                    <a href="{{ route('kehamilan.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Detail</span>
                                    </a>
                                    <a href="{{ route('kehamilan.edit', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" onclick="bukaDialogKonfirmasiHapus({{ $item->id }}, {{ $item->kehamilan_ke }})" class="p-1.5 rounded-xl text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" title="Hapus Data Kehamilan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-slate-50/70 p-4 rounded-2xl border border-slate-100 text-xs">
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-slate-400">HPHT</div>
                                    <div class="font-extrabold text-slate-900 mt-0.5">{{ $item->hpht_formatted }}</div>
                                </div>

                                @if ($isAktif)
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-slate-400">Perkiraan Lahir (HPL)</div>
                                        <div class="font-extrabold text-brand-700 mt-0.5">{{ $item->hpl_formatted }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-slate-400">Usia Kehamilan</div>
                                        <div class="font-extrabold text-slate-900 mt-0.5">{{ $item->usia_kehamilan }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-slate-400">Trimester</div>
                                        <div class="font-extrabold text-blue-700 mt-0.5">{{ $item->trimester }}</div>
                                    </div>
                                @elseif ($isMelahirkan)
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-slate-400">Tanggal Persalinan</div>
                                        <div class="font-extrabold text-blue-700 mt-0.5">{{ $item->tanggal_persalinan_formatted }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-slate-400">Usia Kelahiran</div>
                                        <div class="font-extrabold text-slate-900 mt-0.5">{{ $item->usia_kehamilan }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-slate-400">Status Persalinan</div>
                                        <div class="font-extrabold text-slate-800 mt-0.5">{{ $item->status_persalinan ?? 'Aterm (Cukup Bulan)' }}</div>
                                    </div>
                                @endif
                            </div>

                            <!-- Pasangan Pill or Note -->
                            @if ($item->pasangan)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-pink-50/70 border border-pink-100 text-xs text-slate-700">
                                    <span class="text-sm">👫</span>
                                    <span class="font-medium">Pasangan:</span>
                                    <strong class="font-bold text-brand-900">{{ $item->pasangan->nama_lengkap }}</strong>
                                    <span class="text-slate-400 text-[11px]">({{ $item->pasangan->hubungan ?? 'Calon Ayah' }})</span>
                                </div>
                            @endif

                            @if ($isMelahirkan)
                                <div class="flex items-center gap-2 p-3 bg-blue-50/70 border border-blue-100 rounded-2xl text-xs text-blue-800 font-medium">
                                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Data anak telah terdaftar resmi di menu <strong>Data Anak</strong></span>
                                </div>
                            @endif

                            <!-- Catatan Perkembangan / Persalinan -->
                            @if ($item->catatan)
                                <p class="text-xs text-slate-600 leading-relaxed font-normal bg-slate-50/40 p-3 rounded-xl border border-slate-100">
                                    {{ $item->catatan }}
                                </p>
                            @endif

                            <!-- Card Footer -->
                            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-2 border-t border-slate-50">
                                <div>
                                    @if ($isAktif)
                                        Pembaruan Terakhir: <strong class="text-slate-600">{{ $item->updated_formatted }}</strong>
                                    @else
                                        Status Rekam: <strong class="text-slate-600">Riwayat Selesai</strong>
                                    @endif
                                </div>
                                <div class="text-[10px] text-slate-400">
                                    Kode Rekam: <span class="font-mono">{{ $item->gravida ?? 'G'.$item->kehamilan_ke }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="bg-white rounded-3xl p-10 text-center border border-slate-100 shadow-xs space-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-pink-50 text-brand-600 flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Belum Ada Data Kehamilan</h3>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Mulai catat data kehamilan Anda untuk memantau hari perkiraan lahir, usia kehamilan, dan kesehatan janin.</p>
                        </div>
                        <button type="button" onclick="openModalTambah()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-md shadow-brand-700/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            <span>Catat Kehamilan Sekarang</span>
                        </button>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- ========================================== -->
    <!-- MODAL FORMULIR: TAMBAH DATA KEHAMILAN -->
    <!-- ========================================== -->
    <div id="modalTambahKehamilan" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-100 relative my-8 overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center font-bold shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Catat Data Kehamilan Baru</h2>
                        <p class="text-xs text-slate-500 font-medium">Isi formulir berikut untuk memantau siklus dan usia kehamilan.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalTambah()" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Client-side Error Banner -->
            <div id="modalErrorBanner" class="hidden bg-rose-50 border border-rose-200 text-rose-800 p-3 rounded-2xl mb-4 text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span id="modalErrorMessage"></span>
            </div>

            <!-- Form -->
            <form id="formCatatKehamilan" action="{{ route('kehamilan.store') }}" method="POST" onsubmit="return validateFormKehamilan(event)" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Field: HPHT (Hari Pertama Haid Terakhir) - Acceptance Criteria -->
                    <div>
                        <label for="hpht" class="block text-xs font-bold text-slate-700 mb-1">
                            Tanggal HPHT <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="hpht" name="hpht" value="{{ old('hpht') }}" max="{{ date('Y-m-d') }}" required onchange="hitungPerkiraanOtomatis()" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition">
                        <span class="text-[10px] text-slate-400 mt-1 block">Hari Pertama Haid Terakhir (Maksimal hari ini).</span>
                    </div>

                    <!-- Field: Kehamilan Ke- berapa - Acceptance Criteria -->
                    <div>
                        <label for="kehamilan_ke" class="block text-xs font-bold text-slate-700 mb-1">
                            Kehamilan Ke- Berapa <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="kehamilan_ke" name="kehamilan_ke" value="{{ old('kehamilan_ke', 1) }}" min="1" max="20" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition">
                        <span class="text-[10px] text-slate-400 mt-1 block">Nomor urut kehamilan (contoh: 1, 2, dst).</span>
                    </div>
                </div>

                <!-- Field: Status Kehamilan - Acceptance Criteria -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 mb-1">
                            Status Kehamilan <span class="text-rose-500">*</span>
                        </label>
                        <select id="status" name="status" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition">
                            <option value="berlangsung" {{ old('status') === 'berlangsung' ? 'selected' : '' }}>Berlangsung (Sedang Hamil)</option>
                            <option value="melahirkan" {{ old('status') === 'melahirkan' ? 'selected' : '' }}>Melahirkan (Riwayat Selesai)</option>
                            <option value="keguguran" {{ old('status') === 'keguguran' ? 'selected' : '' }}>Keguguran</option>
                        </select>
                    </div>

                    <!-- Field: Data Pasangan (Relasi Model) -->
                    <div>
                        <label for="pasangan_id" class="block text-xs font-bold text-slate-700 mb-1">
                            Data Pasangan (Calon Ayah)
                        </label>
                        <select id="pasangan_id" name="pasangan_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition">
                            @foreach ($pasangans as $pasangan)
                                <option value="{{ $pasangan->id }}">{{ $pasangan->nama_lengkap }} ({{ $pasangan->hubungan ?? 'Suami' }})</option>
                            @endforeach
                            <option value="">+ Tambah Pasangan Baru...</option>
                        </select>
                    </div>
                </div>

                <!-- Input Pasangan Baru jika diperlukan -->
                <div id="rowPasanganBaru" class="hidden">
                    <label for="nama_pasangan_baru" class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Pasangan Baru</label>
                    <input type="text" id="nama_pasangan_baru" name="nama_pasangan_baru" placeholder="Contoh: Dimas Prasetyo" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition">
                </div>

                <!-- Interactive Live Calculation Preview -->
                <div id="previewKalkulasi" class="hidden bg-gradient-to-r from-pink-50 to-rose-50 border border-pink-200/80 rounded-2xl p-4 space-y-2">
                    <div class="flex items-center gap-1.5 text-[11px] font-bold text-brand-800">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Estimasi Otomatis Berdasarkan Rumus Naegele:</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center pt-1">
                        <div class="bg-white/80 p-2 rounded-xl border border-pink-100">
                            <div class="text-[9px] font-bold uppercase text-slate-400">Perkiraan Lahir (HPL)</div>
                            <div id="previewHpl" class="text-xs font-extrabold text-brand-700 mt-0.5">-</div>
                        </div>
                        <div class="bg-white/80 p-2 rounded-xl border border-pink-100">
                            <div class="text-[9px] font-bold uppercase text-slate-400">Usia Kehamilan</div>
                            <div id="previewUsia" class="text-xs font-extrabold text-slate-800 mt-0.5">-</div>
                        </div>
                        <div class="bg-white/80 p-2 rounded-xl border border-pink-100">
                            <div class="text-[9px] font-bold uppercase text-slate-400">Trimester</div>
                            <div id="previewTrimester" class="text-xs font-extrabold text-blue-700 mt-0.5">-</div>
                        </div>
                    </div>
                </div>

                <!-- Field Tambahan: Tinggi & Berat Badan Pra-Hamil -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tinggi_badan" class="block text-xs font-bold text-slate-700 mb-1">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" id="tinggi_badan" name="tinggi_badan" placeholder="Contoh: 160" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition">
                    </div>
                    <div>
                        <label for="berat_badan_pra_hamil" class="block text-xs font-bold text-slate-700 mb-1">Berat Badan Pra-Hamil (kg)</label>
                        <input type="number" step="0.1" id="berat_badan_pra_hamil" name="berat_badan_pra_hamil" placeholder="Contoh: 54" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition">
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label for="catatan" class="block text-xs font-bold text-slate-700 mb-1">Catatan Kondisi Awal</label>
                    <textarea id="catatan" name="catatan" rows="2" placeholder="Catatan tensi, konsumsi vitamin, atau kondisi kesehatan..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-medium text-slate-800 transition"></textarea>
                </div>

                <!-- Modal Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeModalTambah()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-800 to-rose-700 hover:from-brand-900 hover:to-rose-800 text-white font-bold text-xs shadow-md shadow-brand-900/20 transition">
                        Simpan Data Kehamilan
                    </button>
                </div>
            </form>
        </div>
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
                    Apakah Anda yakin ingin menghapus data kehamilan ini? Seluruh catatan terkait akan dihapus permanen.
                </p>
            </div>

            <!-- Actions -->
            <form id="formHapusKehamilan" action="" method="POST" class="flex items-center justify-center gap-3">
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

    <!-- Script Javascript Pendukung & Validasi Interaktif -->
    <script>
        function bukaDialogKonfirmasiHapus(id, nomor) {
            document.getElementById('formHapusKehamilan').action = `/data-kehamilan/${id}`;
            document.getElementById('pesanKonfirmasiHapus').innerHTML = `Apakah Anda yakin ingin menghapus data <strong>Kehamilan Ke-${nomor}</strong>? Seluruh catatan terkait akan dihapus permanen.`;
            document.getElementById('modalKonfirmasiHapus').classList.remove('hidden');
        }

        function tutupDialogKonfirmasiHapus() {
            document.getElementById('modalKonfirmasiHapus').classList.add('hidden');
        }
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openModalTambah() {
            document.getElementById('modalTambahKehamilan').classList.remove('hidden');
        }

        function closeModalTambah() {
            document.getElementById('modalTambahKehamilan').classList.add('hidden');
            hideErrorBanner();
        }

        document.getElementById('pasangan_id').addEventListener('change', function() {
            const rowBaru = document.getElementById('rowPasanganBaru');
            if (this.value === '') {
                rowBaru.classList.remove('hidden');
                document.getElementById('nama_pasangan_baru').focus();
            } else {
                rowBaru.classList.add('hidden');
            }
        });

        // Hitung perkiraan HPL, usia gestasi, dan trimester saat input HPHT berubah
        function hitungPerkiraanOtomatis() {
            const hphtVal = document.getElementById('hpht').value;
            if (!hphtVal) {
                document.getElementById('previewKalkulasi').classList.add('hidden');
                return;
            }

            const hphtDate = new Date(hphtVal);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Validasi Acceptance Criteria: HPHT tidak boleh melebihi hari ini
            if (hphtDate > today) {
                showErrorBanner("Tanggal HPHT tidak boleh melebihi tanggal hari ini.");
                document.getElementById('previewKalkulasi').classList.add('hidden');
                return;
            } else {
                hideErrorBanner();
            }

            // Rumus Naegele: HPHT + 280 hari
            const hplDate = new Date(hphtDate);
            hplDate.setDate(hplDate.getDate() + 280);

            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            const hplFormatted = hplDate.toLocaleDateString('id-ID', options);

            // Hitung usia kehamilan
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

            document.getElementById('previewHpl').textContent = hplFormatted;
            document.getElementById('previewUsia').textContent = `${weeks} Mg ${days} Hr`;
            document.getElementById('previewTrimester').textContent = trimester;
            document.getElementById('previewKalkulasi').classList.remove('hidden');
        }

        function showErrorBanner(message) {
            const banner = document.getElementById('modalErrorBanner');
            const msgEl = document.getElementById('modalErrorMessage');
            msgEl.textContent = message;
            banner.classList.remove('hidden');
        }

        function hideErrorBanner() {
            document.getElementById('modalErrorBanner').classList.add('hidden');
        }

        // Validasi Frontend terhadap Acceptance Criteria
        function validateFormKehamilan(e) {
            const hphtVal = document.getElementById('hpht').value;
            if (!hphtVal) {
                e.preventDefault();
                showErrorBanner("Tanggal HPHT wajib diisi.");
                return false;
            }

            const hphtDate = new Date(hphtVal);
            const today = new Date();
            today.setHours(23, 59, 59, 999);

            if (hphtDate > today) {
                e.preventDefault();
                showErrorBanner("Tanggal HPHT tidak boleh melebihi tanggal hari ini.");
                return false;
            }

            const kehamilanKe = document.getElementById('kehamilan_ke').value;
            if (!kehamilanKe || kehamilanKe < 1) {
                e.preventDefault();
                showErrorBanner("Kehamilan ke berapa wajib diisi dengan angka minimal 1.");
                return false;
            }

            return true;
        }

        function showDetailKehamilan(id) {
            fetch(`/data-kehamilan/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const item = data.data;
                        alert(`Detail Kehamilan Ke-${item.kehamilan_ke}\nHPHT: ${data.hpht_formatted}\nHPL: ${data.hpl_formatted}\nUsia Kehamilan: ${data.usia_kehamilan}\nTrimester: ${data.trimester}\nStatus: ${item.status}\nCatatan: ${item.catatan || '-'}`);
                    }
                })
                .catch(err => console.error(err));
        }

        function editKehamilan(id) {
            fetch(`/data-kehamilan/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const item = data.data;
                        openModalTambah();
                        document.getElementById('kehamilan_ke').value = item.kehamilan_ke;
                        document.getElementById('hpht').value = item.hpht.split('T')[0];
                        document.getElementById('status').value = item.status;
                        if (item.pasangan_id) {
                            document.getElementById('pasangan_id').value = item.pasangan_id;
                        }
                        if (item.tinggi_badan) {
                            document.getElementById('tinggi_badan').value = item.tinggi_badan;
                        }
                        if (item.berat_badan_pra_hamil) {
                            document.getElementById('berat_badan_pra_hamil').value = item.berat_badan_pra_hamil;
                        }
                        if (item.catatan) {
                            document.getElementById('catatan').value = item.catatan;
                        }
                        hitungPerkiraanOtomatis();
                    }
                });
        }
    </script>
</body>
</html>
