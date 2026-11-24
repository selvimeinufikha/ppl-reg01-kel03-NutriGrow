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
    <title>Edit Profil Pengguna - NutriGrow</title>

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
            <a href="{{ route('profil.index') }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-slate-600 hover:text-brand-700 bg-white rounded-xl border border-pink-100 shadow-xs transition">
                <span>&larr; Batal &amp; Kembali ke Profil</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- TOP HEADER -->
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
            <div class="text-xs font-bold text-slate-700 flex items-center gap-2">
                @if ($user->foto_profil_url)
                    <img src="{{ $user->foto_profil_url }}" alt="{{ $userName }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-pink-100">
                @else
                    <div class="w-7 h-7 rounded-full bg-brand-800 text-white flex items-center justify-center font-bold text-[10px]">
                        {{ strtoupper(substr($userName, 0, 1)) }}
                    </div>
                @endif
                <span>{{ $userName }}</span>
            </div>
        </header>

        <!-- MAIN CONTAINER -->
        <main class="p-4 sm:p-6 lg:p-8 max-w-4xl w-full mx-auto space-y-6">
            
            <!-- Breadcrumb -->
            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-slate-600">Dashboard</a>
                <span>&rsaquo;</span>
                <a href="{{ route('profil.index') }}" class="hover:text-slate-600">Profil Pengguna</a>
                <span>&rsaquo;</span>
                <span class="text-brand-700 font-bold">Edit Profil &amp; Alamat</span>
            </div>

            <!-- Page Title -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Formulir Edit Profil Pengguna</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Ubah nama, nomor kontak, dan alamat tempat tinggal untuk akurasi rekomendasi layanan kesehatan.</p>
                </div>
                <a href="{{ route('profil.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-700">
                    <span>&larr; Batal</span>
                </a>
            </div>

            <!-- Error Alerts if any -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl shadow-xs">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs font-bold">Terjadi Kesalahan Pengisian Formulir</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm">
                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- ============================================== -->
                    <!-- SECTION: KOMPONEN UNGGAH FOTO PROFIL (PBI-011) -->
                    <!-- ============================================== -->
                    <div class="pb-6 border-b border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider text-brand-700 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                                <span>Foto Profil Pengguna</span>
                            </h2>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Maks. 2 MB (JPG, PNG, WEBP)</span>
                        </div>

                        <!-- Alert error sisi client jika ukuran atau format tidak sesuai -->
                        <div id="foto-client-error" class="hidden mb-4 bg-rose-50 border border-rose-200 text-rose-800 p-3.5 rounded-2xl text-xs font-semibold flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span id="foto-client-error-msg"></span>
                        </div>

                        @error('foto_profil')
                            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 p-3.5 rounded-2xl text-xs font-semibold flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 p-4 rounded-2xl bg-gradient-to-r from-pink-50/40 to-slate-50 border border-pink-100/70">
                            <!-- Avatar Preview Container -->
                            <div class="relative flex-shrink-0">
                                <!-- Image element -->
                                <img id="avatar-preview-img" 
                                     src="{{ $user->foto_profil_url ?? '' }}" 
                                     alt="Foto Profil {{ $user->name }}" 
                                     class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover ring-4 ring-white shadow-md {{ $user->foto_profil_url ? '' : 'hidden' }}">
                                
                                <!-- Fallback Initials Placeholder -->
                                <div id="avatar-preview-placeholder" 
                                     class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-gradient-to-tr from-brand-800 via-brand-700 to-pink-600 text-white flex items-center justify-center font-black text-3xl shadow-md ring-4 ring-white {{ $user->foto_profil_url ? 'hidden' : '' }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                                <!-- Badge Status Foto Baru -->
                                <span id="badge-foto-baru" class="hidden absolute bottom-0 right-0 bg-emerald-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-sm ring-2 ring-white">
                                    Baru
                                </span>
                            </div>

                            <!-- Controls & Information -->
                            <div class="flex-1 space-y-2.5 text-center sm:text-left">
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Unggah Foto Profil Baru</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">
                                        Pilih foto wajah yang jelas. Foto yang diunggah akan otomatis terhubung ke akun profil Anda.
                                    </p>
                                </div>

                                <!-- Action buttons -->
                                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-1">
                                    <!-- Hidden file input -->
                                    <input type="file" 
                                           id="foto_profil" 
                                           name="foto_profil" 
                                           accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" 
                                           class="hidden">
                                    
                                    <!-- Hidden input untuk penanda hapus foto -->
                                    <input type="hidden" id="hapus_foto" name="hapus_foto" value="0">

                                    <button type="button" 
                                            onclick="document.getElementById('foto_profil').click()" 
                                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-brand-700 hover:bg-brand-800 text-white text-xs font-bold shadow-xs transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Pilih Foto</span>
                                    </button>

                                    <!-- Tombol Hapus / Reset Foto -->
                                    <button type="button" 
                                            id="btn-hapus-foto" 
                                            onclick="handleHapusFoto()" 
                                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 hover:border-rose-300 text-slate-600 hover:text-rose-600 bg-white text-xs font-semibold transition {{ $user->foto_profil ? '' : 'hidden' }}">
                                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span id="btn-hapus-foto-label">Hapus Foto</span>
                                    </button>

                                    <span id="foto-filename" class="text-[11px] font-medium text-slate-500 italic hidden"></span>
                                </div>

                                <!-- Guidelines / Ketentuan Sesuai Acceptance Criteria -->
                                <div class="flex items-center gap-3 pt-1 text-[11px] text-slate-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        <span>Format: <strong>JPG, JPEG, PNG, WEBP</strong></span>
                                    </span>
                                    <span>&bull;</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        <span>Ukuran Maksimum: <strong>2 MB</strong></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Informasi Pokok (Nama, Kontak, Alamat) -->
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider text-brand-700 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                            <span>Data Pokok Profil (Acceptance Criteria)</span>
                        </h2>

                        <div class="space-y-4">
                            
                            <!-- Field: Nama Lengkap -->
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Lengkap Pengguna <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Contoh: Sarah Rahmawati" class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/50' }} focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                                <span class="text-[11px] text-slate-400 mt-1 block">Nama lengkap sesuai identitas KTP/Buku KIA.</span>
                                @error('name')
                                    <span class="text-xs text-rose-600 font-bold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Field: Nomor Kontak / Telepon - Acceptance Criteria & Validasi -->
                            <div>
                                <label for="no_telepon" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nomor Kontak / Telepon (WhatsApp) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </span>
                                    <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" required placeholder="Contoh: 081234567890" class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border {{ $errors->has('no_telepon') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/50' }} focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                                </div>
                                <span class="text-[11px] text-slate-400 mt-1 block">Format nomor ponsel Indonesia (minimal 10 digit, contoh: 081298765432).</span>
                                @error('no_telepon')
                                    <span class="text-xs text-rose-600 font-bold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Field: Alamat Lengkap Domisili - Acceptance Criteria 2 -->
                            <div>
                                <label for="alamat" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Alamat Lengkap Domisili <span class="text-rose-500">*</span>
                                </label>
                                <textarea id="alamat" name="alamat" rows="3" required placeholder="Contoh: Jl. Cempaka Putih Tengah No. 12, RT 04/RW 02" class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('alamat') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/50' }} focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">{{ old('alamat', $user->alamat) }}</textarea>
                                
                                <!-- Info Card: Acceptance Criteria 2 Highlight -->
                                <div class="mt-2 p-3 bg-blue-50/80 border border-blue-200/70 rounded-xl text-xs text-blue-900 flex items-start gap-2">
                                    <span class="text-base">📍</span>
                                    <div>
                                        <strong class="font-bold">Penting:</strong> Alamat profil ini akan digunakan sistem secara otomatis sebagai <strong>acuan lokasi rekomendasi layanan kesehatan</strong> (Posyandu, Puskesmas, dan RSIA terdekat).
                                    </div>
                                </div>
                                @error('alamat')
                                    <span class="text-xs text-rose-600 font-bold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kota & Kecamatan -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                                <div>
                                    <label for="kota" class="block text-xs font-bold text-slate-700 mb-1.5">Kota / Kabupaten</label>
                                    <input type="text" id="kota" name="kota" value="{{ old('kota', $user->kota ?? 'Jakarta Pusat') }}" placeholder="Contoh: Jakarta Pusat" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                                </div>
                                <div>
                                    <label for="kecamatan" class="block text-xs font-bold text-slate-700 mb-1.5">Kecamatan</label>
                                    <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $user->kecamatan ?? 'Cempaka Putih') }}" placeholder="Contoh: Cempaka Putih" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('profil.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-800 to-rose-700 hover:from-brand-900 hover:to-rose-800 text-white font-bold text-xs shadow-md shadow-brand-900/20 hover:shadow-lg transition">
                            Simpan Perubahan Profil
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

    <!-- Client-side Validation & Live Preview Script (Acceptance Criteria PBI-011) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('foto_profil');
            const previewImg = document.getElementById('avatar-preview-img');
            const placeholder = document.getElementById('avatar-preview-placeholder');
            const clientErrorBox = document.getElementById('foto-client-error');
            const clientErrorMsg = document.getElementById('foto-client-error-msg');
            const btnHapusFoto = document.getElementById('btn-hapus-foto');
            const btnHapusFotoLabel = document.getElementById('btn-hapus-foto-label');
            const hapusFotoInput = document.getElementById('hapus_foto');
            const badgeBaru = document.getElementById('badge-foto-baru');
            const filenameLabel = document.getElementById('foto-filename');

            const originalPhotoUrl = @json($user->foto_profil_url);
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            const maxSizeBytes = 2 * 1024 * 1024; // 2 MB Sesuai Acceptance Criteria

            function showError(msg) {
                if (clientErrorBox && clientErrorMsg) {
                    clientErrorMsg.textContent = msg;
                    clientErrorBox.classList.remove('hidden');
                }
            }

            function hideError() {
                if (clientErrorBox && clientErrorMsg) {
                    clientErrorBox.classList.add('hidden');
                    clientErrorMsg.textContent = '';
                }
            }

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    hideError();
                    const file = this.files[0];
                    if (!file) return;

                    // Reset flag penanda hapus
                    if (hapusFotoInput) hapusFotoInput.value = '0';

                    // 1. Validasi Ekstensi / Format File
                    const ext = file.name.split('.').pop().toLowerCase();
                    if (!allowedExtensions.includes(ext)) {
                        showError('Format file tidak sesuai! Format foto profil harus berupa JPG, JPEG, PNG, atau WEBP.');
                        this.value = '';
                        resetToOriginal();
                        return;
                    }

                    // 2. Validasi Ukuran File (Maksimal 2 MB)
                    if (file.size > maxSizeBytes) {
                        showError('Ukuran file terlalu besar! Ukuran file foto profil tidak boleh melebihi 2 MB.');
                        this.value = '';
                        resetToOriginal();
                        return;
                    }

                    // 3. Tampilkan Live Preview Real-time
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (previewImg) {
                            previewImg.src = e.target.result;
                            previewImg.classList.remove('hidden');
                        }
                        if (placeholder) {
                            placeholder.classList.add('hidden');
                        }
                        if (badgeBaru) {
                            badgeBaru.classList.remove('hidden');
                        }
                        if (btnHapusFoto) {
                            btnHapusFoto.classList.remove('hidden');
                        }
                        if (btnHapusFotoLabel) {
                            btnHapusFotoLabel.textContent = 'Batalkan Pilihan';
                        }
                        if (filenameLabel) {
                            filenameLabel.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                            filenameLabel.classList.remove('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }

            window.handleHapusFoto = function() {
                hideError();
                // Jika sedang memilih file baru tapi belum disimpan
                if (fileInput && fileInput.files && fileInput.files.length > 0) {
                    fileInput.value = '';
                    resetToOriginal();
                    return;
                }

                // Jika ingin menghapus foto yang sudah tersimpan di database
                if (confirm('Apakah Anda yakin ingin menghapus foto profil ini dan menggunakan inisial nama?')) {
                    if (hapusFotoInput) hapusFotoInput.value = '1';
                    if (previewImg) {
                        previewImg.src = '';
                        previewImg.classList.add('hidden');
                    }
                    if (placeholder) {
                        placeholder.classList.remove('hidden');
                    }
                    if (badgeBaru) {
                        badgeBaru.classList.add('hidden');
                    }
                    if (btnHapusFoto) {
                        btnHapusFoto.classList.add('hidden');
                    }
                    if (filenameLabel) {
                        filenameLabel.classList.add('hidden');
                    }
                }
            };

            function resetToOriginal() {
                if (originalPhotoUrl) {
                    if (previewImg) {
                        previewImg.src = originalPhotoUrl;
                        previewImg.classList.remove('hidden');
                    }
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                    if (btnHapusFoto) {
                        btnHapusFoto.classList.remove('hidden');
                    }
                    if (btnHapusFotoLabel) {
                        btnHapusFotoLabel.textContent = 'Hapus Foto';
                    }
                } else {
                    if (previewImg) {
                        previewImg.src = '';
                        previewImg.classList.add('hidden');
                    }
                    if (placeholder) {
                        placeholder.classList.remove('hidden');
                    }
                    if (btnHapusFoto) {
                        btnHapusFoto.classList.add('hidden');
                    }
                }
                if (badgeBaru) badgeBaru.classList.add('hidden');
                if (filenameLabel) filenameLabel.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
