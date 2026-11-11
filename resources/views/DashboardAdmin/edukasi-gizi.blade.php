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
    <title>Data Edukasi Gizi - NutriGrow | Portal Admin Tenaga Kesehatan</title>

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

                    <!-- 4. Data Tumbuh Kembang Anak (PBI-016) -->
                    <a
                        href="{{ route('admin.pengukuran.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Tumbuh Kembang Anak</span>
                    </a>

                    <!-- 5. Data Edukasi Gizi (ACTIVE) -->
                    <a
                        href="{{ route('admin.edukasi.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#0284c7] text-white shadow-xs font-bold transition"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
            <div class="pt-4 border-t border-slate-100">
                <!-- Faskes Info Card -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 mb-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-white shadow-xs border border-slate-100 flex items-center justify-center text-sky-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-xs font-bold text-slate-800 truncate">{{ $faskesName }}</h4>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="px-1.5 py-0.5 rounded-md bg-rose-50 text-[8.5px] font-bold text-[#e11d48]">
                                    Akreditasi Paripurna
                                </span>
                            </div>
                            <p class="text-[9.5px] font-medium text-slate-400 mt-1 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Faskes Wilayah 01
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Keluar Portal Link -->
                <button
                    type="button"
                    onclick="openLogoutModal()"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50/70 transition cursor-pointer"
                >
                    <span class="font-bold">Keluar Portal</span>
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </div>
        </aside>

        <!-- =============================================================== -->
        <!-- 2. MAIN CONTENT AREA                                            -->
        <!-- =============================================================== -->
        <main class="flex-1 min-w-0 flex flex-col">

            <!-- Top Header Bar -->
            <header class="bg-white border-b border-slate-200/90 sticky top-0 z-30 px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
                <!-- Left: Breadcrumbs -->
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <span class="hover:text-slate-700 cursor-pointer">Portal Faskes</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="font-semibold text-slate-800">Monitoring Klinis</span>
                </div>

                <!-- Right: Notification & Profile -->
                <div class="flex items-center gap-3">
                    <!-- Notification Bell -->
                    <button
                        type="button"
                        onclick="showToast('Notifikasi', '3 artikel baru dalam antrean telaah dokter spesialis.')"
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
                        <svg class="w-3.5 h-3.5 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Page Body Content -->
            <div class="p-4 sm:p-6 lg:p-8 space-y-6">

                <!-- Header Halaman & Tombol Aksi (Persis Tata Letak Referensi Mockup) -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400 mb-1.5">
                            <span>Portal Tenaga Kesehatan</span>
                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="text-slate-600 font-bold">Data Edukasi Gizi</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Data Edukasi Gizi
                        </h1>
                        <p class="text-xs sm:text-[13px] text-slate-500 mt-1 leading-relaxed">
                            Kelola artikel gizi dan edukasi pencegahan stunting untuk masyarakat &amp;<br class="hidden sm:inline"> keluarga sasaran.
                        </p>
                    </div>

                    <!-- Action Buttons: 2 Tombol Bertumpuk ke Kanan Sesuai Mockup -->
                    <div class="flex flex-col items-start sm:items-end gap-2.5 shrink-0 self-start sm:self-auto">
                        <!-- 1. Pratinjau Portal Edukasi Pengguna (Pill Biru Muda) -->
                        <a
                            href="{{ route('home') }}#edukasi"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#e8f2fc] hover:bg-[#d8e8f8] text-xs font-semibold text-[#0284c7] transition cursor-pointer"
                        >
                            <svg class="w-4 h-4 text-[#0284c7] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="6" y="2" width="12" height="20" rx="3"/>
                                <line x1="11" y1="18" x2="13" y2="18"/>
                            </svg>
                            <span>Pratinjau Portal Edukasi Pengguna</span>
                        </a>

                        <!-- 2. + Tambah Artikel (Pill Biru Solid dengan Ikon Lingkaran Plus) -->
                        <button
                            type="button"
                            onclick="openAddArticleModal()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs hover:shadow transition cursor-pointer"
                        >
                            <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                            </svg>
                            <span>+ Tambah Artikel</span>
                        </button>
                    </div>
                </div>

                <!-- Alert Notifikasi Flash Sukses / Error -->
                @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-bold text-xs sm:text-sm text-emerald-900">Operasi Berhasil</h5>
                            <p class="text-[11px] text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @endif

                <!-- Info Notice Callout (Pemisahan Ruang Lingkup Sistem Klinis) -->
                <div class="p-4 rounded-2xl bg-[#f0f9ff] border border-sky-100 flex items-start gap-3.5 shadow-2xs">
                    <div class="w-7 h-7 rounded-xl bg-sky-100 text-[#0284c7] flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs text-slate-600 leading-relaxed">
                        <span class="font-bold text-slate-800 block mb-0.5">Pemisahan Ruang Lingkup Sistem Klinis:</span>
                        Halaman ini khusus untuk publikasi artikel ilmiah populer, panduan praktik pola asuh, dan kampanye pencegahan stunting. Master data tabel Angka Kecukupan Gizi (AKG), densitas mikro/makronutrien pangan lokal dikelola secara terpisah melalui modul
                        <a href="javascript:void(0)" onclick="showFeatureNotice('Data Informasi Nutrisi')" class="font-bold text-[#0284c7] hover:underline">Data Informasi Nutrisi</a>.
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- 3. KARTU STATISTIK (4 STAT CARDS)                           -->
                <!-- =========================================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- 1. TOTAL ARTIKEL -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-sky-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TOTAL ARTIKEL</span>
                            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-3xl font-black text-slate-900 tracking-tight">28</div>
                            <div class="mt-1 flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <span>+3 artikel ditambahkan bulan ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. ARTIKEL TERBIT -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-sky-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">ARTIKEL TERBIT</span>
                            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-3xl font-black text-slate-900 tracking-tight">22</div>
                            <div class="mt-1 flex items-center gap-1.5 text-[11px] font-semibold text-slate-500">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <span>Aktif di aplikasi NutriGrow Pengguna</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. DRAFT DISIMPAN -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-rose-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">DRAFT DISIMPAN</span>
                            <div class="w-8 h-8 rounded-xl bg-rose-50 text-[#e11d48] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-3xl font-black text-[#e11d48] tracking-tight">6</div>
                            <div class="mt-1 flex items-center gap-1.5 text-[11px] font-semibold text-slate-500">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                                <span>Tahap telaah nakes &amp; dokter spesialis</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. PEMBACA BULAN INI -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-sky-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">PEMBACA BULAN INI</span>
                            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-3xl font-black text-slate-900 tracking-tight">14.820</div>
                            <div class="mt-1 flex items-center justify-between text-[11px] font-semibold text-slate-500">
                                <span>Fase Anak terbanyak (58%)</span>
                                <button type="button" onclick="showToast('Analisis Pembaca', 'Sebanyak 8.595 pembaca berinteraksi dengan artikel kategori Anak & Balita bulan ini.')" class="text-sky-600 hover:text-sky-700 font-bold flex items-center gap-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Detail</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- 4. FILTER & SEARCH BAR SECTION                              -->
                <!-- =========================================================== -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs space-y-3.5">
                    <!-- Top Filter Row: Search + Status + Sorting -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        <!-- Search Input -->
                        <div class="md:col-span-6 relative">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input
                                type="text"
                                id="articleSearchInput"
                                onkeyup="filterArticlesTable()"
                                placeholder="Cari judul artikel, topik gizi, atau penulis..."
                                class="w-full pl-9 pr-4 py-2.5 bg-slate-50/70 border border-slate-200/90 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"
                            >
                        </div>

                        <!-- Status Filter Dropdown -->
                        <div class="md:col-span-3 relative">
                            <select
                                id="articleStatusFilter"
                                onchange="filterArticlesTable()"
                                class="w-full pl-9 pr-8 py-2.5 bg-white border border-slate-200/90 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 appearance-none transition cursor-pointer"
                            >
                                <option value="all">Status: Semua Status</option>
                                <option value="terbit">Status: Terbit</option>
                                <option value="draft">Status: Draft</option>
                            </select>
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <svg class="w-3.5 h-3.5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        <!-- Sorting Filter Dropdown -->
                        <div class="md:col-span-3 relative">
                            <select
                                id="articleSortFilter"
                                onchange="sortArticlesTable()"
                                class="w-full pl-9 pr-8 py-2.5 bg-white border border-slate-200/90 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 appearance-none transition cursor-pointer"
                            >
                                <option value="newest">Urutan: Paling Baru Diperbarui</option>
                                <option value="oldest">Urutan: Terlama</option>
                                <option value="views">Urutan: Pembaca Terbanyak</option>
                            </select>
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                            </svg>
                            <svg class="w-3.5 h-3.5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Bottom Filter Row: Fase Sasaran Pills -->
                    <div class="flex items-center gap-2 pt-2 border-t border-slate-100 flex-wrap">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mr-1">FASE SASARAN:</span>
                        
                        <button
                            type="button"
                            onclick="setPhaseFilter('semua', this)"
                            class="phase-filter-pill px-3 py-1.5 rounded-full text-xs font-bold bg-[#0284c7] text-white transition cursor-pointer"
                            data-phase="semua"
                        >
                            Semua Fase (28)
                        </button>
                        
                        <button
                            type="button"
                            onclick="setPhaseFilter('pra-hamil', this)"
                            class="phase-filter-pill px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer"
                            data-phase="pra-hamil"
                        >
                            Pra-Hamil (6)
                        </button>

                        <button
                            type="button"
                            onclick="setPhaseFilter('hamil', this)"
                            class="phase-filter-pill px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer"
                            data-phase="hamil"
                        >
                            Hamil (9)
                        </button>

                        <button
                            type="button"
                            onclick="setPhaseFilter('anak', this)"
                            class="phase-filter-pill px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer"
                            data-phase="anak"
                        >
                            Anak &amp; Balita (13)
                        </button>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- 5. TABEL DATA EDUKASI GIZI (PERSIS MOCKUP REFERENSI)        -->
                <!-- =========================================================== -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="articlesTable">
                            <thead>
                                <tr class="bg-[#f8fafc] border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                                    <th class="py-3.5 px-4 sm:px-6">JUDUL &amp; RINGKASAN MATERI</th>
                                    <th class="py-3.5 px-4">KATEGORI FASE</th>
                                    <th class="py-3.5 px-4">TANGGAL PUBLIKASI</th>
                                    <th class="py-3.5 px-4">STATUS PUBLIKASI</th>
                                    <th class="py-3.5 px-4 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs text-slate-700" id="articlesTableBody">
                                @forelse($articles as $article)
                                <tr
                                    class="article-row hover:bg-slate-50/80 transition cursor-pointer group"
                                    data-title="{{ strtolower($article['title']) }}"
                                    data-author="{{ strtolower($article['author']) }}"
                                    data-phase="{{ $article['phase'] }}"
                                    data-status="{{ $article['status'] }}"
                                    onclick="openArticleDetail({{ json_encode($article) }})"
                                >
                                    <!-- Kolom 1: Judul & Ringkasan Materi -->
                                    <td class="py-4 px-4 sm:px-6">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-16 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200/80 shadow-2xs group-hover:scale-105 transition-transform duration-200">
                                                <img
                                                    src="{{ $article['image'] }}"
                                                    alt="{{ $article['title'] }}"
                                                    class="w-full h-full object-cover"
                                                    onerror="this.onerror=null;this.src='{{ asset('images/nutrigrow-icon.png') }}';"
                                                >
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#0284c7] transition truncate">
                                                    {{ $article['title'] }}
                                                </h4>
                                                <div class="mt-1 flex items-center gap-2 text-[11px] text-slate-400">
                                                    <span class="inline-flex items-center gap-1">
                                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span>{{ $article['read_time'] }}</span>
                                                    </span>
                                                    <span>•</span>
                                                    <span class="text-slate-500 font-medium truncate">Oleh: {{ $article['author'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Kolom 2: Kategori Fase -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $article['phase_badge'] }}">
                                            <span>{{ $article['phase_icon'] }}</span>
                                            <span>{{ $article['phase_label'] }}</span>
                                        </span>
                                    </td>

                                    <!-- Kolom 3: Tanggal Publikasi -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        @if($article['publish_date'] !== '-')
                                            <div class="font-bold text-slate-800">{{ $article['publish_date'] }}</div>
                                            <div class="text-[10.5px] text-slate-400">{{ $article['publish_time'] }}</div>
                                        @else
                                            <div class="font-bold text-slate-400">-</div>
                                            <div class="text-[10.5px] text-slate-400">{{ $article['publish_time'] }}</div>
                                        @endif
                                    </td>

                                    <!-- Kolom 4: Status Publikasi -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        @if($article['status'] === 'terbit')
                                            <div class="flex items-center gap-1.5 font-bold text-slate-900">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                <span>Terbit</span>
                                            </div>
                                            <div class="text-[10.5px] text-slate-400">{{ $article['status_note'] }}</div>
                                        @else
                                            <div class="flex items-center gap-1.5 font-bold text-slate-600">
                                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                                <span>Draft</span>
                                            </div>
                                            <div class="text-[10.5px] text-slate-400">{{ $article['status_note'] }}</div>
                                        @endif
                                    </td>

                                    <!-- Kolom 5: Aksi (Perbarui & Hapus) -->
                                    <td class="py-4 px-4 whitespace-nowrap text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center gap-1">
                                            <!-- Button Edit / Perbarui -->
                                            <button
                                                type="button"
                                                onclick="openEditArticleModal({{ json_encode($article) }})"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-[#0284c7] hover:bg-sky-50 transition cursor-pointer"
                                                title="Perbarui / Ubah Artikel"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>

                                            <!-- Button Hapus -->
                                            <button
                                                type="button"
                                                onclick="openDeleteArticleModal({{ $article['id'] }}, '{{ addslashes($article['title']) }}')"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                                                title="Hapus Artikel"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-slate-400 text-xs">
                                        Tidak ada artikel edukasi gizi yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer: Record Count & Pagination -->
                    <div class="py-3.5 px-4 sm:px-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                        <div id="tableRecordCount">
                            Menampilkan {{ count($articles) }} dari {{ $statistics['total_artikel']['val'] }} artikel terdaftar
                        </div>

                        <!-- Pagination Controls -->
                        <div class="flex items-center gap-1.5 font-semibold">
                            <button
                                type="button"
                                onclick="showToast('Paginasi', 'Ini adalah halaman pertama')"
                                class="w-7 h-7 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 cursor-pointer"
                                aria-label="Sebelumnya"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            
                            <button
                                type="button"
                                class="w-7 h-7 rounded-lg bg-[#0284c7] text-white flex items-center justify-center font-bold shadow-2xs"
                            >
                                1
                            </button>

                            <button
                                type="button"
                                onclick="showToast('Halaman 2', 'Beralih ke halaman 2 artikel edukasi gizi')"
                                class="w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center cursor-pointer"
                            >
                                2
                            </button>

                            <button
                                type="button"
                                onclick="showToast('Halaman 3', 'Beralih ke halaman 3 artikel edukasi gizi')"
                                class="w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center cursor-pointer"
                            >
                                3
                            </button>

                            <button
                                type="button"
                                onclick="showToast('Halaman Selanjutnya', 'Beralih ke halaman berikutnya')"
                                class="w-7 h-7 rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 cursor-pointer"
                                aria-label="Selanjutnya"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Footer Copyright & Security -->
                <div class="pt-2 pb-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-400 border-t border-slate-200/80">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Standar Publikasi Edukasi Medis Terverifikasi Kemenkes</span>
                    </div>
                    <div>
                        NutriGrow Health Admin v2.4 • &copy; 2025 Puskesmas Gambir
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 1: TAMBAH ARTIKEL EDUKASI GIZI                                -->
    <!-- =================================================================== -->
    <div id="addArticleModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Tambah Artikel Edukasi Gizi</h3>
                        <p class="text-xs text-slate-500">Publikasikan panduan ilmiah untuk keluarga &amp; ibu sasaran</p>
                    </div>
                </div>
                <button type="button" onclick="closeAddArticleModal()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.edukasi.store') }}" method="POST" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        name="title"
                        required
                        placeholder="Contoh: Pedoman Pencegahan Stunting Melalui Protein Hewani"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    >
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Fase Sasaran <span class="text-rose-500">*</span></label>
                        <select
                            name="phase"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                            <option value="anak">👶 Anak &amp; Balita (0-59 Bulan)</option>
                            <option value="hamil">🤰 Ibu Hamil</option>
                            <option value="pra-hamil">💙 Calon Ibu / Pra-Hamil</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Penulis / Nakes Verifikator <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="author"
                            value="{{ $adminName }}"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Estimasi Waktu Baca <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="read_time"
                            value="5 mnt baca"
                            required
                            placeholder="Contoh: 5 mnt baca"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select
                            name="status"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                            <option value="terbit">● Terbit (Tampil ke aplikasi Pengguna)</option>
                            <option value="draft">● Draft (Hanya tim nakes &amp; telaah)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Ringkasan Materi / Panduan Medis <span class="text-rose-500">*</span></label>
                    <textarea
                        name="summary"
                        rows="3"
                        required
                        placeholder="Tuliskan rangkuman inti artikel, bukti klinis, dan instruksi tindakan pola asuh..."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    ></textarea>
                </div>

                <!-- Gambar Thumbnail -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Sampul Artikel (Thumbnail)</label>
                    <div class="flex items-center gap-3">
                        <label class="flex-1 border-2 border-dashed border-slate-200 hover:border-sky-400 rounded-2xl p-3 text-center cursor-pointer transition">
                            <span class="text-xs text-slate-500 block">Klik untuk memilih gambar atau seret berkas</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">JPG, PNG atau WebP (Maks. 2MB)</span>
                            <input type="file" class="hidden" accept="image/*" onchange="previewThumbnailName(this)">
                        </label>
                    </div>
                    <span id="thumbnailFileName" class="text-[10px] font-semibold text-sky-600 block mt-1 hidden"></span>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        onclick="closeAddArticleModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        Simpan &amp; Publikasikan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 2: PERBARUI ARTIKEL EDUKASI GIZI (EDIT/UPDATE)                -->
    <!-- =================================================================== -->
    <div id="editArticleModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Perbarui Artikel Edukasi Gizi</h3>
                        <p class="text-xs text-slate-500">Ubah materi edukasi, sasaran fase, dan status publikasi</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditArticleModal()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="editArticleForm" method="POST" action="" class="mt-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        name="title"
                        id="editArticleTitleInput"
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    >
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Fase Sasaran <span class="text-rose-500">*</span></label>
                        <select
                            name="phase"
                            id="editArticlePhaseInput"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                            <option value="anak">👶 Anak &amp; Balita (0-59 Bulan)</option>
                            <option value="hamil">🤰 Ibu Hamil</option>
                            <option value="pra-hamil">💙 Calon Ibu / Pra-Hamil</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Penulis / Nakes Verifikator <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="author"
                            id="editArticleAuthorInput"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Estimasi Waktu Baca <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="read_time"
                            id="editArticleReadTimeInput"
                            required
                            placeholder="Contoh: 5 mnt baca"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select
                            name="status"
                            id="editArticleStatusInput"
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                        >
                            <option value="terbit">● Terbit (Tampil ke aplikasi Pengguna)</option>
                            <option value="draft">● Draft (Hanya tim nakes &amp; telaah)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Ringkasan Materi / Panduan Medis <span class="text-rose-500">*</span></label>
                    <textarea
                        name="summary"
                        id="editArticleSummaryInput"
                        rows="4"
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500"
                    ></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        onclick="closeEditArticleModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 3: KONFIRMASI HAPUS ARTIKEL                                   -->
    <!-- =================================================================== -->
    <div id="deleteArticleModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl text-center border border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-[#e11d48] mx-auto flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">Hapus Artikel Edukasi?</h3>
            <p id="deleteArticleTitleDisplay" class="text-xs font-semibold text-slate-700 mt-1 italic leading-snug"></p>
            <p class="text-[11px] text-slate-500 mt-2">Artikel ini akan dihapus dari sistem publikasi faskes dan tidak lagi tampil pada aplikasi pengguna.</p>

            <form id="deleteArticleForm" method="POST" action="" class="mt-6 flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button
                    type="button"
                    onclick="closeDeleteArticleModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#e11d48] hover:bg-rose-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                >
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 4: DETAIL & PRATINJAU ARTIKEL                                 -->
    <!-- =================================================================== -->
    <div id="articleDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="pr-4">
                    <span id="detailArticleBadge" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold mb-2"></span>
                    <h3 id="detailArticleTitle" class="text-base sm:text-lg font-black text-slate-900 leading-snug"></h3>
                    <div class="flex items-center gap-2 mt-1.5 text-xs text-slate-400">
                        <span id="detailArticleReadTime"></span>
                        <span>•</span>
                        <span id="detailArticleAuthor" class="text-slate-600 font-semibold"></span>
                    </div>
                </div>
                <button type="button" onclick="closeArticleDetail()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="mt-4 space-y-4">
                <div class="w-full h-44 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
                    <img id="detailArticleImage" src="" alt="Thumbnail" class="w-full h-full object-cover">
                </div>

                <div>
                    <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Ringkasan Materi Klinis:</h5>
                    <p id="detailArticleSummary" class="text-xs sm:text-sm text-slate-700 leading-relaxed bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80"></p>
                </div>

                <div class="grid grid-cols-2 gap-3 p-3 rounded-2xl bg-sky-50/50 border border-sky-100 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 font-semibold block uppercase">Tanggal Terbit</span>
                        <span id="detailArticleDate" class="font-bold text-slate-800"></span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 font-semibold block uppercase">Status Publikasi</span>
                        <span id="detailArticleStatus" class="font-bold"></span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            onclick="openEditFromDetail()"
                            class="px-4 py-2 rounded-xl bg-sky-50 text-[#0284c7] hover:bg-sky-100 border border-sky-200/80 text-xs font-bold transition cursor-pointer flex items-center gap-1.5"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Ubah Artikel</span>
                        </button>

                        <button
                            type="button"
                            onclick="openDeleteFromDetail()"
                            class="px-4 py-2 rounded-xl bg-rose-50 text-[#e11d48] hover:bg-rose-100 border border-rose-200/80 text-xs font-bold transition cursor-pointer flex items-center gap-1.5"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>

                    <button
                        type="button"
                        onclick="closeArticleDetail()"
                        class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 3: LOGOUT CONFIRMATION                                        -->
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
    <!-- JAVASCRIPT LOGIC & INTERAKSI CLIENT-SIDE                            -->
    <!-- =================================================================== -->
    <script>
        // State Filter & Active Modal State
        let currentPhaseFilter = 'semua';
        let activeDetailArticle = null;

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

        // Feature Notice Dialog
        function showFeatureNotice(featureName) {
            showToast(featureName, 'Modul ' + featureName + ' sedang dalam sinkronisasi data faskes.');
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

        // Phase Filter Handler
        function setPhaseFilter(phase, button) {
            currentPhaseFilter = phase;
            
            // Update button styles
            document.querySelectorAll('.phase-filter-pill').forEach(btn => {
                btn.classList.remove('bg-[#0284c7]', 'text-white');
                btn.classList.add('bg-slate-100', 'text-slate-600');
            });
            button.classList.remove('bg-slate-100', 'text-slate-600');
            button.classList.add('bg-[#0284c7]', 'text-white');

            filterArticlesTable();
        }

        // Live Filter Articles Table
        function filterArticlesTable() {
            const searchQuery = document.getElementById('articleSearchInput').value.toLowerCase().trim();
            const statusFilter = document.getElementById('articleStatusFilter').value;
            const rows = document.querySelectorAll('.article-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const title = row.getAttribute('data-title') || '';
                const author = row.getAttribute('data-author') || '';
                const phase = row.getAttribute('data-phase') || '';
                const status = row.getAttribute('data-status') || '';

                const matchesSearch = title.includes(searchQuery) || author.includes(searchQuery);
                const matchesPhase = currentPhaseFilter === 'semua' || phase === currentPhaseFilter;
                const matchesStatus = statusFilter === 'all' || status === statusFilter;

                if (matchesSearch && matchesPhase && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('tableRecordCount').textContent = `Menampilkan ${visibleCount} dari {{ $statistics['total_artikel']['val'] }} artikel terdaftar`;
        }

        // Sort Articles Table
        function sortArticlesTable() {
            const sortMode = document.getElementById('articleSortFilter').value;
            const tbody = document.getElementById('articlesTableBody');
            const rows = Array.from(tbody.querySelectorAll('.article-row'));

            if (sortMode === 'oldest') {
                rows.reverse();
            } else if (sortMode === 'views') {
                rows.sort((a, b) => {
                    return (b.getAttribute('data-title').length) - (a.getAttribute('data-title').length);
                });
            }

            rows.forEach(row => tbody.appendChild(row));
            showToast('Urutan Artikel', 'Daftar artikel diperbarui sesuai pilihan urutan.');
        }

        // Open Add Article Modal
        function openAddArticleModal() {
            document.getElementById('addArticleModal').classList.remove('hidden');
        }

        // Close Add Article Modal
        function closeAddArticleModal() {
            document.getElementById('addArticleModal').classList.add('hidden');
        }

        // Open Edit Article Modal
        function openEditArticleModal(article) {
            document.getElementById('editArticleTitleInput').value = article.full_title || article.title;
            document.getElementById('editArticlePhaseInput').value = article.phase;
            document.getElementById('editArticleAuthorInput').value = article.author;
            document.getElementById('editArticleReadTimeInput').value = article.read_time;
            document.getElementById('editArticleStatusInput').value = article.status;
            document.getElementById('editArticleSummaryInput').value = article.summary;

            const form = document.getElementById('editArticleForm');
            form.action = `/admin/edukasi-gizi/${article.id}`;

            document.getElementById('editArticleModal').classList.remove('hidden');
        }

        // Close Edit Article Modal
        function closeEditArticleModal() {
            document.getElementById('editArticleModal').classList.add('hidden');
        }

        // Open Delete Article Modal
        function openDeleteArticleModal(id, title) {
            document.getElementById('deleteArticleTitleDisplay').textContent = '"' + title + '"';
            const form = document.getElementById('deleteArticleForm');
            form.action = `/admin/edukasi-gizi/${id}`;
            document.getElementById('deleteArticleModal').classList.remove('hidden');
        }

        // Close Delete Article Modal
        function closeDeleteArticleModal() {
            document.getElementById('deleteArticleModal').classList.add('hidden');
        }

        // Actions from Detail Modal
        function openEditFromDetail() {
            if (activeDetailArticle) {
                closeArticleDetail();
                openEditArticleModal(activeDetailArticle);
            }
        }

        function openDeleteFromDetail() {
            if (activeDetailArticle) {
                closeArticleDetail();
                openDeleteArticleModal(activeDetailArticle.id, activeDetailArticle.title);
            }
        }

        // Preview File Name
        function previewThumbnailName(input) {
            if (input.files && input.files[0]) {
                const label = document.getElementById('thumbnailFileName');
                label.textContent = 'Berkas dipilih: ' + input.files[0].name;
                label.classList.remove('hidden');
            }
        }

        // Open Article Detail Modal
        function openArticleDetail(article) {
            activeDetailArticle = article;

            document.getElementById('detailArticleTitle').textContent = article.full_title || article.title;
            document.getElementById('detailArticleReadTime').textContent = article.read_time;
            document.getElementById('detailArticleAuthor').textContent = 'Oleh: ' + article.author;
            document.getElementById('detailArticleSummary').textContent = article.summary;
            document.getElementById('detailArticleImage').src = article.image;
            document.getElementById('detailArticleDate').textContent = article.publish_date !== '-' ? `${article.publish_date} (${article.publish_time})` : 'Belum Terbit (Draft)';
            
            const statusEl = document.getElementById('detailArticleStatus');
            if (article.status === 'terbit') {
                statusEl.textContent = '● Terbit (Tampil di Aplikasi Pengguna)';
                statusEl.className = 'font-bold text-emerald-600';
            } else {
                statusEl.textContent = '● Draft (Khusus Internal Faskes)';
                statusEl.className = 'font-bold text-slate-500';
            }

            const badgeEl = document.getElementById('detailArticleBadge');
            badgeEl.className = `inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold mb-2 ${article.phase_badge}`;
            badgeEl.textContent = `${article.phase_icon} Fase ${article.phase_label}`;

            document.getElementById('articleDetailModal').classList.remove('hidden');
        }

        // Close Article Detail Modal
        function closeArticleDetail() {
            document.getElementById('articleDetailModal').classList.add('hidden');
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

