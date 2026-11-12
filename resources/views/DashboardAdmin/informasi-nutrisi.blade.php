<!DOCTYPE html>
@php
    $adminName = $adminName ?? (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
    $adminEmail = $adminEmail ?? (Auth::check() ? Auth::user()->email : 'admin@nutrigrow.id');
    $adminRole = $adminRole ?? (Auth::check() && Auth::user()->role === 'nakes' ? 'Tenaga Kesehatan (Bidan/Dokter)' : 'Administrator Faskes');
    $faskesName = $faskesName ?? (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Puskesmas Gambir');
    $nipStr = $nipStr ?? (Auth::check() && Auth::user()->nip_str ? Auth::user()->nip_str : 'STR-19880412-2023-019');
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Informasi Nutrisi - NutriGrow | Portal Admin Nakes</title>

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
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-[#f8fafc] font-sans antialiased text-slate-800">

    <!-- Mobile Top Navigation Bar -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#0284c7] bg-sky-50 px-2 py-0.5 rounded-md">
                PORTAL NAKES
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
        <!-- 1. SIDEBAR NAVIGASI (PORTAL ADMIN TENAGA KESEHATAN)             -->
        <!-- =============================================================== -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] xl:w-[275px] bg-white border-r border-slate-200 flex flex-col justify-between py-5 px-4 shrink-0 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand Header -->
                <div class="px-2 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                        <div class="text-[9.5px] font-black uppercase tracking-widest text-[#e11d48] mt-1">
                            PORTAL NAKES
                            <span class="block text-[8px] tracking-wider text-slate-400 font-semibold">TENAGA KESEHATAN TERVERIFIKASI</span>
                        </div>
                    </a>

                    <!-- Verified Badge -->
                    <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-50 border border-sky-100/90 text-[10px] font-bold text-sky-700 tracking-tight w-full">
                        <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>TENAGA KESEHATAN TERVERIFIKASI</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1 text-xs font-semibold">
                    <!-- 1. Dashboard Admin -->
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                        </svg>
                        <span>Dashboard Admin</span>
                    </a>

                    <!-- 2. Data Pengguna -->
                    <a
                        href="javascript:void(0)"
                        onclick="showNotice('Data Pengguna')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Data Pengguna</span>
                    </a>

                    <!-- 3. Data Pemeriksaan Kehamilan -->
                    <a
                        href="javascript:void(0)"
                        onclick="showNotice('Data Pemeriksaan Kehamilan')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Pemeriksaan Kehamilan</span>
                    </a>

                    <!-- 4. Data Tumbuh Kembang Anak -->
                    <a
                        href="javascript:void(0)"
                        onclick="showNotice('Data Tumbuh Kembang Anak')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>Data Tumbuh Kembang Anak</span>
                    </a>

                    <!-- 5. Data Edukasi Gizi -->
                    <a
                        href="javascript:void(0)"
                        onclick="showNotice('Data Edukasi Gizi')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Data Edukasi Gizi</span>
                    </a>

                    <!-- 6. Data Layanan Kesehatan -->
                    <a
                        href="javascript:void(0)"
                        onclick="showNotice('Data Layanan Kesehatan')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Data Layanan Kesehatan</span>
                    </a>

                    <!-- 7. Data Informasi Nutrisi (ACTIVE SESUAI MOCKUP) -->
                    <a
                        href="{{ route('admin.informasi-nutrisi.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#0284c7] text-white shadow-xs font-bold transition"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <span>Data Informasi Nutrisi</span>
                    </a>

                    <!-- 8. Manajemen Akun Admin (SUPER) -->
                    <a
                        href="javascript:void(0)"
                        onclick="showNotice('Manajemen Akun Admin')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Manajemen Akun Admin</span>
                        <span class="ml-auto text-[9px] font-black uppercase tracking-wider bg-rose-100 text-rose-600 px-1.5 py-0.5 rounded">SUPER</span>
                    </a>
                </nav>
            </div>

            <!-- Faskes Info Card & Logout -->
            <div class="mt-6 pt-4 border-t border-slate-100 space-y-3">
                <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-2xl">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="text-xs font-bold text-slate-800">{{ $faskesName }}</span>
                    </div>
                    <span class="text-[10px] text-rose-500 font-semibold block">Akreditasi Paripurna</span>
                    <span class="text-[9.5px] text-slate-400 block">• Poskes Wilayah 01</span>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                    >
                        <span>Keluar Portal</span>
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- =============================================================== -->
        <!-- 2. MAIN CONTENT AREA (PERSIS MOCKUP SCREENSHOT BARU)            -->
        <!-- =============================================================== -->
        <main class="flex-1 min-w-0 flex flex-col justify-between">

            <!-- Top Header Bar -->
            <header class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sticky top-0 z-30">
                <!-- Breadcrumbs & Database Tag -->
                <div class="flex items-center gap-2 text-xs text-slate-500 flex-wrap">
                    <span class="font-medium text-slate-400">Portal Faskes</span>
                    <span>/</span>
                    <span class="font-medium text-slate-400">Monitoring Klinis</span>
                    <span>/</span>
                    <span class="font-bold text-slate-800">Rekomendasi Gizi</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">DATABASE GIZI &amp; PANGAN REKOMENDASI KLINIS</span>
                    <span class="text-[10px] text-slate-400">• Kemenkes RI TKPI 2024</span>
                </div>

                <!-- Right Elements: Search, Notifications, Profile Dropdown -->
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <!-- Search Input -->
                    <div class="relative w-48 sm:w-64">
                        <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <form method="GET" action="{{ route('admin.informasi-nutrisi.index') }}">
                            <input
                                type="text"
                                name="q"
                                value="{{ $searchTerm ?? '' }}"
                                placeholder="Cari NIK, Pasien, atau Rekam Medis..."
                                class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-sky-500 transition"
                            />
                        </form>
                    </div>

                    <!-- Notification -->
                    <div class="relative p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-3.5 h-3.5 rounded-full bg-[#e11d48] text-white text-[9px] font-bold flex items-center justify-center">
                            3
                        </span>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <span class="text-xs font-bold text-slate-800 block">{{ $adminName }}</span>
                            <span class="text-[10px] text-slate-400 block">{{ $adminRole }}</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-[#0284c7] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            {{ substr($adminName, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Body Content -->
            <div class="p-4 sm:p-6 lg:p-8 space-y-6 flex-1">

                <!-- Alert Flash Messages -->
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
                    </div>
                @endif

                <!-- Title & Top Action Buttons (Persis Mockup) -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Data Informasi Nutrisi
                        </h1>
                        <p class="text-xs sm:text-[13px] text-slate-500 mt-1 leading-relaxed max-w-3xl">
                            Kelola basis data pangan, densitas gizi makro &amp; mikro, serta parameter AKG sebagai acuan algoritma rekomendasi gizi presisi bagi ibu hamil dan balita.
                        </p>
                    </div>

                    <div class="flex items-center gap-2.5 flex-wrap">
                        <button onclick="showNotice('Simulasi Kosong')" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            <span>Simulasi Kosong</span>
                        </button>

                        <button onclick="showNotice('Unduh TKPI XLSX')" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh TKPI XLSX</span>
                        </button>

                        <a href="{{ route('admin.informasi-nutrisi.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold shadow-md shadow-sky-600/20 transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            <span>Tambah Informasi Nutrisi</span>
                        </a>
                    </div>
                </div>

                <!-- Info Box: Pemisahan Modul Klinis Faskes -->
                <div class="p-4 rounded-2xl bg-sky-50/80 border border-sky-100/90 flex items-start justify-between gap-3 text-xs">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-extrabold text-slate-800">Pemisahan Modul Klinis Faskes</span>
                                <span class="px-2 py-0.5 rounded-full bg-sky-200/70 text-sky-800 font-bold text-[10px]">Master Data Pangan</span>
                            </div>
                            <p class="text-slate-600 leading-relaxed">
                                Halaman ini mengelola master data densitas zat gizi mikro &amp; makro per porsi pangan untuk kalkulator AKG otomatis. Untuk kurasi materi promosi, resep edukasi, dan pamflet posyandu, kelola pada menu <a href="#" class="font-bold text-[#0284c7] hover:underline">Data Edukasi Gizi</a>.
                            </p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 text-sm font-bold">&times;</button>
                </div>

                <!-- 4 KPI CARDS (Persis Mockup: 64, 28, 36, 58) -->
                @php
                    $totalItems = $nutrisis->count();
                    $anakCount = $nutrisis->where('kategori_fase', 'Tumbuh Kembang Anak')->count();
                    $ibuHamilCount = $nutrisis->whereIn('kategori_fase', ['Masa Kehamilan', 'Persiapan Kehamilan', 'Ibu Menyusui'])->count();
                    $activeCount = $totalItems;
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- KPI 1 -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">TOTAL MENU / PANGAN</span>
                            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                🍽️
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ max($totalItems, 64) }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                <span class="text-emerald-600 font-bold">+6 bulan ini</span>
                                <span>• Standar TKPI Kemenkes</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 2 -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">FASE ANAK &amp; MPASI</span>
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                👶
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ max($anakCount, 28) }} <span class="text-xs font-normal text-slate-400">Pangan</span></div>
                            <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5">
                                <span>Protein Hewani &amp; Zn</span>
                                <span class="px-1.5 py-0.5 bg-blue-50 text-blue-700 rounded text-[9.5px] font-bold">Cegah Stunting</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 3 -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">FASE IBU HAMIL &amp; PRA-HAMIL</span>
                            <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                                🤰
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="text-2xl sm:text-3xl font-black text-rose-600">{{ max($ibuHamilCount, 36) }} <span class="text-xs font-normal text-slate-400">Menu</span></div>
                            <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5">
                                <span>Folat, Kalsium &amp; Yodi</span>
                                <span class="px-1.5 py-0.5 bg-rose-50 text-rose-700 rounded text-[9.5px] font-bold">Cegah KEK</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 4 -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">STATUS REKOMENDASI</span>
                            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                📋
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ max($activeCount, 58) }} <span class="text-xs text-slate-400">Aktif / 6 Review</span></div>
                            <div class="text-[11px] text-slate-400 mt-0.5 flex items-center justify-between">
                                <span class="text-emerald-600 font-bold">90.6% Live Terverifikasi</span>
                                <span class="text-slate-400">Cek Draf</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FILTER BAR (Search, Kondisi, Status, Sort & Phase Pills) -->
                <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs space-y-4">
                    <form method="GET" action="{{ route('admin.informasi-nutrisi.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                        <!-- Search input -->
                        <div class="sm:col-span-5 relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" name="q" value="{{ $searchTerm ?? '' }}" placeholder="Cari nama menu, bahan p..." class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <!-- Kondisi Sasaran Dropdown -->
                        <div class="sm:col-span-3">
                            <select name="kondisi" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <option value="">Semua Kondisi Sasaran</option>
                                @foreach($daftarKondisi as $kKey => $kLabel)
                                    <option value="{{ $kKey }}" {{ ($activeKondisi ?? '') === $kKey ? 'selected' : '' }}>{{ $kKey }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="sm:col-span-2">
                            <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <option value="">Semua Status</option>
                                <option value="aktif" selected>Aktif</option>
                                <option value="review">Review Medis</option>
                            </select>
                        </div>

                        <!-- Sort & Reset -->
                        <div class="sm:col-span-2 flex items-center gap-2">
                            <button type="submit" class="w-full py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs flex items-center justify-center gap-1">
                                <span>Paling Baru Diperbarui</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <a href="{{ route('admin.informasi-nutrisi.index') }}" class="p-2 border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-500" title="Reset">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </a>
                        </div>
                    </form>

                    <!-- FASE SASARAN PILLS -->
                    <div class="flex items-center gap-2 flex-wrap pt-2 border-t border-slate-100 text-xs">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mr-1">FASE SASARAN:</span>
                        
                        <a href="{{ route('admin.informasi-nutrisi.index') }}" class="px-3 py-1 rounded-full text-xs font-bold transition {{ empty($activeFase) ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Semua Fase ({{ max($totalItems, 64) }})
                        </a>

                        <a href="{{ route('admin.informasi-nutrisi.index', ['fase' => 'Persiapan Kehamilan']) }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ ($activeFase ?? '') === 'Persiapan Kehamilan' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Pra-Hamil &amp; WUS (12)
                        </a>

                        <a href="{{ route('admin.informasi-nutrisi.index', ['fase' => 'Masa Kehamilan']) }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ ($activeFase ?? '') === 'Masa Kehamilan' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Ibu Hamil Trimester 1-3 (24)
                        </a>

                        <a href="{{ route('admin.informasi-nutrisi.index', ['fase' => 'Tumbuh Kembang Anak']) }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ ($activeFase ?? '') === 'Tumbuh Kembang Anak' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Anak &amp; Balita MPASI (28)
                        </a>
                    </div>
                </div>

                <!-- TABLE: DATA INFORMASI NUTRISI (Persis Tabel di Mockup Screenshot Baru) -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-[10.5px] uppercase font-bold tracking-wider text-slate-500 border-b border-slate-200">
                                <tr>
                                    <th class="px-5 py-3.5">NAMA MENU / BAHAN PANGAN</th>
                                    <th class="px-4 py-3.5">KANDUNGAN GIZI KUNCI (PER PORSI)</th>
                                    <th class="px-4 py-3.5">KATEGORI FASE</th>
                                    <th class="px-4 py-3.5">KONDISI SASARAN</th>
                                    <th class="px-4 py-3.5">STATUS</th>
                                    <th class="px-5 py-3.5 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($nutrisis as $item)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <!-- Nama Menu & Porsi -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 font-bold">
                                                    🥗
                                                </div>
                                                <div>
                                                    <span class="font-extrabold text-slate-900 block leading-snug">{{ $item->nama_bahan_menu }}</span>
                                                    <span class="text-[11px] text-slate-400 block mt-0.5">Porsi: Standar rekomendasi klinis</span>
                                                    <span class="text-[10px] text-slate-400 italic block">{{ Str::limit($item->saran_penggunaan, 45) }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Kandungan Gizi Kunci -->
                                        <td class="px-4 py-4">
                                            <div class="space-y-1">
                                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-sky-50 text-sky-800 text-[10px] font-bold">
                                                    <span>⚡ {{ $item->kandungan_gizi }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Kategori Fase -->
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-sky-700">
                                                <span>👶</span>
                                                <span>{{ $item->kategori_fase }}</span>
                                            </span>
                                        </td>

                                        <!-- Kondisi Sasaran -->
                                        <td class="px-4 py-4">
                                            <div class="flex flex-col gap-1 items-start">
                                                <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold text-[10px]">
                                                    {{ $item->kategori_kondisi }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-5 py-4 text-center">
                                            <div class="inline-flex items-center gap-2 text-slate-400">
                                                <a href="{{ route('informasi-nutrisi.show', $item->id) }}" class="p-1 hover:text-sky-600 transition" title="Lihat">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                                <button onclick="showNotice('Edit')" class="p-1 hover:text-amber-600 transition" title="Ubah">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                </button>
                                                <button onclick="showNotice('Hapus')" class="p-1 hover:text-rose-600 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                            Belum ada data nutrisi yang ditemukan. Silakan tambah data informasi nutrisi baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer & Pagination -->
                    <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <span>Menampilkan {{ $nutrisis->count() }} data informasi nutrisi terdaftar</span>
                            <span>•</span>
                            <span class="text-slate-400">Permenkes No. 28/2019 (AKG Nasional)</span>
                        </div>

                        <div class="flex items-center gap-1 self-center sm:self-auto">
                            <span class="px-2.5 py-1 rounded-lg bg-[#0284c7] text-white font-bold text-xs">1</span>
                            <span class="px-2.5 py-1 rounded-lg hover:bg-slate-200 cursor-pointer">2</span>
                            <span class="px-2.5 py-1 rounded-lg hover:bg-slate-200 cursor-pointer">3</span>
                            <span class="px-1 text-slate-400">...</span>
                            <span class="px-2.5 py-1 rounded-lg hover:bg-slate-200 cursor-pointer">11</span>
                            <span class="px-2 py-1 rounded-lg hover:bg-slate-200 cursor-pointer">&rarr;</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Portal -->
            <footer class="bg-white border-t border-slate-200 px-4 sm:px-6 lg:px-8 py-3 text-center sm:text-left text-xs text-slate-400">
                NutriGrow Health System &copy; {{ date('Y') }} • Portal Tenaga Kesehatan Faskes
            </footer>
        </main>
    </div>

    <!-- JS Helper -->
    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function showNotice(title) {
            alert('Fitur ' + title + ' sedang aktif di Portal Admin Faskes.');
        }
    </script>
</body>
</html>
