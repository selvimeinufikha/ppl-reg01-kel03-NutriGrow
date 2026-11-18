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
    <title>Tambah Akun Administrator - NutriGrow | Portal Admin Faskes</title>

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
                    <!-- ACTIVE MENU: MANAJEMEN AKUN ADMIN - PINK -->
                    <a href="{{ route('admin.akun.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-pink-600 text-white shadow-xs font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Manajemen Akun Admin</span>
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-rose-600 transition">Portal Admin</a>
                    <span>/</span>
                    <a href="{{ route('admin.akun.index') }}" class="hover:text-rose-600 transition">Manajemen Akun</a>
                    <span>/</span>
                    <span class="text-slate-800 font-bold">Tambah Akun Baru (PBI-028)</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>{{ $tanggalHariIni }}</span>
                </div>
            </header>

            <div class="p-6 md:p-8 max-w-5xl w-full mx-auto space-y-6">

                <!-- Banner Header - PINK ACCENT -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-rose-600 via-rose-700 to-pink-800 p-6 md:p-8 text-white shadow-lg shadow-pink-600/15">
                    <div class="relative z-10 max-w-2xl space-y-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-[11px] font-bold text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            PBI-028: Menambahkan Akun Administrator &amp; Nakes
                        </span>
                        <h1 class="text-xl md:text-2xl font-black tracking-tight">Formulir Registrasi Akun Administrator Faskes</h1>
                        <p class="text-xs md:text-sm text-pink-100 leading-relaxed">
                            Daftarkan akun baru untuk administrator sistem, dokter anak, bidan koordinator, atau tenaga ahli gizi puskesmas dengan hak akses klinis yang terstandar.
                        </p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                        <p class="font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            Mohon perbaiki kesalahan berikut:
                        </p>
                        <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Form Input (2 cols) -->
                    <div class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 border border-slate-200 shadow-xs">
                        <form action="{{ route('admin.akun.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- SECTION 1: PROFIL & IDENTITAS -->
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-rose-700 mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                                    <span>Identitas &amp; Profesi Administrator</span>
                                </h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: dr. Bambang Sudiro, Sp.A / Bdn. Sarah, S.Tr.Keb" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                                                Alamat Email Dinas <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@nutrigrow.id / nama@puskesmas.go.id" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-mono">
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-xs font-bold text-slate-700 mb-1.5">
                                                No. Telepon / WhatsApp
                                            </label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081298765432" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-mono">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="nip_str" class="block text-xs font-bold text-slate-700 mb-1.5">
                                                Nomor Induk Pegawai (NIP) / Nomor STR
                                            </label>
                                            <input type="text" id="nip_str" name="nip_str" value="{{ old('nip_str') }}" placeholder="Contoh: STR-19880412-2023-019" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-mono">
                                        </div>

                                        <div>
                                            <label for="jabatan" class="block text-xs font-bold text-slate-700 mb-1.5">
                                                Jabatan Struktural / Fungsional
                                            </label>
                                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Bidan Koordinator / Kepala Poli KIA" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 2: HAK AKSES & FASILITAS KESEHATAN -->
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-rose-700 mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                                    <span>Hak Akses &amp; Penugasan Fasilitas Kesehatan</span>
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="role" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Peran / Hak Akses <span class="text-rose-500">*</span>
                                        </label>
                                        <select id="role" name="role" required onchange="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
                                            <option value="">-- Pilih Hak Akses --</option>
                                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator Faskes / Puskesmas</option>
                                            <option value="dokter" {{ old('role') === 'dokter' ? 'selected' : '' }}>Dokter Spesialis Anak / Umum</option>
                                            <option value="bidan" {{ old('role') === 'bidan' ? 'selected' : '' }}>Bidan Koordinator KIA</option>
                                            <option value="ahli_gizi" {{ old('role') === 'ahli_gizi' ? 'selected' : '' }}>Nutrisionis / Ahli Gizi</option>
                                            <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Super Administrator</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="faskes_name" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Fasilitas Kesehatan Penugasan <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" id="faskes_name" name="faskes_name" list="faskesList" value="{{ old('faskes_name', 'Puskesmas Gambir') }}" required placeholder="Pilih atau ketik nama faskes..." oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
                                        <datalist id="faskesList">
                                            @foreach ($daftarFaskes ?? ['Puskesmas Gambir', 'Puskesmas Menteng', 'RSUD Tarakan Jakarta', 'RSIA Bunda Sehat'] as $f)
                                                <option value="{{ $f }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3: KEAMANAN KATA SANDI -->
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-rose-700 mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                                    <span>Keamanan Kata Sandi</span>
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Kata Sandi Akun <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter aman" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi di atas" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-4 text-xs text-slate-600">
                                    <span class="font-bold">Status Awal Akun:</span>
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                        <input type="radio" name="status" value="active" checked class="text-rose-600 focus:ring-rose-500">
                                        <span>Aktif Langsung</span>
                                    </label>
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                        <input type="radio" name="status" value="inactive" class="text-rose-600 focus:ring-rose-500">
                                        <span>Nonaktif (Perlu Aktivasi)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- BUTTON AKSI - PINK GRADIENT -->
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.akun.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white font-bold text-xs shadow-md shadow-pink-600/20 hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Simpan Akun Administrator</span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- Live Preview Card (1 col) - PINK -->
                    <div class="space-y-4">
                        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Pratinjau Kartu Identitas</h3>
                                <span class="px-2 py-0.5 rounded-full bg-pink-50 text-rose-700 text-[10px] font-bold">Preview Live</span>
                            </div>

                            <div class="p-5 rounded-2xl bg-gradient-to-br from-pink-50/70 via-white to-rose-50/60 border border-pink-100 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div id="previewAvatar" class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-rose-600 to-pink-600 text-white flex items-center justify-center font-black text-base shadow-sm">
                                        NA
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p id="previewName" class="font-black text-slate-900 text-sm truncate">Nama Administrator</p>
                                        <span id="previewRoleBadge" class="inline-block mt-0.5 px-2.5 py-0.5 rounded-full bg-pink-100 text-rose-800 text-[10px] font-bold">
                                            Administrator Faskes
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-2 text-xs border-t border-pink-100/70 pt-3">
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>Email:</span>
                                        <span id="previewEmail" class="font-semibold text-slate-800 font-mono truncate max-w-[150px]">-</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>Fasilitas Kesehatan:</span>
                                        <span id="previewFaskes" class="font-semibold text-slate-800 truncate max-w-[150px]">Puskesmas Gambir</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>NIP / STR:</span>
                                        <span id="previewNip" class="font-semibold text-slate-800 font-mono">-</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>Jabatan:</span>
                                        <span id="previewJabatan" class="font-semibold text-slate-800 truncate max-w-[150px]">-</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200 text-amber-900 text-[11px] flex gap-2">
                                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>Akun yang dibuat akan langsung memiliki hak akses portal sesuai wewenangnya dan diawasi oleh <strong>Log Audit Administrator (PBI-030)</strong>.</span>
                            </div>
                        </div>
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

        function updateAdminPreview() {
            const name = document.getElementById('name').value.trim() || 'Nama Administrator';
            const email = document.getElementById('email').value.trim() || '-';
            const role = document.getElementById('role').value;
            const faskes = document.getElementById('faskes_name').value.trim() || 'Puskesmas Gambir';
            const nip = document.getElementById('nip_str').value.trim() || '-';
            const jabatan = document.getElementById('jabatan').value.trim() || '-';

            document.getElementById('previewName').textContent = name;
            document.getElementById('previewEmail').textContent = email;
            document.getElementById('previewFaskes').textContent = faskes;
            document.getElementById('previewNip').textContent = nip;
            document.getElementById('previewJabatan').textContent = jabatan;

            const roleLabels = {
                'superadmin': 'Super Administrator',
                'admin': 'Administrator Faskes',
                'dokter': 'Dokter Spesialis / Umum',
                'bidan': 'Bidan Koordinator KIA',
                'ahli_gizi': 'Nutrisionis / Ahli Gizi'
            };
            document.getElementById('previewRoleBadge').textContent = roleLabels[role] || 'Administrator Faskes';

            // Inisial
            const clean = name.replace(/^(dr\.|drg\.|prof\.|dr\s+|drg\s+|prof\s+|bidan\s+|bdn\.\s*)/i, '').trim();
            const words = clean.split(/\s+/);
            let inisial = words[0] ? words[0][0] : 'A';
            if (words[1]) inisial += words[1][0];
            document.getElementById('previewAvatar').textContent = inisial.toUpperCase();
        }

        document.addEventListener('DOMContentLoaded', updateAdminPreview);
    </script>
</body>
</html>
