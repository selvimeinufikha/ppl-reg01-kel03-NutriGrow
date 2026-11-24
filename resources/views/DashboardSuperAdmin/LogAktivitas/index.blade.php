<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Aktivitas & Audit Administrator - NutriGrow | Portal Super Admin</title>

    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- Mobile Top Navigation Bar -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#e11d48] bg-pink-50 px-2 py-0.5 rounded-md">
                SUPER ADMIN
            </span>
        </div>
        <button type="button" onclick="toggleAdminSidebar()" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div id="adminSidebarBackdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden"></div>

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- SIDEBAR NAVIGASI TERPUSAT -->
        @include('components.admin-sidebar', ['active' => 'log-aktivitas'])

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header Bar -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button type="button" onclick="toggleAdminSidebar()" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-sky-600 transition">Portal Super Admin</a>
                            <span>/</span>
                            <span class="text-slate-800 font-bold">Log Aktivitas &amp; Audit Administrator (PBI-030)</span>
                        </div>
                        <h1 class="text-base font-extrabold text-slate-900 tracking-tight">Log Aktivitas &amp; Audit Keamanan Administrator</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-xs text-[#0284c7] font-bold">
                        <span class="w-2 h-2 rounded-full bg-[#0284c7] animate-pulse"></span>
                        <span>{{ $tanggalHariIni }}</span>
                    </div>

                    <!-- TOMBOL EKSPOR PDF LENGKAP - BIRU SOLID PILL -->
                    <a href="{{ (request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.log.export-pdf') : route('admin.log.export-pdf')) . '?' . http_build_query(request()->all()) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs hover:shadow transition cursor-pointer">
                        <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Export PDF Lengkap</span>
                    </a>

                    <a href="{{ route('admin.akun.index') }}" class="px-4 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 text-[#0284c7] border border-sky-200 font-bold text-xs transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Kelola Akun Admin</span>
                    </a>
                </div>
            </header>

            <div class="p-6 sm:p-8 space-y-6">

                <!-- 4 KARTU STATISTIK LOG AKTIVITAS (TEMA BIRU NUTRIGROW) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Log -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Log Tercatat</p>
                            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($totalLogs) }}</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Seluruh riwayat audit</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center border border-sky-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>

                    <!-- Aktivitas Hari Ini -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Aktivitas Hari Ini</p>
                            <h3 class="text-2xl font-black text-[#0284c7] mt-1">{{ number_format($logsToday) }}</h3>
                            <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">Real-time dipantau</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center border border-sky-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    <!-- Penambahan Akun -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penambahan Akun</p>
                            <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($totalTambahAkun) }}</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Akun admin baru dibuat</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                    </div>

                    <!-- Perubahan Hak Akses -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perubahan Hak Akses</p>
                            <h3 class="text-2xl font-black text-blue-600 mt-1">{{ number_format($totalUbahAkses) }}</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Role &amp; status dimodifikasi</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- FORM PENCARIAN & FILTER LOG (PBI-030) -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                    <form action="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.log.index') : route('admin.log.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                        <!-- Input Pencarian -->
                        <div class="sm:col-span-5 relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Cari nama pelaku, target akun, email, atau keterangan..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-[#0284c7] transition">
                        </div>

                        <!-- Filter Jenis Aksi -->
                        <div class="sm:col-span-3">
                            <select name="action" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-[#0284c7] transition cursor-pointer">
                                <option value="all" {{ $selectedAction === 'all' ? 'selected' : '' }}>Semua Jenis Aktivitas</option>
                                <option value="TAMBAH_AKUN" {{ $selectedAction === 'TAMBAH_AKUN' ? 'selected' : '' }}>Tambah Akun Baru</option>
                                <option value="UBAH_HAK_AKSES" {{ $selectedAction === 'UBAH_HAK_AKSES' ? 'selected' : '' }}>Ubah Hak Akses</option>
                                <option value="TOGGLE_STATUS" {{ $selectedAction === 'TOGGLE_STATUS' ? 'selected' : '' }}>Ubah Status Keaktifan</option>
                                <option value="LOGIN_ADMIN" {{ $selectedAction === 'LOGIN_ADMIN' ? 'selected' : '' }}>Login Super Admin</option>
                            </select>
                        </div>

                        <!-- Filter Periode Waktu -->
                        <div class="sm:col-span-2">
                            <select name="period" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-[#0284c7] transition cursor-pointer">
                                <option value="all" {{ $selectedPeriod === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                                <option value="today" {{ $selectedPeriod === 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="week" {{ $selectedPeriod === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="month" {{ $selectedPeriod === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            </select>
                        </div>

                        <!-- Tombol Aksi Filter -->
                        <div class="sm:col-span-2 flex items-center gap-2">
                            <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-[#0284c7] hover:bg-sky-700 text-white font-bold text-xs shadow-xs transition cursor-pointer text-center">
                                Terapkan
                            </button>
                            @if ($searchQuery || $selectedAction !== 'all' || $selectedPeriod !== 'all')
                                <a href="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.log.index') : route('admin.log.index') }}" title="Reset Filter"
                                   class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- TABEL LOG AKTIVITAS & AUDIT ADMINISTRATOR (PBI-030) -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm font-extrabold text-slate-800">Catatan Riwayat Audit Administrator</h2>
                            <span class="px-2 py-0.5 rounded-full bg-sky-50 text-[#0284c7] border border-sky-200 text-[10px] font-bold">
                                {{ $logs->total() }} Log Ditemukan
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Direct binary PDF download -->
                            <a href="{{ (request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.log.export-pdf') : route('admin.log.export-pdf')) . '?format=pdf&' . http_build_query(request()->except('format')) }}"
                               title="Unduh langsung file dokumen .PDF"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span>Unduh .PDF</span>
                            </a>
                            <!-- Print-to-PDF preview -->
                            <a href="{{ (request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.log.export-pdf') : route('admin.log.export-pdf')) . '?' . http_build_query(request()->all()) }}"
                               target="_blank"
                               title="Pratinjau Cetak / Simpan PDF dengan browser"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-[#0284c7] border border-sky-200 text-xs font-bold transition shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                <span>Cetak Dokumen</span>
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80 text-slate-500 font-bold border-b border-slate-200 text-[11px] uppercase tracking-wider">
                                    <th class="px-5 py-3.5">Waktu &amp; Tanggal</th>
                                    <th class="px-5 py-3.5">Pelaku Aktivitas</th>
                                    <th class="px-5 py-3.5 text-center">Jenis Aksi</th>
                                    <th class="px-5 py-3.5">Akun Target</th>
                                    <th class="px-5 py-3.5">Keterangan / Rincian Audit</th>
                                    <th class="px-5 py-3.5 text-center">Perangkat &amp; IP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($logs as $log)
                                    @php
                                        $badge = $log->action_badge;
                                    @endphp
                                    <tr class="hover:bg-sky-50/20 transition">
                                        <!-- Waktu & Tanggal -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </div>
                                                <div>
                                                    <p class="font-extrabold text-slate-800 text-xs">
                                                        {{ $log->created_at->translatedFormat('H:i:s') }} WIB
                                                    </p>
                                                    <p class="text-[10px] text-slate-400">
                                                        {{ $log->created_at->translatedFormat('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Pelaku Aktivitas -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-xl bg-sky-100 text-[#0284c7] font-bold text-xs flex items-center justify-center shrink-0">
                                                    {{ strtoupper(substr($log->actor_name, 0, 2)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-bold text-slate-900 text-xs truncate">{{ $log->actor_name }}</p>
                                                    <p class="text-[10px] text-slate-400 truncate">{{ $log->actor_email ?? '-' }}</p>
                                                    <span class="inline-block mt-0.5 px-1.5 py-0.2 rounded-md bg-sky-50 text-sky-700 border border-sky-200 text-[9px] font-bold">
                                                        {{ strtoupper($log->actor_role) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Jenis Aksi -->
                                        <td class="px-5 py-4 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge['bg'] }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                                <span>{{ $badge['label'] }}</span>
                                            </span>
                                        </td>

                                        <!-- Akun Target -->
                                        <td class="px-5 py-4">
                                            @if ($log->target_name)
                                                <div class="min-w-0">
                                                    <p class="font-bold text-slate-800 text-xs">{{ $log->target_name }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $log->target_email ?? '-' }}</p>
                                                </div>
                                            @else
                                                <span class="text-slate-400 text-xs italic">Sistem / Portal</span>
                                            @endif
                                        </td>

                                        <!-- Keterangan & Rincian Perubahan -->
                                        <td class="px-5 py-4 max-w-md">
                                            <p class="text-xs text-slate-700 font-medium leading-relaxed">{{ $log->description }}</p>

                                            <!-- Tampilan visual perbedaan old_values -> new_values jika ada -->
                                            @if (!empty($log->old_values) && !empty($log->new_values))
                                                <div class="mt-2 p-2 bg-slate-50 rounded-xl border border-slate-200/80 text-[10.5px] space-y-1">
                                                    @if (isset($log->old_values['role']) && isset($log->new_values['role']) && $log->old_values['role'] !== $log->new_values['role'])
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="font-bold text-slate-500">Peran:</span>
                                                            <span class="px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 line-through">{{ $log->old_values['role'] }}</span>
                                                            <span class="text-slate-400">→</span>
                                                            <span class="px-1.5 py-0.5 rounded bg-sky-100 text-sky-800 font-bold">{{ $log->new_values['role'] }}</span>
                                                        </div>
                                                    @endif
                                                    @if (isset($log->old_values['status']) && isset($log->new_values['status']) && $log->old_values['status'] !== $log->new_values['status'])
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="font-bold text-slate-500">Status:</span>
                                                            <span class="px-1.5 py-0.5 rounded {{ $log->old_values['status'] === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }} line-through">
                                                                {{ $log->old_values['status'] === 'active' ? 'Aktif' : 'Nonaktif' }}
                                                            </span>
                                                            <span class="text-slate-400">→</span>
                                                            <span class="px-1.5 py-0.5 rounded {{ $log->new_values['status'] === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }} font-bold">
                                                                {{ $log->new_values['status'] === 'active' ? 'Aktif' : 'Nonaktif' }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Info Jaringan & Perangkat -->
                                        <td class="px-5 py-4 text-center whitespace-nowrap">
                                            <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-mono text-[10px] font-semibold border border-slate-200">
                                                {{ $log->ip_address ?? '127.0.0.1' }}
                                            </span>
                                            <p class="text-[9px] text-slate-400 mt-1 truncate max-w-[140px]" title="{{ $log->user_agent }}">
                                                {{ Str::limit($log->user_agent ?? 'Client Browser', 20) }}
                                            </p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <p class="font-bold text-slate-700 text-sm">Tidak ada log aktivitas yang sesuai kriteria filter.</p>
                                            <p class="text-xs text-slate-400 mt-1">Coba reset filter atau gunakan kata kunci pencarian yang lain.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($logs->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            if (sidebar && backdrop) {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }
        }
    </script>
</body>
</html>
