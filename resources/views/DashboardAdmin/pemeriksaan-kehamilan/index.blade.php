<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pemeriksaan Kehamilan - Portal Tenaga Kesehatan | NutriGrow</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        brand: {
                            pink: '#e11d48',
                            rose: '#f43f5e',
                            sidebar: '#f0f6ff',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        @keyframes scaleUp {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-scale-up {
            animation: scaleUp 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-[#f8fafc]">

    <!-- Mobile Header Bar -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40 shadow-xs">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#e11d48]">PORTAL NAKES</span>
        </a>
        <button onclick="toggleSidebar()" type="button" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-hidden" aria-label="Toggle menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Backdrop Mobile Sidebar -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden"></div>

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- =============================================================== -->
        <!-- 1. SIDEBAR NAVIGASI (WARNA BIRU MUDA #f0f6ff SESUAI MOCKUP)      -->
        <!-- =============================================================== -->
        <aside id="sidebarMenu" class="fixed inset-y-0 left-0 z-50 w-[265px] bg-[#f0f6ff] border-r border-sky-100/90 flex flex-col justify-between py-5 px-4 shrink-0 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand Header -->
                <div class="px-2 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                        <div class="text-[9.5px] font-black uppercase tracking-widest text-[#e11d48] mt-1.5">
                            PORTAL ADMIN
                            <span class="block text-[8px] tracking-wider text-slate-500 font-semibold">TENAGA KESEHATAN</span>
                        </div>
                    </a>

                    <!-- Verified Badge Putih Bersih -->
                    <div class="mt-3.5 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-sky-200/80 text-[10.5px] font-bold text-sky-800 tracking-tight w-full shadow-xs">
                        <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>KLINIS TERVERIFIKASI</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1 text-xs font-semibold">
                    <!-- 1. Dashboard Admin -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-sky-100/60 transition">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                        </svg>
                        <span>Dashboard Admin</span>
                    </a>

                    <!-- 2. Data Pengguna -->
                    <a href="javascript:void(0)" onclick="alert('Fitur Data Pengguna sedang sinkronisasi dengan database terpusat.')" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-sky-100/60 transition">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Data Pengguna</span>
                    </a>

                    <!-- 3. Data Pemeriksaan Kehamilan (AKTIF) -->
                    <a href="{{ route('admin.pemeriksaan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#0284c7] text-white shadow-xs font-bold transition">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Pemeriksaan Kehamilan</span>
                    </a>

                    <!-- 4. Data Tumbuh Kembang Anak -->
                    <a href="javascript:void(0)" onclick="alert('Fitur Data Tumbuh Kembang Anak segera hadir pada modul pemantauan balita.')" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-sky-100/60 transition">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Tumbuh Kembang Anak</span>
                    </a>

                    <!-- 5. Data Edukasi Gizi -->
                    <a href="{{ Route::has('admin.edukasi.index') ? route('admin.edukasi.index') : 'javascript:void(0)' }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-sky-100/60 transition">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Data Edukasi Gizi</span>
                    </a>

                    <!-- 6. Data Layanan Kesehatan -->
                    <a href="javascript:void(0)" onclick="alert('Fitur Data Layanan Kesehatan faskes dalam tahap pengembangan.')" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-sky-100/60 transition">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Data Layanan Kesehatan</span>
                    </a>

                    <!-- 7. Data Informasi Nutrisi -->
                    <a href="javascript:void(0)" onclick="alert('Fitur Data Informasi Nutrisi bahan pangan terintegrasi dengan tabel komposisi pangan Kemenkes.')" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-sky-100/60 transition">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <span>Data Informasi Nutrisi</span>
                    </a>

                    <!-- 8. Manajemen Akun Admin (SUPER) -->
                    @if(Auth::check() && (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()))
                    <a href="{{ route('admin.dashboard') }}#modalManajemenAdmin" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-sky-100/60 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Manajemen Akun Admin</span>
                        </div>
                        <span class="px-1.5 py-0.5 rounded-md bg-rose-50 text-[9px] font-black uppercase text-[#e11d48] border border-rose-200">
                            SUPER
                        </span>
                    </a>
                    @endif
                </nav>
            </div>

            <!-- Footer Sidebar: Faskes Card & Keluar Portal -->
            <div class="pt-4 border-t border-sky-200/70 space-y-2">
                <div class="bg-white/90 rounded-xl p-3 border border-sky-100 shadow-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-md bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs shrink-0">
                            🏥
                        </div>
                        <div class="truncate">
                            <p class="text-[11px] font-bold text-slate-800 truncate">{{ $faskesName ?? 'Puskesmas Gambir' }}</p>
                            <p class="text-[9.5px] font-medium text-emerald-600 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Akreditasi Paripurna
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-200 text-xs font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar Portal</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- =============================================================== -->
        <!-- 2. MAIN CONTENT AREA                                            -->
        <!-- =============================================================== -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header Bar Sesuai Referensi Gambar -->
            <header class="bg-white border-b border-slate-200/90 h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium truncate">
                    <span class="hover:text-slate-800 transition">Portal Tenaga Kesehatan</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-900 font-bold truncate">Data Pemeriksaan Kehamilan</span>
                </div>

                <!-- Right Header Elements -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Pill Search Bar -->
                    <div class="relative hidden md:block w-64 lg:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            placeholder="Cari faskes, NIK, atau nama..."
                            class="w-full pl-9 pr-4 py-1.5 rounded-full bg-slate-50 border border-slate-200/90 text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                        >
                    </div>

                    <!-- Notification Bell -->
                    <div class="relative">
                        <button class="p-2 rounded-full text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition relative" title="Notifikasi Faskes">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    <!-- Admin Profile Badge -->
                    <div class="flex items-center gap-2.5 pl-1">
                        <div class="w-8 h-8 rounded-full bg-[#0284c7] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-bold text-slate-800 leading-tight">{{ $adminName ?? 'dr. Siti Nurhaliza, Sp.A' }}</div>
                            <div class="text-[10px] text-slate-500">{{ $adminRole ?? 'Administrator Faskes' }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Body Content -->
            <div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

                @if(!empty($errors) && $errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold shadow-xs">
                    <p class="font-bold mb-1">Terdapat kesalahan pengisian formulir:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Title Header & Top Action Buttons -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Data Pemeriksaan Kehamilan</h1>
                        <p class="text-xs text-slate-500 mt-1">Catat, pantau antropometri dan kelola hasil pemeriksaan komprehensif ibu hamil.</p>
                    </div>

                    <div class="flex items-center gap-2.5 shrink-0">
                        <!-- Unduh Rekap (XLS) Button -->
                        <button
                            type="button"
                            onclick="exportExcelNotice()"
                            class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-emerald-300 bg-emerald-50/70 hover:bg-emerald-100/80 text-emerald-800 text-xs font-bold transition shadow-2xs"
                        >
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Unduh Rekap (XLS)</span>
                        </button>

                        <!-- Tambah Pemeriksaan Button (Ikon plus tunggal) -->
                        <button
                            type="button"
                            onclick="openTambahModal()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold transition shadow-sm hover:shadow"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            <span>Tambah Pemeriksaan</span>
                        </button>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- 3. EMPAT KARTU STATISTIK INDIKATOR KLINIS                   -->
                <!-- =========================================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- 1. Total Pemeriksaan Bulan Ini -->
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-wider text-slate-500">TOTAL PEMERIKSAAN BULAN INI</p>
                                <div class="flex items-baseline gap-2 mt-2">
                                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistics['total_pemeriksaan']['val'] ?? '142' }}</span>
                                    <span class="text-xs font-bold text-slate-500">Pemeriksaan</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                            <span>↗ {{ $statistics['total_pemeriksaan']['growth'] ?? '+14.2%' }}</span>
                            <span class="text-slate-400 font-normal">{{ $statistics['total_pemeriksaan']['growth_note'] ?? 'dari bulan September 2025' }}</span>
                        </div>
                    </div>

                    <!-- 2. Terjadwal Kontrol -->
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-wider text-slate-500">TERJADWAL KONTROL</p>
                                <div class="flex items-baseline gap-2 mt-2">
                                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistics['terjadwal_kontrol']['val'] ?? '38' }}</span>
                                    <span class="text-xs font-bold text-slate-500">Ibu Hamil</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 border border-teal-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-600 font-medium flex items-center gap-1.5 truncate">
                            <span class="font-bold text-teal-700">{{ $statistics['terjadwal_kontrol']['sub'] ?? '7 Kunjungan' }}</span>
                            <span class="text-slate-400 truncate">{{ $statistics['terjadwal_kontrol']['note'] ?? 'dijadwalkan dalam 3 hari ke depan' }}</span>
                        </div>
                    </div>

                    <!-- 3. Perlu Intervensi KEK -->
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-wider text-rose-600">PERLU INTERVENSI KEK</p>
                                <div class="flex items-baseline gap-2 mt-2">
                                    <span class="text-3xl font-black text-rose-600 tracking-tight">{{ $statistics['perlu_intervensi_kek']['val'] ?? '12' }}</span>
                                    <span class="text-xs font-bold text-slate-500">Pasien</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] flex items-center gap-2">
                            <span class="px-1.5 py-0.5 rounded-md bg-rose-50 text-rose-700 font-bold border border-rose-200 text-[10px]">{{ $statistics['perlu_intervensi_kek']['badge'] ?? 'LiLA < 23.5 cm' }}</span>
                            <span class="text-slate-500 truncate">• {{ $statistics['perlu_intervensi_kek']['note'] ?? 'Rekomendasi PMT Rutin' }}</span>
                        </div>
                    </div>

                    <!-- 4. Perhatian Anemia -->
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-wider text-red-600">PERHATIAN ANEMIA</p>
                                <div class="flex items-baseline gap-2 mt-2">
                                    <span class="text-3xl font-black text-red-600 tracking-tight">{{ $statistics['perhatian_anemia']['val'] ?? '9' }}</span>
                                    <span class="text-xs font-bold text-slate-500">Pasien</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] flex items-center gap-2">
                            <span class="px-1.5 py-0.5 rounded-md bg-red-50 text-red-700 font-bold border border-red-200 text-[10px]">{{ $statistics['perhatian_anemia']['badge'] ?? 'Hb < 11.0 g/dL' }}</span>
                            <span class="text-slate-500 truncate">• {{ $statistics['perhatian_anemia']['note'] ?? 'Evaluasi Tablet Fe 90 butir' }}</span>
                        </div>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- 4. TOOLBAR FILTER & SEARCH                                  -->
                <!-- =========================================================== -->
                <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs space-y-3.5">
                    <form method="GET" action="{{ route('admin.pemeriksaan.index') }}" class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                        <!-- Search Box -->
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama pasien, NIK, atau nomor rekam medis..."
                                class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                            >
                        </div>

                        <!-- Dropdown Filters -->
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 lg:pb-0">
                            <!-- Bulan -->
                            <div class="relative shrink-0">
                                <select name="bulan" onchange="this.form.submit()" class="pl-3 pr-8 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 focus:bg-white focus:outline-hidden focus:border-sky-500 transition appearance-none">
                                    <option value="10">Bulan Ini: Oktober 2025</option>
                                    <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November 2025</option>
                                    <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September 2025</option>
                                    <option value="all" {{ request('bulan') == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>

                            <!-- Filter Risiko -->
                            <div class="relative shrink-0">
                                <select name="filter_risiko" onchange="this.form.submit()" class="pl-3 pr-8 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 focus:bg-white focus:outline-hidden focus:border-sky-500 transition appearance-none">
                                    <option value="">Filter Risiko</option>
                                    <option value="kek" {{ request('filter_risiko') == 'kek' ? 'selected' : '' }}>Risiko KEK (LiLA &lt; 23.5)</option>
                                    <option value="anemia" {{ request('filter_risiko') == 'anemia' ? 'selected' : '' }}>Risiko Anemia (Hb &lt; 11.0)</option>
                                    <option value="hipertensi" {{ request('filter_risiko') == 'hipertensi' ? 'selected' : '' }}>Pra-Hipertensi / Hipertensi</option>
                                    <option value="normal" {{ request('filter_risiko') == 'normal' ? 'selected' : '' }}>Kondisi Normal</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>

                            <!-- Reset Button -->
                            <a href="{{ route('admin.pemeriksaan.index') }}" class="p-2 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-600 transition shrink-0" title="Reset filter">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </a>
                        </div>
                    </form>

                    <!-- Filter Pill Tabs Sesuai Mockup -->
                    <div class="flex items-center gap-2 overflow-x-auto pt-1 pb-1 border-t border-slate-100">
                        @php
                            $activeTab = request('tab', 'semua');
                        @endphp
                        <a href="{{ route('admin.pemeriksaan.index', array_merge(request()->query(), ['tab' => 'semua'])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeTab === 'semua' ? 'bg-[#0284c7] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Semua Kunjungan
                        </a>
                        <a href="{{ route('admin.pemeriksaan.index', array_merge(request()->query(), ['tab' => 'kek'])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeTab === 'kek' ? 'bg-rose-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span class="inline-block w-2 h-2 rounded-full bg-rose-500 mr-1.5"></span>
                            Risiko KEK
                        </a>
                        <a href="{{ route('admin.pemeriksaan.index', array_merge(request()->query(), ['tab' => 'anemia'])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeTab === 'anemia' ? 'bg-red-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-1.5"></span>
                            Risiko Anemia
                        </a>
                        <a href="{{ route('admin.pemeriksaan.index', array_merge(request()->query(), ['tab' => 'normal'])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeTab === 'normal' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Normal
                        </a>
                        <a href="{{ route('admin.pemeriksaan.index', array_merge(request()->query(), ['tab' => 'trimester_1'])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeTab === 'trimester_1' ? 'bg-sky-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Trimester 1
                        </a>
                        <a href="{{ route('admin.pemeriksaan.index', array_merge(request()->query(), ['tab' => 'trimester_2'])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeTab === 'trimester_2' ? 'bg-sky-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Trimester 2
                        </a>
                        <a href="{{ route('admin.pemeriksaan.index', array_merge(request()->query(), ['tab' => 'trimester_3'])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition shrink-0 {{ $activeTab === 'trimester_3' ? 'bg-sky-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Trimester 3
                        </a>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- 5. TABEL HASIL PEMERIKSAAN KEHAMILAN (SESUAI MOCKUP GAMBAR) -->
                <!-- =========================================================== -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[10.5px] font-black uppercase tracking-wider text-slate-500">
                                    <th class="py-3.5 px-4 sm:px-6">NAMA IBU HAMIL &amp; GRAVIDA</th>
                                    <th class="py-3.5 px-4">TGL PERIKSA</th>
                                    <th class="py-3.5 px-4">GESTASI</th>
                                    <th class="py-3.5 px-4">BB / PERUBAHAN</th>
                                    <th class="py-3.5 px-4">TEKANAN DARAH</th>
                                    <th class="py-3.5 px-4">LILA</th>
                                    <th class="py-3.5 px-4">HB</th>
                                    <th class="py-3.5 px-4 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($pemeriksaans as $item)
                                @php
                                    $ibu = $item->ibu;
                                    $kehamilan = $item->kehamilan;
                                    $gestasiBadge = $item->gestasi_badge;
                                    $inisial = $ibu ? $ibu->inisial : 'IH';
                                    
                                    // Variasi warna inisial avatar
                                    $colorMap = [
                                        'RS' => 'bg-sky-100 text-sky-700',
                                        'DS' => 'bg-rose-100 text-rose-700',
                                        'FH' => 'bg-amber-100 text-amber-700',
                                        'SA' => 'bg-emerald-100 text-emerald-700',
                                        'LP' => 'bg-indigo-100 text-indigo-700',
                                        'NH' => 'bg-pink-100 text-pink-700',
                                    ];
                                    $avatarClass = $colorMap[$inisial] ?? 'bg-sky-100 text-sky-700';
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <!-- Nama Ibu Hamil & Gravida -->
                                    <td class="py-4 px-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full {{ $avatarClass }} font-bold text-xs flex items-center justify-center shrink-0 uppercase shadow-2xs">
                                                {{ $inisial }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-slate-900 text-xs">{{ $ibu ? $ibu->name : 'Ny. Pasien' }}</span>
                                                    <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold text-[9.5px] border border-slate-200">
                                                        {{ $kehamilan ? ($kehamilan->gravida ?: 'G1P0A0') : 'G1P0A0' }}
                                                    </span>
                                                </div>
                                                <p class="text-[11px] text-slate-400 mt-0.5">
                                                    NIK: {{ $ibu && $ibu->nik ? $ibu->nik : '3171025508920001' }} • {{ $ibu && $ibu->usia_tahun ? $ibu->usia_tahun . ' thn' : '30 thn' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Tanggal Periksa -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 text-xs">
                                            {{ \Carbon\Carbon::parse($item->tgl_periksa)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-[10.5px] text-slate-400 mt-0.5">
                                            {{ $item->jam_periksa ?: '09:30' }} WIB
                                        </div>
                                    </td>

                                    <!-- Gestasi -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-sky-700 text-xs">
                                            {{ $gestasiBadge['minggu'] }}
                                        </div>
                                        <div class="mt-0.5">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $gestasiBadge['badge'] }}">
                                                {{ $gestasiBadge['label'] }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- BB / Perubahan -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 text-xs">
                                            {{ number_format($item->berat_badan, 1) }} kg
                                        </div>
                                        @if($item->perubahan_bb_formatted)
                                        <div class="text-[10.5px] font-semibold mt-0.5 {{ str_contains($item->perubahan_bb_formatted, '↓') ? 'text-rose-600' : 'text-emerald-600' }}">
                                            {{ $item->perubahan_bb_formatted }}
                                        </div>
                                        @else
                                        <div class="text-[10px] text-slate-400 mt-0.5">Basis pertama</div>
                                        @endif
                                    </td>

                                    <!-- Tekanan Darah -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-xs {{ $item->status_tekanan_darah === 'pra_hipertensi' ? 'text-red-600' : 'text-slate-800' }}">
                                            {{ $item->tekanan_darah }} <span class="font-normal text-[10px] text-slate-400">mmHg</span>
                                        </div>
                                        <div class="text-[10.5px] font-semibold mt-0.5">
                                            @if($item->status_tekanan_darah === 'pra_hipertensi')
                                                <span class="text-rose-600 font-bold">• Pra-Hipertensi</span>
                                            @elseif($item->status_tekanan_darah === 'optimal')
                                                <span class="text-emerald-700 font-bold">• Optimal</span>
                                            @elseif($item->status_tekanan_darah === 'normal_rendah')
                                                <span class="text-slate-500">Normal Rendah</span>
                                            @else
                                                <span class="text-slate-500">Normal</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- LiLA -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 text-xs">
                                            {{ number_format($item->lila, 1) }} cm
                                        </div>
                                        <div class="text-[10.5px] font-semibold mt-0.5">
                                            @if($item->status_kek === 'risiko_kek')
                                                <span class="text-rose-600 font-bold">Risiko KEK</span>
                                            @else
                                                <span class="text-slate-500">&ge; 23.5 cm (Aman)</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Hb -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-xs {{ str_starts_with($item->status_anemia, 'anemia_') ? 'text-red-600' : 'text-slate-800' }}">
                                            {{ $item->hb ? number_format($item->hb, 1) . ' g/dL' : '-' }}
                                        </div>
                                        <div class="text-[10.5px] font-semibold mt-0.5">
                                            @if($item->status_anemia === 'anemia_ringan')
                                                <span class="text-rose-600 font-bold">Anemia Ringan</span>
                                            @elseif($item->status_anemia === 'anemia_sedang')
                                                <span class="text-red-700 font-bold">Anemia Sedang</span>
                                            @elseif($item->status_anemia === 'anemia_berat')
                                                <span class="text-red-800 font-black">Anemia Berat</span>
                                            @else
                                                <span class="text-slate-500">&ge; 11.0 g/dL</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Aksi / Hapus / Detail -->
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                onclick="lihatDetail({{ json_encode($item) }})"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition"
                                                title="Lihat Detail Rekomendasi"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>

                                            <form method="POST" action="{{ route('admin.pemeriksaan.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam pemeriksaan ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Rekam">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="py-12 px-4 text-center">
                                        <div class="max-w-sm mx-auto text-center space-y-2">
                                            <div class="w-12 h-12 rounded-full bg-sky-50 text-sky-600 mx-auto flex items-center justify-center font-bold">
                                                🩺
                                            </div>
                                            <h3 class="text-sm font-bold text-slate-800">Belum Ada Rekam Pemeriksaan Kehamilan</h3>
                                            <p class="text-xs text-slate-500">Mulai catat antropometri dan rekam medis ibu hamil pertama Anda sekarang.</p>
                                            <button type="button" onclick="openTambahModal()" class="mt-2 inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold shadow-xs transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                                <span>Tambah Pemeriksaan</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Paginasi Sesuai Mockup -->
                    <div class="py-3 px-4 sm:px-6 bg-slate-50/70 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                        <div class="text-slate-500 font-medium">
                            Menampilkan <span class="font-bold text-slate-800">{{ $pemeriksaans->firstItem() ?? 1 }}-{{ $pemeriksaans->lastItem() ?? count($pemeriksaans) }}</span> dari <span class="font-bold text-slate-800">{{ $pemeriksaans->total() ?? '142' }}</span> data pemeriksaan ANC
                        </div>

                        <!-- Pagination Links -->
                        <div class="flex items-center gap-1">
                            @if($pemeriksaans->hasPages())
                                {{ $pemeriksaans->links() }}
                            @else
                                <span class="px-3 py-1.5 rounded-lg bg-[#0284c7] text-white font-bold text-xs">1</span>
                                <span class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 text-xs">2</span>
                                <span class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 text-xs">3</span>
                                <span class="px-2 text-slate-400">...</span>
                                <span class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 text-xs">24</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- 6. CATATAN PENUNJANG KEPUTUSAN KLINIS (ALERT BOX MOCKUP)    -->
                <!-- =========================================================== -->
                <div class="rounded-2xl bg-sky-50/70 border border-sky-100 p-4 sm:p-5 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs text-sky-900 leading-relaxed">
                        <p class="font-bold text-slate-900">Catatan Penunjang Keputusan Klinis:</p>
                        <p class="mt-0.5 text-slate-600">
                            Indikator risiko (KEK dan Anemia) merupakan sistem penunjang keputusan klinis otomatis berdasarkan standar antropometri Kemenkes RI dan WHO. Indikator ini berfungsi sebagai sinyal deteksi dini dan memerlukan konfirmasi asesmen langsung oleh dokter spesialis kandungan atau bidan penanggung jawab faskes.
                        </p>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- =================================================================== -->
    <!-- 7. MODAL POPUP FORMULIR TAMBAH PEMERIKSAAN KEHAMILAN BARU (IMAGE 2) -->
    <!-- =================================================================== -->
    <div id="modalTambahPemeriksaan" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeTambahModal()"></div>

        <div class="min-h-screen px-4 py-6 sm:py-10 flex items-center justify-center">
            <div class="relative bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 p-6 sm:p-8 z-10 space-y-6">

                <!-- Header Modal -->
                <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-sky-100/80 text-sky-700 flex items-center justify-center font-bold text-lg shrink-0">
                            🤰
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 tracking-tight">Tambah Pemeriksaan Kehamilan Baru</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Lengkapi data rekam medis antropometri dan tanda vital ibu hamil</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeTambahModal()" class="p-1.5 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup modal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Formulir Tambah Rekam Medis -->
                <form id="formTambahPemeriksaan" method="POST" action="{{ route('admin.pemeriksaan.store') }}" class="space-y-6">
                    @csrf

                    <!-- 1. INFORMASI PASIEN & KEHAMILAN -->
                    <div class="space-y-3.5">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-700 text-[11px] font-black flex items-center justify-center">1</span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-700">INFORMASI PASIEN &amp; KEHAMILAN</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <!-- Pilih Ibu Hamil -->
                            <div class="space-y-1 sm:col-span-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Pilih Ibu Hamil <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    id="inputKehamilanId"
                                    name="kehamilan_id"
                                    required
                                    onchange="onPasienSelected(this.value)"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                >
                                    <option value="">Pilih nama ibu hamil (NIK / No. KIA)...</option>
                                    @foreach($daftarIbuHamil as $ibuOption)
                                        <option
                                            value="{{ $ibuOption['kehamilan_id'] }}"
                                            data-gravida-hpl="{{ $ibuOption['gravida_hpl_label'] }}"
                                            data-gestasi="{{ $ibuOption['estimasi_gestasi'] }}"
                                            data-bb="{{ $ibuOption['bb_terakhir'] }}"
                                            data-lila="{{ $ibuOption['lila_terakhir'] }}"
                                        >
                                            {{ $ibuOption['nama'] }} (NIK: {{ $ibuOption['nik'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Gravida & HPL (Terisi Otomatis) -->
                            <div class="space-y-1 sm:col-span-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Status Gravida &amp; HPL <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="displayGravidaHpl"
                                    placeholder="G2P1A0 • HPL 28 Des 2025"
                                    readonly
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100/80 border border-slate-200 text-xs font-semibold text-slate-700 cursor-not-allowed"
                                >
                            </div>

                            <!-- Tanggal Pemeriksaan -->
                            <div class="space-y-1 sm:col-span-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Tanggal Pemeriksaan <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="inputTglPeriksa"
                                    name="tgl_periksa"
                                    value="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                >
                            </div>

                            <!-- Usia Gestasi (Minggu) -->
                            <div class="space-y-1 sm:col-span-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Usia Gestasi (Minggu) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="inputGestasi"
                                        name="usia_gestasi_minggu"
                                        min="1"
                                        max="45"
                                        value="32"
                                        required
                                        oninput="liveClinicalAssessment()"
                                        placeholder="32"
                                        class="w-full pl-3.5 pr-14 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-xs text-slate-400 font-medium pointer-events-none">
                                        Minggu
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. ANTROPOMETRI & TANDA VITAL -->
                    <div class="space-y-3.5 pt-2 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-700 text-[11px] font-black flex items-center justify-center">2</span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-700">ANTROPOMETRI &amp; TANDA VITAL</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                            <!-- Berat Badan -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Berat Badan <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        step="0.1"
                                        id="inputBb"
                                        name="berat_badan"
                                        value="64.5"
                                        min="35"
                                        max="180"
                                        required
                                        oninput="liveClinicalAssessment()"
                                        placeholder="64.5"
                                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs text-slate-400 font-medium pointer-events-none">
                                        kg
                                    </span>
                                </div>
                            </div>

                            <!-- Tekanan Darah -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Tekanan Darah <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        id="inputTd"
                                        name="tekanan_darah"
                                        value="118/78"
                                        required
                                        pattern="^\d{2,3}\/\d{2,3}$"
                                        title="Format tekanan darah harus sistol/diastol (contoh: 120/80)"
                                        oninput="liveClinicalAssessment()"
                                        placeholder="118/78"
                                        class="w-full pl-3.5 pr-14 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs text-slate-400 font-medium pointer-events-none">
                                        mmHg
                                    </span>
                                </div>
                            </div>

                            <!-- LiLA (Lingkar Lengan) -->
                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs font-bold text-slate-700">
                                        LiLA (Lingkar Lengan) <span class="text-rose-500">*</span>
                                    </label>
                                    <span class="text-[9.5px] font-bold text-rose-600 bg-rose-50 px-1.5 py-0.2 rounded border border-rose-200/60">&lt; 23.5 KEK</span>
                                </div>
                                <div class="relative">
                                    <input
                                        type="number"
                                        step="0.1"
                                        id="inputLila"
                                        name="lila"
                                        value="25.0"
                                        min="15"
                                        max="50"
                                        required
                                        oninput="liveClinicalAssessment()"
                                        placeholder="25.0"
                                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs text-slate-400 font-medium pointer-events-none">
                                        cm
                                    </span>
                                </div>
                            </div>

                            <!-- Hemoglobin (Hb) -->
                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs font-bold text-slate-700">
                                        Hemoglobin (Hb) <span class="text-rose-500">*</span>
                                    </label>
                                    <span class="text-[9.5px] font-bold text-rose-600 bg-rose-50 px-1.5 py-0.2 rounded border border-rose-200/60">&lt; 11.0 Anemia</span>
                                </div>
                                <div class="relative">
                                    <input
                                        type="number"
                                        step="0.1"
                                        id="inputHb"
                                        name="hb"
                                        value="12.1"
                                        min="4"
                                        max="20"
                                        required
                                        oninput="liveClinicalAssessment()"
                                        placeholder="12.1"
                                        class="w-full pl-3.5 pr-12 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs text-slate-400 font-medium pointer-events-none">
                                        g/dL
                                    </span>
                                </div>
                            </div>

                            <!-- Tinggi Fundus (TFU) -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Tinggi Fundus (TFU) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        step="0.1"
                                        id="inputTfu"
                                        name="tfu"
                                        value="28"
                                        min="5"
                                        max="50"
                                        required
                                        oninput="liveClinicalAssessment()"
                                        placeholder="28"
                                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs text-slate-400 font-medium pointer-events-none">
                                        cm
                                    </span>
                                </div>
                            </div>

                            <!-- Denyut Janin (DJJ) -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Denyut Janin (DJJ) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="inputDjj"
                                        name="djj"
                                        value="142"
                                        min="60"
                                        max="220"
                                        required
                                        oninput="liveClinicalAssessment()"
                                        placeholder="142"
                                        class="w-full pl-3.5 pr-12 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs text-slate-400 font-medium pointer-events-none">
                                        dpm
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. PREVIEW PENILAIAN RISIKO OTOMATIS (DYNAMIC LIVE CARD) -->
                    <div class="space-y-2.5 pt-2 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-700 text-[11px] font-black flex items-center justify-center">3</span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-700">PREVIEW PENILAIAN RISIKO OTOMATIS</h4>
                        </div>

                        <div id="riskPreviewBox" class="p-4 rounded-2xl bg-sky-50/80 border border-sky-200/80 flex items-start gap-3 transition-colors duration-300">
                            <div id="riskIconContainer" class="w-6 h-6 rounded-full bg-sky-600 text-white flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-xs leading-relaxed">
                                <p id="riskTitle" class="font-bold text-sky-950">Kondisi Parameter Terpantau Baik / Normal</p>
                                <p id="riskDescription" class="text-slate-600 mt-0.5">
                                    LiLA &ge; 23.5 cm (Nutrisi adekuat) dan Hb &ge; 11.0 g/dL. Tidak terdeteksi risiko KEK maupun anemia gestasional.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 4. CATATAN PETUGAS & JADWAL KONTROL -->
                    <div class="space-y-3.5 pt-2 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-700 text-[11px] font-black flex items-center justify-center">4</span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-700">CATATAN PETUGAS &amp; JADWAL KONTROL</h4>
                        </div>

                        <div class="space-y-3">
                            <!-- Catatan & Rekomendasi Klinis -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">
                                    Catatan &amp; Rekomendasi Klinis <span class="text-rose-500">*</span>
                                </label>
                                <textarea
                                    id="inputCatatan"
                                    name="catatan_klinis"
                                    rows="2"
                                    required
                                    minlength="3"
                                    placeholder="Lanjutkan konsumsi Tablet Tambah Darah (TTD) 1x1 tablet malam hari, konseling senam hamil Trimester 3, dan pemantauan gerakan janin mandiri."
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:border-sky-500 transition resize-none"
                                >Lanjutkan konsumsi Tablet Tambah Darah (TTD) 1x1 tablet malam hari, konseling senam hamil Trimester 3, dan pemantauan gerakan janin mandiri.</textarea>
                            </div>

                            <!-- Tanggal Kontrol Berikutnya + Quick Shortcuts -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 items-end">
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">
                                        Tanggal Kontrol Berikutnya <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        id="inputTglKontrol"
                                        name="tgl_kontrol_berikutnya"
                                        value="{{ date('Y-m-d', strtotime('+4 weeks')) }}"
                                        required
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-hidden focus:border-sky-500 transition"
                                    >
                                </div>

                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        onclick="tambahMingguKontrol(2)"
                                        class="flex-1 py-2.5 px-3 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200/70 text-xs font-bold transition text-center"
                                    >
                                        +2 Minggu
                                    </button>
                                    <button
                                        type="button"
                                        onclick="tambahMingguKontrol(4)"
                                        class="flex-1 py-2.5 px-3 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200/70 text-xs font-bold transition text-center"
                                    >
                                        +4 Minggu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi Modal Footer -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button
                            type="button"
                            onclick="closeTambahModal()"
                            class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            id="btnSimpanPemeriksaan"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold shadow-md hover:shadow-lg transition"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span>Simpan Rekam Pemeriksaan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- 8. MODAL DETAIL REKOMENDASI KLINIS                                  -->
    <!-- =================================================================== -->
    <div id="modalDetailPemeriksaan" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" onclick="closeDetailModal()"></div>
        <div class="min-h-screen px-4 py-8 flex items-center justify-center">
            <div class="relative bg-white rounded-3xl max-w-lg w-full shadow-2xl p-6 border border-slate-100 z-10 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900" id="detailNamaIbu">Detail Rekomendasi Klinis</h3>
                    <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-700 text-lg">&times;</button>
                </div>
                <div class="space-y-3 text-xs">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                        <p class="font-bold text-slate-800">Catatan &amp; Tindakan Nakes:</p>
                        <p id="detailCatatan" class="text-slate-600 leading-relaxed"></p>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-sky-50 border border-sky-100 text-sky-900">
                        <span class="font-bold">Jadwal Kontrol Berikutnya:</span>
                        <span id="detailJadwalKontrol" class="font-extrabold text-[#0284c7]"></span>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 text-right">
                    <button onclick="closeDetailModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL POPUP BERHASIL SIMPAN (CENTER DIALOG CENTANG HIJAU)           -->
    <!-- =================================================================== -->
    <div id="modalSuccessSave" class="fixed inset-0 z-50 overflow-y-auto {{ session('success') ? 'flex' : 'hidden' }} items-center justify-center p-4">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeSuccessModal()"></div>

        <!-- Modal Card in Center -->
        <div class="relative bg-white rounded-3xl max-w-sm sm:max-w-md w-full shadow-2xl border border-slate-100 p-6 sm:p-8 z-10 text-center transform transition-all animate-scale-up">
            <!-- Big Centered Green Checkmark Circle with ripple ring -->
            <div class="mx-auto w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 ring-8 ring-emerald-50/70 shadow-inner">
                <div class="w-14 h-14 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <h3 class="text-xl font-black text-slate-900 tracking-tight">Pemeriksaan Berhasil Disimpan!</h3>
            <p id="successModalMessage" class="text-xs text-slate-600 mt-2 leading-relaxed px-2">
                {{ session('success') ?? 'Data rekam medis antropometri & tanda vital ibu hamil telah berhasil dicatat ke sistem NutriGrow.' }}
            </p>

            <div class="mt-6">
                <button
                    type="button"
                    onclick="closeSuccessModal()"
                    class="w-full py-3 px-5 rounded-2xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold shadow-md hover:shadow-lg transition flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Selesai &amp; Lihat Data</span>
                </button>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- 9. JAVASCRIPT LOGIC (MODAL, CLINICAL ASSESSMENT, QUICK SHORTCUTS)   -->
    <!-- =================================================================== -->
    <script>
        // Toggle Mobile Sidebar
        function toggleSidebar() {
            const menu = document.getElementById('sidebarMenu');
            const backdrop = document.getElementById('sidebarBackdrop');
            menu.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        // Modal Tambah Pemeriksaan
        function openTambahModal() {
            document.getElementById('modalTambahPemeriksaan').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Inisialisasi jika opsi pertama sudah terpilih
            const selectEl = document.getElementById('inputKehamilanId');
            if (selectEl && selectEl.value) {
                onPasienSelected(selectEl.value);
            }
            liveClinicalAssessment();
        }

        function closeTambahModal() {
            document.getElementById('modalTambahPemeriksaan').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Event saat pasien dipilih dari dropdown
        function onPasienSelected(kehamilanId) {
            const selectEl = document.getElementById('inputKehamilanId');
            const selectedOption = selectEl.options[selectEl.selectedIndex];
            
            if (!kehamilanId || !selectedOption) {
                document.getElementById('displayGravidaHpl').value = '';
                return;
            }

            const gravidaHpl = selectedOption.getAttribute('data-gravida-hpl');
            const gestasi = selectedOption.getAttribute('data-gestasi');
            const bb = selectedOption.getAttribute('data-bb');
            const lila = selectedOption.getAttribute('data-lila');

            if (gravidaHpl) document.getElementById('displayGravidaHpl').value = gravidaHpl;
            if (gestasi) document.getElementById('inputGestasi').value = gestasi;
            if (bb) document.getElementById('inputBb').value = bb;
            if (lila) document.getElementById('inputLila').value = lila;

            liveClinicalAssessment();
        }

        // Live Clinical Decision Support Evaluation
        function liveClinicalAssessment() {
            const bbVal = parseFloat(document.getElementById('inputBb').value) || 0;
            const lilaVal = parseFloat(document.getElementById('inputLila').value) || 0;
            const hbVal = parseFloat(document.getElementById('inputHb').value) || 0;
            const tfuVal = parseFloat(document.getElementById('inputTfu').value) || 0;
            const djjVal = parseInt(document.getElementById('inputDjj').value) || 0;
            const tdVal = (document.getElementById('inputTd').value || '').trim();
            const gestasiVal = parseInt(document.getElementById('inputGestasi').value) || 20;

            const box = document.getElementById('riskPreviewBox');
            const iconContainer = document.getElementById('riskIconContainer');
            const titleEl = document.getElementById('riskTitle');
            const descEl = document.getElementById('riskDescription');

            // Parse Tekanan Darah (Sistol / Diastol)
            let sistol = 120;
            let diastol = 80;
            let tdValid = false;
            if (tdVal.includes('/')) {
                const parts = tdVal.split('/');
                sistol = parseInt(parts[0]) || 0;
                diastol = parseInt(parts[1]) || 0;
                tdValid = sistol > 0 && diastol > 0;
            }

            // 1. Pengecekan Nilai Tidak Wajar (Out of Reasonable Medical Bounds)
            let outOfBounds = [];
            if (bbVal > 0 && (bbVal < 35 || bbVal > 180)) {
                outOfBounds.push(`Berat badan (${bbVal} kg) tidak wajar (35-180 kg)`);
            }
            if (lilaVal > 0 && (lilaVal < 15 || lilaVal > 50)) {
                outOfBounds.push(`LiLA (${lilaVal} cm) tidak wajar (15-50 cm)`);
            }
            if (hbVal > 0 && (hbVal < 4 || hbVal > 20)) {
                outOfBounds.push(`Kadar Hb (${hbVal} g/dL) tidak wajar (4-20 g/dL)`);
            }
            if (tdValid && (sistol < 70 || sistol > 240 || diastol < 40 || diastol > 150 || sistol <= diastol)) {
                outOfBounds.push(`Tekanan darah (${tdVal}) tidak wajar`);
            }
            if (tfuVal > 0 && (tfuVal < 5 || tfuVal > 50)) {
                outOfBounds.push(`Tinggi fundus (${tfuVal} cm) tidak wajar (5-50 cm)`);
            }
            if (djjVal > 0 && (djjVal < 60 || djjVal > 220)) {
                outOfBounds.push(`Denyut janin (${djjVal} dpm) tidak wajar (60-220 dpm)`);
            }

            if (outOfBounds.length > 0) {
                box.className = 'p-4 rounded-2xl bg-amber-50/90 border border-amber-300 flex items-start gap-3 transition-colors duration-300';
                iconContainer.className = 'w-6 h-6 rounded-full bg-amber-600 text-white flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs';
                iconContainer.innerHTML = '!';

                titleEl.className = 'font-bold text-amber-950';
                titleEl.innerHTML = 'Peringatan: Nilai Tidak Wajar Terdeteksi';
                descEl.innerHTML = `<span class="text-amber-800 font-semibold">${outOfBounds.join(', ')}.</span> Mohon periksa kembali input sebelum menyimpan.`;
                return;
            }

            const isKek = lilaVal > 0 && lilaVal < 23.5;
            const anemiaThreshold = (gestasiVal >= 14 && gestasiVal <= 27) ? 10.5 : 11.0;
            const isAnemia = hbVal > 0 && hbVal < anemiaThreshold;
            const isHipertensi = sistol >= 140 || diastol >= 90;
            const isPraHipertensi = !isHipertensi && (sistol >= 120 || diastol >= 80);

            // Logika Evaluasi & Tampilan Warna
            if (isKek || isAnemia || isHipertensi) {
                // Ada Risiko Terdeteksi
                box.className = 'p-4 rounded-2xl bg-rose-50/90 border border-rose-200 flex items-start gap-3 transition-colors duration-300';
                iconContainer.className = 'w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center shrink-0 mt-0.5';
                iconContainer.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`;

                let warnings = [];
                let rekomendasi = [];

                if (isKek) {
                    warnings.push(`Terdeteksi Risiko KEK (LiLA ${lilaVal} cm &lt; 23.5 cm)`);
                    rekomendasi.push('Berikan PMT pemulihan berbasis protein hewani dan konseling gizi.');
                }
                if (isAnemia) {
                    warnings.push(`Terdeteksi Anemia Gestasional (Hb ${hbVal} g/dL &lt; ${anemiaThreshold} g/dL)`);
                    rekomendasi.push('Tingkatkan dosis Tablet Tambah Darah (TTD) dan evaluasi asupan vitamin C.');
                }
                if (isHipertensi) {
                    warnings.push(`Hipertensi Gestasional (${tdVal} mmHg)`);
                    rekomendasi.push('Segera periksa proteinuria dan lakukan rujukan klinis ke dokter Sp.OG.');
                }

                titleEl.className = 'font-bold text-rose-900';
                titleEl.innerHTML = warnings.join(' &amp; ');
                descEl.innerHTML = `<strong>Rekomendasi Nakes:</strong> ${rekomendasi.join(' ')}`;
            } else if (isPraHipertensi) {
                // Perhatian Pra-Hipertensi
                box.className = 'p-4 rounded-2xl bg-amber-50/90 border border-amber-200 flex items-start gap-3 transition-colors duration-300';
                iconContainer.className = 'w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5';
                iconContainer.innerHTML = `!`;

                titleEl.className = 'font-bold text-amber-900';
                titleEl.innerHTML = `Waspada Tekanan Darah (${tdVal} mmHg)`;
                descEl.innerHTML = 'LiLA dan Hb optimal. Pantau kenaikan tekanan darah dan anjurkan istirahat cukup serta diet rendah natrium.';
            } else {
                // Kondisi Normal / Baik
                box.className = 'p-4 rounded-2xl bg-sky-50/80 border border-sky-200/80 flex items-start gap-3 transition-colors duration-300';
                iconContainer.className = 'w-6 h-6 rounded-full bg-sky-600 text-white flex items-center justify-center shrink-0 mt-0.5';
                iconContainer.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;

                titleEl.className = 'font-bold text-sky-950';
                titleEl.innerHTML = 'Kondisi Parameter Terpantau Baik / Normal';
                descEl.innerHTML = `LiLA &ge; 23.5 cm (${lilaVal} cm, Nutrisi adekuat) dan Hb &ge; 11.0 g/dL (${hbVal > 0 ? hbVal + ' g/dL' : 'Normal'}). Tidak terdeteksi risiko KEK maupun anemia gestasional.`;
            }
        }

        // Helper Tombol Shortcut Jadwal Kontrol (+2 Minggu, +4 Minggu)
        function tambahMingguKontrol(minggu) {
            const inputTglPeriksa = document.getElementById('inputTglPeriksa');
            const basisTgl = inputTglPeriksa.value ? new Date(inputTglPeriksa.value) : new Date();
            
            basisTgl.setDate(basisTgl.getDate() + (minggu * 7));
            const yyyy = basisTgl.getFullYear();
            const mm = String(basisTgl.getMonth() + 1).padStart(2, '0');
            const dd = String(basisTgl.getDate()).padStart(2, '0');

            document.getElementById('inputTglKontrol').value = `${yyyy}-${mm}-${dd}`;
        }

        // Modal Detail Rekomendasi
        function lihatDetail(data) {
            document.getElementById('detailNamaIbu').innerText = `Catatan Medis: ${data.ibu ? data.ibu.name : 'Ibu Hamil'}`;
            document.getElementById('detailCatatan').innerText = data.catatan_klinis || 'Tidak ada catatan klinis khusus.';
            document.getElementById('detailJadwalKontrol').innerText = data.tgl_kontrol_berikutnya ? data.tgl_kontrol_berikutnya : 'Sesuai instruksi nakes';
            document.getElementById('modalDetailPemeriksaan').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('modalDetailPemeriksaan').classList.add('hidden');
        }

        // Tutup Modal Pop-up Berhasil Simpan
        function closeSuccessModal() {
            const modal = document.getElementById('modalSuccessSave');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            document.body.style.overflow = 'auto';
        }

        function exportExcelNotice() {
            alert('Mengunduh rekapitulasi data pemeriksaan kehamilan (Format XLS/Spreadsheet Dinkes)...');
        }
    </script>
</body>
</html>
