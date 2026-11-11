<!DOCTYPE html>
@php
    $userName = $userName ?? (Auth::check() ? Auth::user()->name : 'Sarah Rahmawati');
    $userId = $userId ?? 'NGW-88291-JKT';
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
    $trimesterNomor = $calc['trimester']['nomor'];
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informasi Usia Kehamilan &amp; Trimester - NutriGrow</title>

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
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- LEFT SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
        <div class="p-5 overflow-y-auto flex-1 bg-transparent">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between mb-7 pl-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain transition group-hover:scale-102">
                </a>
            </div>

            <!-- Group: UTAMA -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">UTAMA</span>
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Group: DATA KELUARGA & PROFIL -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">DATA KELUARGA &amp; PROFIL</span>
                <nav class="space-y-1">
                    <a href="#data-pasangan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Data Pasangan</span>
                    </a>
                    
                    <a href="{{ route('kehamilan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-gradient-to-r from-brand-800 to-brand-700 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4 text-rose-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Data Kehamilan</span>
                    </a>

                    <a href="#data-anak" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Data Anak</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="p-4 border-t border-pink-100/60 bg-white/40 backdrop-blur-sm">
            <a href="{{ route('kehamilan.index') }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-slate-600 hover:text-brand-700 bg-white rounded-xl border border-pink-100 shadow-xs transition">
                <span>&larr; Kembali ke Daftar Kehamilan</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        
        <!-- HEADER -->
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-20 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200/80 text-[11px] font-medium text-slate-600">
                    <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $tanggalHariIni }}</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50/80 border border-blue-200/70 text-[11px] font-semibold text-blue-700">
                    <span>Faskes: {{ $faskesName }}</span>
                </div>
            </div>
            <div class="text-xs font-bold text-slate-700">{{ $userName }}</div>
        </header>

        <!-- MAIN CONTAINER -->
        <main class="p-4 sm:p-6 lg:p-8 max-w-5xl w-full mx-auto space-y-6">

            <!-- Breadcrumbs -->
            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-slate-600">Dashboard</a>
                <span>&rsaquo;</span>
                <a href="{{ route('kehamilan.index') }}" class="hover:text-slate-600">Data Kehamilan</a>
                <span>&rsaquo;</span>
                <span class="text-brand-700 font-bold">Informasi Usia &amp; Trimester Kehamilan Ke-{{ $kehamilan->kehamilan_ke }}</span>
            </div>

            <!-- Page Header Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-3xl bg-rose-50 border border-rose-100 text-brand-700 flex items-center justify-center font-bold shadow-xs flex-shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Kehamilan Ke-{{ $kehamilan->kehamilan_ke }}</h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-rose-50 text-brand-700 border border-rose-200">
                                {{ $calc['trimester']['badge'] }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-pink-100 text-brand-800">
                                <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                                <span>{{ ucfirst($kehamilan->status) }}</span>
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            Calon Ibu: <strong class="text-slate-700">{{ $kehamilan->user?->name ?? $userName }}</strong> &bull;
                            Pasangan: <strong class="text-slate-700">{{ $kehamilan->pasangan?->nama_lengkap ?? 'Dimas Prasetyo' }}</strong>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 self-start md:self-center">
                    <a href="{{ route('kehamilan.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                        &larr; Kembali
                    </a>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- SECTION 1: TRIPLE HIGHLIGHT CARDS -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                
                <!-- Card 1: Hari Perkiraan Lahir (HPL) -->
                <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-3xl p-5 border border-rose-100 shadow-xs relative overflow-hidden">
                    <div class="w-10 h-10 rounded-2xl bg-white text-brand-700 flex items-center justify-center shadow-xs mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Hari Perkiraan Lahir (HPL)</div>
                    <div class="text-lg font-black text-brand-900 mt-1">{{ $calc['hpl_formatted'] }}</div>
                    <div class="text-[11px] text-brand-700 font-semibold mt-1">
                        Sisa: <strong>{{ $calc['sisa_hari'] }} Hari</strong> (±{{ $calc['sisa_minggu'] }} Minggu)
                    </div>
                    <div class="text-[9px] text-slate-400 mt-2">Dihitung otomatis: HPHT + 280 hari (Rumus Naegele)</div>
                </div>

                <!-- Card 2: Usia Kehamilan Saat Ini -->
                <div class="bg-gradient-to-br from-slate-50 to-blue-50/50 rounded-3xl p-5 border border-slate-200 shadow-xs relative overflow-hidden">
                    <div class="w-10 h-10 rounded-2xl bg-white text-blue-700 flex items-center justify-center shadow-xs mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Usia Gestasi Saat Ini</div>
                    <div class="text-lg font-black text-slate-900 mt-1">{{ $calc['usia_kehamilan'] }}</div>
                    <div class="text-[11px] text-blue-700 font-semibold mt-1">
                        Total <strong>{{ $calc['total_hari'] }} Hari</strong> &bull; Progres <strong>{{ $calc['persentase'] }}%</strong>
                    </div>
                    <div class="text-[9px] text-slate-400 mt-2">HPHT: {{ $calc['hpht_formatted'] }}</div>
                </div>

                <!-- Card 3: Trimester Kehamilan -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50/60 rounded-3xl p-5 border border-blue-100 shadow-xs relative overflow-hidden">
                    <div class="w-10 h-10 rounded-2xl bg-white text-indigo-700 flex items-center justify-center shadow-xs mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kategori Trimester</div>
                    <div class="text-lg font-black text-indigo-900 mt-1">{{ $calc['trimester']['nama'] }}</div>
                    <div class="text-[11px] text-indigo-700 font-semibold mt-1">
                        Rentang: <strong>{{ $calc['trimester']['rentang'] }}</strong>
                    </div>
                    <div class="text-[9px] text-slate-400 mt-2">Standar klinis Kemenkes RI / WHO</div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- SECTION 2: INTERACTIVE TRIMESTER TIMELINE -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Garis Waktu &amp; Perkembangan Trimester</h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Pemantauan bertahap perjalanan 40 minggu kehamilan menuju persalinan sehat bebas stunting.</p>
                </div>

                <!-- Visual Bar Timeline -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                        <span>Minggu 1</span>
                        <span class="text-brand-700">Saat Ini: Minggu ke-{{ $calc['usia_minggu'] }} ({{ $calc['persentase'] }}%)</span>
                        <span>Minggu 40 (HPL)</span>
                    </div>

                    <!-- Progress Bar Container -->
                    <div class="relative w-full h-5 bg-slate-100 rounded-full overflow-hidden p-1 flex">
                        <!-- Trimester 1 Zone (1 - 13 wks = 32.5%) -->
                        <div class="h-full rounded-l-full bg-pink-200/80 relative" style="width: 32.5%;">
                            <span class="absolute inset-0 flex items-center justify-center text-[9px] font-bold text-slate-600">T1</span>
                        </div>
                        <!-- Trimester 2 Zone (14 - 27 wks = 35%) -->
                        <div class="h-full bg-rose-200/90 relative" style="width: 35%;">
                            <span class="absolute inset-0 flex items-center justify-center text-[9px] font-bold text-slate-600">T2</span>
                        </div>
                        <!-- Trimester 3 Zone (28 - 40 wks = 32.5%) -->
                        <div class="h-full rounded-r-full bg-blue-200/80 relative" style="width: 32.5%;">
                            <span class="absolute inset-0 flex items-center justify-center text-[9px] font-bold text-slate-600">T3</span>
                        </div>

                        <!-- Active Indicator Overlay -->
                        <div class="absolute top-0 bottom-0 left-0 bg-gradient-to-r from-brand-700 via-rose-500 to-pink-500 rounded-full transition-all duration-700 shadow-sm opacity-90" style="width: {{ $calc['persentase'] }}%;"></div>
                    </div>

                    <!-- Trimester Stages Legend Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                        <!-- T1 Block -->
                        <div class="p-4 rounded-2xl border {{ $trimesterNomor === 1 ? 'border-brand-500 bg-rose-50/60 ring-2 ring-brand-500/20' : 'border-slate-100 bg-slate-50/50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-extrabold {{ $trimesterNomor === 1 ? 'text-brand-700' : 'text-slate-700' }}">Trimester 1</span>
                                <span class="text-[10px] font-bold text-slate-400">1–13 Minggu</span>
                            </div>
                            <p class="text-[11px] text-slate-600 leading-relaxed font-medium">Pembentukan organ vital janin (organogenesis). Waspada mual &amp; penuhi asam folat.</p>
                            @if ($trimesterNomor === 1)
                                <span class="inline-block mt-2 text-[10px] font-extrabold text-brand-700 bg-brand-100/70 px-2.5 py-0.5 rounded-full">&bull; Fase Anda Saat Ini</span>
                            @endif
                        </div>

                        <!-- T2 Block -->
                        <div class="p-4 rounded-2xl border {{ $trimesterNomor === 2 ? 'border-brand-500 bg-rose-50/60 ring-2 ring-brand-500/20' : 'border-slate-100 bg-slate-50/50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-extrabold {{ $trimesterNomor === 2 ? 'text-brand-700' : 'text-slate-700' }}">Trimester 2</span>
                                <span class="text-[10px] font-bold text-slate-400">14–27 Minggu</span>
                            </div>
                            <p class="text-[11px] text-slate-600 leading-relaxed font-medium">Pertumbuhan pesat janin &amp; tulang. Mulai rasakan tendangan aktif, konsumsi zat besi rutin.</p>
                            @if ($trimesterNomor === 2)
                                <span class="inline-block mt-2 text-[10px] font-extrabold text-brand-700 bg-brand-100/70 px-2.5 py-0.5 rounded-full">&bull; Fase Anda Saat Ini</span>
                            @endif
                        </div>

                        <!-- T3 Block -->
                        <div class="p-4 rounded-2xl border {{ $trimesterNomor === 3 ? 'border-brand-500 bg-rose-50/60 ring-2 ring-brand-500/20' : 'border-slate-100 bg-slate-50/50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-extrabold {{ $trimesterNomor === 3 ? 'text-brand-700' : 'text-slate-700' }}">Trimester 3</span>
                                <span class="text-[10px] font-bold text-slate-400">28–40 Minggu</span>
                            </div>
                            <p class="text-[11px] text-slate-600 leading-relaxed font-medium">Pematangan paru janin &amp; persiapan kelahiran. Pantau gerakan janin dan tanda persalinan.</p>
                            @if ($trimesterNomor === 3)
                                <span class="inline-block mt-2 text-[10px] font-extrabold text-brand-700 bg-brand-100/70 px-2.5 py-0.5 rounded-full">&bull; Fase Anda Saat Ini</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- SECTION 3: MILESTONE JANIN & PANDUAN GIZI -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Card Perkembangan Janin -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                            🌽
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Perkembangan &amp; Ukuran Janin</h3>
                            <p class="text-xs text-slate-500">Estimasi fisik janin pada usia {{ $calc['usia_minggu'] }} minggu</p>
                        </div>
                    </div>

                    <div class="bg-amber-50/50 border border-amber-200/60 rounded-2xl p-4 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-amber-900">Ukuran Sebesar:</span>
                            <span class="text-xs font-extrabold text-amber-700">{{ $calc['milestone']['nama'] }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-center pt-1">
                            <div class="bg-white p-2.5 rounded-xl border border-amber-100">
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Panjang Janin</div>
                                <div class="text-xs font-extrabold text-slate-800 mt-0.5">{{ $calc['milestone']['panjang'] }}</div>
                            </div>
                            <div class="bg-white p-2.5 rounded-xl border border-amber-100">
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Berat Janin</div>
                                <div class="text-xs font-extrabold text-slate-800 mt-0.5">{{ $calc['milestone']['berat'] }}</div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed pt-2">
                            {{ $calc['milestone']['deskripsi'] }}
                        </p>
                    </div>

                    @if ($kehamilan->catatan)
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-xs text-slate-600">
                            <strong class="text-slate-800 block mb-0.5">Catatan Khusus Dokter / Bidan:</strong>
                            {{ $kehamilan->catatan }}
                        </div>
                    @endif
                </div>

                <!-- Card Panduan Gizi Trimester -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                            🥗
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Fokus Nutrisi {{ $calc['trimester']['nama'] }}</h3>
                            <p class="text-xs text-slate-500">Panduan pencegahan stunting &amp; kesehatan ibu</p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 font-medium">
                        {{ $calc['trimester']['fokus_kesehatan'] }}
                    </p>

                    <div class="space-y-2">
                        <div class="text-xs font-bold text-slate-800">Rekomendasi Asupan Harian:</div>
                        <ul class="space-y-2">
                            @foreach ($calc['trimester']['asupan_nutrisi'] as $nutrisi)
                                <li class="flex items-start gap-2.5 text-xs text-slate-700 bg-emerald-50/40 p-2.5 rounded-xl border border-emerald-100/70">
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $nutrisi }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

        </main>
    </div>

</body>
</html>
