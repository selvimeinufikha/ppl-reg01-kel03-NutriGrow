<!DOCTYPE html>
@php
    $adminName = $adminName ?? (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
    $adminRole = $adminRole ?? (Auth::check() ? Auth::user()->role_label : 'Super Administrator');
    $faskesName = $faskesName ?? (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Puskesmas Gambir');
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Akun Administrator - NutriGrow | Portal Admin Faskes</title>

    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
<body class="min-h-screen bg-[#f8fafc] font-sans antialiased text-slate-800">

    <!-- Mobile Top Navigation Bar -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#e11d48] bg-pink-50 px-2 py-0.5 rounded-md">
                PORTAL ADMIN
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

        <!-- SIDEBAR -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] xl:w-[275px] bg-white border-r border-slate-200 flex flex-col justify-between py-5 px-4 shrink-0 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div>
                <div class="px-2 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                        <div class="text-[9.5px] font-black uppercase tracking-widest text-[#e11d48] mt-1">
                            PORTAL ADMIN
                            <span class="block text-[8px] tracking-wider text-slate-400 font-semibold">TENAGA KESEHATAN</span>
                        </div>
                    </a>
                </div>

                <nav class="space-y-1 text-xs font-semibold">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard Admin</span>
                    </a>
                    <a href="{{ route('admin.fasilitas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Fasilitas Kesehatan</span>
                    </a>
                    <a href="{{ route('admin.edukasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Edukasi Gizi &amp; KIA</span>
                    </a>
                    <!-- ACTIVE MENU: MANAJEMEN AKUN ADMIN (PINK ACCENT) -->
                    <a href="{{ route('admin.akun.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-pink-600 text-white shadow-xs font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Manajemen Akun Admin</span>
                    </a>
                    <!-- MENU LOG AKTIVITAS (PBI-030) -->
                    <a href="{{ route('admin.log.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Log Aktivitas &amp; Audit</span>
                    </a>
                </nav>
            </div>

            <div class="pt-4 border-t border-slate-100 px-2 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-pink-100 text-[#e11d48] font-bold text-xs flex items-center justify-center">
                        {{ strtoupper(substr($adminName, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $adminName }}</p>
                        <p class="text-[10px] text-slate-400 truncate">{{ $adminRole }}</p>
                    </div>
                </div>
            </div>
        </aside>

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
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-rose-600 transition">Portal Admin</a>
                            <span>/</span>
                            <span class="text-slate-800 font-bold">Manajemen Akun Administrator (PBI-028)</span>
                        </div>
                        <h1 class="text-base font-extrabold text-slate-900 tracking-tight">Kelola Akun Administrator &amp; Tenaga Kesehatan</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500 font-medium bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>{{ $tanggalHariIni }}</span>
                    </div>

                    <!-- TOMBOL TAMBAH AKUN (PBI-028) - PINK -->
                    <a href="{{ route('admin.akun.create') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white font-bold text-xs shadow-md shadow-pink-600/20 hover:shadow-lg transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        <span>Tambah Akun Administrator</span>
                    </a>
                </div>
            </header>

            <div class="p-6 md:p-8 max-w-7xl w-full mx-auto space-y-6">

                <!-- Flash Success Notification -->
                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3 shadow-xs">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="font-bold">Pendaftaran Akun Berhasil!</p>
                            <p class="text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- SUMMARY METRICS - PINK ACCENTS -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Akun Admin</p>
                            <p class="text-2xl font-black text-slate-800 mt-1">{{ $totalAdmin }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-pink-50 text-rose-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tenaga Medis &amp; Nakes</p>
                            <p class="text-2xl font-black text-rose-600 mt-1">{{ $totalNakes }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-pink-50 text-rose-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Super Administrator</p>
                            <p class="text-2xl font-black text-purple-600 mt-1">{{ $totalSuper }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Akun Aktif</p>
                            <p class="text-2xl font-black text-rose-700 mt-1">{{ $totalAktif }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-pink-50 text-rose-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                </div>

                <!-- FILTER BAR -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <form action="{{ route('admin.akun.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3 w-full">
                        <div class="relative flex-1 w-full">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="{{ $filterSearch }}" placeholder="Cari nama, email dinas, NIP/STR, atau faskes..." class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
                        </div>

                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <select name="role" class="px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 text-slate-600 font-medium">
                                <option value="all" {{ $filterRole === 'all' ? 'selected' : '' }}>Semua Role</option>
                                <option value="superadmin" {{ $filterRole === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ $filterRole === 'admin' ? 'selected' : '' }}>Admin Faskes</option>
                                <option value="dokter" {{ $filterRole === 'dokter' ? 'selected' : '' }}>Dokter</option>
                                <option value="bidan" {{ $filterRole === 'bidan' ? 'selected' : '' }}>Bidan</option>
                                <option value="ahli_gizi" {{ $filterRole === 'ahli_gizi' ? 'selected' : '' }}>Ahli Gizi</option>
                            </select>

                            <select name="status" class="px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 text-slate-600 font-medium">
                                <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="active" {{ $filterStatus === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $filterStatus === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>

                            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition">
                                Terapkan
                            </button>

                            @if ($filterSearch || $filterRole !== 'all' || $filterStatus !== 'all')
                                <a href="{{ route('admin.akun.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- TABLE DAFTAR AKUN ADMINISTRATOR -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-extrabold text-slate-900">Daftar Akun Administrator Terdaftar</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Seluruh petugas kesehatan yang memiliki akses login ke sistem NutriGrow.</p>
                        </div>
                        <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $adminList->count() }} Akun Ditemukan
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                <tr>
                                    <th class="px-5 py-3.5">Nama &amp; Email</th>
                                    <th class="px-5 py-3.5">Hak Akses (Role)</th>
                                    <th class="px-5 py-3.5">Instansi Faskes &amp; Jabatan</th>
                                    <th class="px-5 py-3.5">NIP / STR</th>
                                    <th class="px-5 py-3.5 text-center">Status</th>
                                    <th class="px-5 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($adminList as $adm)
                                    @php
                                        $badgeClasses = match($adm->role) {
                                            'superadmin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'admin' => 'bg-pink-50 text-rose-700 border-pink-200',
                                            'dokter' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'bidan' => 'bg-pink-100 text-pink-700 border-pink-200',
                                            'ahli_gizi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            default => 'bg-slate-100 text-slate-600 border-slate-200',
                                        };
                                    @endphp
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <!-- Nama & Email -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-rose-500 to-pink-600 text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">
                                                    {{ $adm->inisial }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-extrabold text-slate-900 text-xs truncate">{{ $adm->name }}</p>
                                                    <p class="text-slate-400 text-[11px] font-mono truncate">{{ $adm->email }}</p>
                                                    @if ($adm->phone)
                                                        <p class="text-slate-400 text-[10px]">{{ $adm->phone }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Hak Akses (Role Badge) -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10.5px] font-bold border {{ $badgeClasses }}">
                                                {{ $adm->role_label }}
                                            </span>
                                        </td>

                                        <!-- Faskes & Jabatan -->
                                        <td class="px-5 py-4">
                                            <p class="font-bold text-slate-800 text-xs">{{ $adm->faskes_name ?? 'Faskes Pusat' }}</p>
                                            <p class="text-slate-500 text-[11px] truncate max-w-xs">{{ $adm->jabatan ?? '-' }}</p>
                                        </td>

                                        <!-- NIP / STR -->
                                        <td class="px-5 py-4 whitespace-nowrap font-mono text-[11px] text-slate-600">
                                            {{ $adm->nip_str ?? '-' }}
                                        </td>

                                        <!-- Status (PBI-029: Toggle Cepat) -->
                                        <td class="px-5 py-4 text-center whitespace-nowrap">
                                            <form action="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.akun.toggle-status', $adm->id) : route('admin.akun.toggle-status', $adm->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Ubah status keaktifan akun {{ $adm->name }}?')">
                                                @csrf
                                                @if (($adm->status ?? 'active') === 'active')
                                                    <button type="submit" title="Klik untuk menonaktifkan akun langsung" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-200 transition cursor-pointer">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        <span>Aktif</span>
                                                    </button>
                                                @else
                                                    <button type="submit" title="Klik untuk mengaktifkan akun langsung" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-700 text-[10px] font-bold border border-rose-200 transition cursor-pointer">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        <span>Nonaktif</span>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>

                                        <!-- Aksi Ubah Hak Akses (PBI-029) -->
                                        <td class="px-5 py-4 text-right whitespace-nowrap">
                                            <a href="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.akun.edit', $adm->id) : route('admin.akun.edit', $adm->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-pink-50 hover:bg-pink-100 text-[#e11d48] font-bold text-xs transition border border-pink-200 shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Ubah Akses</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                            <p class="font-bold text-slate-700 text-sm">Tidak ada akun administrator yang sesuai kriteria pencarian.</p>
                                            <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain atau daftarkan akun administrator baru.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html>
