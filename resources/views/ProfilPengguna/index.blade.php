<!DOCTYPE html>
@php
    $userName = $userName ?? (Auth::check() ? Auth::user()->name : 'Sarah Rahmawati');
    $userId = $userId ?? 'NGW-88291-JKT';
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Pengguna &amp; Rekomendasi Faskes - NutriGrow</title>

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
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- LEFT SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
        <div class="p-5 overflow-y-auto no-scrollbar flex-1 bg-transparent">
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
                    <!-- PROFIL PENGGUNA - ACTIVE MENU -->
                    <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-gradient-to-r from-brand-800 to-brand-700 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4 text-rose-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Profil Pengguna</span>
                    </a>

                    <a href="{{ route('kehamilan.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Data Kehamilan</span>
                    </a>

                    <a href="#data-pasangan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Data Pasangan</span>
                    </a>

                    <a href="#data-anak" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Data Anak</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="p-4 border-t border-pink-100/60 bg-white/40 backdrop-blur-sm">
            <a href="{{ route('dashboard.pengguna') }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-slate-600 hover:text-brand-700 bg-white rounded-xl border border-pink-100 shadow-xs transition">
                <span>&larr; Kembali ke Dashboard</span>
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
            <a href="{{ route('profil.index') }}" class="flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-brand-700 transition">
                <div class="w-7 h-7 rounded-full bg-brand-800 text-white flex items-center justify-center font-bold text-[10px]">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <span>{{ $user->name }}</span>
            </a>
        </header>

        <!-- MAIN CONTAINER -->
        <main class="p-4 sm:p-6 lg:p-8 max-w-5xl w-full mx-auto space-y-6">

            <!-- Success Flash Notification -->
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Breadcrumbs -->
            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-slate-600">Dashboard</a>
                <span>&rsaquo;</span>
                <span>Data Keluarga &amp; Profil</span>
                <span>&rsaquo;</span>
                <span class="text-brand-700 font-bold">Profil Pengguna</span>
            </div>

            <!-- Page Header Title -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Profil Pengguna &amp; Keluarga</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola data identitas, kontak, dan alamat domisili untuk acuan layanan kesehatan terdekat.</p>
                </div>
                <a href="{{ route('profil.edit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-800 to-rose-700 hover:from-brand-900 hover:to-rose-800 text-white font-bold text-xs shadow-md shadow-brand-900/20 transition transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit Profil &amp; Alamat</span>
                </a>
            </div>

            <!-- ========================================== -->
            <!-- SECTION 1: KARTU IDENTITAS PROFIL PENGGUNA -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-brand-700 via-rose-500 to-pink-500 absolute top-0 left-0 right-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center pt-2">
                    <!-- Avatar & Ringkasan Singkat -->
                    <div class="md:col-span-4 flex flex-col items-center text-center border-b md:border-b-0 md:border-r border-slate-100 pb-5 md:pb-0 md:pr-6">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-brand-800 via-brand-700 to-pink-600 text-white flex items-center justify-center font-black text-2xl shadow-md ring-4 ring-pink-100 mb-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">{{ $user->name }}</h2>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-[10px] font-extrabold bg-pink-50 text-brand-700 border border-pink-200">
                            Ibu Hamil / Pengguna
                        </span>
                        <div class="text-[11px] text-slate-400 font-mono mt-2">ID: {{ $userId }}</div>
                    </div>

                    <!-- Detail Data Pokok (Nama, Kontak, Alamat) - Acceptance Criteria 1 -->
                    <div class="md:col-span-8 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <!-- Nama Lengkap -->
                            <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Nama Lengkap</span>
                                <span class="font-extrabold text-slate-900 text-sm">{{ $user->name }}</span>
                            </div>

                            <!-- Email Akun -->
                            <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Email Terdaftar</span>
                                <span class="font-extrabold text-slate-900 text-sm">{{ $user->email }}</span>
                            </div>

                            <!-- Nomor Kontak / Telepon - Acceptance Criteria -->
                            <div class="bg-rose-50/60 p-3.5 rounded-2xl border border-rose-100">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-700 block mb-1">Nomor Kontak / Telepon</span>
                                <span class="font-extrabold text-brand-900 text-sm flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $user->no_telepon ?: 'Belum diisi' }}</span>
                                </span>
                            </div>

                            <!-- Pasangan -->
                            <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Nama Pasangan (Calon Ayah)</span>
                                <span class="font-extrabold text-slate-900 text-sm">
                                    {{ $pasangan ? $pasangan->nama_lengkap : 'Dimas Prasetyo' }}
                                </span>
                            </div>

                            <!-- Alamat Domisili - Acceptance Criteria -->
                            <div class="sm:col-span-2 bg-blue-50/60 p-4 rounded-2xl border border-blue-100">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700">Alamat Lengkap Domisili (Acuan Faskes)</span>
                                    <span class="text-[10px] font-semibold text-blue-600 bg-blue-100/70 px-2 py-0.5 rounded-full">Acuan Lokasi Aktif</span>
                                </div>
                                <div class="font-extrabold text-slate-900 text-sm flex items-start gap-2 mt-1">
                                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <div>
                                        <span>{{ $user->alamat ?: 'Jl. Cempaka Putih Tengah No. 12, RT 04/RW 02' }}</span>
                                        @if ($user->kota || $user->kecamatan)
                                            <div class="text-xs font-semibold text-slate-500 mt-0.5">
                                                {{ $user->kecamatan ? 'Kec. ' . $user->kecamatan : '' }}{{ $user->kota ? ', ' . $user->kota : '' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- SECTION 2: REKOMENDASI LAYANAN KESEHATAN (ACCEPTANCE CRITERIA 2) -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-sm space-y-5">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-extrabold text-slate-900">Rekomendasi Layanan Kesehatan Terdekat</h2>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200">
                                <span>✔ Otomatis Terhubung</span>
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">
                            Fasilitas kesehatan rujukan KIA yang dipetakan langsung berdasarkan <strong>alamat domisili profil Anda</strong>.
                        </p>
                    </div>

                    <!-- Badge Acuan Lokasi -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 self-start sm:self-center">
                        <span class="text-rose-500">📍</span>
                        <span>Acuan: <strong class="text-slate-900">{{ $rekomendasiFaskes['acuan_lokasi'] }}</strong></span>
                    </div>
                </div>

                <!-- 3 Health Facility Recommendation Cards (Posyandu, Puskesmas, RSIA) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($rekomendasiFaskes['fasilitas'] as $faskes)
                        @php
                            $isPosyandu = $faskes['kategori'] === 'Posyandu';
                            $isPuskesmas = $faskes['kategori'] === 'Puskesmas';
                        @endphp

                        <div class="rounded-2xl p-4 border {{ $isPosyandu ? 'border-pink-200 bg-pink-50/40' : ($isPuskesmas ? 'border-blue-200 bg-blue-50/40' : 'border-indigo-200 bg-indigo-50/40') }} flex flex-col justify-between space-y-3">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full {{ $isPosyandu ? 'bg-pink-100 text-brand-800' : ($isPuskesmas ? 'bg-blue-100 text-blue-800' : 'bg-indigo-100 text-indigo-800') }}">
                                        {{ $faskes['kategori'] }}
                                    </span>
                                    <span class="text-[11px] font-extrabold text-slate-700 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                        <span>{{ $faskes['jarak'] }}</span>
                                    </span>
                                </div>

                                <h3 class="text-sm font-extrabold text-slate-900 leading-snug">{{ $faskes['nama'] }}</h3>
                                
                                <p class="text-[11px] text-slate-600 flex items-start gap-1">
                                    <span class="text-slate-400">&bull;</span>
                                    <span>{{ $faskes['alamat'] }}</span>
                                </p>
                                <p class="text-[10px] text-slate-500 font-medium">
                                    🕒 {{ $faskes['jam_buka'] }}
                                </p>

                                <!-- Layanan List -->
                                <div class="pt-2 border-t border-slate-200/60">
                                    <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Layanan Utama:</span>
                                    <ul class="text-[11px] space-y-1 text-slate-700">
                                        @foreach ($faskes['layanan'] as $layanan)
                                            <li class="flex items-center gap-1.5">
                                                <svg class="w-3 h-3 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                <span>{{ $layanan }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-200/60">
                                <a href="tel:{{ $faskes['telepon'] }}" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>Hubungi: {{ $faskes['telepon'] }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </main>
    </div>

</body>
</html>
