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
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- SIDEBAR TERPUSAT -->
    @include('components.user-sidebar', ['active' => 'rekomendasi-nutrisi'])

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- TOP HEADER -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20 sticky top-0">
            <div class="flex items-center gap-3">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition" title="Buka Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5 font-medium text-slate-600">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-semibold border border-blue-100">
                        Faskes: Posyandu Mawar 1 &amp; Puskesmas Sejahtera
                    </span>
                </div>
            </div>

            <!-- Profile & Family Pill -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-pink-50 border border-pink-100 text-xs font-semibold text-brand-700">
                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                    <span>Keluarga {{ $userName }}</span>
                </div>
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

        <!-- MAIN SCROLLABLE BODY -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 sm:p-6 lg:p-8 space-y-8 max-w-7xl w-full mx-auto">
            <!-- Breadcrumbs (Tanpa Tombol Tambah untuk Pengguna) -->
            <div class="flex items-center justify-between flex-wrap gap-2 text-xs text-slate-500">
                <div class="flex items-center gap-1.5 font-medium">
                    <a href="{{ route('dashboard.pengguna') }}" class="hover:text-brand-600 transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>
                    <span>&rsaquo;</span>
                    <span>Nutrisi &amp; Pantauan</span>
                    <span>&rsaquo;</span>
                    <span class="text-brand-600 font-bold">Rekomendasi Nutrisi</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                    <span>Terverifikasi Ahli Gizi &amp; Kemenkes RI</span>
                </div>
            </div>

            <!-- HERO BANNER -->
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
                                💊 Zat Besi &amp; Asam Folat
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 border border-slate-200/80 shadow-xs">
                                🛡️ Bebas Stunting
                            </span>
                        </div>
                    </div>

                    <!-- Right Illustration Banner -->
                    <div class="lg:col-span-5 flex justify-center lg:justify-end">
                        <div class="relative w-full max-w-sm rounded-2xl overflow-hidden shadow-md border-2 border-white bg-slate-100 aspect-video flex items-center justify-center group">
                            <img src="{{ asset('images/hero-family-organic.png') }}" 
                                 alt="Gizi Seimbang" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80';">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent flex items-end p-3">
                                <span class="text-[11px] font-bold text-white drop-shadow">Isi Piringku &amp; Menu Bergizi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FASE KRUSIAL NUTRISI: PILIH TAHAP KEHIDUPAN (DESAIN RAPI & PROPORSIONAL) -->
            <div class="space-y-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-rose-500 block">FASE KRUSIAL NUTRISI</span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Pilih Tahap Kehidupan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Klik salah satu tahap untuk memfilter rekomendasi gizi yang sesuai dengan kondisi keluarga Anda saat ini.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                    
                    <!-- FASE 1: PERSIAPAN KEHAMILAN -->
                    @php $isFase1 = ($activeFase === 'Persiapan Kehamilan'); @endphp
                    <a href="{{ $isFase1 ? route('informasi-nutrisi.index') : route('informasi-nutrisi.index', ['fase' => 'Persiapan Kehamilan']) }}" 
                       class="rounded-3xl p-5 sm:p-6 transition-all duration-300 flex flex-col justify-between cursor-pointer group {{ $isFase1 ? 'bg-gradient-to-b from-rose-50/80 via-pink-50/30 to-white border-2 border-[#b8235a] shadow-md shadow-pink-500/10' : 'bg-white border border-slate-200/90 hover:border-pink-300 hover:shadow-md' }}">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="w-11 h-11 rounded-2xl {{ $isFase1 ? 'bg-[#b8235a] text-white shadow-xs' : 'bg-rose-50 text-rose-600 group-hover:bg-rose-100' }} flex items-center justify-center font-bold text-lg transition">
                                    ❤️
                                </span>
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full {{ $isFase1 ? 'bg-[#b8235a] text-white shadow-2xs' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $isFase1 ? '✓ Aktif' : 'Fase 1' }}
                                </span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-brand-600 transition mb-1 leading-snug">
                                Persiapan Kehamilan
                            </h3>
                            <span class="text-[11px] font-bold text-rose-500 block mb-2.5">Prakonsepsi &amp; Calon Ibu</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Asupan asam folat, zat besi, seng, dan gizi seimbang untuk mempersiapkan ovulasi dan kualitas sel telur.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold {{ $isFase1 ? 'text-[#b8235a]' : 'text-slate-500 group-hover:text-brand-600' }}">
                            <span>{{ $isFase1 ? 'Sedang Ditampilkan' : 'Pilih Tahap Ini' }}</span>
                            <span class="text-sm font-semibold group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </a>

                    <!-- FASE 2: MASA KEHAMILAN -->
                    @php $isFase2 = ($activeFase === 'Masa Kehamilan'); @endphp
                    <a href="{{ $isFase2 ? route('informasi-nutrisi.index') : route('informasi-nutrisi.index', ['fase' => 'Masa Kehamilan']) }}" 
                       class="rounded-3xl p-5 sm:p-6 transition-all duration-300 flex flex-col justify-between cursor-pointer group {{ $isFase2 ? 'bg-gradient-to-b from-rose-50/80 via-pink-50/30 to-white border-2 border-[#b8235a] shadow-md shadow-pink-500/10' : 'bg-white border border-slate-200/90 hover:border-pink-300 hover:shadow-md' }}">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="w-11 h-11 rounded-2xl {{ $isFase2 ? 'bg-[#b8235a] text-white shadow-xs' : 'bg-pink-50 text-pink-600 group-hover:bg-pink-100' }} flex items-center justify-center font-bold text-lg transition">
                                    🤰
                                </span>
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full {{ $isFase2 ? 'bg-[#b8235a] text-white shadow-2xs' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $isFase2 ? '✓ Aktif' : 'Fase 2' }}
                                </span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-brand-600 transition mb-1 leading-snug">
                                Masa Kehamilan
                            </h3>
                            <span class="text-[11px] font-bold text-rose-500 block mb-2.5">Trimester 1, 2, &amp; 3</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Kebutuhan kalori tambahan, DHA, kalsium, dan protein hewani esensial untuk pembentukan organ janin.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold {{ $isFase2 ? 'text-[#b8235a]' : 'text-slate-500 group-hover:text-brand-600' }}">
                            <span>{{ $isFase2 ? 'Sedang Ditampilkan' : 'Pilih Tahap Ini' }}</span>
                            <span class="text-sm font-semibold group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </a>

                    <!-- FASE 3: IBU MENYUSUI -->
                    @php $isFase3 = ($activeFase === 'Ibu Menyusui'); @endphp
                    <a href="{{ $isFase3 ? route('informasi-nutrisi.index') : route('informasi-nutrisi.index', ['fase' => 'Ibu Menyusui']) }}" 
                       class="rounded-3xl p-5 sm:p-6 transition-all duration-300 flex flex-col justify-between cursor-pointer group {{ $isFase3 ? 'bg-gradient-to-b from-rose-50/80 via-pink-50/30 to-white border-2 border-[#b8235a] shadow-md shadow-pink-500/10' : 'bg-white border border-slate-200/90 hover:border-pink-300 hover:shadow-md' }}">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="w-11 h-11 rounded-2xl {{ $isFase3 ? 'bg-[#b8235a] text-white shadow-xs' : 'bg-sky-50 text-sky-600 group-hover:bg-sky-100' }} flex items-center justify-center font-bold text-lg transition">
                                    🍼
                                </span>
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full {{ $isFase3 ? 'bg-[#b8235a] text-white shadow-2xs' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $isFase3 ? '✓ Aktif' : 'Fase 3' }}
                                </span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-brand-600 transition mb-1 leading-snug">
                                Ibu Menyusui
                            </h3>
                            <span class="text-[11px] font-bold text-sky-600 block mb-2.5">Masa Laktasi / ASI Eksklusif</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Nutrisi pelancar ASI, hidrasi cairan cukup (+3 liter), vitamin A, dan nutrisi pemulihan pasca melahirkan.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold {{ $isFase3 ? 'text-[#b8235a]' : 'text-slate-500 group-hover:text-brand-600' }}">
                            <span>{{ $isFase3 ? 'Sedang Ditampilkan' : 'Pilih Tahap Ini' }}</span>
                            <span class="text-sm font-semibold group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </a>

                    <!-- FASE 4: TUMBUH KEMBANG ANAK -->
                    @php $isFase4 = ($activeFase === 'Tumbuh Kembang Anak'); @endphp
                    <a href="{{ $isFase4 ? route('informasi-nutrisi.index') : route('informasi-nutrisi.index', ['fase' => 'Tumbuh Kembang Anak']) }}" 
                       class="rounded-3xl p-5 sm:p-6 transition-all duration-300 flex flex-col justify-between cursor-pointer group {{ $isFase4 ? 'bg-gradient-to-b from-rose-50/80 via-pink-50/30 to-white border-2 border-[#b8235a] shadow-md shadow-pink-500/10' : 'bg-white border border-slate-200/90 hover:border-pink-300 hover:shadow-md' }}">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="w-11 h-11 rounded-2xl {{ $isFase4 ? 'bg-[#b8235a] text-white shadow-xs' : 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100' }} flex items-center justify-center font-bold text-lg transition">
                                    👶
                                </span>
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full {{ $isFase4 ? 'bg-[#b8235a] text-white shadow-2xs' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $isFase4 ? '✓ Aktif' : 'Fase 4' }}
                                </span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-brand-600 transition mb-1 leading-snug">
                                Tumbuh Kembang Anak
                            </h3>
                            <span class="text-[11px] font-bold text-emerald-600 block mb-2.5">MPASI &amp; Balita (0-5 Tahun)</span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Kepadatan energi tinggi, protein hewani (telur, ikan, daging) pencegah stunting dan pembentuk kecerdasan.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold {{ $isFase4 ? 'text-[#b8235a]' : 'text-slate-500 group-hover:text-brand-600' }}">
                            <span>{{ $isFase4 ? 'Sedang Ditampilkan' : 'Pilih Tahap Ini' }}</span>
                            <span class="text-sm font-semibold group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- SEARCH & FILTER BAR (DESAIN BARU: PINK THEME, EDITABLE, INTERAKTIF & JELAS) -->
            <div class="bg-white rounded-3xl p-4 sm:p-5 border-2 border-pink-100 shadow-sm shadow-pink-500/5 space-y-3">
                <form method="GET" action="{{ route('informasi-nutrisi.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                    <!-- Search input -->
                    <div class="sm:col-span-5 relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#b8235a]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" 
                               name="q" 
                               id="nutrisiSearchInput"
                               value="{{ $searchTerm }}" 
                               oninput="filterNutrisiLive()"
                               placeholder="Cari MPASI, makanan bergizi, zat besi, asam folat..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-white border-2 border-pink-200 hover:border-pink-300 focus:border-[#b8235a] focus:ring-4 focus:ring-pink-100 rounded-xl text-xs font-semibold text-slate-800 placeholder:text-pink-300 placeholder:font-normal shadow-2xs transition">
                    </div>

                    <!-- Custom Dropdown: Fase (Bertema Pink Penuh & Tanpa Abu-abu Bawaan Browser) -->
                    <div class="sm:col-span-3 relative" id="custom-dropdown-fase">
                        <input type="hidden" name="fase" id="inputFase" value="{{ $activeFase }}">
                        <button type="button" 
                                onclick="toggleCustomDropdown('fase')" 
                                class="w-full px-3.5 py-2.5 bg-white border-2 border-pink-200 hover:border-pink-300 focus:border-[#b8235a] focus:ring-4 focus:ring-pink-100 rounded-xl text-xs font-bold text-slate-800 shadow-2xs cursor-pointer transition flex items-center justify-between">
                            <span id="labelFase" class="truncate">{{ $activeFase ?: 'Semua Tahap Kehidupan' }}</span>
                            <svg id="arrowFase" class="w-4 h-4 text-[#b8235a] transition-transform duration-200 shrink-0 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Menu Dropdown Pink -->
                        <div id="menuFase" class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white rounded-2xl border-2 border-pink-100 shadow-xl shadow-pink-500/10 z-50 py-1.5 overflow-hidden">
                            <div onclick="selectCustomDropdown('fase', '', 'Semua Tahap Kehidupan')"
                                 class="px-3.5 py-2.5 text-xs font-bold cursor-pointer transition flex items-center justify-between {{ empty($activeFase) ? 'bg-gradient-to-r from-rose-50 to-pink-50 text-[#b8235a] border-l-4 border-[#b8235a]' : 'text-slate-700 hover:bg-pink-50/70 hover:text-[#b8235a]' }}">
                                <span>Semua Tahap Kehidupan</span>
                                @if(empty($activeFase))
                                    <span class="text-xs font-extrabold text-[#b8235a]">✓</span>
                                @endif
                            </div>
                            @foreach($daftarFase as $fKey => $fLabel)
                                @php $isSelected = ($activeFase === $fKey); @endphp
                                <div onclick="selectCustomDropdown('fase', '{{ $fKey }}', '{{ $fKey }}')"
                                     class="px-3.5 py-2.5 text-xs font-bold cursor-pointer transition flex items-center justify-between {{ $isSelected ? 'bg-gradient-to-r from-rose-50 to-pink-50 text-[#b8235a] border-l-4 border-[#b8235a]' : 'text-slate-700 hover:bg-pink-50/70 hover:text-[#b8235a]' }}">
                                    <span>{{ $fKey }}</span>
                                    @if($isSelected)
                                        <span class="text-xs font-extrabold text-[#b8235a]">✓</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Custom Dropdown: Kondisi (Bertema Pink Penuh & Tanpa Abu-abu Bawaan Browser) -->
                    <div class="sm:col-span-3 relative" id="custom-dropdown-kondisi">
                        <input type="hidden" name="kondisi" id="inputKondisi" value="{{ $activeKondisi }}">
                        <button type="button" 
                                onclick="toggleCustomDropdown('kondisi')" 
                                class="w-full px-3.5 py-2.5 bg-white border-2 border-pink-200 hover:border-pink-300 focus:border-[#b8235a] focus:ring-4 focus:ring-pink-100 rounded-xl text-xs font-bold text-slate-800 shadow-2xs cursor-pointer transition flex items-center justify-between">
                            <span id="labelKondisi" class="truncate">{{ $activeKondisi ?: 'Semua Kategori' }}</span>
                            <svg id="arrowKondisi" class="w-4 h-4 text-[#b8235a] transition-transform duration-200 shrink-0 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Menu Dropdown Pink -->
                        <div id="menuKondisi" class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white rounded-2xl border-2 border-pink-100 shadow-xl shadow-pink-500/10 z-50 py-1.5 overflow-hidden">
                            <div onclick="selectCustomDropdown('kondisi', '', 'Semua Kategori')"
                                 class="px-3.5 py-2.5 text-xs font-bold cursor-pointer transition flex items-center justify-between {{ empty($activeKondisi) ? 'bg-gradient-to-r from-rose-50 to-pink-50 text-[#b8235a] border-l-4 border-[#b8235a]' : 'text-slate-700 hover:bg-pink-50/70 hover:text-[#b8235a]' }}">
                                <span>Semua Kategori</span>
                                @if(empty($activeKondisi))
                                    <span class="text-xs font-extrabold text-[#b8235a]">✓</span>
                                @endif
                            </div>
                            @foreach($daftarKondisi as $kKey => $kLabel)
                                @php $isSelected = ($activeKondisi === $kKey); @endphp
                                <div onclick="selectCustomDropdown('kondisi', '{{ $kKey }}', '{{ $kKey }}')"
                                     class="px-3.5 py-2.5 text-xs font-bold cursor-pointer transition flex items-center justify-between {{ $isSelected ? 'bg-gradient-to-r from-rose-50 to-pink-50 text-[#b8235a] border-l-4 border-[#b8235a]' : 'text-slate-700 hover:bg-pink-50/70 hover:text-[#b8235a]' }}">
                                    <span>{{ $kKey }}</span>
                                    @if($isSelected)
                                        <span class="text-xs font-extrabold text-[#b8235a]">✓</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="sm:col-span-1 flex items-center gap-1">
                        <button type="submit" class="w-full py-2.5 px-3 bg-gradient-to-r from-[#b8235a] to-[#d83b75] hover:opacity-95 text-white rounded-xl text-xs font-bold transition flex items-center justify-center shadow-md shadow-pink-500/20 active:scale-95 cursor-pointer" title="Cari Rekomendasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>

                <div class="flex items-center justify-between text-[11px] text-slate-500 pt-2.5 border-t border-pink-100 flex-wrap gap-2">
                    <span class="flex items-center gap-1.5 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Menampilkan <strong id="visible-count" class="text-slate-800">{{ $nutrisis->count() }}</strong> rekomendasi nutrisi</span>
                        @if($activeFase)
                            untuk tahap <strong class="text-[#b8235a]">"{{ $activeFase }}"</strong>
                        @else
                            (seluruh tahap)
                        @endif
                    </span>
                    @if($searchTerm || $activeFase || $activeKondisi)
                        <a href="{{ route('informasi-nutrisi.index') }}" class="text-[#b8235a] hover:text-[#911644] font-bold flex items-center gap-1 transition">
                            <span>↺ Reset Filter &amp; Pencarian</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- KOLEKSI TERPILIH: REKOMENDASI UNTUK ANDA (Persis Gambar media_1795506220354_603ca97d.jpg) -->
            <div id="rekomendasi-grid" class="space-y-4 pt-2">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-rose-500 block">KOLEKSI TERPILIH</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Rekomendasi untuk Anda</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Konten edukasi umum berbasis pedoman gizi seimbang Kemenkes RI. Bukan pengganti anjuran/resep dokter/ahli gizi klinis.</p>
                </div>

                @if($nutrisis->isEmpty())
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center space-y-4 shadow-xs">
                        <div class="w-16 h-16 mx-auto rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-2xl">
                            🔍
                        </div>
                        <div class="max-w-md mx-auto">
                            <h3 class="text-base font-bold text-slate-900">Data Tidak Ditemukan</h3>
                            <p class="text-xs text-slate-500 mt-1">
                                Tidak ada rekomendasi nutrisi yang sesuai dengan filter atau kata kunci saat ini. Silakan coba tahap lain atau reset filter.
                            </p>
                            <a href="{{ route('informasi-nutrisi.index') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 rounded-full bg-[#b8235a] hover:bg-[#a01d4d] text-white font-bold text-xs shadow-xs transition">
                                ↺ Tampilkan Semua Rekomendasi
                            </a>
                        </div>
                    </div>
                @else
                    <div id="rekomendasi-grid-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($nutrisis as $item)
                            <div class="nutrisi-card bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between group"
                                 data-nama="{{ strtolower($item->nama_bahan_menu) }}"
                                 data-gizi="{{ strtolower($item->kandungan_gizi) }}"
                                 data-saran="{{ strtolower($item->saran_penggunaan) }}"
                                 data-manfaat="{{ strtolower($item->deskripsi_manfaat) }}"
                                 data-fase="{{ strtolower($item->kategori_fase) }}"
                                 data-kondisi="{{ strtolower($item->kategori_kondisi) }}">
                                <!-- Card Image & Badges -->
                                <div>
                                    <div class="relative h-52 bg-slate-100 overflow-hidden">
                                        <img src="{{ $item->foto ? $item->foto : 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80' }}" 
                                             alt="{{ $item->nama_bahan_menu }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=600&q=80';">
                                        
                                        <!-- Top Left Badges (Fase) -->
                                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 max-w-[80%]">
                                            <span class="text-[11px] font-bold px-3 py-1 rounded-full bg-[#b8235a] text-white shadow-xs backdrop-blur-xs">
                                                 {{ $item->kategori_fase }}
                                            </span>
                                        </div>

                                        <!-- Bottom Right Category Badge (Kondisi) -->
                                        <div class="absolute bottom-3 right-3">
                                            <span class="text-[11px] font-bold px-3 py-1 rounded-xl bg-white/95 text-slate-800 shadow-xs backdrop-blur-xs border border-slate-100">
                                                {{ $item->kategori_kondisi }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-5 sm:p-6 space-y-3">
                                        <!-- Kandungan Gizi Pill with Bolt Icon (Persis Gambar Referensi) -->
                                        <div class="flex items-center gap-1.5 text-xs font-bold text-sky-700">
                                            <span class="text-sky-600">⚡</span>
                                            <span class="truncate">{{ $item->kandungan_gizi }}</span>
                                        </div>

                                        <!-- Title -->
                                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 leading-snug group-hover:text-brand-600 transition line-clamp-2">
                                            {{ $item->nama_bahan_menu }}
                                        </h3>

                                        <!-- Description -->
                                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                            {{ $item->saran_penggunaan }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Card Footer: Tombol Baca Selengkapnya berbentuk Pill Pink Halus (Persis Gambar Referensi) -->
                                <div class="px-5 sm:px-6 pb-6 pt-2">
                                    <button 
                                        type="button" 
                                        onclick="openNutrisiDetail({{ $item->id }})" 
                                        class="w-full py-2.5 px-4 rounded-full bg-rose-50 hover:bg-rose-100 text-[#b8235a] font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer border border-rose-100/80 shadow-2xs group-hover:border-rose-200"
                                    >
                                        <span>Baca Selengkapnya</span>
                                        <span class="text-sm">📖</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <!-- Empty state untuk Live Search -->
                        <div id="live-empty-state" class="hidden col-span-full bg-white rounded-3xl border-2 border-dashed border-pink-200 p-12 text-center space-y-4 shadow-xs">
                            <div class="w-16 h-16 mx-auto rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-2xl">
                                🔍
                            </div>
                            <div class="max-w-md mx-auto">
                                <h3 class="text-base font-bold text-slate-900">Rekomendasi Tidak Ditemukan</h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    Tidak ada rekomendasi nutrisi yang cocok dengan pencarian kata kunci tersebut. Coba kata kunci lain seperti "ikan", "telur", "mpasi", atau "zat besi".
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- PEDOMAN PERILAKU HIDUP BERSIH & SEHAT: TIPS GIZI SEHARI-HARI (Persis Gambar media_1795506287454_320af4ab.png dan Berfungsi Penuh) -->
            <div class="space-y-4 pt-6 border-t border-slate-200/70">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-wider text-rose-500 block">PEDOMAN PERILAKU HIDUP BERSIH &amp; SEHAT</span>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tips Gizi Sehari-hari</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kebiasaan sederhana dalam dapur keluarga yang berdampak besar bagi pertumbuhan prima anak. Klik tiap tips untuk melihat panduan lengkapnya.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                    <!-- Tip 1: Konsumsi Beragam & Bervariasi -->
                    <div 
                        onclick="openTipsModal(0)" 
                        class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-pink-300 transition-all duration-300 cursor-pointer group flex flex-col justify-between space-y-3"
                    >
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                                🍱
                            </div>
                            <h4 class="text-sm font-extrabold text-slate-900 group-hover:text-brand-600 transition">
                                Konsumsi Beragam &amp; Bervariasi
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Tidak ada satu jenis makanan tunggal yang memiliki semua zat gizi lengkap. Kombinasikan lauk hewani, nabati, dan aneka sayur warna-warni setiap kali makan.
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 text-[11px] font-bold text-[#b8235a] flex items-center justify-between group-hover:text-brand-700">
                            <span>Buka Panduan Detail</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>

                    <!-- Tip 2: Kebersihan Bahan & Masak -->
                    <div 
                        onclick="openTipsModal(1)" 
                        class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-pink-300 transition-all duration-300 cursor-pointer group flex flex-col justify-between space-y-3"
                    >
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                                🧼
                            </div>
                            <h4 class="text-sm font-extrabold text-slate-900 group-hover:text-brand-600 transition">
                                Kebersihan Bahan &amp; Masak
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Cuci tangan pakai sabun, masak matang sempurna, dan pisahkan talenan daging mentah dengan makanan siap saji untuk mencegah infeksi diare pemicu stunting.
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 text-[11px] font-bold text-[#b8235a] flex items-center justify-between group-hover:text-brand-700">
                            <span>Buka Panduan Detail</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>

                    <!-- Tip 3: Porsi Sesuai Tahap Kehidupan -->
                    <div 
                        onclick="openTipsModal(2)" 
                        class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-pink-300 transition-all duration-300 cursor-pointer group flex flex-col justify-between space-y-3"
                    >
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                                ⚖️
                            </div>
                            <h4 class="text-sm font-extrabold text-slate-900 group-hover:text-brand-600 transition">
                                Porsi Sesuai Tahap Kehidupan
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Ibu hamil dan menyusui butuh tambahan kalori serta asam folat, sedangkan balita membutuhkan porsi kecil tapi sering dan bertekstur padat gizi hewani.
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 text-[11px] font-bold text-[#b8235a] flex items-center justify-between group-hover:text-brand-700">
                            <span>Buka Panduan Detail</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>

                    <!-- Tip 4: Konsultasi Tenaga Kesehatan -->
                    <div 
                        onclick="openTipsModal(3)" 
                        class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-pink-300 transition-all duration-300 cursor-pointer group flex flex-col justify-between space-y-3"
                    >
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                                🩺
                            </div>
                            <h4 class="text-sm font-extrabold text-slate-900 group-hover:text-brand-600 transition">
                                Konsultasi Tenaga Kesehatan
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Apabila balita mengalami kenaikan berat badan tidak memadai (weight faltering) atau ibu mengalami mual berlebih, segera temu bidan/dokter faskes terdekat.
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 text-[11px] font-bold text-[#b8235a] flex items-center justify-between group-hover:text-brand-700">
                            <span>Buka Panduan Detail</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- DETAIL REKOMENDASI NUTRISI MODAL -->
    <div id="detail-modal" class="fixed inset-0 bg-slate-900/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span id="modal-badge-fase" class="text-[11px] font-bold px-3 py-1 rounded-full bg-rose-100 text-rose-800">Fase</span>
                    <span id="modal-badge-kondisi" class="text-[11px] font-bold px-3 py-1 rounded-full bg-slate-100 text-slate-700">Kategori</span>
                </div>
                <button type="button" onclick="closeNutrisiDetail()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold text-lg transition cursor-pointer">&times;</button>
            </div>

            <div>
                <h3 id="modal-title" class="text-xl font-extrabold text-slate-900 leading-snug">Judul Bahan/Menu</h3>
            </div>

            <!-- Kandungan Gizi Utama -->
            <div class="p-4 rounded-2xl bg-sky-50/80 border border-sky-100 text-xs text-sky-950 space-y-1.5 shadow-2xs">
                <div class="font-bold text-sky-900 flex items-center gap-1.5">
                    <span>⚡</span>
                    <span>Kandungan Gizi Utama:</span>
                </div>
                <p id="modal-kandungan" class="text-xs font-semibold leading-relaxed"></p>
            </div>

            <!-- Saran Penggunaan / Porsi -->
            <div class="space-y-1.5">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Saran Penggunaan &amp; Anjuran Konsumsi:</h4>
                <p id="modal-saran" class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100 whitespace-pre-line"></p>
            </div>

            <!-- Deskripsi & Manfaat Klinis -->
            <div id="modal-manfaat-wrap" class="space-y-1.5 hidden">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Manfaat Klinis &amp; Pencegahan Stunting:</h4>
                <p id="modal-manfaat" class="text-xs text-slate-600 leading-relaxed bg-rose-50/40 p-4 rounded-2xl border border-rose-100/70 whitespace-pre-line"></p>
            </div>

            <div class="pt-3 flex justify-end">
                <button type="button" onclick="closeNutrisiDetail()" class="w-full sm:w-auto px-6 py-2.5 bg-[#b8235a] hover:bg-[#a01d4d] text-white font-bold text-xs rounded-full shadow-md transition cursor-pointer">
                    Tutup Panduan
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL PANDUAN TIPS GIZI SEHARI-HARI (BERFUNGSI LENGKAP) -->
    <div id="tips-modal" class="fixed inset-0 bg-slate-900/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div id="tips-modal-icon" class="w-11 h-11 rounded-2xl bg-rose-50 text-2xl flex items-center justify-center flex-shrink-0">
                        🍱
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-500">Panduan Perilaku Hidup Bersih &amp; Sehat</span>
                        <h3 id="tips-modal-title" class="text-lg font-extrabold text-slate-900 leading-tight">Judul Tips</h3>
                    </div>
                </div>
                <button type="button" onclick="closeTipsModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold text-lg transition cursor-pointer">&times;</button>
            </div>

            <!-- Subtitle -->
            <div class="p-3.5 rounded-2xl bg-pink-50/70 border border-pink-100 text-xs text-brand-900 font-semibold flex items-center gap-2">
                <span>💡</span>
                <span id="tips-modal-subtitle">Subjudul tips praktis keluarga</span>
            </div>

            <!-- Konten Penjelasan Utama -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Prinsip Penting:</h4>
                <p id="tips-modal-desc" class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100"></p>
            </div>

            <!-- Poin-poin Langkah Praktis -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Langkah Praktis Dapur Keluarga:</h4>
                <ul id="tips-modal-steps" class="space-y-2 text-xs text-slate-700">
                    <!-- diisi lewat JS -->
                </ul>
            </div>

            <!-- Pesan Tambahan / Catatan Ahli Gizi -->
            <div class="p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-100 text-xs text-emerald-900 space-y-1">
                <span class="font-bold flex items-center gap-1.5">🌟 Catatan Ahli Gizi Kemenkes:</span>
                <p id="tips-modal-note" class="text-xs leading-relaxed text-emerald-800"></p>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" onclick="closeTipsModal()" class="w-full sm:w-auto px-6 py-2.5 bg-[#b8235a] hover:bg-[#a01d4d] text-white font-bold text-xs rounded-full shadow-md transition cursor-pointer">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- JS SCRIPTS -->
    <script>
        // Data Interaktif untuk 4 Tips Gizi Sehari-hari
        const tipsData = [
            {
                icon: "🍱",
                title: "Konsumsi Beragam & Bervariasi",
                subtitle: "Pedoman Piring Sehat & Rotasi Menu Bergizi",
                desc: "Tidak ada satu jenis makanan tunggal yang memiliki semua zat gizi lengkap. Kunci tumbuh kembang prima anak adalah kombinasi seimbang antara protein hewani, protein nabati, karbohidrat kompleks, serat, dan aneka mikronutrien.",
                steps: [
                    "<strong>Sertakan Protein Hewani Setiap Makan:</strong> Prioritaskan telur ayam, ikan kembung, ayam, atau daging sapi karena asam amino esensial hewani lebih mudah diserap oleh tubuh balita dan ibu hamil.",
                    "<strong>Variasikan Warna Sayur & Buah:</strong> Pilih sayuran berwarna hijau tua (bayam, brokoli), oranye (wortel, labu), dan merah (tomat) untuk mencukupi kebutuhan vitamin A, C, dan antioksidan.",
                    "<strong>Batasi Gula, Garam, dan Lemak (GGL):</strong> Hindari makanan instan atau berpengawet tinggi pada masa kehamilan dan MPASI balita.",
                    "<strong>Rotasi Menu Mingguan:</strong> Ganti kombinasi menu setiap 2-3 hari agar anak tidak bosan dan asupan mikronutrien beragam."
                ],
                note: "Konsumsi protein hewani bersama makanan kaya vitamin C (seperti jeruk atau tomat) dapat meningkatkan penyerapan zat besi hingga 3 kali lipat untuk mencegah anemia."
            },
            {
                icon: "🧼",
                title: "Kebersihan Bahan & Masak",
                subtitle: "5 Kunci Keamanan Pangan Mencegah Infeksi & Diare",
                desc: "Penyakit infeksi berulang seperti diare dan cacingan adalah salah satu pemicu utama kegagalan pertumbuhan (growth faltering) yang berujung pada stunting. Menjaga higienitas makanan sama pentingnya dengan kandungan gizi makanan itu sendiri.",
                steps: [
                    "<strong>Cuci Tangan dengan Sabun:</strong> Cuci tangan di bawah air mengalir minimal 20 detik sebelum memegang bahan makanan, sebelum menyuapi anak, dan setelah dari kamar mandi.",
                    "<strong>Pisahkan Talenan & Pisau:</strong> Gunakan talenan terpisah untuk daging/ikan mentah dan makanan matang/sayuran siap santap guna mencegah kontaminasi silang bakteri.",
                    "<strong>Masak Hingga Matang Sempurna:</strong> Pastikan daging, ayam, telur, dan ikan dimasak hingga matang menyeluruh (suhu di atas 75°C) untuk membunuh kuman Salmonella dan parasit.",
                    "<strong>Gunakan Air Bersih & Bahan Segar:</strong> Selalu gunakan air matang untuk membilas peralatan makan bayi dan sayuran mentah.",
                    "<strong>Simpan Makanan dengan Benar:</strong> Jangan biarkan makanan matang berada di suhu ruang lebih dari 2 jam. Simpan dalam kulkas bertutup rapat."
                ],
                note: "Kebersihan peralatan makan balita dan air minum yang terjamin menurunkan risiko diare hingga 45%, melindungi berat badan anak agar tetap di garis hijau KMS."
            },
            {
                icon: "⚖️",
                title: "Porsi Sesuai Tahap Kehidupan",
                subtitle: "Penyesuaian Kalori & Tekstur Dari Hamil hingga Balita",
                desc: "Kebutuhan gizi bersifat spesifik pada setiap periode 1000 Hari Pertama Kehidupan. Mengatur porsi secara tepat mencegah kekurangan gizi (underweight) maupun kelebihan berat badan.",
                steps: [
                    "<strong>Ibu Hamil Trimester 1:</strong> Belum butuh porsi besar tambahan, namun wajib konsumsi asam folat 400-600 mcg dan makanan bertekstur lembut untuk mengatasi mual.",
                    "<strong>Ibu Hamil Trimester 2 & 3:</strong> Tambahkan 1 porsi makan selingan padat gizi (+300 kkal/hari) kaya zat besi dan kalsium untuk pertumbuhan pesat kerangka janin.",
                    "<strong>Ibu Menyusui:</strong> Butuh tambahan +500 kkal/hari dengan asupan cairan minimal 3 liter (10-12 gelas) air putih per hari agar volume ASI melimpah.",
                    "<strong>Balita MPASI (6-8 Bulan):</strong> Tekstur lumat kental (tidak cair), berikan 2-3 kali makan utama sehari (2-3 sendok makan bertahap) kaya zat besi.",
                    "<strong>Balita 9-11 Bulan:</strong> Tekstur cincang halus / finger food, berikan 3-4 kali sehari setengah mangkok kecil.",
                    "<strong>Balita 12-24 Bulan:</strong> Makanan keluarga dengan cita rasa tidak pedas, porsi 3/4 mangkok kecil 3-4 kali sehari ditambah 1-2 kali selingan."
                ],
                note: "Lambung balita masih berukuran kecil. Jangan berikan kuah sup berlebih tanpa lauk; utamakan kepadatan kalori dan protein hewani di setiap suapan."
            },
            {
                icon: "🩺",
                title: "Konsultasi Tenaga Kesehatan",
                subtitle: "Deteksi Dini Tumbuh Kembang & Suplementasi Nutrisi",
                desc: "Pemantauan rutin ke faskes memastikan setiap keterlambatan kenaikan berat badan atau tanda anemia dapat diintervensi sebelum terlambat menjadi stunting kronis.",
                steps: [
                    "<strong>Kunjungan Rutin Posyandu Tiap Bulan:</strong> Timbang berat badan dan ukur panjang/tinggi badan balita secara rutin sampai usia 5 tahun.",
                    "<strong>Waspadai 'Weight Faltering':</strong> Jika kenaikan berat badan balita tidak memenuhi garis target KBM pada KMS, segera konsultasi ke Bidan atau Dokter Puskesmas.",
                    "<strong>Pemeriksaan Kehamilan (ANC Minimal 6 Kali):</strong> 2 kali pada trimester 1 (oleh dokter dengan USG), 1 kali trimester 2, dan 3 kali trimester 3.",
                    "<strong>Dapatkan Suplementasi Program:</strong> Pastikan ibu hamil meminum Tablet Tambah Darah (TTD) minimal 90 tablet, dan balita mendapatkan Vitamin A (Februari & Agustus) serta obat cacing.",
                    "<strong>Tanyakan Konseling Gizi:</strong> Jangan ragu berkonsultasi mengenai keluhan balita sulit makan (GTM) atau alergi makanan di Poli Gizi Puskesmas terdekat."
                ],
                note: "Konsultasi gratis tersedia di Posyandu dan Puskesmas terdekat. Intervensi stunting paling efektif dilakukan sebelum anak berusia 2 tahun (periode emas HPK)."
            }
        ];

        // Fungsi Buka Modal Tips Gizi
        function openTipsModal(index) {
            const tip = tipsData[index];
            if (!tip) return;

            document.getElementById('tips-modal-icon').textContent = tip.icon;
            document.getElementById('tips-modal-title').textContent = tip.title;
            document.getElementById('tips-modal-subtitle').textContent = tip.subtitle;
            document.getElementById('tips-modal-desc').innerHTML = tip.desc;
            document.getElementById('tips-modal-note').textContent = tip.note;

            const stepsContainer = document.getElementById('tips-modal-steps');
            stepsContainer.innerHTML = '';
            tip.steps.forEach(step => {
                const li = document.createElement('li');
                li.className = 'flex items-start gap-2 bg-slate-50 p-3 rounded-2xl border border-slate-100';
                li.innerHTML = `<span class="text-rose-500 font-bold mt-0.5">•</span><span>${step}</span>`;
                stepsContainer.appendChild(li);
            });

            document.getElementById('tips-modal').classList.remove('hidden');
        }

        function closeTipsModal() {
            document.getElementById('tips-modal').classList.add('hidden');
        }

        // Nutrisi Detail Modal
        function openNutrisiDetail(id) {
            fetch(`/informasi-nutrisi/${id}`, {
                headers: { 
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
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

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeNutrisiDetail();
                closeTipsModal();
                closeAllCustomDropdowns();
            }
        });

        // Handler Custom Dropdown Bertema Pink Penuh (Bebas dari Abu-Abu Bawaan Browser)
        function toggleCustomDropdown(type) {
            const menuFase = document.getElementById('menuFase');
            const menuKondisi = document.getElementById('menuKondisi');
            const arrowFase = document.getElementById('arrowFase');
            const arrowKondisi = document.getElementById('arrowKondisi');

            if (type === 'fase') {
                const isClosed = menuFase.classList.contains('hidden');
                if (isClosed) {
                    menuFase.classList.remove('hidden');
                    if (arrowFase) arrowFase.classList.add('rotate-180');
                    if (menuKondisi) menuKondisi.classList.add('hidden');
                    if (arrowKondisi) arrowKondisi.classList.remove('rotate-180');
                } else {
                    menuFase.classList.add('hidden');
                    if (arrowFase) arrowFase.classList.remove('rotate-180');
                }
            } else if (type === 'kondisi') {
                const isClosed = menuKondisi.classList.contains('hidden');
                if (isClosed) {
                    menuKondisi.classList.remove('hidden');
                    if (arrowKondisi) arrowKondisi.classList.add('rotate-180');
                    if (menuFase) menuFase.classList.add('hidden');
                    if (arrowFase) arrowFase.classList.remove('rotate-180');
                } else {
                    menuKondisi.classList.add('hidden');
                    if (arrowKondisi) arrowKondisi.classList.remove('rotate-180');
                }
            }
        }

        function selectCustomDropdown(type, value, label) {
            if (type === 'fase') {
                const input = document.getElementById('inputFase');
                input.value = value;
                const labelEl = document.getElementById('labelFase');
                if (labelEl) labelEl.textContent = label;
                const menu = document.getElementById('menuFase');
                if (menu) menu.classList.add('hidden');
                const arrow = document.getElementById('arrowFase');
                if (arrow) arrow.classList.remove('rotate-180');
                input.closest('form').submit();
            } else if (type === 'kondisi') {
                const input = document.getElementById('inputKondisi');
                input.value = value;
                const labelEl = document.getElementById('labelKondisi');
                if (labelEl) labelEl.textContent = label;
                const menu = document.getElementById('menuKondisi');
                if (menu) menu.classList.add('hidden');
                const arrow = document.getElementById('arrowKondisi');
                if (arrow) arrow.classList.remove('rotate-180');
                input.closest('form').submit();
            }
        }

        function closeAllCustomDropdowns() {
            const menuFase = document.getElementById('menuFase');
            const menuKondisi = document.getElementById('menuKondisi');
            const arrowFase = document.getElementById('arrowFase');
            const arrowKondisi = document.getElementById('arrowKondisi');
            if (menuFase) menuFase.classList.add('hidden');
            if (menuKondisi) menuKondisi.classList.add('hidden');
            if (arrowFase) arrowFase.classList.remove('rotate-180');
            if (arrowKondisi) arrowKondisi.classList.remove('rotate-180');
        }

        // Tutup dropdown saat klik di luar elemen dropdown
        document.addEventListener('click', function(e) {
            const dropdownFase = document.getElementById('custom-dropdown-fase');
            const dropdownKondisi = document.getElementById('custom-dropdown-kondisi');

            if (dropdownFase && !dropdownFase.contains(e.target)) {
                const menu = document.getElementById('menuFase');
                const arrow = document.getElementById('arrowFase');
                if (menu) menu.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
            if (dropdownKondisi && !dropdownKondisi.contains(e.target)) {
                const menu = document.getElementById('menuKondisi');
                const arrow = document.getElementById('arrowKondisi');
                if (menu) menu.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        });

        // Live Search Real-time Instan & Cerdas
        function filterNutrisiLive() {
            const input = document.getElementById('nutrisiSearchInput');
            if (!input) return;
            const query = input.value.trim().toLowerCase();
            const cards = document.querySelectorAll('.nutrisi-card');
            const emptyState = document.getElementById('live-empty-state');
            const countDisplay = document.getElementById('visible-count');

            let visibleCount = 0;

            cards.forEach(card => {
                if (!query) {
                    card.classList.remove('hidden');
                    visibleCount++;
                    return;
                }

                const nama = card.getAttribute('data-nama') || '';
                const gizi = card.getAttribute('data-gizi') || '';
                const saran = card.getAttribute('data-saran') || '';
                const manfaat = card.getAttribute('data-manfaat') || '';
                const fase = card.getAttribute('data-fase') || '';
                const kondisi = card.getAttribute('data-kondisi') || '';

                const isMpasi = query.includes('mpasi');
                let match = false;
                if (nama.includes(query) || gizi.includes(query) || saran.includes(query) || manfaat.includes(query) || fase.includes(query) || kondisi.includes(query)) {
                    match = true;
                } else if (isMpasi || query.includes('balita') || query.includes('bayi') || /\banak\b/.test(query)) {
                    if (fase.includes('tumbuh kembang anak') || nama.includes('mpasi') || saran.includes('mpasi')) match = true;
                } else if (/\b(hamil|janin|bumil|trimester)\b/.test(query)) {
                    if (fase.includes('masa kehamilan')) match = true;
                } else if (!isMpasi && /\b(asi|laktasi|busui|menyusui)\b/.test(query)) {
                    if (fase.includes('ibu menyusui')) match = true;
                } else if (/\b(promil|subur|konsepsi|prakonsepsi)\b/.test(query)) {
                    if (fase.includes('persiapan kehamilan')) match = true;
                }

                if (match) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (countDisplay) {
                countDisplay.textContent = visibleCount;
            }

            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>
