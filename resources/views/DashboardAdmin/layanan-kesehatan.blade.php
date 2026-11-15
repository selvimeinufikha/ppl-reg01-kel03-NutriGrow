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
    <title>Data Layanan Kesehatan - NutriGrow | Portal Admin Tenaga Kesehatan</title>

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

    <!-- Mobile Top Navigation Bar -->
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
        <!-- 1. SIDEBAR NAVIGASI (PORTAL ADMIN TENAGA KESEHATAN)             -->
        <!-- =============================================================== -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] xl:w-[275px] bg-white border-r border-slate-200 flex flex-col justify-between py-5 px-4 shrink-0 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand Header -->
                <div class="px-2 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                        <div class="text-[9.5px] font-black uppercase tracking-widest text-[#e11d48] mt-1">
                            PORTAL ADMIN <span class="text-slate-400 font-normal">| TENAGA KESEHATAN</span>
                        </div>
                    </a>

                    <!-- Badge Nakes Terverifikasi -->
                    <div class="mt-3.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200/60 text-emerald-700 text-[10px] font-bold">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
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
                        href="javascript:void(0)"
                        onclick="showFeatureNotice('Data Pemeriksaan Kehamilan')"
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
                        onclick="showFeatureNotice('Data Tumbuh Kembang Anak')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Tumbuh Kembang Anak</span>
                    </a>

                    <!-- 5. Data Edukasi Gizi -->
                    <a
                        href="{{ route('admin.edukasi.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Data Edukasi Gizi</span>
                    </a>

                    <!-- 6. Data Layanan Kesehatan (ACTIVE) -->
                    <a
                        href="{{ route('admin.fasilitas.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#0284c7] text-white shadow-xs font-bold transition"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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

                    <!-- 8. Manajemen Akun Admin -->
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
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#e11d48] bg-rose-50 px-1.5 py-0.5 rounded">
                            SUPER
                        </span>
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar: Faskes Card & Logout -->
            <div class="pt-4 border-t border-slate-100">
                <div class="p-3 bg-slate-50 border border-slate-200/60 rounded-2xl mb-3 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-[#0284c7] shadow-2xs shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs font-bold text-slate-800 truncate">{{ $faskesName }}</div>
                        <div class="text-[10px] text-slate-400 truncate">Wilayah Binaan Gambir 01</div>
                    </div>
                </div>

                <button
                    type="button"
                    onclick="openLogoutModal()"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-[#e11d48] hover:bg-rose-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar Portal</span>
                </button>
            </div>
        </aside>

        <!-- =============================================================== -->
        <!-- 2. KONTEN UTAMA (MAIN AREA)                                     -->
        <!-- =============================================================== -->
        <main class="flex-1 min-w-0 flex flex-col min-h-screen">

            <!-- Top Header Bar -->
            <header class="bg-white border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between sticky top-0 z-30">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <span class="hover:text-slate-600 transition">Portal Faskes</span>
                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="font-bold text-slate-800">Monitoring Klinis</span>
                </div>

                <!-- Header Actions (Notifikasi & Profil) -->
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        onclick="showToast('Notifikasi', '3 fasilitas kesehatan dalam peninjauan integrasi SatuSehat.')"
                        class="relative p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer"
                        title="Notifikasi"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-[#e11d48] text-white text-[9.5px] font-black flex items-center justify-center">
                            3
                        </span>
                    </button>

                    <!-- Profile Pill -->
                    <div class="flex items-center gap-2.5 pl-2 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#0284c7] to-sky-400 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:block text-left leading-tight">
                            <div class="text-xs font-bold text-slate-800">{{ $adminName }}</div>
                            <div class="text-[10px] font-medium text-slate-400">{{ $adminRole }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body Content -->
            <div class="p-4 sm:p-6 lg:p-8 space-y-6">

                <!-- Alert Feedback (Success / Error) -->
                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer text-sm font-bold">&times;</button>
                </div>
                @endif

                @if(isset($errors) && $errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-xs shadow-xs space-y-1">
                    <div class="font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>Gagal Menyimpan Data Fasilitas Kesehatan:</span>
                    </div>
                    <ul class="list-disc pl-6 space-y-0.5 text-[11px] text-rose-700">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- =========================================================== -->
                <!-- HEADER HALAMAN & TOMBOL AKSI                                -->
                <!-- =========================================================== -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-1.5 text-[10.5px] font-black uppercase tracking-wider text-[#e11d48] mb-1">
                            <span class="w-2 h-2 rounded-full bg-[#e11d48] animate-pulse"></span>
                            <span>MODUL RUJUKAN TERINTEGRASI WILAYAH</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Data Layanan Kesehatan
                        </h1>
                        <p class="text-xs sm:text-[13px] text-slate-500 mt-1 leading-relaxed">
                            Kelola direktori fasilitas kesehatan, posyandu berkala, dan jejaring rujukan stunting-KIA untuk rekomendasi geolokasi otomatis bagi ibu hamil dan balita.
                        </p>
                    </div>

                    <!-- Tombol Aksi: Unduh XLS & Tambah Fasilitas -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 shrink-0">
                        <button
                            type="button"
                            onclick="showToast('Unduh Data', 'Mengunduh rekapitulasi data faskes dalam format spreadsheet XLS...')"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 text-xs font-bold text-emerald-700 transition cursor-pointer shadow-2xs"
                        >
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Unduh Daftar (XLS)</span>
                        </button>

                        <button
                            type="button"
                            onclick="openAddFacilityModal()"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs hover:shadow transition cursor-pointer"
                        >
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>+ Tambah Fasilitas</span>
                        </button>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- BANNER SUMBER REKOMENDASI TERDEKAT (SESUAI MOCKUP)          -->
                <!-- =========================================================== -->
                <div class="p-4 sm:p-5 rounded-2xl bg-[#eef6ff] border border-sky-200/70 shadow-2xs flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white border border-sky-200 text-[#0284c7] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-5 h-5 text-[#0284c7]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900">
                                Sumber Rekomendasi Terdekat Aplikasi NutriGrow Ibu &amp; Balita
                            </h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-rose-100 text-[#e11d48] text-[10px] font-extrabold uppercase">
                                SatuSehat Ready
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Data faskes di halaman ini merupakan rujukan utama yang dihitung berdasarkan radius GPS pada aplikasi pengguna. Digunakan saat ibu mencari jadwal penimbangan Posyandu, skrining gizi Puskesmas, maupun intervensi kegawatdaruratan stunting/KEK ke Rumah Sakit Rujukan.
                        </p>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- STATISTIK RINGKASAN (4 CARDS SESUAI MOCKUP)                 -->
                <!-- =========================================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- 1. Total Fasilitas -->
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-8 h-8 rounded-xl bg-sky-50 text-[#0284c7] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-[#0284c7] border border-sky-100">
                                {{ $statistics['total_fasilitas']['badge'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">TOTAL FASILITAS</span>
                            <div class="mt-1 flex items-baseline gap-1.5">
                                <span class="text-2xl font-black text-slate-900">{{ $statistics['total_fasilitas']['val'] }}</span>
                                <span class="text-xs font-semibold text-slate-500">Fasilitas</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 leading-snug">{{ $statistics['total_fasilitas']['sub'] }}</p>
                        </div>
                    </div>

                    <!-- 2. Posyandu Aktif -->
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-8 h-8 rounded-xl bg-pink-50 text-[#e11d48] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-pink-50 text-[#e11d48] border border-pink-100">
                                {{ $statistics['posyandu_aktif']['badge'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">POSYANDU AKTIF</span>
                            <div class="mt-1 flex items-baseline gap-1.5">
                                <span class="text-2xl font-black text-slate-900">{{ $statistics['posyandu_aktif']['val'] }}</span>
                                <span class="text-xs font-semibold text-slate-500">Titik Layanan</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 leading-snug">{{ $statistics['posyandu_aktif']['sub'] }}</p>
                        </div>
                    </div>

                    <!-- 3. Puskesmas & Klinik -->
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-100">
                                {{ $statistics['puskesmas_klinik']['badge'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">PUSKESMAS &amp; KLINIK</span>
                            <div class="mt-1 flex items-baseline gap-1.5">
                                <span class="text-2xl font-black text-slate-900">{{ $statistics['puskesmas_klinik']['val'] }}</span>
                                <span class="text-xs font-semibold text-slate-500">Unit Faskes 1</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 leading-snug">{{ $statistics['puskesmas_klinik']['sub'] }}</p>
                        </div>
                    </div>

                    <!-- 4. Rumah Sakit Rujukan -->
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                {{ $statistics['rumah_sakit']['badge'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">RUMAH SAKIT RUJUKAN</span>
                            <div class="mt-1 flex items-baseline gap-1.5">
                                <span class="text-2xl font-black text-slate-900">{{ $statistics['rumah_sakit']['val'] }}</span>
                                <span class="text-xs font-semibold text-slate-500">RS Tipe A/B/C</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 leading-snug">{{ $statistics['rumah_sakit']['sub'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- FILTER BAR & PENCARIAN (MOCKUP REFERENSI)                   -->
                <!-- =========================================================== -->
                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <!-- Search Box -->
                        <div class="relative flex-1">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input
                                type="text"
                                id="facilitySearchInput"
                                value="{{ $search ?? '' }}"
                                onkeyup="filterFacilityTable()"
                                placeholder="Cari nama fasilitas, jalan, kelurahan, atau kode faskes..."
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 shadow-2xs transition"
                            >
                        </div>

                        <!-- Dropdowns: Status & Urutan -->
                        <div class="flex items-center gap-2">
                            <select
                                id="facilityStatusFilter"
                                onchange="filterFacilityTable()"
                                class="px-3 py-2.5 bg-white border border-slate-200/80 rounded-xl text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-sky-500/20 shadow-2xs"
                            >
                                <option value="all">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>

                            <select
                                id="facilitySortFilter"
                                onchange="sortFacilityTable()"
                                class="px-3 py-2.5 bg-white border border-slate-200/80 rounded-xl text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-sky-500/20 shadow-2xs"
                            >
                                <option value="newest">Urutan: Paling Baru</option>
                                <option value="name_asc">Nama: A - Z</option>
                                <option value="name_desc">Nama: Z - A</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Kategori Jenis Pills (PBI-024) -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar text-xs">
                        @foreach($jenisCategories as $cat)
                        <button
                            type="button"
                            onclick="setJenisFilter('{{ $cat['key'] }}', this)"
                            class="jenis-filter-pill px-3.5 py-1.5 rounded-full font-semibold transition cursor-pointer whitespace-nowrap {{ ($selectedJenis ?? 'semua') === $cat['key'] ? 'bg-[#0284c7] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                            data-jenis="{{ $cat['key'] }}"
                        >
                            {{ $cat['label'] }} ({{ $cat['count'] }})
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- TABEL DATA FASILITAS KESEHATAN (PERSIS MOCKUP)              -->
                <!-- =========================================================== -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="facilityTable">
                            <thead>
                                <tr class="bg-[#f8fafc] border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                                    <th class="py-3.5 px-4 sm:px-6">NAMA FASILITAS &amp; KODE FASKES</th>
                                    <th class="py-3.5 px-4">JENIS</th>
                                    <th class="py-3.5 px-4">ALAMAT &amp; WILAYAH</th>
                                    <th class="py-3.5 px-4">JAM LAYANAN</th>
                                    <th class="py-3.5 px-4">KONTAK &amp; PIC</th>
                                    <th class="py-3.5 px-4">KOORDINAT</th>
                                    <th class="py-3.5 px-4">STATUS</th>
                                    <th class="py-3.5 px-4 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs text-slate-700" id="facilityTableBody">
                                @forelse($fasilitas as $item)
                                <tr
                                    class="facility-row hover:bg-slate-50/80 transition cursor-pointer group"
                                    data-name="{{ strtolower($item->nama_fasilitas) }}"
                                    data-code="{{ strtolower($item->kode_faskes) }}"
                                    data-address="{{ strtolower($item->alamat . ' ' . $item->wilayah) }}"
                                    data-jenis="{{ $item->jenis }}"
                                    data-status="{{ $item->status }}"
                                    onclick="openFacilityDetail({{ json_encode($item) }})"
                                >
                                    <!-- Kolom 1: Nama Fasilitas & Kode -->
                                    <td class="py-4 px-4 sm:px-6">
                                        <div class="flex items-start gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0 border border-sky-100 shadow-2xs mt-0.5">
                                                @if($item->jenis === 'posyandu')
                                                    <span class="text-sm">👶</span>
                                                @elseif($item->jenis === 'rumah_sakit')
                                                    <span class="text-sm">🏥</span>
                                                @elseif($item->jenis === 'klinik')
                                                    <span class="text-sm">🩺</span>
                                                @else
                                                    <span class="text-sm">🏛️</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="font-bold text-slate-900 group-hover:text-[#0284c7] transition leading-snug">
                                                    {{ $item->nama_fasilitas }}
                                                </h4>
                                                <div class="flex flex-wrap items-center gap-1.5 mt-1 text-[11px]">
                                                    <span class="font-mono text-slate-400">KODE: {{ $item->kode_faskes }}</span>
                                                    @if($item->akreditasi)
                                                    <span>•</span>
                                                    <span class="text-emerald-700 font-semibold bg-emerald-50 px-1.5 py-0.2 rounded border border-emerald-200/60">
                                                        {{ $item->akreditasi }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Kolom 2: Jenis Fasilitas -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item->jenis_badge }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->jenis_dot_color }}"></span>
                                            <span>{{ $item->jenis_label }}</span>
                                        </span>
                                    </td>

                                    <!-- Kolom 3: Alamat & Wilayah -->
                                    <td class="py-4 px-4">
                                        <div class="text-slate-800 leading-snug max-w-xs">{{ $item->alamat }}</div>
                                        <div class="mt-1 flex items-center gap-2">
                                            <a
                                                href="{{ $item->maps_url }}"
                                                target="_blank"
                                                onclick="event.stopPropagation()"
                                                class="inline-flex items-center gap-1 text-[11px] font-bold text-[#0284c7] hover:underline"
                                            >
                                                <span>🗺️</span>
                                                <span>Lihat di Peta</span>
                                            </a>
                                        </div>
                                    </td>

                                    <!-- Kolom 4: Jam Layanan -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $item->jam_layanan }}</div>
                                        @if($item->layanan_tambahan)
                                            <div class="text-[10.5px] font-bold text-[#e11d48] mt-0.5">{{ $item->layanan_tambahan }}</div>
                                        @endif
                                    </td>

                                    <!-- Kolom 5: Kontak & PIC -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800">{{ $item->kontak }}</div>
                                        @if($item->pic)
                                            <div class="text-[10.5px] text-slate-400 mt-0.5">{{ $item->pic }}</div>
                                        @endif
                                    </td>

                                    <!-- Kolom 6: Koordinat GPS -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-mono text-slate-700 bg-slate-50 px-2 py-0.5 rounded text-[11px] border border-slate-200/80 inline-block">
                                            {{ $item->koordinat_formatted }}
                                        </div>
                                        <div class="text-[10.5px] font-semibold text-sky-700 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="9"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                            <span>GPS Akurat</span>
                                        </div>
                                    </td>

                                    <!-- Kolom 7: Status -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        @if($item->status === 'aktif')
                                            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                <span>Aktif</span>
                                            </div>
                                        @else
                                            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                                <span>Tidak Aktif</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Kolom 8: Aksi (PBI-023: Detail, Ubah & Hapus) -->
                                    <td class="py-4 px-4 whitespace-nowrap text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center gap-1">
                                            <!-- Detail Button -->
                                            <button
                                                type="button"
                                                onclick="openFacilityDetail({{ json_encode($item) }})"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-[#0284c7] hover:bg-sky-50 transition cursor-pointer"
                                                title="Lihat Detail Fasilitas"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>

                                            <!-- Edit Button (PBI-023) -->
                                            <button
                                                type="button"
                                                onclick="openEditFacilityModal({{ json_encode($item) }})"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-[#0284c7] hover:bg-sky-50 transition cursor-pointer"
                                                title="Ubah / Perbarui Fasilitas"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>

                                            <!-- Delete Button (PBI-023) -->
                                            <button
                                                type="button"
                                                onclick="openDeleteFacilityModal({{ $item->id }}, '{{ addslashes($item->nama_fasilitas) }}')"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                                                title="Hapus Fasilitas"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row Pesan Kosong Realtime / Filter Javascript (PBI-024) -->
                                <tr id="clientEmptyRow" class="hidden">
                                    <td colspan="8" class="text-center py-12 px-4 bg-slate-50/50">
                                        <div class="max-w-sm mx-auto text-center">
                                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 mx-auto flex items-center justify-center mb-3 border border-amber-200/70 shadow-2xs">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-bold text-slate-800">Data Fasilitas Tidak Ditemukan</h4>
                                            <p id="clientEmptyMsg" class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                Tidak ada fasilitas kesehatan yang sesuai dengan kata kunci pencarian atau filter jenis yang dipilih.
                                            </p>
                                            <button
                                                type="button"
                                                onclick="resetSearchAndFilter()"
                                                class="mt-3.5 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                <span>Reset Pencarian &amp; Filter</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-12 px-4 bg-slate-50/50">
                                        <div class="max-w-sm mx-auto text-center">
                                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 mx-auto flex items-center justify-center mb-3 border border-amber-200/70 shadow-2xs">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-bold text-slate-800">Data Fasilitas Tidak Ditemukan</h4>
                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                Tidak ada data fasilitas kesehatan yang sesuai dengan kata kunci pencarian atau filter jenis yang dipilih.
                                            </p>
                                            <a
                                                href="{{ route('admin.fasilitas.index') }}"
                                                class="mt-3.5 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                <span>Reset Pencarian &amp; Filter</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Tabel -->
                    <div class="py-3.5 px-4 sm:px-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                        <div id="tableRecordCount">
                            Menampilkan {{ count($fasilitas) }} dari {{ $statistics['total_fasilitas']['val'] }} fasilitas kesehatan terdaftar
                        </div>
                        <div class="flex items-center gap-1 font-semibold">
                            <span class="text-slate-400 text-[11px]">Sistem Geolokasi NutriGrow v2.4 • Akurasi GPS ±5m</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Copyright & Legal -->
                <div class="pt-2 pb-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-400 border-t border-slate-200/80">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Jejaring Rujukan Faskes Terintegrasi Kementerian Kesehatan RI</span>
                    </div>
                    <div>
                        NutriGrow Faskes Admin &bull; &copy; 2026 Puskesmas Gambir
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 1: TAMBAH FASILITAS KESEHATAN (PBI-022)                       -->
    <!-- =================================================================== -->
    <div id="addFacilityModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Tambah Fasilitas Kesehatan</h3>
                        <p class="text-xs text-slate-500">Daftarkan faskes baru untuk rekomendasi layanan terdekat</p>
                    </div>
                </div>
                <button type="button" onclick="closeAddFacilityModal()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.fasilitas.store') }}" method="POST" class="mt-5 space-y-4">
                @csrf
                
                <!-- Nama Fasilitas -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Fasilitas Kesehatan <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        name="nama_fasilitas"
                        required
                        placeholder="Contoh: Puskesmas Kelurahan Petojo Selatan / Posyandu Mawar 02"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    >
                </div>

                <!-- Jenis & Kode Faskes -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Fasilitas <span class="text-rose-500">*</span></label>
                        <select
                            name="jenis"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                            <option value="puskesmas">🏛️ Puskesmas (Pusat Kesehatan Masyarakat)</option>
                            <option value="posyandu" selected>👶 Posyandu (Pos Pelayanan Terpadu)</option>
                            <option value="klinik">🩺 Klinik Pratama / Swasta</option>
                            <option value="rumah_sakit">🏥 Rumah Sakit Rujukan Stunting</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kode Faskes (Opsional)</label>
                        <input
                            type="text"
                            name="kode_faskes"
                            placeholder="Contoh: FASKES-317109 (otomatis jika kosong)"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-mono"
                        >
                    </div>
                </div>

                <!-- Alamat Fasilitas (Validasi min 10 karakter) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap &amp; Lokasi <span class="text-rose-500">*</span></label>
                    <textarea
                        name="alamat"
                        rows="2.5"
                        required
                        placeholder="Contoh: Jl. Petojo Enclek No. 14, RT 03/RW 02, Kel. Gambir (Wajib alamat valid minimal 10 karakter)"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    ></textarea>
                    <span class="text-[10.5px] text-slate-400 mt-0.5 block">Alamat yang tidak valid atau kurang lengkap akan ditolak oleh sistem validasi.</span>
                </div>

                <!-- Jam Layanan & Layanan Tambahan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jam Layanan Operasional <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="jam_layanan"
                            value="Senin - Jumat: 08.00 - 15.00 WIB"
                            required
                            placeholder="Contoh: Senin - Jumat: 07.30 - 16.00 WIB"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Layanan Tambahan / Khusus</label>
                        <input
                            type="text"
                            name="layanan_tambahan"
                            placeholder="Contoh: UGD 24 Jam / Penimbangan & PMT"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>
                </div>

                <!-- Kontak & PIC -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Kontak / Telepon <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="kontak"
                            required
                            placeholder="Contoh: (021) 384-5120 atau 0812-9844-3321"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">PIC / Petugas Faskes (Opsional)</label>
                        <input
                            type="text"
                            name="pic"
                            placeholder="Contoh: Kader Ibu Endang / dr. Maya Sp.A"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>
                </div>

                <!-- Titik Koordinat GPS (Latitude & Longitude) -->
                <div class="p-3.5 rounded-2xl bg-sky-50/60 border border-sky-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-800">
                            Titik Koordinat GPS (Geolokasi) <span class="text-rose-500">*</span>
                        </label>
                        <button
                            type="button"
                            onclick="fillSampleCoordinate()"
                            class="text-[11px] font-bold text-[#0284c7] hover:underline cursor-pointer"
                        >
                            📍 Isi Titik Wilayah Gambir
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-600 mb-1">Garis Lintang (Latitude: -90 s/d 90)</span>
                            <input
                                type="number"
                                step="any"
                                name="latitude"
                                id="addFacilityLat"
                                required
                                placeholder="Contoh: -6.1724000"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                            >
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-600 mb-1">Garis Bujur (Longitude: -180 s/d 180)</span>
                            <input
                                type="number"
                                step="any"
                                name="longitude"
                                id="addFacilityLng"
                                required
                                placeholder="Contoh: 106.8185000"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                            >
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-500 block">Koordinat di luar rentang geografis valid akan ditolak secara otomatis oleh server.</span>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        onclick="closeAddFacilityModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        Simpan Fasilitas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 2: EDIT / UBAH FASILITAS KESEHATAN (PBI-023)                  -->
    <!-- =================================================================== -->
    <div id="editFacilityModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Perbarui Data Fasilitas Kesehatan</h3>
                        <p class="text-xs text-slate-500">Ubah detail layanan, jadwal operasional, dan titik GPS fasilitas</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditFacilityModal()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="editFacilityForm" action="" method="POST" class="mt-5 space-y-4">
                @csrf
                @method('PUT')
                
                <!-- Nama Fasilitas -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Fasilitas Kesehatan <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        name="nama_fasilitas"
                        id="editFacilityName"
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    >
                </div>

                <!-- Jenis & Kode Faskes -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Fasilitas <span class="text-rose-500">*</span></label>
                        <select
                            name="jenis"
                            id="editFacilityJenis"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                            <option value="puskesmas">🏛️ Puskesmas (Pusat Kesehatan Masyarakat)</option>
                            <option value="posyandu">👶 Posyandu (Pos Pelayanan Terpadu)</option>
                            <option value="klinik">🩺 Klinik Pratama / Swasta</option>
                            <option value="rumah_sakit">🏥 Rumah Sakit Rujukan Stunting</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kode Faskes</label>
                        <input
                            type="text"
                            name="kode_faskes"
                            id="editFacilityCode"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-mono"
                        >
                    </div>
                </div>

                <!-- Alamat Fasilitas -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap &amp; Lokasi <span class="text-rose-500">*</span></label>
                    <textarea
                        name="alamat"
                        id="editFacilityAddress"
                        rows="2.5"
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    ></textarea>
                </div>

                <!-- Jam Layanan & Layanan Tambahan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jam Layanan Operasional <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="jam_layanan"
                            id="editFacilityHours"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Layanan Tambahan / Khusus</label>
                        <input
                            type="text"
                            name="layanan_tambahan"
                            id="editFacilityExtra"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>
                </div>

                <!-- Kontak & PIC -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Kontak / Telepon <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="kontak"
                            id="editFacilityContact"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">PIC / Petugas Faskes</label>
                        <input
                            type="text"
                            name="pic"
                            id="editFacilityPic"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>
                </div>

                <!-- Titik Koordinat GPS -->
                <div class="p-3.5 rounded-2xl bg-sky-50/60 border border-sky-100 space-y-3">
                    <label class="block text-xs font-bold text-slate-800">
                        Titik Koordinat GPS (Geolokasi) <span class="text-rose-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-600 mb-1">Garis Lintang (Latitude: -90 s/d 90)</span>
                            <input
                                type="number"
                                step="any"
                                name="latitude"
                                id="editFacilityLat"
                                required
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                            >
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-600 mb-1">Garis Bujur (Longitude: -180 s/d 180)</span>
                            <input
                                type="number"
                                step="any"
                                name="longitude"
                                id="editFacilityLng"
                                required
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                            >
                        </div>
                    </div>
                </div>

                <!-- Status Fasilitas -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Layanan Faskes <span class="text-rose-500">*</span></label>
                    <select
                        name="status"
                        id="editFacilityStatus"
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    >
                        <option value="aktif">● Aktif (Tampil pada rujukan terdekat pengguna)</option>
                        <option value="tidak_aktif">● Tidak Aktif (Sementara dinonaktifkan)</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        onclick="closeEditFacilityModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        Simpan Perubahan Fasilitas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 3: KONFIRMASI HAPUS FASILITAS KESEHATAN (PBI-023)             -->
    <!-- =================================================================== -->
    <div id="deleteFacilityModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl text-center border border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-[#e11d48] mx-auto flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">Hapus Fasilitas Kesehatan?</h3>
            <p id="deleteFacilityNameDisplay" class="text-xs font-semibold text-slate-800 mt-1 italic leading-snug"></p>
            <p class="text-[11px] text-slate-500 mt-2">Data fasilitas ini akan dihapus dari direktori dan tidak lagi direkomendasikan pada aplikasi pengguna.</p>

            <form id="deleteFacilityForm" method="POST" action="" class="mt-6 flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button
                    type="button"
                    onclick="closeDeleteFacilityModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#e11d48] hover:bg-rose-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                >
                    Ya, Hapus Fasilitas
                </button>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 4: DETAIL FASILITAS                                           -->
    <!-- =================================================================== -->
    <div id="facilityDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                <div>
                    <span id="detailFacilityBadge" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold mb-2"></span>
                    <h3 id="detailFacilityName" class="text-base font-black text-slate-900 leading-snug"></h3>
                    <p id="detailFacilityCode" class="text-xs font-mono text-slate-400 mt-0.5"></p>
                </div>
                <button type="button" onclick="closeFacilityDetail()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="mt-4 space-y-3.5 text-xs">
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">Alamat Fasilitas</span>
                    <p id="detailFacilityAddress" class="text-slate-800 leading-relaxed font-medium"></p>
                    <a id="detailFacilityMapsLink" href="#" target="_blank" class="inline-flex items-center gap-1 mt-2 text-[#0284c7] font-bold hover:underline">
                        <span>🗺️ Buka di Google Maps</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 rounded-2xl bg-sky-50/50 border border-sky-100">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">Jam Layanan</span>
                        <p id="detailFacilityHours" class="font-bold text-slate-800 leading-snug"></p>
                        <p id="detailFacilityExtra" class="text-[10.5px] font-bold text-[#e11d48] mt-0.5"></p>
                    </div>

                    <div class="p-3 rounded-2xl bg-emerald-50/50 border border-emerald-100">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">Kontak &amp; PIC</span>
                        <p id="detailFacilityContact" class="font-bold text-slate-800 leading-snug"></p>
                        <p id="detailFacilityPic" class="text-[10.5px] text-slate-500 mt-0.5"></p>
                    </div>
                </div>

                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Koordinat Geografis</span>
                        <span id="detailFacilityCoord" class="font-mono text-slate-700 font-bold"></span>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10.5px] font-bold bg-emerald-100 text-emerald-800">
                        Status: Terdaftar Aktif
                    </span>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            onclick="openEditFromDetail()"
                            class="px-4 py-2 rounded-xl bg-sky-50 text-[#0284c7] hover:bg-sky-100 border border-sky-200 text-xs font-bold transition cursor-pointer flex items-center gap-1.5"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Ubah Fasilitas</span>
                        </button>

                        <button
                            type="button"
                            onclick="openDeleteFromDetail()"
                            class="px-4 py-2 rounded-xl bg-rose-50 text-[#e11d48] hover:bg-rose-100 border border-rose-200 text-xs font-bold transition cursor-pointer flex items-center gap-1.5"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>

                    <button
                        type="button"
                        onclick="closeFacilityDetail()"
                        class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL LOGOUT                                                        -->
    <!-- =================================================================== -->
    <div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl text-center border border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-[#e11d48] mx-auto flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">Keluar dari Portal Nakes?</h3>
            <p class="text-xs text-slate-500 mt-1">Sesi Anda sebagai Administrator / Tenaga Kesehatan Faskes akan diakhiri.</p>

            <div class="mt-6 flex items-center justify-center gap-3">
                <button
                    type="button"
                    onclick="closeLogoutModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                >
                    Batal
                </button>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#e11d48] hover:bg-rose-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- TOAST NOTIFICATION CONTAINER                                        -->
    <!-- =================================================================== -->
    <div id="toastNotification" class="fixed bottom-5 right-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-xl flex items-center gap-3 border border-slate-800 text-xs max-w-sm">
            <div id="toastIcon" class="w-7 h-7 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div id="toastTitle" class="font-bold text-slate-100">Pemberitahuan</div>
                <div id="toastMessage" class="text-slate-400 text-[11px] truncate">Pesan Anda berhasil diproses.</div>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- JAVASCRIPT LOGIC CLIENT-SIDE                                        -->
    <!-- =================================================================== -->
    <script>
        let currentJenisFilter = 'semua';
        let activeFacility = null;

        // Toggle Sidebar Mobile
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

        // Feature notice toast
        function showFeatureNotice(featureName) {
            showToast(featureName, 'Modul ' + featureName + ' sedang dalam sinkronisasi faskes.');
        }

        // Toast Helper
        function showToast(title, message) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;

            toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3500);
        }

        // Modal Tambah Fasilitas
        function openAddFacilityModal() {
            document.getElementById('addFacilityModal').classList.remove('hidden');
        }

        function closeAddFacilityModal() {
            document.getElementById('addFacilityModal').classList.add('hidden');
        }

        // Helper isi koordinat contoh di wilayah Gambir
        function fillSampleCoordinate() {
            document.getElementById('addFacilityLat').value = -6.1735000;
            document.getElementById('addFacilityLng').value = 106.8180000;
            showToast('Koordinat Terisi', 'Titik koordinat wilayah Gambir (-6.1735, 106.8180) telah diisikan.');
        }

        // Modal Detail Fasilitas
        function openFacilityDetail(item) {
            activeFacility = item;
            document.getElementById('detailFacilityName').textContent = item.nama_fasilitas;
            document.getElementById('detailFacilityCode').textContent = 'KODE: ' + (item.kode_faskes || '-');
            document.getElementById('detailFacilityAddress').textContent = item.alamat + (item.wilayah ? ', ' + item.wilayah : '');
            document.getElementById('detailFacilityHours').textContent = item.jam_layanan;
            document.getElementById('detailFacilityExtra').textContent = item.layanan_tambahan || '';
            document.getElementById('detailFacilityContact').textContent = item.kontak;
            document.getElementById('detailFacilityPic').textContent = item.pic ? 'PIC: ' + item.pic : 'PIC Faskes Terdaftar';
            document.getElementById('detailFacilityCoord').textContent = item.latitude + ', ' + item.longitude;
            document.getElementById('detailFacilityMapsLink').href = `https://www.google.com/maps/search/?api=1&query=${item.latitude},${item.longitude}`;

            const badge = document.getElementById('detailFacilityBadge');
            badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold mb-2 bg-sky-50 text-sky-700 border border-sky-200';
            badge.textContent = (item.jenis ? item.jenis.toUpperCase() : 'FASILITAS') + ' • ' + (item.akreditasi || 'TERVERIFIKASI');

            document.getElementById('facilityDetailModal').classList.remove('hidden');
        }

        function closeFacilityDetail() {
            document.getElementById('facilityDetailModal').classList.add('hidden');
        }

        // Modal Edit Fasilitas (PBI-023)
        function openEditFacilityModal(item) {
            activeFacility = item;
            document.getElementById('editFacilityName').value = item.nama_fasilitas || '';
            document.getElementById('editFacilityJenis').value = item.jenis || 'puskesmas';
            document.getElementById('editFacilityCode').value = item.kode_faskes || '';
            document.getElementById('editFacilityAddress').value = item.alamat || '';
            document.getElementById('editFacilityHours').value = item.jam_layanan || '';
            document.getElementById('editFacilityExtra').value = item.layanan_tambahan || '';
            document.getElementById('editFacilityContact').value = item.kontak || '';
            document.getElementById('editFacilityPic').value = item.pic || '';
            document.getElementById('editFacilityLat').value = item.latitude || '';
            document.getElementById('editFacilityLng').value = item.longitude || '';
            document.getElementById('editFacilityStatus').value = item.status || 'aktif';

            const form = document.getElementById('editFacilityForm');
            form.action = `/admin/layanan-kesehatan/${item.id}`;

            document.getElementById('editFacilityModal').classList.remove('hidden');
        }

        function closeEditFacilityModal() {
            document.getElementById('editFacilityModal').classList.add('hidden');
        }

        // Modal Konfirmasi Hapus Fasilitas (PBI-023)
        function openDeleteFacilityModal(id, name) {
            document.getElementById('deleteFacilityNameDisplay').textContent = '"' + name + '"';
            const form = document.getElementById('deleteFacilityForm');
            form.action = `/admin/layanan-kesehatan/${id}`;
            document.getElementById('deleteFacilityModal').classList.remove('hidden');
        }

        function closeDeleteFacilityModal() {
            document.getElementById('deleteFacilityModal').classList.add('hidden');
        }

        // Aksi Ubah & Hapus dari Modal Detail
        function openEditFromDetail() {
            if (activeFacility) {
                closeFacilityDetail();
                openEditFacilityModal(activeFacility);
            }
        }

        function openDeleteFromDetail() {
            if (activeFacility) {
                closeFacilityDetail();
                openDeleteFacilityModal(activeFacility.id, activeFacility.nama_fasilitas);
            }
        }

        // Filter Jenis Pills
        function setJenisFilter(jenis, button) {
            currentJenisFilter = jenis;
            document.querySelectorAll('.jenis-filter-pill').forEach(btn => {
                btn.classList.remove('bg-[#0284c7]', 'text-white');
                btn.classList.add('bg-slate-100', 'text-slate-600');
            });
            button.classList.remove('bg-slate-100', 'text-slate-600');
            button.classList.add('bg-[#0284c7]', 'text-white');
            filterFacilityTable();
        }

        // Filter tabel live & pencarian gabungan (PBI-024)
        function filterFacilityTable() {
            const query = document.getElementById('facilitySearchInput').value.toLowerCase().trim();
            const statusFilter = document.getElementById('facilityStatusFilter').value;
            const rows = document.querySelectorAll('.facility-row');
            const clientEmpty = document.getElementById('clientEmptyRow');
            let count = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const code = row.getAttribute('data-code') || '';
                const address = row.getAttribute('data-address') || '';
                const jenis = row.getAttribute('data-jenis') || '';
                const status = row.getAttribute('data-status') || '';

                // Pencarian berdasarkan nama & filter jenis digabung (Acceptance Criteria 1)
                const matchesQuery = query === '' || name.includes(query) || code.includes(query) || address.includes(query);
                const matchesJenis = currentJenisFilter === 'semua' || jenis === currentJenisFilter;
                const matchesStatus = statusFilter === 'all' || status === statusFilter;

                if (matchesQuery && matchesJenis && matchesStatus) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan pesan ketika data tidak ditemukan (Acceptance Criteria 2)
            if (clientEmpty) {
                if (count === 0 && rows.length > 0) {
                    clientEmpty.classList.remove('hidden');
                    const emptyMsg = document.getElementById('clientEmptyMsg');
                    if (emptyMsg) {
                        if (query && currentJenisFilter !== 'semua') {
                            emptyMsg.textContent = `Tidak ditemukan fasilitas kesehatan berjenis '${currentJenisFilter}' dengan kata kunci '${query}'.`;
                        } else if (query) {
                            emptyMsg.textContent = `Tidak ditemukan fasilitas kesehatan yang memuat kata kunci '${query}'.`;
                        } else {
                            emptyMsg.textContent = `Tidak ditemukan fasilitas kesehatan dalam kategori '${currentJenisFilter}'.`;
                        }
                    }
                } else {
                    clientEmpty.classList.add('hidden');
                }
            }

            document.getElementById('tableRecordCount').textContent = `Menampilkan ${count} fasilitas kesehatan terdaftar`;
        }

        // Reset Filter & Pencarian (PBI-024)
        function resetSearchAndFilter() {
            document.getElementById('facilitySearchInput').value = '';
            document.getElementById('facilityStatusFilter').value = 'all';
            document.getElementById('facilitySortFilter').value = 'newest';
            const allBtn = document.querySelector('.jenis-filter-pill[data-jenis="semua"]');
            if (allBtn) {
                setJenisFilter('semua', allBtn);
            } else {
                currentJenisFilter = 'semua';
                filterFacilityTable();
            }
            showToast('Filter Direset', 'Menampilkan seluruh daftar fasilitas kesehatan.');
        }

        // Sort Table
        function sortFacilityTable() {
            const mode = document.getElementById('facilitySortFilter').value;
            const tbody = document.getElementById('facilityTableBody');
            const rows = Array.from(tbody.querySelectorAll('.facility-row'));

            if (mode === 'name_asc') {
                rows.sort((a, b) => a.getAttribute('data-name').localeCompare(b.getAttribute('data-name')));
            } else if (mode === 'name_desc') {
                rows.sort((a, b) => b.getAttribute('data-name').localeCompare(a.getAttribute('data-name')));
            }

            rows.forEach(r => tbody.appendChild(r));
        }

        // Logout Modal
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }
    </script>
</body>
</html>
