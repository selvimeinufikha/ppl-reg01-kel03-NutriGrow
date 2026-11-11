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
    <title>Ganti Kata Sandi - NutriGrow</title>

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
                    <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Profil Pengguna</span>
                    </a>

                    <a href="{{ route('profil.password.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-gradient-to-r from-brand-800 to-brand-700 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4 text-rose-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Ganti Kata Sandi</span>
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
                <span>&larr; Kembali ke Profil</span>
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
            
            <a href="{{ route('profil.index') }}" class="flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-brand-700 transition">
                @if ($user->foto_profil_url)
                    <img src="{{ $user->foto_profil_url }}" alt="{{ $userName }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-pink-100">
                @else
                    <div class="w-7 h-7 rounded-full bg-brand-800 text-white flex items-center justify-center font-bold text-[10px]">
                        {{ strtoupper(substr($userName, 0, 1)) }}
                    </div>
                @endif
                <span>{{ $userName }}</span>
            </a>
        </header>

        <!-- MAIN CONTAINER -->
        <main class="p-4 sm:p-6 lg:p-8 max-w-2xl w-full mx-auto space-y-6">
            
            <!-- Breadcrumb -->
            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-slate-600">Dashboard</a>
                <span>&rsaquo;</span>
                <a href="{{ route('profil.index') }}" class="hover:text-slate-600">Profil Pengguna</a>
                <span>&rsaquo;</span>
                <span class="text-brand-700 font-bold">Ganti Kata Sandi</span>
            </div>

            <!-- Page Title -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ganti Kata Sandi Akun</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun dan privasi data keluarga Anda.</p>
                </div>
                <a href="{{ route('profil.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-700">
                    <span>&larr; Batal</span>
                </a>
            </div>

            <!-- Ketentuan Acceptance Criteria Banner -->
            <div class="p-4 rounded-2xl bg-gradient-to-r from-pink-50/80 via-rose-50/60 to-purple-50/60 border border-pink-200/80 text-xs text-slate-700 space-y-2">
                <div class="flex items-center gap-2 font-bold text-brand-800">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Ketentuan Keamanan Kata Sandi (Acceptance Criteria)</span>
                </div>
                <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside pl-1">
                    <li><strong>Kata sandi baru minimal 8 karakter</strong> dan disimpan terenkripsi di sistem.</li>
                    <li>Penggantian kata sandi <strong>meminta kata sandi lama yang benar</strong> untuk verifikasi identitas pemilik akun.</li>
                    <li>Kata sandi baru tidak boleh sama dengan kata sandi lama.</li>
                </ul>
            </div>

            <!-- Error Alerts if any -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl shadow-xs">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs font-bold">Terjadi Kesalahan Pengisian Kata Sandi</span>
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
                <form action="{{ route('profil.password.update') }}" method="POST" class="space-y-5" id="form-ganti-password">
                    @csrf
                    @method('PUT')

                    <!-- Field 1: Kata Sandi Saat Ini (Lama) - Acceptance Criteria 2 -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="current_password" class="block text-xs font-bold text-slate-700">
                                Kata Sandi Saat Ini (Lama) <span class="text-rose-500">*</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 hover:underline">
                                Lupa kata sandi?
                            </a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   required 
                                   placeholder="Masukkan kata sandi lama Anda" 
                                   class="w-full pl-10 pr-11 py-2.5 text-xs rounded-xl border {{ $errors->has('current_password') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/50' }} focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('current_password', 'eye-icon-current')" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition"
                                    title="Lihat / Sembunyikan Kata Sandi">
                                <svg id="eye-icon-current" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <span class="text-[11px] text-slate-400 mt-1 block">Wajib memasukkan kata sandi lama yang benar untuk memverifikasi akun Anda.</span>
                        @error('current_password')
                            <span class="text-xs text-rose-600 font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 my-4"></div>

                    <!-- Field 2: Kata Sandi Baru - Acceptance Criteria 1 -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Kata Sandi Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            </span>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   minlength="8" 
                                   placeholder="Minimal 8 karakter" 
                                   class="w-full pl-10 pr-11 py-2.5 text-xs rounded-xl border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/50' }} focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('password', 'eye-icon-new')" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition"
                                    title="Lihat / Sembunyikan Kata Sandi">
                                <svg id="eye-icon-new" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>

                        <!-- Real-time Validation Criteria Checklist -->
                        <div class="mt-2 space-y-1">
                            <div id="check-length" class="flex items-center gap-1.5 text-[11px] text-slate-400 transition-colors">
                                <span class="w-3.5 h-3.5 rounded-full flex items-center justify-center text-[9px] bg-slate-100 text-slate-400" id="icon-check-length">&#x25CB;</span>
                                <span>Minimal 8 karakter (Acceptance Criteria)</span>
                            </div>
                        </div>

                        @error('password')
                            <span class="text-xs text-rose-600 font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Field 3: Konfirmasi Kata Sandi Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="Ulangi kata sandi baru" 
                                   class="w-full pl-10 pr-11 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 font-semibold text-slate-800 transition">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-confirm')" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition"
                                    title="Lihat / Sembunyikan Kata Sandi">
                                <svg id="eye-icon-confirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <div id="match-status" class="text-[11px] mt-1 font-semibold hidden"></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('profil.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" id="btn-submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-800 to-rose-700 hover:from-brand-900 hover:to-rose-800 text-white font-bold text-xs shadow-md shadow-brand-900/20 hover:shadow-lg transition">
                            Perbarui Kata Sandi
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

    <!-- Client-side Interactive Script -->
    <script>
        function togglePasswordVisibility(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (!field) return;

            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>';
            } else {
                field.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const checkLength = document.getElementById('check-length');
            const iconCheckLength = document.getElementById('icon-check-length');
            const matchStatus = document.getElementById('match-status');

            function validateInputs() {
                const passVal = passwordInput.value;
                const confirmVal = confirmInput.value;

                // Check minimal 8 karakter
                if (passVal.length >= 8) {
                    checkLength.classList.remove('text-slate-400', 'text-rose-600');
                    checkLength.classList.add('text-emerald-600');
                    iconCheckLength.innerHTML = '✔';
                    iconCheckLength.className = 'w-3.5 h-3.5 rounded-full flex items-center justify-center text-[9px] bg-emerald-100 text-emerald-700 font-bold';
                } else if (passVal.length > 0) {
                    checkLength.classList.remove('text-slate-400', 'text-emerald-600');
                    checkLength.classList.add('text-rose-600');
                    iconCheckLength.innerHTML = '✕';
                    iconCheckLength.className = 'w-3.5 h-3.5 rounded-full flex items-center justify-center text-[9px] bg-rose-100 text-rose-700 font-bold';
                } else {
                    checkLength.classList.remove('text-emerald-600', 'text-rose-600');
                    checkLength.classList.add('text-slate-400');
                    iconCheckLength.innerHTML = '○';
                    iconCheckLength.className = 'w-3.5 h-3.5 rounded-full flex items-center justify-center text-[9px] bg-slate-100 text-slate-400';
                }

                // Check match confirmation
                if (confirmVal.length > 0) {
                    matchStatus.classList.remove('hidden');
                    if (passVal === confirmVal) {
                        matchStatus.textContent = '✔ Konfirmasi kata sandi cocok.';
                        matchStatus.className = 'text-[11px] mt-1 font-semibold text-emerald-600';
                    } else {
                        matchStatus.textContent = '✕ Konfirmasi kata sandi belum cocok.';
                        matchStatus.className = 'text-[11px] mt-1 font-semibold text-rose-600';
                    }
                } else {
                    matchStatus.classList.add('hidden');
                }
            }

            if (passwordInput) passwordInput.addEventListener('input', validateInputs);
            if (confirmInput) confirmInput.addEventListener('input', validateInputs);
        });
    </script>
</body>
</html>
