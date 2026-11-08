<!DOCTYPE html>
@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
    // Tentukan mode awal berdasarkan rute atau error yang terjadi
    if (!isset($initialMode)) {
        if ($errors->has('login_error') || old('_auth_mode') === 'login' || request()->routeIs('login')) {
            $initialMode = 'login';
        } else {
            $initialMode = 'register';
        }
    }
@endphp
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $initialMode === 'login' ? 'Masuk ke Akun Keluarga' : 'Pendaftaran Akun Baru' }} - NutriGrow | Cegah Stunting</title>

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
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Ultra Smooth Physics-based Slide */
        .showcase-slider {
            transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1);
            will-change: transform;
        }
        /* Smooth Crossfade without any layout jump */
        .fade-layer {
            transition: opacity 0.35s ease, transform 0.35s ease;
        }
    </style>
</head>
<body class="min-h-screen lg:h-screen bg-white font-sans antialiased text-slate-800 flex flex-col justify-between selection:bg-brand-500 selection:text-white lg:overflow-hidden">

    <!-- =================================================================== -->
    <!-- MAIN CONTAINER: SPLIT SCREEN WITH ZERO-JUMP SLIDING SHOWCASE       -->
    <!-- =================================================================== -->
    <div id="authContainer" class="min-h-screen lg:h-full w-full bg-white relative overflow-x-hidden lg:overflow-hidden select-none">

        <!-- =============================================================== -->
        <!-- LAYER 1: FORMS GRID (Static on desktop: Left=Login, Right=Reg)  -->
        <!-- =============================================================== -->
        <div class="min-h-screen lg:h-full w-full flex flex-col lg:flex-row relative z-10">

            <!-- ========================================== -->
            <!-- 1. LEFT FORM COLUMN: LOGIN FORM            -->
            <!-- ========================================== -->
            <div id="loginFormCol" class="w-full lg:w-1/2 min-h-screen lg:min-h-0 lg:h-full bg-white px-6 sm:px-8 lg:px-10 xl:px-14 py-5 sm:py-6 lg:py-6 flex flex-col justify-between items-center relative z-10 transition-opacity duration-300 {{ $initialMode === 'login' ? 'flex' : 'hidden lg:flex' }}">

                <!-- Mobile Top Bar for Login -->
                <div class="lg:hidden w-full flex items-center justify-between mb-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain">
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                </div>

                <div class="w-full max-w-[390px] sm:max-w-[420px] mx-auto my-auto py-1">

                    <!-- Pill Badge: Masuk ke Akun Keluarga -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200/80 text-brand-600 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>MASUK KE AKUN KELUARGA</span>
                    </div>

                    <!-- Heading & Subtitle -->
                    <h1 class="text-2xl sm:text-[28px] font-extrabold text-slate-900 tracking-tight mb-1">
                        Selamat Datang Kembali
                    </h1>
                    <p class="text-xs sm:text-[13px] text-slate-500 mb-3.5 leading-relaxed">
                        Masuk untuk memantau tumbuh kembang si kecil dan jadwal kesehatan keluarga Anda.
                    </p>

                    <!-- Alert: Login Error -->
                    @if ($errors->has('login_error'))
                        <div class="mb-3 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2">
                            <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span class="font-medium">{{ $errors->first('login_error') }}</span>
                        </div>
                    @endif

                    @if (session('success_reset'))
                        <div class="mb-3 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('success_reset') }}</span>
                        </div>
                    @endif

                    @if (session('success_logout'))
                        <div class="mb-3 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('success_logout') }}</span>
                        </div>
                    @endif

                    <!-- LOGIN FORM -->
                    <form action="{{ route('login.submit') }}" method="POST" id="loginForm" class="space-y-3">
                        @csrf
                        <input type="hidden" name="_auth_mode" value="login">

                        <!-- Field 1: Email Akun -->
                        <div>
                            <label for="login_email" class="block text-xs font-bold text-slate-700 mb-0.5">
                                Email Akun <span class="text-brand-600">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    id="login_email"
                                    name="email"
                                    required
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    class="w-full pl-10 pr-3.5 py-2 sm:py-2.5 rounded-xl bg-slate-50/70 border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                                />
                            </div>
                            @error('email')
                                <p class="mt-0.5 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Field 2: Kata Sandi -->
                        <div>
                            <div class="flex items-center justify-between mb-0.5">
                                <label for="login_password" class="text-xs font-bold text-slate-700">
                                    Kata Sandi <span class="text-brand-600">*</span>
                                </label>
                                <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition">
                                    Lupa Kata Sandi?
                                </a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="login_password"
                                    name="password"
                                    required
                                    placeholder="Masukkan kata sandi Anda"
                                    class="w-full pl-10 pr-10 py-2 sm:py-2.5 rounded-xl bg-slate-50/70 border @error('password') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                                />
                                <button
                                    type="button"
                                    id="toggleLoginPassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none"
                                    title="Lihat password"
                                >
                                    <svg id="eyeLoginIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-0.5 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row: Ingat Sesi & Enkripsi -->
                        <div class="flex items-center justify-between text-xs pt-0.5">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    {{ old('remember') ? 'checked' : '' }}
                                    class="w-3.5 h-3.5 rounded text-brand-600 focus:ring-brand-500 border-slate-300 accent-pink-600 cursor-pointer"
                                />
                                <span class="text-[11px] text-slate-600 font-medium">Ingat sesi login saya</span>
                            </label>

                            <div class="flex items-center gap-1 text-[11px] text-slate-400 font-medium">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Enkripsi 256-bit</span>
                            </div>
                        </div>

                        <!-- Submit Button: Masuk Sekarang -->
                        <div class="pt-1">
                            <button
                                type="submit"
                                class="w-full py-2.5 sm:py-3 px-5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 hover:from-brand-700 hover:to-pink-600 shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-pink-500/30 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>Masuk Sekarang</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Divider & Switch to Register Button -->
                    <div class="mt-3.5 pt-2.5 border-t border-slate-100 text-center">
                        <p class="text-[11px] text-slate-400 mb-1.5 font-medium">Belum punya akun keluarga?</p>
                        <button
                            type="button"
                            id="btnSwitchToRegister"
                            class="w-full py-2 sm:py-2.5 px-4 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer group"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-500 group-hover:text-brand-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>Belum punya akun? Daftar Sekarang</span>
                        </button>
                    </div>

                    <!-- Link Khusus Tenaga Medis / Admin -->
                    <div class="mt-2.5 text-center">
                        <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-sky-600 hover:text-sky-700 hover:underline transition">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Petugas Faskes / Tenaga Medis? Masuk Admin &rarr;</span>
                        </a>
                    </div>

                </div>

                <!-- Footer: Data Medis Terenkripsi -->
                <div class="w-full max-w-[390px] sm:max-w-[420px] pt-3 flex items-center justify-between text-[10px] text-slate-400 border-t border-slate-100/80">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/>
                        </svg>
                        <span>Data medis anak terenkripsi standar Kemenkes</span>
                    </div>
                    <div>
                        &copy; 2025 NutriGrow
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- 2. RIGHT FORM COLUMN: REGISTER FORM        -->
            <!-- ========================================== -->
            <div id="registerFormCol" class="w-full lg:w-1/2 min-h-screen lg:min-h-0 lg:h-full bg-white px-6 sm:px-8 lg:px-10 xl:px-14 py-5 sm:py-6 lg:py-6 flex flex-col justify-between items-center relative z-10 transition-opacity duration-300 {{ $initialMode === 'register' ? 'flex' : 'hidden lg:flex' }}">

                <!-- Mobile Top Bar for Register -->
                <div class="lg:hidden w-full flex items-center justify-between mb-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain">
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                </div>

                <div class="w-full max-w-[390px] sm:max-w-[420px] mx-auto my-auto py-1">

                    <!-- Pill Badge: Pendaftaran Akun Baru -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200/80 text-brand-600 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <span>PENDAFTARAN AKUN BARU</span>
                    </div>

                    <!-- Heading & Subtitle -->
                    <h1 class="text-2xl sm:text-[28px] font-extrabold text-slate-900 tracking-tight mb-1">
                        Bergabung dengan NutriGrow
                    </h1>
                    <p class="text-xs sm:text-[13px] text-slate-500 mb-3">
                        Buat akun untuk mulai memantau kesehatan keluarga.
                    </p>

                    <!-- Alert: Validation Errors on Register -->
                    @if (isset($errors) && $errors->any() && !$errors->has('login_error'))
                        <div class="mb-3 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                            <div class="font-bold flex items-center gap-1.5 mb-1 text-rose-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                <span>Periksa kembali isian formulir:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 text-rose-600 text-[11px]">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- REGISTER FORM -->
                    <form action="{{ route('register.submit') }}" method="POST" id="registerForm" class="space-y-2.5 sm:space-y-3">
                        @csrf
                        <input type="hidden" name="_auth_mode" value="register">

                        <!-- Field 1: Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 mb-0.5">
                                Nama Lengkap <span class="text-brand-600">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    required
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Siti Rahmawati"
                                    class="w-full pl-10 pr-3.5 py-2 sm:py-2.5 rounded-xl bg-slate-50/70 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                                />
                            </div>
                        </div>

                        <!-- Field 2: Email -->
                        <div>
                            <div class="flex items-center justify-between mb-0.5">
                                <label for="email" class="text-xs font-bold text-slate-700">
                                    Email <span class="text-brand-600">*</span>
                                </label>
                                <span id="email-hint" class="text-[11px] text-slate-400 font-medium transition">
                                    Pencegahan email duplikat aktif
                                </span>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    class="w-full pl-10 pr-10 py-2 sm:py-2.5 rounded-xl bg-slate-50/70 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                                />
                                <div id="email-icon-indicator" class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none hidden">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <p id="email-live-msg" class="mt-0.5 text-[11px] font-medium hidden"></p>
                        </div>

                        <!-- Field 3: Password -->
                        <div>
                            <div class="flex items-center justify-between mb-0.5">
                                <label for="password" class="text-xs font-bold text-slate-700">
                                    Password <span class="text-brand-600">*</span>
                                </label>
                                <span class="text-[11px] text-slate-400 font-medium">Minimal 8 karakter</span>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="Minimal 8 karakter"
                                    class="w-full pl-10 pr-10 py-2 sm:py-2.5 rounded-xl bg-slate-50/70 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                                />
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none"
                                    title="Lihat password"
                                >
                                    <svg id="eyeIcon1" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="mt-1.5">
                                <div class="flex items-center justify-between text-[11px] mb-1">
                                    <span class="text-slate-400 font-medium">Kekuatan Sandi</span>
                                    <span id="strengthText" class="font-bold text-slate-400">-</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden flex gap-1">
                                    <div id="str-bar-1" class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300"></div>
                                    <div id="str-bar-2" class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300"></div>
                                    <div id="str-bar-3" class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300"></div>
                                    <div id="str-bar-4" class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Field 4: Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-0.5">
                                Konfirmasi Password <span class="text-brand-600">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    placeholder="Ulangi kata sandi Anda"
                                    class="w-full pl-10 pr-10 py-2 sm:py-2.5 rounded-xl bg-slate-50/70 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                                />
                                <button
                                    type="button"
                                    id="toggleConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none"
                                    title="Lihat konfirmasi password"
                                >
                                    <svg id="eyeIcon2" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <p id="match-msg" class="mt-0.5 text-[11px] font-medium hidden"></p>
                        </div>

                        <!-- Checkbox: Syarat & Ketentuan -->
                        <div class="pt-0.5">
                            <label class="flex items-start gap-2 cursor-pointer select-none">
                                <input
                                    type="checkbox"
                                    id="terms"
                                    name="terms"
                                    value="1"
                                    required
                                    {{ old('terms') ? 'checked' : '' }}
                                    class="mt-0.5 w-3.5 h-3.5 rounded text-brand-600 focus:ring-brand-500 border-slate-300 accent-pink-600 cursor-pointer"
                                />
                                <span class="text-[11px] text-slate-600 leading-snug">
                                    Saya menyetujui <a href="javascript:void(0)" class="text-brand-600 hover:text-brand-700 font-semibold underline">Syarat & Ketentuan</a> serta <a href="javascript:void(0)" class="text-brand-600 hover:text-brand-700 font-semibold underline">Kebijakan Privasi</a> NutriGrow.
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button: Daftar Sekarang -->
                        <div class="pt-1">
                            <button
                                type="submit"
                                id="submitBtn"
                                class="w-full py-2.5 sm:py-3 px-5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 hover:from-brand-700 hover:to-pink-600 shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-pink-500/30 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>Daftar Sekarang</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Divider & Switch to Login Button -->
                    <div class="mt-3 pt-2.5 border-t border-slate-100 text-center">
                        <p class="text-[11px] text-slate-400 mb-1.5 font-medium">Sudah punya akun NutriGrow?</p>
                        <button
                            type="button"
                            id="btnSwitchToLogin"
                            class="w-full py-2 sm:py-2.5 px-4 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer group"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-500 group-hover:text-brand-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span>Sudah punya akun? Masuk</span>
                        </button>
                    </div>

                </div>

                <!-- Footer: Keamanan Hashing -->
                <div class="w-full max-w-[390px] sm:max-w-[420px] pt-3 flex items-center justify-center gap-1.5 text-center text-[10px] text-slate-400 border-t border-slate-100/80">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Sistem dirancang dengan hashing kata sandi aman & perlindungan data medis keluarga.</span>
                </div>

            </div>

        </div>

        <!-- =============================================================== -->
        <!-- LAYER 2: THE FLOATING SLIDING SHOWCASE PANEL (Desktop Overlay)   -->
        <!-- =============================================================== -->
        <!-- Solid, jitter-free sliding overlay with zero opacity drops on background -->
        <div
            id="showcasePanel"
            class="hidden lg:flex w-1/2 h-full absolute inset-y-0 left-0 z-20 showcase-slider pointer-events-auto bg-transparent px-6 sm:px-8 lg:px-10 xl:px-12 py-4 sm:py-5 lg:py-6 flex-col justify-between overflow-visible"
            style="transform: {{ $initialMode === 'login' ? 'translateX(100%)' : 'translateX(0%)' }};"
        >

            <!-- 1. LATAR BELAKANG SEAMLESS DENGAN KURVA TERINTEGRASI (100% BEBAS DARI GARIS LURUS) -->
            <!-- Kurva untuk Mode Register (Menghadap Kanan) -->
            <div id="svgCurveRegister" class="absolute inset-y-0 left-0 right-[-50px] xl:right-[-65px] pointer-events-none z-0 transition-opacity duration-500 {{ $initialMode === 'register' ? 'opacity-100' : 'opacity-0' }}">
                <svg class="w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="bgGradReg" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#fff1f2" />
                            <stop offset="35%" stop-color="#fdf2f4" />
                            <stop offset="70%" stop-color="#fae8ed" />
                            <stop offset="100%" stop-color="#f5f3ff" stop-opacity="0.95" />
                        </linearGradient>
                        <radialGradient id="topGlowReg" cx="20%" cy="15%" r="55%">
                            <stop offset="0%" stop-color="#fb7185" stop-opacity="0.18" />
                            <stop offset="100%" stop-color="#fb7185" stop-opacity="0" />
                        </radialGradient>
                        <radialGradient id="botGlowReg" cx="75%" cy="80%" r="50%">
                            <stop offset="0%" stop-color="#c084fc" stop-opacity="0.15" />
                            <stop offset="100%" stop-color="#c084fc" stop-opacity="0" />
                        </radialGradient>
                    </defs>
                    <path d="M 0,0 L 910,0 C 970,300 1000,550 900,1000 L 0,1000 Z" fill="url(#bgGradReg)" />
                    <path d="M 0,0 L 910,0 C 970,300 1000,550 900,1000 L 0,1000 Z" fill="url(#topGlowReg)" />
                    <path d="M 0,0 L 910,0 C 970,300 1000,550 900,1000 L 0,1000 Z" fill="url(#botGlowReg)" />
                </svg>
            </div>

            <!-- Kurva untuk Mode Login (Menghadap Kiri) -->
            <div id="svgCurveLogin" class="absolute inset-y-0 left-[-50px] xl:left-[-65px] right-0 pointer-events-none z-0 transition-opacity duration-500 {{ $initialMode === 'login' ? 'opacity-100' : 'opacity-0' }}">
                <svg class="w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="bgGradLog" x1="100%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#fff1f2" />
                            <stop offset="35%" stop-color="#fdf2f4" />
                            <stop offset="70%" stop-color="#fae8ed" />
                            <stop offset="100%" stop-color="#f5f3ff" stop-opacity="0.95" />
                        </linearGradient>
                        <radialGradient id="topGlowLog" cx="80%" cy="15%" r="55%">
                            <stop offset="0%" stop-color="#fb7185" stop-opacity="0.18" />
                            <stop offset="100%" stop-color="#fb7185" stop-opacity="0" />
                        </radialGradient>
                        <radialGradient id="botGlowLog" cx="25%" cy="80%" r="50%">
                            <stop offset="0%" stop-color="#c084fc" stop-opacity="0.15" />
                            <stop offset="100%" stop-color="#c084fc" stop-opacity="0" />
                        </radialGradient>
                    </defs>
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#bgGradLog)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#topGlowLog)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#botGlowLog)" />
                </svg>
            </div>

            <!-- Top Row: Logo & Back Link -->
            <div class="relative z-10 flex items-center justify-between mb-3 sm:mb-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain transition transform group-hover:scale-102">
                </a>

                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 hover:bg-white border border-slate-200/90 text-[11px] sm:text-xs font-semibold text-slate-600 hover:text-brand-600 shadow-2xs hover:shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <!-- Center Content: Visual Illustration & Copy (Zero-Jumping CSS Grid Overlay) -->
            <div class="relative z-10 w-full max-w-[390px] xl:max-w-[420px] mx-auto text-center my-auto py-1 sm:py-2">

                <!-- 1. Pill Badge: Superposed in Grid Cell (Zero Layout Shift) -->
                <div class="grid grid-cols-1 grid-rows-1 h-7 mb-3 sm:mb-3.5">
                    <!-- Register Pill -->
                    <div id="pillRegister" class="col-start-1 row-start-1 fade-layer inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full bg-pink-100/90 border border-pink-200/90 text-brand-600 text-[11px] sm:text-xs font-bold shadow-2xs mx-auto {{ $initialMode === 'register' ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none' }}">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>Langkah Pertama Cegah Stunting</span>
                    </div>

                    <!-- Login Pill -->
                    <div id="pillLogin" class="col-start-1 row-start-1 fade-layer inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full bg-pink-100/90 border border-pink-200/90 text-brand-600 text-[11px] sm:text-xs font-bold shadow-2xs mx-auto {{ $initialMode === 'login' ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none' }}">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>Pantau Kesehatan Si Kecil Secara Terpadu</span>
                    </div>
                </div>

                <!-- 2. Illustration Card (Rock-solid, No Jiggle, No Jump) -->
                <div class="relative mx-auto w-full max-w-[340px] sm:max-w-[370px] bg-white rounded-[26px] sm:rounded-[28px] p-4 sm:p-5 shadow-xl shadow-pink-500/10 border border-white mb-4 sm:mb-5">

                    <!-- Floating Badge Top Left: Standar Kemenkes RI (Solid, Identik) -->
                    <div class="absolute -top-3.5 -left-2 sm:-left-3 bg-white/95 backdrop-blur-md rounded-2xl px-3 py-1.5 sm:px-3.5 sm:py-2 border border-slate-100 shadow-md shadow-slate-200/70 flex items-center gap-2 z-20 pointer-events-none">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">Standar Kemenkes RI</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium leading-tight">Kurva WHO Terintegrasi</div>
                        </div>
                    </div>

                    <!-- Mother & Child Image/Illustration (Solid & Glides Smoothly Without Jitter) -->
                    <div class="relative w-full h-44 sm:h-48 lg:h-52 rounded-2xl overflow-hidden bg-gradient-to-b from-rose-50/50 via-pink-50/30 to-slate-50 flex items-center justify-center">
                        <img
                            src="{{ asset('images/register-mother-child.jpg') }}"
                            alt="Ibu dan Anak Sehat NutriGrow"
                            class="w-full h-full object-cover object-center"
                            onerror="this.onerror=null; this.src='{{ asset('images/family-hero.png') }}';"
                        />
                    </div>

                    <!-- Floating Badge Bottom Right: Superposed Crossfade (Zero Movement) -->
                    <div class="absolute -bottom-3.5 -right-2 sm:-right-3 z-20 pointer-events-none">
                        <div class="relative grid grid-cols-1 grid-rows-1">
                            <!-- Register Badge: 100% Gratis -->
                            <div id="cardBadgeRegister" class="col-start-1 row-start-1 fade-layer bg-white/95 backdrop-blur-md rounded-2xl px-3 py-1.5 sm:px-3.5 sm:py-2 border border-slate-100 shadow-md shadow-pink-500/10 flex items-center gap-2 {{ $initialMode === 'register' ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none' }}">
                                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-pink-50 text-brand-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">100% Gratis</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium leading-tight">Untuk Semua Ibu Indonesia</div>
                                </div>
                            </div>

                            <!-- Login Badge: Deteksi Dini Stunting -->
                            <div id="cardBadgeLogin" class="col-start-1 row-start-1 fade-layer bg-white/95 backdrop-blur-md rounded-2xl px-3 py-1.5 sm:px-3.5 sm:py-2 border border-slate-100 shadow-md shadow-pink-500/10 flex items-center gap-2 {{ $initialMode === 'login' ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none' }}">
                                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-pink-50 text-brand-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">Deteksi Dini Stunting</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium leading-tight">Analisis Grafik KMS Digital</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3. Headline: Superposed in Grid Cell -->
                <div class="grid grid-cols-1 grid-rows-1 min-h-[56px] mb-1.5 sm:mb-2 text-center items-center">
                    <!-- Register Headline -->
                    <div id="headRegister" class="col-start-1 row-start-1 fade-layer {{ $initialMode === 'register' ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1 pointer-events-none' }}">
                        <h2 class="text-xl sm:text-2xl lg:text-[25px] font-extrabold text-slate-900 tracking-tight leading-snug">
                            Lindungi Generasi Masa Depan<br>
                            <span class="bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 bg-clip-text text-transparent">
                                Sejak 1000 Hari Pertama
                            </span>
                        </h2>
                    </div>

                    <!-- Login Headline -->
                    <div id="headLogin" class="col-start-1 row-start-1 fade-layer {{ $initialMode === 'login' ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1 pointer-events-none' }}">
                        <h2 class="text-xl sm:text-2xl lg:text-[25px] font-extrabold text-slate-900 tracking-tight leading-snug">
                            Pantau Tumbuh Kembang &<br>
                            Nutrisi <span class="bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 bg-clip-text text-transparent">Setiap Hari</span>
                        </h2>
                    </div>
                </div>

                <!-- 4. Subtitle: Superposed in Grid Cell -->
                <div class="grid grid-cols-1 grid-rows-1 min-h-[36px] mb-3 sm:mb-4 text-center items-center">
                    <p id="subRegister" class="col-start-1 row-start-1 fade-layer text-xs sm:text-[13px] text-slate-600 leading-relaxed max-w-sm mx-auto {{ $initialMode === 'register' ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1 pointer-events-none' }}">
                        Satu akun untuk mencatat tumbuh kembang, memantau asupan gizi harian, dan deteksi dini stunting.
                    </p>
                    <p id="subLogin" class="col-start-1 row-start-1 fade-layer text-xs sm:text-[13px] text-slate-600 leading-relaxed max-w-sm mx-auto {{ $initialMode === 'login' ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1 pointer-events-none' }}">
                        Satu akun keluarga aman untuk mencatat grafik KMS digital, riwayat nutrisi seimbang, dan deteksi dini stunting.
                    </p>
                </div>

                <!-- 5. 3 Feature Badges: Superposed in Grid Cell -->
                <div class="grid grid-cols-1 grid-rows-1 min-h-[32px] text-center items-center">
                    <!-- Register Badges -->
                    <div id="badgesRegister" class="col-start-1 row-start-1 fade-layer flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs font-semibold text-slate-700 {{ $initialMode === 'register' ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none' }}">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Pantau Berat & Tinggi</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Notifikasi Imunisasi</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Resep MPASI Teruji</span>
                        </span>
                    </div>

                    <!-- Login Badges -->
                    <div id="badgesLogin" class="col-start-1 row-start-1 fade-layer flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs font-semibold text-slate-700 {{ $initialMode === 'login' ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none' }}">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span>Grafik Real-time</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span>Pengingat Imunisasi</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Menu MPASI Teruji</span>
                        </span>
                    </div>
                </div>

            </div>

            <!-- Bottom Footer: Keamanan & Hak Cipta -->
            <div class="relative z-10 pt-3 border-t border-pink-200/60 flex flex-col sm:flex-row items-center justify-between gap-1 text-[11px] text-slate-400 font-medium">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Data terenkripsi & privasi keluarga terjamin</span>
                </div>
                <div class="grid grid-cols-1 grid-rows-1 text-right">
                    <span id="footerRightRegister" class="col-start-1 row-start-1 fade-layer {{ $initialMode === 'register' ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">&copy; 2025 NutriGrow Indonesia</span>
                    <span id="footerRightLogin" class="col-start-1 row-start-1 fade-layer {{ $initialMode === 'login' ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">Akses Terproteksi SSL 256-Bit</span>
                </div>
            </div>

        </div>

    </div>

    <!-- ========================================== -->
    <!-- SUCCESS MODAL (When registered)            -->
    <!-- ========================================== -->
    @if (session('success_modal'))
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-[28px] p-6 sm:p-7 max-w-sm w-full text-center shadow-2xl border border-slate-100 animate-fadeIn">
            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h3 class="text-lg font-extrabold text-slate-900 mb-1">Pendaftaran Berhasil!</h3>
            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                Akun keluarga Anda telah aktif dan tersimpan aman di database NutriGrow.
            </p>

            <div class="bg-slate-50 rounded-2xl p-3.5 text-left text-xs mb-4 space-y-1.5 border border-slate-100">
                <div class="flex justify-between">
                    <span class="text-slate-400">Nama:</span>
                    <strong class="text-slate-800">{{ session('success_modal')['name'] }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Email:</span>
                    <strong class="text-slate-800">{{ session('success_modal')['email'] }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Terdaftar:</span>
                    <span class="text-slate-600">{{ session('success_modal')['created_at'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Status DB:</span>
                    <span class="inline-flex items-center gap-1 text-emerald-600 font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersimpan di SQLite
                    </span>
                </div>
            </div>

            <div class="space-y-2">
                <a href="{{ route('home') }}" class="block w-full py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand-600 to-pink-500 hover:from-brand-700 hover:to-pink-600 shadow-md transition">
                    Kembali ke Beranda
                </a>
                <button type="button" onclick="document.getElementById('successModal').remove()" class="block w-full py-2 rounded-xl text-xs font-semibold text-slate-500 hover:text-slate-800 transition cursor-pointer">
                    Tutup Notifikasi
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- ========================================== -->
    <!-- INTERACTIVE JAVASCRIPT & SLIDER LOGIC      -->
    <!-- ========================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentMode = '{{ $initialMode }}';

            const showcasePanel = document.getElementById('showcasePanel');
            const svgCurveRegister = document.getElementById('svgCurveRegister');
            const svgCurveLogin = document.getElementById('svgCurveLogin');

            const pillRegister = document.getElementById('pillRegister');
            const pillLogin = document.getElementById('pillLogin');

            const cardBadgeRegister = document.getElementById('cardBadgeRegister');
            const cardBadgeLogin = document.getElementById('cardBadgeLogin');

            const headRegister = document.getElementById('headRegister');
            const headLogin = document.getElementById('headLogin');

            const subRegister = document.getElementById('subRegister');
            const subLogin = document.getElementById('subLogin');

            const badgesRegister = document.getElementById('badgesRegister');
            const badgesLogin = document.getElementById('badgesLogin');

            const footerRightRegister = document.getElementById('footerRightRegister');
            const footerRightLogin = document.getElementById('footerRightLogin');

            const loginFormCol = document.getElementById('loginFormCol');
            const registerFormCol = document.getElementById('registerFormCol');

            const btnSwitchToLogin = document.getElementById('btnSwitchToLogin');
            const btnSwitchToRegister = document.getElementById('btnSwitchToRegister');

            // --- ZERO-JUMP CROSSFADE FUNCTION ---
            function setLayerState(elem, active, translate = false) {
                if (!elem) return;
                if (active) {
                    elem.classList.remove('opacity-0', 'pointer-events-none', 'scale-95', 'translate-y-1');
                    elem.classList.add('opacity-100', 'scale-100');
                    if (translate) elem.classList.add('translate-y-0');
                } else {
                    elem.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
                    elem.classList.add('opacity-0', 'pointer-events-none');
                    if (translate) {
                        elem.classList.add('translate-y-1');
                    } else {
                        elem.classList.add('scale-95');
                    }
                }
            }

            // --- FUNCTION TO SWITCH MODES WITH BUTTER-SMOOTH SLIDE ---
            function switchMode(targetMode, pushHistory = true) {
                if (currentMode === targetMode) return;
                currentMode = targetMode;

                const isDesktop = window.innerWidth >= 1024;

                if (targetMode === 'login') {
                    // 1. Desktop Showcase glides to RIGHT side
                    if (isDesktop && showcasePanel) {
                        showcasePanel.style.transform = 'translateX(100%)';
                    }

                    // 2. Crossfade curve extension seamlessly
                    if (svgCurveRegister) {
                        svgCurveRegister.classList.remove('opacity-100');
                        svgCurveRegister.classList.add('opacity-0');
                    }
                    if (svgCurveLogin) {
                        svgCurveLogin.classList.remove('opacity-0');
                        svgCurveLogin.classList.add('opacity-100');
                    }

                    // 3. Crossfade superimposed layers without shifting layout
                    setLayerState(pillRegister, false);
                    setLayerState(pillLogin, true);

                    setLayerState(cardBadgeRegister, false);
                    setLayerState(cardBadgeLogin, true);

                    setLayerState(headRegister, false, true);
                    setLayerState(headLogin, true, true);

                    setLayerState(subRegister, false, true);
                    setLayerState(subLogin, true, true);

                    setLayerState(badgesRegister, false);
                    setLayerState(badgesLogin, true);

                    setLayerState(footerRightRegister, false);
                    setLayerState(footerRightLogin, true);

                    // 4. Mobile layout toggles
                    if (!isDesktop) {
                        if (registerFormCol) {
                            registerFormCol.classList.add('hidden');
                            registerFormCol.classList.remove('flex');
                        }
                        if (loginFormCol) {
                            loginFormCol.classList.remove('hidden');
                            loginFormCol.classList.add('flex');
                        }
                    }

                    // 5. Update browser URL & title
                    document.title = 'Masuk ke Akun Keluarga - NutriGrow | Cegah Stunting';
                    if (pushHistory) {
                        history.pushState({ mode: 'login' }, '', '{{ route("login") }}');
                    }
                } else {
                    // targetMode === 'register'
                    // 1. Desktop Showcase glides to LEFT side
                    if (isDesktop && showcasePanel) {
                        showcasePanel.style.transform = 'translateX(0%)';
                    }

                    // 2. Crossfade curve extension seamlessly
                    if (svgCurveRegister) {
                        svgCurveRegister.classList.remove('opacity-0');
                        svgCurveRegister.classList.add('opacity-100');
                    }
                    if (svgCurveLogin) {
                        svgCurveLogin.classList.remove('opacity-100');
                        svgCurveLogin.classList.add('opacity-0');
                    }

                    // 3. Crossfade superimposed layers without shifting layout
                    setLayerState(pillLogin, false);
                    setLayerState(pillRegister, true);

                    setLayerState(cardBadgeLogin, false);
                    setLayerState(cardBadgeRegister, true);

                    setLayerState(headLogin, false, true);
                    setLayerState(headRegister, true, true);

                    setLayerState(subLogin, false, true);
                    setLayerState(subRegister, true, true);

                    setLayerState(badgesLogin, false);
                    setLayerState(badgesRegister, true);

                    setLayerState(footerRightLogin, false);
                    setLayerState(footerRightRegister, true);

                    // 4. Mobile layout toggles
                    if (!isDesktop) {
                        if (loginFormCol) {
                            loginFormCol.classList.add('hidden');
                            loginFormCol.classList.remove('flex');
                        }
                        if (registerFormCol) {
                            registerFormCol.classList.remove('hidden');
                            registerFormCol.classList.add('flex');
                        }
                    }

                    // 5. Update browser URL & title
                    document.title = 'Pendaftaran Akun Baru - NutriGrow | Bersama Cegah Stunting';
                    if (pushHistory) {
                        history.pushState({ mode: 'register' }, '', '{{ route("register") }}');
                    }
                }
            }

            // Click Handlers for Switching
            if (btnSwitchToLogin) {
                btnSwitchToLogin.addEventListener('click', function (e) {
                    e.preventDefault();
                    switchMode('login');
                });
            }

            if (btnSwitchToRegister) {
                btnSwitchToRegister.addEventListener('click', function (e) {
                    e.preventDefault();
                    switchMode('register');
                });
            }

            // Browser Back / Forward handler (Popstate)
            window.addEventListener('popstate', function (e) {
                if (window.location.pathname.includes('login')) {
                    switchMode('login', false);
                } else if (window.location.pathname.includes('register')) {
                    switchMode('register', false);
                }
            });

            // --- PASSWORD VISIBILITY TOGGLE (LOGIN) ---
            const loginPasswordInput = document.getElementById('login_password');
            const toggleLoginPasswordBtn = document.getElementById('toggleLoginPassword');
            const eyeLoginIcon = document.getElementById('eyeLoginIcon');

            if (toggleLoginPasswordBtn && loginPasswordInput && eyeLoginIcon) {
                toggleLoginPasswordBtn.addEventListener('click', function () {
                    const type = loginPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    loginPasswordInput.setAttribute('type', type);
                    if (type === 'text') {
                        eyeLoginIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
                    } else {
                        eyeLoginIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
                    }
                });
            }

            // --- PASSWORD VISIBILITY TOGGLE (REGISTER) ---
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');
            const strengthText = document.getElementById('strengthText');
            const strBars = [
                document.getElementById('str-bar-1'),
                document.getElementById('str-bar-2'),
                document.getElementById('str-bar-3'),
                document.getElementById('str-bar-4')
            ];
            const matchMsg = document.getElementById('match-msg');
            const emailInput = document.getElementById('email');
            const emailLiveMsg = document.getElementById('email-live-msg');
            const emailIndicator = document.getElementById('email-icon-indicator');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    const eye = document.getElementById('eyeIcon1');
                    if (type === 'text') {
                        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
                    } else {
                        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
                    }
                });
            }

            if (toggleConfirmBtn && confirmInput) {
                toggleConfirmBtn.addEventListener('click', function () {
                    const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmInput.setAttribute('type', type);
                    const eye = document.getElementById('eyeIcon2');
                    if (type === 'text') {
                        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
                    } else {
                        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
                    }
                });
            }

            // Real-time Password Strength Meter
            if (passwordInput && strengthText) {
                passwordInput.addEventListener('input', function () {
                    const val = passwordInput.value;
                    let score = 0;

                    if (val.length >= 8) score++;
                    if (/[A-Z]/.test(val)) score++;
                    if (/[0-9]/.test(val)) score++;
                    if (/[^A-Za-z0-9]/.test(val) || val.length >= 12) score++;

                    strBars.forEach(bar => {
                        if (bar) bar.className = 'h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300';
                    });

                    if (val.length === 0) {
                        strengthText.textContent = '-';
                        strengthText.className = 'font-bold text-slate-400';
                    } else if (score <= 1) {
                        strengthText.textContent = 'Sangat Lemah';
                        strengthText.className = 'font-bold text-rose-500';
                        if (strBars[0]) strBars[0].className = 'h-full w-1/4 bg-rose-500 rounded-full transition-all duration-300';
                    } else if (score === 2) {
                        strengthText.textContent = 'Cukup';
                        strengthText.className = 'font-bold text-amber-500';
                        if (strBars[0]) strBars[0].className = 'h-full w-1/4 bg-amber-500 rounded-full transition-all duration-300';
                        if (strBars[1]) strBars[1].className = 'h-full w-1/4 bg-amber-500 rounded-full transition-all duration-300';
                    } else if (score === 3) {
                        strengthText.textContent = 'Baik';
                        strengthText.className = 'font-bold text-sky-500';
                        if (strBars[0]) strBars[0].className = 'h-full w-1/4 bg-sky-500 rounded-full transition-all duration-300';
                        if (strBars[1]) strBars[1].className = 'h-full w-1/4 bg-sky-500 rounded-full transition-all duration-300';
                        if (strBars[2]) strBars[2].className = 'h-full w-1/4 bg-sky-500 rounded-full transition-all duration-300';
                    } else {
                        strengthText.textContent = 'Sangat Kuat';
                        strengthText.className = 'font-bold text-emerald-600';
                        if (strBars[0]) strBars[0].className = 'h-full w-1/4 bg-emerald-500 rounded-full transition-all duration-300';
                        if (strBars[1]) strBars[1].className = 'h-full w-1/4 bg-emerald-500 rounded-full transition-all duration-300';
                        if (strBars[2]) strBars[2].className = 'h-full w-1/4 bg-emerald-500 rounded-full transition-all duration-300';
                        if (strBars[3]) strBars[3].className = 'h-full w-1/4 bg-emerald-500 rounded-full transition-all duration-300';
                    }

                    validateMatch();
                });
            }

            function validateMatch() {
                if (!passwordInput || !confirmInput || !matchMsg) return;
                const p1 = passwordInput.value;
                const p2 = confirmInput.value;

                if (!p2) {
                    matchMsg.classList.add('hidden');
                    return;
                }

                matchMsg.classList.remove('hidden');
                if (p1 === p2) {
                    matchMsg.textContent = 'Kata sandi cocok ✓';
                    matchMsg.className = 'mt-0.5 text-[11px] font-semibold text-emerald-600';
                } else {
                    matchMsg.textContent = 'Kata sandi belum sama ✗';
                    matchMsg.className = 'mt-0.5 text-[11px] font-semibold text-rose-500';
                }
            }
            if (confirmInput) confirmInput.addEventListener('input', validateMatch);

            // AJAX Check Email
            let checkEmailTimeout = null;
            function checkEmailDuplicate(emailValue) {
                if (!emailLiveMsg || !emailIndicator) return;
                if (!emailValue || !emailValue.includes('@')) {
                    emailLiveMsg.classList.add('hidden');
                    emailIndicator.classList.add('hidden');
                    return;
                }

                emailLiveMsg.classList.remove('hidden');
                emailLiveMsg.textContent = 'Memeriksa ketersediaan email...';
                emailLiveMsg.className = 'mt-0.5 text-[11px] font-medium text-slate-400';

                fetch('{{ route("api.check-email") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: emailValue })
                })
                .then(response => response.json())
                .then(data => {
                    emailLiveMsg.classList.remove('hidden');
                    if (data.available) {
                        emailLiveMsg.textContent = 'Email tersedia ✓';
                        emailLiveMsg.className = 'mt-0.5 text-[11px] font-semibold text-emerald-600';
                        emailIndicator.classList.remove('hidden');
                    } else {
                        emailLiveMsg.textContent = 'Email ini sudah terdaftar! Gunakan email lain.';
                        emailLiveMsg.className = 'mt-0.5 text-[11px] font-semibold text-rose-600';
                        emailIndicator.classList.add('hidden');
                    }
                })
                .catch(err => {
                    emailLiveMsg.classList.add('hidden');
                    emailIndicator.classList.add('hidden');
                });
            }

            if (emailInput) {
                emailInput.addEventListener('input', function () {
                    clearTimeout(checkEmailTimeout);
                    checkEmailTimeout = setTimeout(() => {
                        checkEmailDuplicate(emailInput.value.trim());
                    }, 400);
                });
            }
        });
    </script>
</body>
</html>
