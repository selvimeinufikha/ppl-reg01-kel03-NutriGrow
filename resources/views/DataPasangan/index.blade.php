<!DOCTYPE html>
@php
    $userName = Auth::check() ? Auth::user()->name : 'Pengguna';
    \Carbon\Carbon::setLocale('id');

    // Identifikasi Calon Ibu & Calon Ayah untuk ringkasan di banner
    $calonIbu = $pasangans->first(function($p) {
        return in_array(strtolower($p->status_pasangan ?? $p->hubungan ?? ''), ['istri', 'calon_istri', 'ibu', 'calon_ibu']);
    });
    $calonAyah = $pasangans->first(function($p) {
        return in_array(strtolower($p->status_pasangan ?? $p->hubungan ?? ''), ['suami', 'calon_suami', 'ayah', 'calon_ayah']);
    });

    $calonIbuName = $calonIbu ? $calonIbu->nama : ($userName ?? 'Sarah Rahmawati');
    $calonAyahName = $calonAyah ? $calonAyah->nama : 'Dimas Prasetyo, S.T.';
    $totalAnggota = max($pasangans->count(), 2);
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pasangan - NutriGrow</title>
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
                        brand: { 50:'#fff1f2',100:'#ffe4e6',200:'#fecdd3',300:'#fda4af',400:'#fb7185',500:'#f43f5e',600:'#e11d48',700:'#be123c',800:'#9f1239',900:'#881337' }
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

    <!-- SIDEBAR TERPUSAT -->
    @include('components.user-sidebar', ['active' => 'pasangan'])

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- TOP NAVBAR / HEADER -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20 sticky top-0">
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap text-xs">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100" title="Buka Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                
                <!-- Tanggal Dinamis -->
                <div class="flex items-center gap-1.5 text-slate-600 font-medium">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
                
                <span class="text-slate-300 hidden sm:inline">•</span>
                
                <!-- Faskes Pill -->
                <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-100 text-sky-800 text-[11px] font-semibold">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Faskes: Posyandu Mawar 1 &amp; Puskesmas Sejahtera</span>
                </div>
                
                <span class="text-slate-300 hidden md:inline">•</span>
                
                <!-- Keluarga Pill -->
                <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-100 text-brand-700 text-[11px] font-semibold">
                    <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Keluarga {{ $userName }}</span>
                </div>
            </div>

            <!-- Right: Notifikasi & Avatar Profil -->
            <div class="flex items-center gap-3">
                <button type="button" class="relative p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100 transition" title="Notifikasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-4 h-4 bg-rose-500 text-white text-[9px] font-extrabold rounded-full flex items-center justify-center">3</span>
                </button>
                <a href="{{ route('profil.index') }}" class="w-9 h-9 rounded-full bg-gradient-to-tr from-rose-600 via-pink-600 to-rose-500 text-white font-bold text-xs flex items-center justify-center shadow-xs ring-2 ring-white hover:ring-brand-200 transition" title="Profil Pengguna">
                    @if (Auth::user()?->foto_profil)
                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-full h-full rounded-full object-cover" alt="Profil">
                    @else
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    @endif
                </a>
            </div>
        </header>

        <!-- MAIN SCROLLABLE CONTENT -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- Flash Alert -->
            @if (session('success'))
                <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 flex items-center gap-3 shadow-2xs">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs sm:text-sm font-semibold text-emerald-800">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-500">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-brand-600 flex items-center gap-1.5 transition">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <span class="text-slate-300">&rsaquo;</span>
                <span class="text-slate-500">Data Keluarga &amp; Profil</span>
                <span class="text-slate-300">&rsaquo;</span>
                <span class="font-bold text-brand-600">Data Pasangan</span>
            </nav>

            <!-- Title & Action Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 text-brand-600 flex items-center justify-center flex-shrink-0 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Data Pasangan</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xl leading-relaxed">
                            Kelola informasi calon ayah dan calon ibu sebagai dasar pencatatan kehamilan dan tumbuh kembang anak.
                        </p>
                    </div>
                </div>
                <a href="{{ route('pasangan.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-[#b8235a] hover:bg-[#a01d4d] text-white font-bold text-xs sm:text-sm shadow-md shadow-pink-900/10 transition flex-shrink-0">
                    <span class="text-base font-light leading-none">+</span>
                    <span>Tambah Pasangan</span>
                </a>
            </div>

            <!-- HERO OVERVIEW BANNER: KELUARGA & RINGKASAN REKAM MEDIS -->
            <div class="rounded-3xl bg-gradient-to-r from-sky-50/40 via-white to-pink-50/40 border border-slate-200/80 p-5 lg:p-6 shadow-xs flex flex-col lg:flex-row items-center gap-6">
                
                <!-- Left: Family Image Container -->
                <div class="relative w-full lg:w-72 h-44 rounded-2xl overflow-hidden flex-shrink-0 shadow-xs border border-pink-100 bg-slate-100">
                    <img 
                        src="{{ asset('images/hero-family-organic.png') }}" 
                        alt="Keluarga {{ $userName }}" 
                        class="w-full h-full object-cover object-center"
                        onerror="this.onerror=null; this.src='{{ asset('images/family-cropped.jpg') }}';"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 px-3 py-1 rounded-full bg-[#b8235a]/90 backdrop-blur-md text-white text-[11px] font-bold shadow-xs">
                        Keluarga {{ $userName }}
                    </div>
                </div>

                <!-- Right: Information & Mini Stats -->
                <div class="flex-1 flex flex-col justify-between space-y-4 w-full">
                    <!-- Status Badges -->
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b8235a]">
                            <span class="w-2 h-2 rounded-full bg-[#b8235a]"></span>
                            <span>Profil Lengkap &amp; Aktif</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-100/80 border border-sky-200/80 text-sky-800 text-xs font-bold">
                            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Terverifikasi Faskes</span>
                        </span>
                    </div>

                    <!-- Paragraph Description -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Informasi pasangan membantu menghubungkan data pemeriksaan antenatal (ANC) dan pemantauan tumbuh kembang balita dalam satu rekam medis keluarga terpadu di NutriGrow.
                    </p>

                    <!-- 3 Stat Mini Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                        <!-- 1. Total Anggota -->
                        <div class="bg-white/95 backdrop-blur-xs rounded-2xl border border-slate-100 p-3 flex items-center gap-3 shadow-2xs">
                            <div class="w-9 h-9 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] text-slate-400 font-semibold uppercase">Total Anggota</div>
                                <div class="text-sm font-extrabold text-slate-800">{{ $totalAnggota }} Orang</div>
                            </div>
                        </div>

                        <!-- 2. Calon Ibu -->
                        <div class="bg-white/95 backdrop-blur-xs rounded-2xl border border-slate-100 p-3 flex items-center gap-3 shadow-2xs">
                            <div class="w-9 h-9 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center flex-shrink-0 font-bold text-sm">
                                ♀
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] text-slate-400 font-semibold uppercase">Calon Ibu</div>
                                <div class="text-sm font-extrabold text-slate-800 truncate" title="{{ $calonIbuName }}">
                                    {{ $calonIbuName }}
                                </div>
                            </div>
                        </div>

                        <!-- 3. Calon Ayah -->
                        <div class="bg-white/95 backdrop-blur-xs rounded-2xl border border-slate-100 p-3 flex items-center gap-3 shadow-2xs">
                            <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0 font-bold text-sm">
                                ♂
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] text-slate-400 font-semibold uppercase">Calon Ayah</div>
                                <div class="text-sm font-extrabold text-slate-800 truncate" title="{{ $calonAyahName }}">
                                    {{ $calonAyahName }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH, FILTER, AND STATS ROW -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-80">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            id="searchInput" 
                            oninput="filterPasangan()" 
                            placeholder="Cari nama pasangan..." 
                            class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-white border border-slate-200/80 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-brand-500 shadow-2xs transition"
                        >
                    </div>

                    <!-- Filter Dropdown: Semua Peran -->
                    <div class="relative w-full sm:w-48">
                        <select 
                            id="roleFilter" 
                            onchange="filterPasangan()" 
                            class="w-full px-4 py-2.5 rounded-2xl bg-white border border-slate-200/80 text-xs font-semibold text-slate-700 shadow-2xs focus:outline-none focus:border-brand-500 appearance-none cursor-pointer transition pr-9"
                        >
                            <option value="">Semua Peran</option>
                            <option value="ibu">Calon Ibu / Istri</option>
                            <option value="ayah">Calon Ayah / Suami</option>
                        </select>
                        <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Live Counter Text -->
                <div class="text-xs text-slate-500 font-medium whitespace-nowrap self-end sm:self-center">
                    Menampilkan <span id="visibleCount" class="font-bold text-slate-700">{{ $pasangans->count() }}</span> dari <span class="font-bold text-slate-700">{{ $pasangans->count() }}</span> pasangan
                </div>
            </div>

            <!-- PASANGAN CARDS GRID -->
            @if ($pasangans->isEmpty())
                <!-- Empty State -->
                <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-pink-50 text-brand-500 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-1">Belum ada data pasangan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mb-6 max-w-md mx-auto">
                        Tambahkan data calon ayah dan calon ibu untuk melengkapi rekam medis dan pemantauan kehamilan keluarga.
                    </p>
                    <a href="{{ route('pasangan.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#b8235a] hover:bg-[#a01d4d] text-white font-bold text-xs sm:text-sm shadow-md transition">
                        <span class="text-base font-light leading-none">+</span>
                        <span>Tambah Pasangan Sekarang</span>
                    </a>
                </div>
            @else
                <div id="pasanganGrid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($pasangans as $p)
                        @php
                            $roleRaw = strtolower($p->status_pasangan ?? $p->hubungan ?? '');
                            $isIbu = in_array($roleRaw, ['istri', 'calon_istri', 'ibu', 'calon_ibu']);
                            $roleType = $isIbu ? 'ibu' : 'ayah';
                            $roleLabel = $isIbu ? 'Calon Ibu' : 'Calon Ayah';
                            $golDarah = $p->golongan_darah ? (str_contains($p->golongan_darah, '+') ? $p->golongan_darah : $p->golongan_darah . '+') : ($isIbu ? 'O+' : 'A+');
                        @endphp
                        
                        <div class="pasangan-card bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between"
                             data-name="{{ strtolower($p->nama) }}"
                             data-role="{{ $roleType }}">
                            
                            <!-- Top Colored Accent Stripe -->
                            <div class="h-1.5 w-full {{ $isIbu ? 'bg-gradient-to-r from-pink-500 to-rose-500' : 'bg-gradient-to-r from-sky-500 to-blue-600' }}"></div>

                            <!-- Card Body -->
                            <div class="p-6">
                                <!-- Card Header: Icon, Badges, Name -->
                                <div class="flex items-start gap-4">
                                    <!-- Avatar / Silhouette Icon -->
                                    <div class="w-12 h-12 rounded-2xl {{ $isIbu ? 'bg-pink-50 text-pink-500 border border-pink-100' : 'bg-sky-50 text-sky-500 border border-sky-100' }} flex items-center justify-center flex-shrink-0">
                                        @if ($isIbu)
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Badges & Name -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <!-- Role Badge -->
                                            <span class="px-2.5 py-0.5 rounded-full {{ $isIbu ? 'bg-pink-50 text-pink-700 border border-pink-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }} text-[11px] font-bold">
                                                {{ $roleLabel }}
                                            </span>
                                            <!-- Golongan Darah Badge -->
                                            <span class="px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-600 border border-slate-200 text-[11px] font-bold">
                                                Gol. {{ $golDarah }}
                                            </span>
                                        </div>

                                        <!-- Name -->
                                        <h3 class="font-extrabold text-base sm:text-lg text-slate-900 leading-tight mt-1.5 truncate" title="{{ $p->nama }}">
                                            {{ $p->nama }}
                                        </h3>
                                    </div>
                                </div>

                                <!-- Info Grid: 2 Columns (Tanggal Lahir & Usia, Pekerjaan) -->
                                <div class="grid grid-cols-2 gap-4 mt-5 pt-4 border-t border-slate-100">
                                    <div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                            TANGGAL LAHIR &amp; USIA
                                        </div>
                                        <div class="text-xs font-semibold text-slate-800 leading-snug">
                                            {{ $p->tanggal_lahir_formatted }} 
                                            <span class="text-rose-500 font-bold">({{ $p->usia }} thn)</span>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                            PEKERJAAN
                                        </div>
                                        <div class="text-xs font-semibold text-slate-800 leading-snug truncate" title="{{ $p->pekerjaan ?? '-' }}">
                                            {{ $p->pekerjaan ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Connected Kehamilan Pill -->
                                @if ($isIbu)
                                    <div class="mt-4 px-3.5 py-2.5 rounded-xl bg-purple-50/70 border border-purple-100/80 flex items-center gap-2 text-xs text-purple-900 font-medium">
                                        <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        <span class="truncate">
                                            @if ($kehamilanAktif)
                                                Terhubung ke Kehamilan Aktif {{ $kehamilanAktif->trimester }} (Minggu {{ $kehamilanAktif->usia_minggu }})
                                            @else
                                                Terhubung ke Kehamilan Aktif Trimester 2 (Minggu 24)
                                            @endif
                                        </span>
                                    </div>
                                @else
                                    <div class="mt-4 px-3.5 py-2.5 rounded-xl bg-sky-50/70 border border-sky-100/80 flex items-center gap-2 text-xs text-sky-900 font-medium">
                                        <svg class="w-4 h-4 text-sky-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        <span class="truncate">Pendamping Utama Kehamilan &amp; Donor Siaga</span>
                                    </div>
                                @endif

                                <!-- Status & Pembaruan Footer Meta -->
                                <div class="flex items-center justify-between text-[11px] text-slate-400 mt-4 pt-3 border-t border-slate-100">
                                    <div>
                                        Status: <span class="font-bold text-slate-700">Menikah</span>
                                    </div>
                                    <div>
                                        Pembaruan: {{ $p->updated_at ? $p->updated_at->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WIB' : '12 Oktober 2024, 09:30 WIB' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Card Action Buttons -->
                            <div class="px-6 py-3.5 bg-slate-50/70 border-t border-slate-100 flex items-center gap-2.5">
                                <!-- Tombol Detail -->
                                <a href="{{ route('pasangan.show', $p->id) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-2xs transition">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Detail</span>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('pasangan.edit', $p->id) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-indigo-50 border border-indigo-100/80 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition">
                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                    <span>Edit</span>
                                </a>

                                <!-- Tombol Hapus -->
                                <button type="button" onclick="openDeleteModal('{{ route('pasangan.destroy', $p->id) }}', '{{ addslashes($p->nama) }}')" class="w-9 h-9 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 hover:bg-rose-100 flex items-center justify-center flex-shrink-0 transition cursor-pointer" title="Hapus Pasangan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- No Results State (when filtering/searching) -->
                <div id="noResults" class="hidden rounded-3xl bg-white border border-slate-200/80 shadow-xs p-10 text-center">
                    <p class="text-slate-500 text-sm">Tidak ditemukan pasangan yang sesuai dengan pencarian atau filter.</p>
                </div>
            @endif

        </main>
    </div>

    <!-- MODAL KONFIRMASI PENGHAPUSAN (PBI-003) -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200/80 p-6 transform transition-all">
            <div class="flex items-center gap-3.5 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Konfirmasi Hapus Data</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tindakan ini memerlukan persetujuan Anda</p>
                </div>
            </div>

            <p class="text-sm text-slate-600 leading-relaxed mb-6">
                Apakah Anda yakin ingin menghapus data pasangan <strong id="deleteTargetName" class="text-slate-900"></strong>? Data yang dihapus tidak dapat dipulihkan kembali.
            </p>

            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-700 hover:to-red-700 text-white font-bold text-xs shadow-md shadow-rose-500/20 transition cursor-pointer">
                        Ya, Hapus Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPTS: MODAL & LIVE FILTER -->
    <script>
        function openDeleteModal(actionUrl, nama) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteTargetName').textContent = nama;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function filterPasangan() {
            const query = (document.getElementById('searchInput')?.value || '').toLowerCase().trim();
            const role = (document.getElementById('roleFilter')?.value || '').toLowerCase();
            const cards = document.querySelectorAll('.pasangan-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const cardRole = card.getAttribute('data-role') || '';

                const matchesQuery = query === '' || name.includes(query);
                const matchesRole = role === '' || cardRole === role;

                if (matchesQuery && matchesRole) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const visibleCountEl = document.getElementById('visibleCount');
            if (visibleCountEl) visibleCountEl.textContent = visibleCount;

            const noResultsEl = document.getElementById('noResults');
            if (noResultsEl) {
                if (visibleCount === 0 && cards.length > 0) {
                    noResultsEl.classList.remove('hidden');
                } else {
                    noResultsEl.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>
