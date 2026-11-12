<!DOCTYPE html>
@php
    $userName = auth()->user()->name ?? 'Keluarga Sarah Rahmawati';
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekomendasi Nutrisi - NutriGrow</title>

    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#fff1f2', 100: '#ffe4e6', 200: '#fecdd3', 300: '#fda4af',
                            400: '#fb7185', 500: '#f43f5e', 600: '#e11d48', 700: '#be123c',
                            800: '#9f1239', 900: '#881337',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden">

    <!-- MOBILE OVERLAY -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 z-30 hidden lg:hidden backdrop-blur-xs transition-opacity"></div>

    <!-- LEFT SIDEBAR (Persis seperti mockup screenshot) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
        <div class="p-5 overflow-y-auto flex-1 bg-transparent">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between mb-7 pl-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain">
                </a>
                <button id="close-sidebar-btn" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-white/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Profile Tag -->
            <div class="px-2 mb-6">
                <span class="inline-block text-[11px] font-semibold text-rose-500 bg-rose-50/80 px-2 py-0.5 rounded-md border border-rose-100">Kesehatan Ibu & Anak</span>
            </div>

            <!-- NAVIGATION GROUPS -->
            <nav class="space-y-6">
                <!-- UTAMA -->
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">UTAMA</span>
                    <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- DATA KELUARGA & PROFIL -->
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">DATA KELUARGA & PROFIL</span>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span>Data Pasangan</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>Data Kehamilan</span>
                        </a>
                        <a href="{{ route('data-anak.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Data Anak</span>
                        </a>
                    </div>
                </div>

                <!-- REKAM MEDIS -->
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">REKAM MEDIS</span>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Pemeriksaan Kehamilan</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span>Tumbuh Kembang Anak</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span>Reminder Pemeriksaan</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Layanan Kesehatan</span>
                        </a>
                    </div>
                </div>

                <!-- NUTRISI & PANDUAN (ACTIVE) -->
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">NUTRISI & PANDUAN</span>
                    <div class="space-y-1">
                        <a href="{{ route('informasi-nutrisi.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-brand-800 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Rekomendasi Nutrisi</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Risiko Stunting</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Edukasi Gizi</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- BOTTOM CARD (Sintesa Poskes) -->
        <div class="p-4 border-t border-sky-100/60 bg-transparent space-y-3">
            <div class="bg-white/80 backdrop-blur-xs p-3 rounded-2xl border border-sky-100/80 shadow-xs">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-800">Sintesa Poskes</span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed">Terhubung ke Posyandu Melati 1 & Puskesmas Sejahtera</p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-rose-600 hover:bg-rose-50/60 transition">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- TOP HEADER -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <div class="flex items-center gap-3">
                <button id="open-sidebar-btn" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5 font-medium text-slate-600">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Rabu, 24 Mei 2026
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-semibold border border-blue-100">
                        Poskes: Posyandu Melati 1 & Puskesmas Sejahtera
                    </span>
                </div>
            </div>

            <!-- Profile & Notification -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-50 border border-rose-100 text-xs font-semibold text-rose-700">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>{{ $userName }}</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs border border-rose-200">
                    {{ substr($userName, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- MAIN SCROLLABLE BODY -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6">
            <!-- Breadcrumbs -->
            <div class="flex items-center justify-between flex-wrap gap-2 text-xs text-slate-500">
                <div class="flex items-center gap-1.5 font-medium">
                    <a href="{{ route('dashboard.pengguna') }}" class="hover:text-brand-600 transition">Dashboard</a>
                    <span>/</span>
                    <span>Nutrisi & Panduan</span>
                    <span>/</span>
                    <span class="text-brand-600 font-semibold">Rekomendasi Nutrisi</span>
                </div>

                <!-- Admin Action: Tambah Rekomendasi Nutrisi -->
                <a href="{{ route('admin.informasi-nutrisi.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs shadow-sm transition hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>+ Tambah Informasi Nutrisi</span>
                </a>
            </div>

            <!-- Flash Success Message -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
                </div>
            @endif

            <!-- HERO BANNER (Persis desain screenshot) -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-rose-50/90 via-pink-50/60 to-purple-50/40 border border-pink-100 p-6 sm:p-8 lg:p-10 shadow-xs">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    <div class="lg:col-span-7 space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-100/80 text-brand-800 text-xs font-bold border border-rose-200/80">
                            <span>🌱 Panduan 1000 Hari Pertama Kehidupan (HPK)</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Rekomendasi Nutrisi
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-xl">
                            Temukan informasi dan rekomendasi gizi untuk mendukung kesehatan ibu serta tumbuh kembang anak dari masa prakonsepsi hingga 1000 Hari Pertama Kehidupan demi generasi bebas stunting.
                        </p>
                        <div class="flex flex-wrap items-center gap-2 pt-1 text-[11px] font-semibold text-slate-600">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 border border-slate-200/80 shadow-xs">
                                🐟 Kaya Protein Hewani
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 border border-slate-200/80 shadow-xs">
                                💊 Zat Besi & Asam Folat
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 border border-slate-200/80 shadow-xs">
                                🛡️ Bebas Stunting
                            </span>
                        </div>
                    </div>

                    <!-- Right Illustration Banner -->
                    <div class="lg:col-span-5 flex justify-center lg:justify-end">
                        <div class="relative w-full max-w-sm rounded-2xl overflow-hidden shadow-md border-2 border-white bg-slate-100 aspect-video flex items-center justify-center group">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80" alt="Gizi Seimbang" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent flex items-end p-3">
                                <span class="text-[11px] font-bold text-white drop-shadow">Isi Piringku & Menu Bergizi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FASE KRUSIAL NUTRISI: PILIH TAHAP KEHIDUPAN (4 Cards) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-wider text-rose-500 block">FASE KRUSIAL NUTRISI</span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">Pilih Tahap Kehidupan</h2>
                        <p class="text-xs text-slate-500">Sesuaikan rekomendasi nutrisi dengan fase kesehatan Anda dan keluarga saat ini.</p>
                    </div>
                    @if($activeFase)
                        <a href="{{ route('informasi-nutrisi.index') }}" class="text-xs font-semibold text-brand-700 hover:underline">
                            Tampilkan Semua Tahap &rarr;
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- FASE 1: PERSIAPAN KEHAMILAN -->
                    <div class="rounded-2xl border p-4 bg-white transition hover:shadow-md flex flex-col justify-between {{ $activeFase === 'Persiapan Kehamilan' ? 'ring-2 ring-brand-700 border-brand-700' : 'border-slate-200/80' }}">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-sm">
                                    ❤️
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">Fase 1</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 mb-0.5">Persiapan Kehamilan</h3>
                            <span class="text-[10px] font-semibold text-rose-500 block mb-2">Prakonsepsi & Calon Ibu</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Asupan asam folat, zat besi, seng, dan gizi seimbang untuk...
                            </p>
                        </div>
                        <div class="pt-4 mt-2">
                            <a href="{{ route('informasi-nutrisi.index', ['fase' => 'Persiapan Kehamilan']) }}" class="w-full inline-flex items-center justify-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl transition {{ $activeFase === 'Persiapan Kehamilan' ? 'bg-brand-800 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                                <span>Lihat Rekomendasi</span>
                                <span class="text-xs">&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- FASE 2: MASA KEHAMILAN (ACTIVE / HIGHLIGHT IN MOCKUP) -->
                    <div class="rounded-2xl border p-4 bg-white transition hover:shadow-md flex flex-col justify-between {{ ($activeFase === 'Masa Kehamilan' || !$activeFase) ? 'ring-2 ring-brand-700 border-brand-700' : 'border-slate-200/80' }}">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-sm">
                                    🤰
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-rose-700">Fase 2 (Aktif)</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 mb-0.5">Masa Kehamilan</h3>
                            <span class="text-[10px] font-semibold text-rose-500 block mb-2">Trimester 1, 2, & 3</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Kebutuhan kalori tambahan, DHA, kalsium dan protein esensial untuk...
                            </p>
                        </div>
                        <div class="pt-4 mt-2">
                            <a href="{{ route('informasi-nutrisi.index', ['fase' => 'Masa Kehamilan']) }}" class="w-full inline-flex items-center justify-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl transition {{ ($activeFase === 'Masa Kehamilan' || !$activeFase) ? 'bg-brand-800 text-white shadow-sm' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                                <span>Lihat Rekomendasi</span>
                                <span class="text-xs">&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- FASE 3: IBU MENYUSUI -->
                    <div class="rounded-2xl border p-4 bg-white transition hover:shadow-md flex flex-col justify-between {{ $activeFase === 'Ibu Menyusui' ? 'ring-2 ring-brand-700 border-brand-700' : 'border-slate-200/80' }}">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-sm">
                                    🍼
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">Fase 3</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 mb-0.5">Ibu Menyusui</h3>
                            <span class="text-[10px] font-semibold text-sky-600 block mb-2">Masa Laktasi / ASI Eksklusif</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Nutrisi pelancar ASI, hidrasi cairan cukup, vitamin A, dan nutrisi pemulihan...
                            </p>
                        </div>
                        <div class="pt-4 mt-2">
                            <a href="{{ route('informasi-nutrisi.index', ['fase' => 'Ibu Menyusui']) }}" class="w-full inline-flex items-center justify-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl transition {{ $activeFase === 'Ibu Menyusui' ? 'bg-brand-800 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                                <span>Lihat Rekomendasi</span>
                                <span class="text-xs">&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- FASE 4: TUMBUH KEMBANG ANAK -->
                    <div class="rounded-2xl border p-4 bg-white transition hover:shadow-md flex flex-col justify-between {{ $activeFase === 'Tumbuh Kembang Anak' ? 'ring-2 ring-brand-700 border-brand-700' : 'border-slate-200/80' }}">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                                    👶
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">Fase 4</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 mb-0.5">Tumbuh Kembang Anak</h3>
                            <span class="text-[10px] font-semibold text-emerald-600 block mb-2">MPASI & Balita (0-5 Tahun)</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Kepadatan energi tinggi, protein hewani (telur, ikan, daging) pencegah stunting...
                            </p>
                        </div>
                        <div class="pt-4 mt-2">
                            <a href="{{ route('informasi-nutrisi.index', ['fase' => 'Tumbuh Kembang Anak']) }}" class="w-full inline-flex items-center justify-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl transition {{ $activeFase === 'Tumbuh Kembang Anak' ? 'bg-brand-800 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                                <span>Lihat Rekomendasi</span>
                                <span class="text-xs">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH & FILTER BAR -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs space-y-3">
                <form method="GET" action="{{ route('informasi-nutrisi.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                    <!-- Search input -->
                    <div class="sm:col-span-5 relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="q" value="{{ $searchTerm }}" placeholder="Cari makanan kaya gizi, zat besi, cegah stunting..." class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white">
                    </div>

                    <!-- Fase select -->
                    <div class="sm:col-span-3">
                        <select name="fase" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="">Semua Tahap Kehidupan</option>
                            @foreach($daftarFase as $fKey => $fLabel)
                                <option value="{{ $fKey }}" {{ $activeFase === $fKey ? 'selected' : '' }}>{{ $fKey }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kondisi select -->
                    <div class="sm:col-span-3">
                        <select name="kondisi" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="">Semua Kategori</option>
                            @foreach($daftarKondisi as $kKey => $kLabel)
                                <option value="{{ $kKey }}" {{ $activeKondisi === $kKey ? 'selected' : '' }}>{{ $kKey }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="sm:col-span-1 flex items-center gap-1">
                        <button type="submit" class="w-full p-2 bg-brand-800 hover:bg-brand-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>

                <div class="flex items-center justify-between text-[11px] text-slate-500 pt-1 border-t border-slate-100">
                    <span class="flex items-center gap-1.5 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Menampilkan <strong class="text-slate-800">{{ $nutrisis->count() }}</strong> rekomendasi nutrisi terverifikasi
                    </span>
                    <a href="{{ route('informasi-nutrisi.index') }}" class="text-rose-600 hover:underline font-medium">
                        ↺ Reset Filter
                    </a>
                </div>
            </div>

            <!-- KOLEKSI TERPILIH: REKOMENDASI UNTUK ANDA -->
            <div class="space-y-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-rose-500 block">KOLEKSI TERPILIH</span>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Rekomendasi untuk Anda</h2>
                    <p class="text-xs text-slate-500">Konten edukasi umum berbasis pedoman gizi seimbang Kemenkes RI. Bukan pengganti anjuran/resep dokter/ahli gizi klinis.</p>
                </div>

                @if($nutrisis->isEmpty())
                    <div class="bg-white rounded-3xl border border-dashed border-slate-200 p-12 text-center space-y-4">
                        <div class="w-16 h-16 mx-auto rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-2xl">
                            🥗
                        </div>
                        <div class="max-w-md mx-auto">
                            <h3 class="text-sm font-bold text-slate-800">Belum Ada Informasi Nutrisi</h3>
                            <p class="text-xs text-slate-500 mt-1">
                                Belum ada data nutrisi yang sesuai dengan pencarian atau filter saat ini.
                            </p>
                        </div>
                        <a href="{{ route('admin.informasi-nutrisi.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-800 text-white font-bold text-xs shadow-sm hover:bg-brand-900 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            <span>Tambah Informasi Nutrisi Pertama</span>
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($nutrisis as $item)
                            <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between group">
                                <!-- Card Image & Badges -->
                                <div>
                                    <div class="relative h-44 bg-slate-100 overflow-hidden">
                                        <img src="{{ $item->foto ? $item->foto : 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $item->nama_bahan_menu }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        
                                        <!-- Top Left Badges -->
                                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 max-w-[85%]">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-600/90 text-white shadow-xs backdrop-blur-xs">
                                                {{ $item->kategori_fase }}
                                            </span>
                                        </div>

                                        <!-- Top Right Category Badge -->
                                        <div class="absolute top-3 right-3">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-900/80 text-white shadow-xs backdrop-blur-xs">
                                                {{ $item->kategori_kondisi }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-5 space-y-3">
                                        <!-- Kandungan Gizi pill -->
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200/60 text-[11px] font-semibold text-amber-900">
                                            <span>⚡</span>
                                            <span class="truncate max-w-[240px]">{{ $item->kandungan_gizi }}</span>
                                        </div>

                                        <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-brand-700 transition">
                                            {{ $item->nama_bahan_menu }}
                                        </h3>

                                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                            {{ $item->saran_penggunaan }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Card Footer Action -->
                                <div class="px-5 pb-5 pt-2 border-t border-slate-100 flex items-center gap-2">
                                    <button onclick="openNutrisiDetail({{ $item->id }})" class="flex-1 py-2.5 px-3 rounded-xl bg-rose-50 hover:bg-rose-100/80 text-brand-800 font-bold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                                        <span>Baca Selengkapnya</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                    </button>
                                    <a href="{{ route('informasi-nutrisi.edit', $item->id) }}" class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition" title="Edit Data Nutrisi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDeleteUserNutrisi({{ $item->id }}, '{{ addslashes($item->nama_bahan_menu) }}')" class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus Data Nutrisi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- PEDOMAN PERILAKU HIDUP BERSIH & SEHAT: TIPS GIZI SEHARI-HARI (4 Cards at bottom of screenshot) -->
            <div class="space-y-4 pt-2">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-rose-500 block">PEDOMAN PERILAKU HIDUP BERSIH & SEHAT</span>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Tips Gizi Sehari-hari</h2>
                    <p class="text-xs text-slate-500">Kebiasaan sederhana dalam dapur keluarga yang berdampak besar bagi pertumbuhan prima anak.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="w-9 h-9 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-sm">
                            🍱
                        </div>
                        <h4 class="text-xs font-bold text-slate-900">Konsumsi Beragam & Bervariasi</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Tidak ada satu jenis makanan tunggal yang memiliki semua zat gizi lengkap. Kombinasikan lauk hewani, nabati, dan aneka sayur warna-warni setiap kali makan.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                            🧼
                        </div>
                        <h4 class="text-xs font-bold text-slate-900">Kebersihan Bahan & Masak</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Cuci tangan pakai sabun, masak matang sempurna, dan pisahkan talenan daging mentah dengan makanan siap saji untuk mencegah infeksi diare pemicu stunting.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-sm">
                            ⚖️
                        </div>
                        <h4 class="text-xs font-bold text-slate-900">Porsi Sesuai Tahap Kehidupan</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Ibu hamil dan menyusui butuh tambahan kalori serta asam folat, sedangkan balita membutuhkan porsi kecil tapi sering dan bertekstur padat gizi hewani.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                            🩺
                        </div>
                        <h4 class="text-xs font-bold text-slate-900">Konsultasi Tenaga Kesehatan</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Apabila balita mengalami kenaikan berat badan tidak memadai (weight faltering) atau ibu mengalami mual berlebih, segera temu bidan/dokter faskes terdekat.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- DETAIL MODAL -->
    <div id="detail-modal" class="fixed inset-0 bg-slate-900/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <span id="modal-badge-fase" class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800">Fase</span>
                <button onclick="closeNutrisiDetail()" class="text-slate-400 hover:text-slate-700 text-lg font-bold">&times;</button>
            </div>

            <div>
                <span id="modal-badge-kondisi" class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Kategori</span>
                <h3 id="modal-title" class="text-lg font-bold text-slate-900 leading-snug">Judul Bahan/Menu</h3>
            </div>

            <div class="p-3 rounded-2xl bg-amber-50/80 border border-amber-200/70 text-xs text-amber-900 space-y-1">
                <strong class="font-bold flex items-center gap-1.5">⚡ Kandungan Gizi Utama:</strong>
                <p id="modal-kandungan" class="text-xs"></p>
            </div>

            <div class="space-y-1">
                <h4 class="text-xs font-bold text-slate-700">Saran Penggunaan / Anjuran Konsumsi:</h4>
                <p id="modal-saran" class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-2xl border border-slate-100 whitespace-pre-line"></p>
            </div>

            <div id="modal-manfaat-wrap" class="space-y-1 hidden">
                <h4 class="text-xs font-bold text-slate-700">Deskripsi & Manfaat Kesehatan:</h4>
                <p id="modal-manfaat" class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-2xl border border-slate-100 whitespace-pre-line"></p>
            </div>

            <div class="pt-3 flex justify-end">
                <button onclick="closeNutrisiDetail()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- JS SCRIPTS -->
    <script>
        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openBtn = document.getElementById('open-sidebar-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');

        if (openBtn) {
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            });
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }
        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }

        // Nutrisi Detail Modal
        function openNutrisiDetail(id) {
            fetch(`/informasi-nutrisi/${id}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data;
                    document.getElementById('modal-title').textContent = data.nama_bahan_menu;
                    document.getElementById('modal-badge-fase').textContent = data.kategori_fase;
                    document.getElementById('modal-badge-kondisi').textContent = data.kategori_kondisi;
                    document.getElementById('modal-kandungan').textContent = data.kandungan_gizi;
                    document.getElementById('modal-saran').textContent = data.saran_penggunaan;

                    const manfaatWrap = document.getElementById('modal-manfaat-wrap');
                    if (data.deskripsi_manfaat) {
                        document.getElementById('modal-manfaat').textContent = data.deskripsi_manfaat;
                        manfaatWrap.classList.remove('hidden');
                    } else {
                        manfaatWrap.classList.add('hidden');
                    }

                    document.getElementById('detail-modal').classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
            });
        }

        function closeNutrisiDetail() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        function confirmDeleteUserNutrisi(id, name) {
            document.getElementById('delete-user-item-name').textContent = '"' + name + '"';
            document.getElementById('delete-user-form').action = '/informasi-nutrisi/' + id;
            document.getElementById('delete-user-modal').classList.remove('hidden');
        }

        function closeDeleteUserModal() {
            document.getElementById('delete-user-modal').classList.add('hidden');
        }
    </script>

    <!-- DIALOG KONFIRMASI PENGHAPUSAN (PBI-026) -->
    <div id="delete-user-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto text-xl">
                🗑️
            </div>

            <div class="text-center space-y-1">
                <h3 class="text-base font-extrabold text-slate-900">Konfirmasi Penghapusan</h3>
                <p class="text-xs text-slate-500">
                    Apakah Anda yakin ingin menghapus informasi nutrisi <strong id="delete-user-item-name" class="text-slate-800"></strong> dari rekomendasi? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <form id="delete-user-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <button type="button" onclick="closeDeleteUserModal()" class="w-full py-2.5 px-4 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
