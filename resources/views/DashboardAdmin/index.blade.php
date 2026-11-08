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
    <title>Dashboard Pemantauan Klinis &amp; Gizi - NutriGrow | Portal Admin Faskes</title>

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
<body class="min-h-screen bg-[#f8fafc] font-sans antialiased text-slate-800">

    <!-- Mobile Top Navigation Bar (Admin Only) -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#0284c7] bg-sky-50 px-2 py-0.5 rounded-md">
                PORTAL ADMIN
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
        <!-- 1. SIDEBAR NAVIGASI (PERSIS SESUAI GAMBAR REFERENSI ADMIN)       -->
        <!-- =============================================================== -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] xl:w-[275px] bg-white border-r border-slate-200 flex flex-col justify-between py-5 px-4 shrink-0 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand Header -->
                <div class="px-2 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                        <div class="text-[9.5px] font-black uppercase tracking-widest text-[#e11d48] mt-1">
                            PORTAL ADMIN
                            <span class="block text-[8px] tracking-wider text-slate-400 font-semibold">TENAGA KESEHATAN</span>
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
                    <!-- 1. Dashboard Admin (Active) -->
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#0284c7] text-white shadow-xs font-bold transition"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                        onclick="showFeatureNotice('Data Pengguna')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Data Pengguna</span>
                    </a>

                    <!-- 3. Data Pemeriksaan Kehamilan -->
                    <a
                        href="{{ Route::has('admin.pemeriksaan.index') ? route('admin.pemeriksaan.index') : 'javascript:void(0)' }}"
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
                        onclick="switchTableTab('balita')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Tumbuh Kembang Anak</span>
                    </a>

                    <!-- 5. Data Edukasi Gizi -->
                    <a
                        href="{{ Route::has('admin.edukasi.index') ? route('admin.edukasi.index') : 'javascript:void(0)' }}"
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
                        onclick="showFeatureNotice('Data Layanan Kesehatan')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Data Layanan Kesehatan</span>
                    </a>

                    <!-- 7. Data Informasi Nutrisi -->
                    <a
                        href="javascript:void(0)"
                        onclick="showFeatureNotice('Data Informasi Nutrisi')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <span>Data Informasi Nutrisi</span>
                    </a>

                    <!-- 8. Manajemen Akun Admin (SUPER) -->
                    <a
                        href="javascript:void(0)"
                        onclick="showFeatureNotice('Manajemen Akun Admin')"
                        class="flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Manajemen Akun Admin</span>
                        </div>
                        <span class="px-1.5 py-0.5 rounded-md bg-rose-50 text-[9px] font-black uppercase text-[#e11d48] border border-rose-100">
                            SUPER
                        </span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Section of Sidebar -->
            <div class="pt-4 border-t border-slate-100 space-y-3">
                <!-- Faskes Card -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center shrink-0 text-sky-600 shadow-2xs">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $faskesName }}</p>
                        <p class="text-[10px] font-semibold text-[#e11d48]">Akreditasi Paripurna</p>
                        <p class="text-[9.5px] text-slate-400 flex items-center gap-1 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                            <span>Faskes Wilayah 01</span>
                        </p>
                    </div>
                </div>

                <!-- Keluar Portal -->
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
        <!-- 2. MAIN CONTENT AREA                                            -->
        <!-- =============================================================== -->
        <main class="flex-1 min-w-0 flex flex-col justify-between">

            <!-- Top Header Bar -->
            <header class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sticky top-0 z-30">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="font-medium text-slate-400">Portal Tenaga Kesehatan</span>
                    <span>/</span>
                    <span class="font-bold text-slate-800">Dashboard Admin</span>
                </div>

                <!-- Right Elements: Search, Notifications, Profile Dropdown -->
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <!-- Search Input -->
                    <div class="relative w-48 sm:w-64 lg:w-72">
                        <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            type="text"
                            id="globalSearchInput"
                            onkeyup="handleSearchFilter(this.value)"
                            placeholder="Cari faskes, NIK, atau nama pasien..."
                            class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-sky-500 transition"
                        />
                    </div>

                    <!-- Notification Bell -->
                    <button
                        type="button"
                        onclick="showFeatureNotice('Notifikasi Sistem')"
                        class="relative p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer"
                        title="Notifikasi"
                    >
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500"></span>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-[#0284c7] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-xs font-bold text-slate-800 leading-tight">{{ $adminName }}</p>
                            <p class="text-[10px] text-slate-400 leading-tight">{{ $adminRole }}</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Dashboard Body -->
            <div class="p-4 sm:p-6 lg:p-8 space-y-6">

                <!-- Title & Action Buttons -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Dashboard Pemantauan Klinis &amp; Gizi
                        </h1>
                        <p class="text-xs sm:text-[13px] text-slate-500 mt-1 leading-relaxed">
                            Ringkasan data kesehatan ibu hamil, tumbuh kembang balita, dan deteksi dini stunting wilayah {{ $faskesName }}.
                        </p>
                    </div>

                    <!-- Two Action Buttons (Pink + Blue) -->
                    <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                        <!-- Primary Pink: Catat Tumbuh Kembang -->
                        <button
                            type="button"
                            onclick="openGrowthModal()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#e11d48] hover:bg-[#be123c] active:bg-[#9f1239] text-white text-xs font-bold shadow-sm shadow-rose-500/25 transition transform hover:-translate-y-0.5 cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Catat Tumbuh Kembang</span>
                        </button>

                        <!-- Secondary Blue: Catat Pemeriksaan Kehamilan -->
                        <button
                            type="button"
                            onclick="openAncModal()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] active:bg-[#075985] text-white text-xs font-bold shadow-sm shadow-sky-500/25 transition transform hover:-translate-y-0.5 cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Catat Pemeriksaan Kehamilan</span>
                        </button>
                    </div>
                </div>

                <!-- Filter Controls Bar -->
                <div class="flex flex-wrap items-center justify-between gap-3 p-3 bg-white rounded-2xl border border-slate-200/80 shadow-2xs">
                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        <!-- Dropdown 1: Bulan -->
                        <div class="relative">
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-medium transition cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Bulan ini: Oktober 2025</span>
                                <svg class="w-3 h-3 text-slate-400 ml-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown 2: Wilayah Binaan -->
                        <div class="relative">
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-medium transition cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Semua Wilayah Binaan (12 Posyandu)</span>
                                <svg class="w-3 h-3 text-slate-400 ml-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Filter Status Pills -->
                        <div class="flex items-center gap-1 pl-1">
                            <button
                                type="button"
                                onclick="filterStatus('semua')"
                                id="filterTabSemua"
                                class="px-3 py-1 rounded-xl bg-sky-50 text-sky-700 font-bold border border-sky-200 transition cursor-pointer"
                            >
                                Semua
                            </button>
                            <button
                                type="button"
                                onclick="filterStatus('prioritas')"
                                id="filterTabPrioritas"
                                class="px-3 py-1 rounded-xl text-slate-600 hover:bg-slate-50 font-medium transition cursor-pointer"
                            >
                                Kasus Prioritas
                            </button>
                            <button
                                type="button"
                                onclick="filterStatus('tindak-lanjut')"
                                id="filterTabTindakLanjut"
                                class="px-3 py-1 rounded-xl text-slate-600 hover:bg-slate-50 font-medium transition cursor-pointer"
                            >
                                Perlu Tindak Lanjut
                            </button>
                        </div>
                    </div>

                    <!-- Unduh Laporan Action -->
                    <button
                        type="button"
                        onclick="exportReport()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 transition cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Unduh Laporan (PDF/XLS)</span>
                    </button>
                </div>

                <!-- =========================================================== -->
                <!-- 3. FOUR KEY SUMMARY STAT CARDS                              -->
                <!-- =========================================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    <!-- Stat 1: Total Pengguna -->
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                                    <span>{{ $statistics['total_pengguna']['badge'] }}</span>
                                </span>
                            </div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TOTAL PENGGUNA</p>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $statistics['total_pengguna']['val'] }}</span>
                                <span class="text-xs text-slate-500 font-medium">{{ $statistics['total_pengguna']['label'] }}</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                            <span>{{ $statistics['total_pengguna']['subtext'] }}</span>
                        </p>
                    </div>

                    <!-- Stat 2: Ibu Hamil Pantauan -->
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 rounded-xl bg-pink-50 text-[#e11d48] flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-pink-50 text-[#e11d48] text-[10px] font-bold border border-pink-100">
                                    <span>{{ $statistics['ibu_hamil']['badge'] }}</span>
                                </span>
                            </div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">IBU HAMIL PANTAUAN</p>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-extrabold text-[#e11d48] tracking-tight">{{ $statistics['ibu_hamil']['val'] }}</span>
                                <span class="text-xs text-slate-500 font-medium">{{ $statistics['ibu_hamil']['label'] }}</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>{{ $statistics['ibu_hamil']['subtext'] }}</span>
                        </p>
                    </div>

                    <!-- Stat 3: Balita Terdaftar -->
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[10px] font-bold border border-sky-100">
                                    <span>{{ $statistics['balita']['badge'] }}</span>
                                </span>
                            </div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">BALITA TERDAFTAR</p>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $statistics['balita']['val'] }}</span>
                                <span class="text-xs text-slate-500 font-medium">{{ $statistics['balita']['label'] }}</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                            <span>{{ $statistics['balita']['subtext'] }}</span>
                        </p>
                    </div>

                    <!-- Stat 4: Berisiko Stunting -->
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold border border-rose-100">
                                    <span>{{ $statistics['berisiko_stunting']['badge'] }}</span>
                                </span>
                            </div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">BERISIKO STUNTING</p>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-extrabold text-[#e11d48] tracking-tight">{{ $statistics['berisiko_stunting']['val'] }}</span>
                                <span class="text-xs text-rose-600 font-semibold">{{ $statistics['berisiko_stunting']['label'] }}</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>{{ $statistics['berisiko_stunting']['subtext'] }}</span>
                        </p>
                    </div>

                </div>

                <!-- =========================================================== -->
                <!-- 4. MIDDLE SECTION (3 CARDS: DONUT, RISK CATEGORIES, TREND)  -->
                <!-- =========================================================== -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    <!-- Col 1: Sebaran Status Gizi Balita WHO (Donut Chart) -->
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Sebaran Status Gizi Balita WHO</h3>
                                <svg class="w-3.5 h-3.5 text-slate-400 cursor-pointer" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Berdasarkan indikator BB/U, TB/U, dan BB/TB</p>

                            <!-- Donut SVG Illustration -->
                            <div class="relative w-40 h-40 mx-auto my-5 flex items-center justify-center">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                    <!-- Donut Background Circle -->
                                    <circle cx="50" cy="50" r="38" fill="none" stroke="#f1f5f9" stroke-width="12" />
                                    <!-- Segment 1: Gizi Baik (82.3%) -> dasharray = 82.3 * 2.387 = 196.4, total circum = 238.7 -->
                                    <circle cx="50" cy="50" r="38" fill="none" stroke="#0284c7" stroke-width="12"
                                            stroke-dasharray="196.4 238.7" stroke-dashoffset="0" stroke-linecap="round" />
                                    <!-- Segment 2: Berisiko Gizi Kurang (11.1%) -> 26.5 -->
                                    <circle cx="50" cy="50" r="38" fill="none" stroke="#f59e0b" stroke-width="12"
                                            stroke-dasharray="26.5 238.7" stroke-dashoffset="-198" />
                                    <!-- Segment 3: Wasting / Gizi Kurang (4.3%) -> 10.2 -->
                                    <circle cx="50" cy="50" r="38" fill="none" stroke="#ef4444" stroke-width="12"
                                            stroke-dasharray="10.2 238.7" stroke-dashoffset="-225" />
                                    <!-- Segment 4: Overweight (2.3%) -> 5.5 -->
                                    <circle cx="50" cy="50" r="38" fill="none" stroke="#ec4899" stroke-width="12"
                                            stroke-dasharray="5.5 238.7" stroke-dashoffset="-236" />
                                </svg>
                                <!-- Center Text -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                    <span class="text-xl font-black text-slate-900 leading-none">1.116</span>
                                    <span class="text-[9.5px] text-slate-400 font-semibold mt-0.5">Sasaran Balita</span>
                                </div>
                            </div>
                        </div>

                        <!-- Legend Items -->
                        <div class="space-y-1.5 pt-3 border-t border-slate-100 text-xs">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#0284c7]"></span>
                                    <span class="text-slate-600 font-medium">Gizi Baik (Normal)</span>
                                </div>
                                <span class="font-bold text-slate-800">82.3% <span class="font-normal text-slate-400">(918)</span></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b]"></span>
                                    <span class="text-slate-600 font-medium">Berisiko Gizi Kurang</span>
                                </div>
                                <span class="font-bold text-slate-800">11.1% <span class="font-normal text-slate-400">(124)</span></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#ef4444]"></span>
                                    <span class="text-slate-600 font-medium">Wasting / Gizi Kurang</span>
                                </div>
                                <span class="font-bold text-slate-800">4.3% <span class="font-normal text-slate-400">(48)</span></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#ec4899]"></span>
                                    <span class="text-slate-600 font-medium">Gizi Lebih (Overweight)</span>
                                </div>
                                <span class="font-bold text-slate-800">2.3% <span class="font-normal text-slate-400">(26)</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Col 2: Kategori Risiko & Intervensi -->
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Kategori Risiko &amp; Intervensi</h3>
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-[10px] font-bold text-slate-600">
                                    113 Kasus
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Faktor risiko klinis prioritas {{ $faskesName }}</p>

                            <!-- List of Risk Categories -->
                            <div class="space-y-2.5 my-4">
                                <!-- Item 1: Stunting -->
                                <div class="p-2.5 rounded-xl bg-rose-50/70 border border-rose-100/80 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                        </svg>
                                        <span class="text-xs font-bold text-slate-800">Risiko Stunting TB/U &lt; -2 SD</span>
                                    </div>
                                    <span class="text-xs font-extrabold text-rose-600">48 anak</span>
                                </div>

                                <!-- Item 2: Weight Faltering -->
                                <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-100/80 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                        <span class="text-xs font-bold text-slate-800">Weight Faltering BB Kurang</span>
                                    </div>
                                    <span class="text-xs font-extrabold text-amber-600">34 anak</span>
                                </div>

                                <!-- Item 3: BBLR -->
                                <div class="p-2.5 rounded-xl bg-sky-50/70 border border-sky-100/80 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-xs font-bold text-slate-800">Riwayat BBLR (&lt; 2500 gr)</span>
                                    </div>
                                    <span class="text-xs font-extrabold text-sky-600">19 anak</span>
                                </div>

                                <!-- Item 4: KEK Ibu Hamil -->
                                <div class="p-2.5 rounded-xl bg-pink-50/70 border border-pink-100/80 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span class="text-xs font-bold text-slate-800">Risiko KEK Ibu Hamil (LiLA &lt; 23.5)</span>
                                    </div>
                                    <span class="text-xs font-extrabold text-pink-600">12 ibu</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Callout: Rencana Tata Laksana -->
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70 flex items-center justify-between text-xs">
                            <span class="text-[11px] font-semibold text-slate-500">Rencana Tata Laksana:</span>
                            <span class="px-2 py-0.5 rounded-lg bg-sky-100 text-[#0284c7] font-bold text-[10.5px]">
                                PMT Bahan Pangan Lokal &amp; F-100
                            </span>
                        </div>
                    </div>

                    <!-- Col 3: Tren Kunjungan & Skrining (Trend Line Chart) -->
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Tren Kunjungan &amp; Skrining</h3>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-[10px] font-bold text-emerald-700 border border-emerald-100">
                                    <span>+32% Sem. II</span>
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Kunjungan Posyandu Balita vs ANC Ibu Hamil (Mei - Okt 2025)</p>

                            <!-- Smooth SVG Line Chart Graphic -->
                            <div class="w-full h-40 my-3 relative">
                                <svg class="w-full h-full" viewBox="0 0 300 130" preserveAspectRatio="none">
                                    <defs>
                                        <!-- Gradient Fill for Posyandu Balita (Blue) -->
                                        <linearGradient id="areaBlueGrad" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.25" />
                                            <stop offset="100%" stop-color="#38bdf8" stop-opacity="0.0" />
                                        </linearGradient>
                                        <!-- Gradient Fill for ANC Ibu Hamil (Pink) -->
                                        <linearGradient id="areaPinkGrad" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#f472b6" stop-opacity="0.2" />
                                            <stop offset="100%" stop-color="#f472b6" stop-opacity="0.0" />
                                        </linearGradient>
                                    </defs>

                                    <!-- Grid lines -->
                                    <line x1="0" y1="30" x2="300" y2="30" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>
                                    <line x1="0" y1="70" x2="300" y2="70" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>
                                    <line x1="0" y1="110" x2="300" y2="110" stroke="#f1f5f9" stroke-width="1"/>

                                    <!-- Area & Line 1: Posyandu Balita (Blue) -->
                                    <path d="M 10,95 Q 60,82 120,68 T 230,42 T 290,25 L 290,110 L 10,110 Z" fill="url(#areaBlueGrad)"/>
                                    <path d="M 10,95 Q 60,82 120,68 T 230,42 T 290,25" fill="none" stroke="#0284c7" stroke-width="2.5" stroke-linecap="round"/>

                                    <!-- Area & Line 2: ANC Ibu Hamil (Pink) -->
                                    <path d="M 10,105 Q 60,100 120,92 T 230,78 T 290,65 L 290,110 L 10,110 Z" fill="url(#areaPinkGrad)"/>
                                    <path d="M 10,105 Q 60,100 120,92 T 230,78 T 290,65" fill="none" stroke="#ec4899" stroke-width="2.5" stroke-linecap="round"/>

                                    <!-- End dots -->
                                    <circle cx="290" cy="25" r="3.5" fill="#0284c7" stroke="#ffffff" stroke-width="1.5"/>
                                    <circle cx="290" cy="65" r="3.5" fill="#ec4899" stroke="#ffffff" stroke-width="1.5"/>
                                </svg>

                                <!-- X-Axis Labels -->
                                <div class="flex items-center justify-between text-[10px] text-slate-400 font-medium px-1">
                                    <span>Mei</span>
                                    <span>Jun</span>
                                    <span>Jul</span>
                                    <span>Ags</span>
                                    <span>Sep</span>
                                    <span>Okt</span>
                                </div>
                            </div>
                        </div>

                        <!-- Legend & Total Counts -->
                        <div class="space-y-1.5 pt-3 border-t border-slate-100 text-xs">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#0284c7]"></span>
                                    <span class="text-slate-600 font-medium">Posyandu Balita</span>
                                </div>
                                <span class="font-bold text-slate-800">1.084 kunjungan</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#ec4899]"></span>
                                    <span class="text-slate-600 font-medium">Pemeriksaan ANC</span>
                                </div>
                                <span class="font-bold text-slate-800">298 kunjungan</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- =========================================================== -->
                <!-- 5. BOTTOM SECTION: TABLE (LEFT) & CLINICAL ALERTS (RIGHT)    -->
                <!-- =========================================================== -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

                    <!-- LEFT COLUMN: TABBED TABLE (ANTROPOMETRI BALITA & ANC) (8 cols) -->
                    <div class="lg:col-span-8 p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <!-- Tab Bar Header -->
                            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <!-- Tab 1: Antropometri Balita Terbaru -->
                                    <button
                                        type="button"
                                        id="tableTabBalita"
                                        onclick="switchTableTab('balita')"
                                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-sky-50 text-sky-700 font-bold text-xs border border-sky-100 transition cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Antropometri Balita Terbaru</span>
                                    </button>

                                    <!-- Tab 2: Pemeriksaan Kehamilan (ANC) -->
                                    <button
                                        type="button"
                                        id="tableTabAnc"
                                        onclick="switchTableTab('anc')"
                                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-slate-600 hover:bg-slate-50 font-medium text-xs transition cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>Pemeriksaan Kehamilan (ANC)</span>
                                    </button>
                                </div>

                                <!-- Realtime Status Indicator -->
                                <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-medium">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Pembaruan Real-time</span>
                                </div>
                            </div>

                            <!-- Table Container -->
                            <div class="overflow-x-auto">
                                <!-- 1. Tabel Balita -->
                                <table id="balitaTable" class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="text-[10px] uppercase tracking-wider font-bold text-slate-400 border-b border-slate-100">
                                            <th class="py-3 px-2">NAMA PASIEN</th>
                                            <th class="py-3 px-2">TANGGAL</th>
                                            <th class="py-3 px-2">HASIL UKUR (BB / TB)</th>
                                            <th class="py-3 px-2">STATUS GIZI</th>
                                            <th class="py-3 px-2 text-right">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100/80">
                                        @foreach ($recentChildren as $child)
                                            <tr class="hover:bg-slate-50/60 transition group patient-row" data-name="{{ strtolower($child['nama']) }}">
                                                <td class="py-3 px-2">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="font-bold text-slate-800">{{ $child['nama'] }}</span>
                                                        @if ($child['is_alert'])
                                                            <span class="w-2 h-2 rounded-full bg-rose-500 inline-block" title="Perlu Perhatian Khusus"></span>
                                                        @endif
                                                    </div>
                                                    <span class="text-[10.5px] text-slate-400 font-normal block">{{ $child['sub_info'] }}</span>
                                                </td>
                                                <td class="py-3 px-2 text-slate-600 font-medium whitespace-nowrap">
                                                    {{ $child['tanggal'] }}
                                                </td>
                                                <td class="py-3 px-2">
                                                    <div class="font-bold text-slate-800">{{ $child['bb_tb'] }}</div>
                                                    <div class="text-[10px] {{ $child['is_alert'] ? 'text-rose-500 font-bold' : 'text-slate-400' }}">
                                                        {{ $child['detail_ukur'] }}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-2">
                                                    @if ($child['badge'] === 'emerald')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                            {{ $child['status_gizi'] }}
                                                        </span>
                                                    @elseif ($child['badge'] === 'rose')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                            {{ $child['status_gizi'] }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-sky-50 text-sky-700 border border-sky-100">
                                                            {{ $child['status_gizi'] }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-2 text-right">
                                                    @if ($child['is_alert'])
                                                        <button
                                                            type="button"
                                                            onclick="openInterventionModal('{{ $child['nama'] }}')"
                                                            class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] border border-rose-200 transition cursor-pointer"
                                                        >
                                                            Intervensi
                                                        </button>
                                                    @else
                                                        <button
                                                            type="button"
                                                            onclick="openDetailModal('{{ $child['nama'] }}', '{{ $child['sub_info'] }}', '{{ $child['bb_tb'] }}')"
                                                            class="text-[#0284c7] hover:text-[#0369a1] font-bold text-[11px] hover:underline cursor-pointer"
                                                        >
                                                            Detail
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- 2. Tabel ANC Kehamilan (Terkondisi) -->
                                <table id="ancTable" class="w-full text-left text-xs hidden">
                                    <thead>
                                        <tr class="text-[10px] uppercase tracking-wider font-bold text-slate-400 border-b border-slate-100">
                                            <th class="py-3 px-2">NAMA IBU HAMIL</th>
                                            <th class="py-3 px-2">TANGGAL</th>
                                            <th class="py-3 px-2">HASIL UKUR (BB / TB)</th>
                                            <th class="py-3 px-2">STATUS GIZI &amp; LILA</th>
                                            <th class="py-3 px-2 text-right">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100/80">
                                        @foreach ($recentPregnancies as $preg)
                                            <tr class="hover:bg-slate-50/60 transition group patient-row" data-name="{{ strtolower($preg['nama']) }}">
                                                <td class="py-3 px-2">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="font-bold text-slate-800">{{ $preg['nama'] }}</span>
                                                        @if ($preg['is_alert'])
                                                            <span class="w-2 h-2 rounded-full bg-amber-500 inline-block" title="Perhatian KEK"></span>
                                                        @endif
                                                    </div>
                                                    <span class="text-[10.5px] text-slate-400 font-normal block">{{ $preg['sub_info'] }}</span>
                                                </td>
                                                <td class="py-3 px-2 text-slate-600 font-medium whitespace-nowrap">
                                                    {{ $preg['tanggal'] }}
                                                </td>
                                                <td class="py-3 px-2">
                                                    <div class="font-bold text-slate-800">{{ $preg['bb_tb'] }}</div>
                                                    <div class="text-[10px] {{ $preg['is_alert'] ? 'text-amber-600 font-bold' : 'text-slate-400' }}">
                                                        {{ $preg['detail_ukur'] }}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-2">
                                                    @if ($preg['badge'] === 'emerald')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                            {{ $preg['status_gizi'] }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                            {{ $preg['status_gizi'] }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-2 text-right">
                                                    <button
                                                        type="button"
                                                        onclick="openDetailModal('{{ $preg['nama'] }}', '{{ $preg['sub_info'] }}', '{{ $preg['bb_tb'] }}')"
                                                        class="text-[#0284c7] hover:text-[#0369a1] font-bold text-[11px] hover:underline cursor-pointer"
                                                    >
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Table Footer -->
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                            <span class="text-slate-400 text-[11px]">Menampilkan 4 entri pengukuran terakhir</span>
                            <a
                                href="javascript:void(0)"
                                onclick="showFeatureNotice('Semua Rekam Medis Faskes')"
                                class="text-[#0284c7] hover:text-[#0369a1] font-bold inline-flex items-center gap-1 hover:underline"
                            >
                                <span>Lihat Semua Rekam Medis</span>
                                <span>&rsaquo;</span>
                            </a>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: CLINICAL RISK ALERTS (4 cols) -->
                    <div class="lg:col-span-4 p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <!-- Header with Asterisk Icon -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="text-rose-500 font-black text-lg leading-none">*</span>
                                    <h3 class="text-sm font-bold text-slate-900 tracking-tight">Peringatan Klinis Mendesak</h3>
                                </div>
                                <div class="flex items-center gap-1 text-[10.5px] font-bold text-rose-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                    <span>Risk Alerts</span>
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">Perlu tindakan lanjut &amp; koordinasi faskes</p>

                            <!-- Alert Cards Container -->
                            <div class="space-y-3 mt-3.5">
                                <!-- Alert 1: Stunting -->
                                <div class="p-3.5 rounded-2xl bg-rose-50/60 border border-rose-200/70">
                                    <div class="flex items-center justify-between text-[10px] font-bold mb-1.5">
                                        <span class="inline-flex items-center gap-1 text-rose-700">
                                            <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <span>STUNTING TB/U &lt; -2.4 SD</span>
                                        </span>
                                        <span class="text-slate-400 font-medium">Hari ini</span>
                                    </div>
                                    <h4 class="text-xs font-bold text-slate-900">An. Dimas Nugraha (14 Bulan)</h4>
                                    <p class="text-[11px] text-slate-600 mt-1 leading-snug">
                                        Posyandu Melati 3 &bull; Rekomendasi: Konsul Dokter Spesialis Anak &amp; PKMK.
                                    </p>
                                    <div class="flex items-center gap-2 mt-3">
                                        <button
                                            type="button"
                                            onclick="openRujukanModal('An. Dimas Nugraha')"
                                            class="flex-1 py-1.5 px-3 rounded-xl bg-[#e11d48] hover:bg-[#be123c] text-white text-[11px] font-bold shadow-2xs transition cursor-pointer text-center"
                                        >
                                            Tindak Lanjut Rujukan
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openRekamModal('An. Dimas Nugraha')"
                                            class="py-1.5 px-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-[11px] font-bold transition cursor-pointer"
                                        >
                                            Rekam Medis
                                        </button>
                                    </div>
                                </div>

                                <!-- Alert 2: Ibu Hamil KEK -->
                                <div class="p-3.5 rounded-2xl bg-amber-50/60 border border-amber-200/70">
                                    <div class="flex items-center justify-between text-[10px] font-bold mb-1.5">
                                        <span class="inline-flex items-center gap-1 text-amber-800">
                                            <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            <span>IBU HAMIL RISIKO KEK</span>
                                        </span>
                                        <span class="text-slate-400 font-medium">Kemarin</span>
                                    </div>
                                    <h4 class="text-xs font-bold text-slate-900">Ny. Linda Permata (G1P0A0, 28 Mgg)</h4>
                                    <p class="text-[11px] text-slate-600 mt-1 leading-snug">
                                        LiLA: 21.5 cm (&lt; 23.5 cm) &bull; Rekomendasi: Distribusi biskuit PMT Pemulihan.
                                    </p>
                                    <div class="flex items-center gap-2 mt-3">
                                        <button
                                            type="button"
                                            onclick="openPmtModal('Ny. Linda Permata')"
                                            class="flex-1 py-1.5 px-3 rounded-xl bg-[#ec4899] hover:bg-[#db2777] text-white text-[11px] font-bold shadow-2xs transition cursor-pointer text-center"
                                        >
                                            Jadwalkan PMT
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openKiaModal('Ny. Linda Permata')"
                                            class="py-1.5 px-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-[11px] font-bold transition cursor-pointer"
                                        >
                                            Buku KIA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Integration Badge -->
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-[11px] text-slate-400">Integrasi Sistem:</span>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-sky-50 text-sky-700 border border-sky-200/80 font-bold text-[10.5px]">
                                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>e-PPGBM Terhubung</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <footer class="mt-8 border-t border-slate-200/80 bg-white px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-400">
                <div>
                    &copy; 2025 NutriGrow Health Platform &bull; Fasilitas Pelayanan Kesehatan {{ $faskesName }}
                </div>
                <div class="flex items-center gap-2 text-[11px]">
                    <span class="inline-flex items-center gap-1 text-slate-600 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>SatuSehat Kemenkes RI Aktif</span>
                    </span>
                    <span>&bull;</span>
                    <span>Versi Klinis v2.4</span>
                </div>
            </footer>

        </main>

    </div>

    <!-- =================================================================== -->
    <!-- INTERACTIVE MODALS                                                  -->
    <!-- =================================================================== -->

    <!-- Modal: Catat Tumbuh Kembang -->
    <div id="growthModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                        +
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm sm:text-base">Catat Tumbuh Kembang Balita</h3>
                        <p class="text-[11px] text-slate-400">Penginputan Antropometri Posyandu &amp; Faskes</p>
                    </div>
                </div>
                <button type="button" onclick="closeGrowthModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form onsubmit="handleFormSubmit(event, 'Data tumbuh kembang balita berhasil dicatat dan disinkronisasi ke e-PPGBM!')" class="mt-4 space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Balita / NIK Anak</label>
                    <input type="text" required placeholder="Contoh: Muhammad Rayyan (31710...)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-rose-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Berat Badan (kg)</label>
                        <input type="number" step="0.1" required placeholder="10.2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-rose-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" required placeholder="82.5" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-rose-500">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Lingkar Kepala (LK)</label>
                    <input type="number" step="0.1" placeholder="46.5" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Lokasi Posyandu / Faskes</label>
                    <input type="text" value="Posyandu Melati 2 - Puskesmas Gambir" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-600">
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeGrowthModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#e11d48] hover:bg-[#be123c] text-white font-bold transition">Simpan Data Balita</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Catat Pemeriksaan Kehamilan -->
    <div id="ancModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                        +
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm sm:text-base">Catat Pemeriksaan ANC Ibu Hamil</h3>
                        <p class="text-[11px] text-slate-400">Pemeriksaan Berkala Standar Kemenkes RI</p>
                    </div>
                </div>
                <button type="button" onclick="closeAncModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form onsubmit="handleFormSubmit(event, 'Pemeriksaan kehamilan berhasil dicatat dan terintegrasi!')" class="mt-4 space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Ibu Hamil / NIK</label>
                    <input type="text" required placeholder="Contoh: Ny. Linda Permata" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-sky-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Usia Kehamilan (Minggu)</label>
                        <input type="number" required placeholder="28" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Lingkar Lengan Atas (LiLA cm)</label>
                        <input type="number" step="0.1" required placeholder="21.5" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-sky-500">
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeAncModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white font-bold transition">Simpan Pemeriksaan ANC</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Generic Alert / Notification Toast -->
    <div id="toastNotification" class="fixed bottom-5 right-5 z-50 bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-xl flex items-center gap-3 transform translate-y-12 opacity-0 transition-all duration-300 pointer-events-none">
        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <span id="toastMessage" class="text-xs font-semibold">Operasi berhasil dilakukan!</span>
    </div>

    <!-- Client-side Interactive Scripts -->
    <script>
        // Toggle mobile sidebar
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

        // Tab switcher for table
        function switchTableTab(tab) {
            const balitaTable = document.getElementById('balitaTable');
            const ancTable = document.getElementById('ancTable');
            const tabBalita = document.getElementById('tableTabBalita');
            const tabAnc = document.getElementById('tableTabAnc');

            if (tab === 'balita') {
                balitaTable.classList.remove('hidden');
                ancTable.classList.add('hidden');
                tabBalita.className = 'inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-sky-50 text-sky-700 font-bold text-xs border border-sky-100 transition cursor-pointer';
                tabAnc.className = 'inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-slate-600 hover:bg-slate-50 font-medium text-xs transition cursor-pointer';
            } else {
                balitaTable.classList.add('hidden');
                ancTable.classList.remove('hidden');
                tabAnc.className = 'inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-pink-50 text-[#e11d48] font-bold text-xs border border-pink-100 transition cursor-pointer';
                tabBalita.className = 'inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-slate-600 hover:bg-slate-50 font-medium text-xs transition cursor-pointer';
            }
        }

        // Filter status buttons
        function filterStatus(mode) {
            const tabs = ['Semua', 'Prioritas', 'TindakLanjut'];
            tabs.forEach(t => {
                const el = document.getElementById('filterTab' + t);
                if (el) el.className = 'px-3 py-1 rounded-xl text-slate-600 hover:bg-slate-50 font-medium transition cursor-pointer';
            });

            if (mode === 'semua') {
                document.getElementById('filterTabSemua').className = 'px-3 py-1 rounded-xl bg-sky-50 text-sky-700 font-bold border border-sky-200 transition cursor-pointer';
                document.querySelectorAll('.patient-row').forEach(r => r.classList.remove('hidden'));
            } else if (mode === 'prioritas') {
                document.getElementById('filterTabPrioritas').className = 'px-3 py-1 rounded-xl bg-amber-50 text-amber-700 font-bold border border-amber-200 transition cursor-pointer';
                document.querySelectorAll('.patient-row').forEach(r => {
                    if (r.querySelector('.bg-rose-50') || r.querySelector('.bg-amber-50')) {
                        r.classList.remove('hidden');
                    } else {
                        r.classList.add('hidden');
                    }
                });
            } else if (mode === 'tindak-lanjut') {
                document.getElementById('filterTabTindakLanjut').className = 'px-3 py-1 rounded-xl bg-rose-50 text-rose-700 font-bold border border-rose-200 transition cursor-pointer';
                document.querySelectorAll('.patient-row').forEach(r => {
                    if (r.querySelector('.bg-rose-50')) {
                        r.classList.remove('hidden');
                    } else {
                        r.classList.add('hidden');
                    }
                });
            }
        }

        // Search Filter
        function handleSearchFilter(q) {
            const query = q.toLowerCase().trim();
            document.querySelectorAll('.patient-row').forEach(row => {
                const name = row.getAttribute('data-name') || '';
                if (name.includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        // Modals & Actions
        function openGrowthModal() {
            const m = document.getElementById('growthModal');
            m.classList.remove('opacity-0', 'pointer-events-none');
        }
        function closeGrowthModal() {
            const m = document.getElementById('growthModal');
            m.classList.add('opacity-0', 'pointer-events-none');
        }

        function openAncModal() {
            const m = document.getElementById('ancModal');
            m.classList.remove('opacity-0', 'pointer-events-none');
        }
        function closeAncModal() {
            const m = document.getElementById('ancModal');
            m.classList.add('opacity-0', 'pointer-events-none');
        }

        function openRujukanModal(patient) {
            showToast('Surat rujukan klinis untuk ' + patient + ' berhasil digenerate dan dikirim ke Poli Spesialis Anak RSUD!');
        }
        function openRekamModal(patient) {
            showToast('Membuka rekam medis lengkap KMS digital untuk ' + patient + '...');
        }
        function openPmtModal(patient) {
            showToast('Paket PMT Bahan Pangan Lokal & F-100 berhasil dijadwalkan untuk ' + patient + '!');
        }
        function openKiaModal(patient) {
            showToast('Buku KIA digital untuk ' + patient + ' berhasil dibuka.');
        }
        function openInterventionModal(patient) {
            showToast('Protokol intervensi medis stunting dimulai untuk ' + patient + '!');
        }
        function openDetailModal(patient, info, bbTb) {
            showToast('Menampilkan data rincian: ' + patient + ' (' + info + ') - ' + bbTb);
        }
        function exportReport() {
            showToast('Laporan Pemantauan Gizi & Stunting sedang diunduh dalam format PDF/XLS...');
        }
        function showFeatureNotice(feature) {
            showToast('Fitur ' + feature + ' aktif dan terintegrasi dengan data faskes!');
        }

        function handleFormSubmit(e, message) {
            e.preventDefault();
            closeGrowthModal();
            closeAncModal();
            showToast(message);
        }

        function showToast(msg) {
            const toast = document.getElementById('toastNotification');
            const toastMsg = document.getElementById('toastMessage');
            toastMsg.textContent = msg;
            toast.classList.remove('translate-y-12', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-12', 'opacity-0', 'pointer-events-none');
            }, 3500);
        }
    </script>
</body>
</html>
