<!DOCTYPE html>
@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
    $isInvalid = $isInvalid ?? false;
    $token = $token ?? 'simulator';
    $email = $email ?? 'ibu.anita@nutrigrow.id';
@endphp
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Password Baru - NutriGrow | Perlindungan Akun Keluarga</title>

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
    </style>
</head>
<body class="min-h-screen lg:h-screen bg-white font-sans antialiased text-slate-800 flex flex-col justify-between selection:bg-brand-500 selection:text-white lg:overflow-hidden">

    <!-- MAIN CONTAINER: SPLIT SCREEN -->
    <div class="min-h-screen lg:h-full flex flex-col lg:flex-row w-full bg-white relative overflow-x-hidden lg:overflow-hidden select-none">

        <!-- ========================================== -->
        <!-- LEFT COLUMN: FORM BUAT PASSWORD BARU       -->
        <!-- ========================================== -->
        <div class="w-full lg:w-[48%] xl:w-[47%] bg-white px-6 sm:px-8 lg:px-12 xl:px-16 py-4 sm:py-5 lg:py-6 flex flex-col justify-between relative z-10 lg:h-full lg:overflow-y-auto no-scrollbar">

            <!-- Top Row: Logo with Subtitle & Back Link -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain transition transform group-hover:scale-102">
                        </a>
                        <div class="text-[10px] sm:text-[11px] text-slate-400 font-medium mt-0.5">
                            Maternal &amp; Child Health Care
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 hover:bg-white border border-slate-200/90 text-[11px] sm:text-xs font-semibold text-slate-600 hover:text-brand-600 shadow-2xs hover:shadow-xs transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Masuk</span>
                    </a>
                </div>
            </div>

            <!-- Center Content: Reset Password Form -->
            <div class="w-full max-w-[390px] sm:max-w-[420px] mx-auto my-auto py-2">

                <!-- Badge: PEMBARUAN KATA SANDI -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200/80 text-brand-600 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>PEMBARUAN KATA SANDI</span>
                </div>

                <!-- Headline & Subtitle -->
                <h1 class="text-2xl sm:text-[28px] font-extrabold text-slate-900 tracking-tight mb-1">
                    Buat Password Baru
                </h1>
                <p class="text-xs sm:text-[13px] text-slate-500 mb-4 leading-relaxed">
                    Gunakan kata sandi baru untuk mengamankan akun NutriGrow Anda. Pastikan kata sandi baru tidak sama dengan yang pernah digunakan sebelumnya.
                </p>

                <!-- Invalid Link Banner (Shown conditionally or via simulator) -->
                <div id="invalidLinkBanner" class="{{ $isInvalid ? 'block' : 'hidden' }} mb-3.5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <div>
                            <div class="font-bold mb-0.5">Tautan Reset Tidak Valid atau Kedaluwarsa</div>
                            <p class="text-[11px] text-rose-700 leading-relaxed mb-2">
                                Tautan reset kata sandi ini tidak dapat digunakan lagi. Silakan ajukan permohonan baru.
                            </p>
                            <a href="{{ route('password.request') }}" class="inline-flex items-center gap-1 font-bold text-brand-700 hover:text-brand-800 underline">
                                <span>Kirim Ulang Tautan Reset Baru</span> &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Error Messages dari Backend -->
                @if ($errors->any())
                    <div class="mb-3.5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <div class="font-medium space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Form Reset Password -->
                <form action="{{ route('password.update') }}" method="POST" id="formResetPassword" class="space-y-3.5">
                    @csrf
                    <input type="hidden" name="token" id="inputToken" value="{{ $token }}">
                    <input type="hidden" name="email" id="inputEmail" value="{{ $email }}">

                    <!-- Field: Password Baru -->
                    <div>
                        <div class="flex items-center justify-between mb-0.5">
                            <label for="password" class="text-xs font-bold text-slate-700">
                                Password Baru <span class="text-brand-600">*</span>
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
                                autofocus
                                placeholder="Buat sandi baru yang kuat..."
                                class="w-full pl-10 pr-10 py-2.5 sm:py-3 rounded-xl bg-slate-50/70 border @error('password') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                            />
                            <button
                                type="button"
                                onclick="toggleVisibility('password', 'eyeIconPassword')"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer"
                                title="Lihat/Sembunyikan Kata Sandi"
                            >
                                <svg id="eyeIconPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Strength Row: Label & 3-Segment Progress Bar -->
                        <div class="mt-1.5">
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="text-slate-500 font-medium">Kekuatan Kata Sandi:</span>
                                <span id="labelKekuatan" class="font-semibold text-slate-400 transition-colors">Belum diisi</span>
                            </div>
                            <div class="flex gap-1 h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div id="barSegment1" class="h-full w-1/3 bg-slate-200 transition-colors duration-300"></div>
                                <div id="barSegment2" class="h-full w-1/3 bg-slate-200 transition-colors duration-300"></div>
                                <div id="barSegment3" class="h-full w-1/3 bg-slate-200 transition-colors duration-300"></div>
                            </div>
                        </div>

                        <!-- Criteria Chips: Min. 8 Karakter & Huruf & Angka -->
                        <div class="mt-2 flex items-center gap-4 text-[11px] text-slate-500 font-medium">
                            <div id="ruleLength" class="flex items-center gap-1.5 transition-colors">
                                <span id="ruleLengthIcon" class="w-3.5 h-3.5 rounded-full border border-slate-300 flex items-center justify-center text-[9px] text-slate-400">○</span>
                                <span>Min. 8 karakter</span>
                            </div>
                            <div id="ruleAlphaNum" class="flex items-center gap-1.5 transition-colors">
                                <span id="ruleAlphaNumIcon" class="w-3.5 h-3.5 rounded-full border border-slate-300 flex items-center justify-center text-[9px] text-slate-400">○</span>
                                <span>Huruf &amp; angka</span>
                            </div>
                        </div>
                    </div>

                    <!-- Field: Konfirmasi Password Baru -->
                    <div>
                        <div class="flex items-center justify-between mb-0.5">
                            <label for="password_confirmation" class="text-xs font-bold text-slate-700">
                                Konfirmasi Password Baru <span class="text-brand-600">*</span>
                            </label>
                            <span id="labelMatch" class="text-[11px] text-slate-400 font-medium transition-colors">Harus sama persis</span>
                        </div>
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
                                placeholder="Ulangi kata sandi baru..."
                                class="w-full pl-10 pr-10 py-2.5 sm:py-3 rounded-xl bg-slate-50/70 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                            />
                            <button
                                type="button"
                                onclick="toggleVisibility('password_confirmation', 'eyeIconConfirm')"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer"
                                title="Lihat/Sembunyikan Kata Sandi"
                            >
                                <svg id="eyeIconConfirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button: Simpan Password Baru -->
                    <div class="pt-1">
                        <button
                            type="submit"
                            id="btnSubmitReset"
                            class="w-full py-2.5 sm:py-3 px-5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 hover:from-brand-700 hover:to-pink-600 shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-pink-500/30 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span>Simpan Password Baru</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Secondary Link: Batalkan & Kembali ke Masuk -->
                    <div class="pt-0.5 text-center">
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Batalkan &amp; Kembali ke Masuk</span>
                        </a>
                    </div>
                </form>

            </div>

            <!-- Bottom Left Footer -->
            <div class="relative z-10 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[10px] text-slate-400 font-medium">
                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Sistem dirancang dengan hashing kata sandi aman &amp; perlindungan data keluarga.</span>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN: BRANDING & SECURITY SHOWCASE -->
        <!-- ========================================== -->
        <div class="w-full lg:w-[52%] xl:w-[53%] bg-transparent px-6 sm:px-8 lg:px-10 xl:px-12 py-4 sm:py-5 lg:py-6 flex flex-col justify-between relative overflow-visible flex-shrink-0 z-10 lg:h-full">

            <!-- 1. LATAR BELAKANG VEKTOR MELENGKUNG: 100% BEBAS DARI GARIS LURUS (Menghadap Kiri) -->
            <div class="hidden lg:block absolute inset-y-0 left-[-50px] xl:left-[-65px] right-0 pointer-events-none z-0">
                <svg class="w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="bgGradResetRight" x1="100%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#fff1f2" />
                            <stop offset="35%" stop-color="#fdf2f4" />
                            <stop offset="70%" stop-color="#fae8ed" />
                            <stop offset="100%" stop-color="#f5f3ff" stop-opacity="0.95" />
                        </linearGradient>
                        <radialGradient id="topGlowResetRight" cx="80%" cy="15%" r="55%">
                            <stop offset="0%" stop-color="#fb7185" stop-opacity="0.18" />
                            <stop offset="100%" stop-color="#fb7185" stop-opacity="0" />
                        </radialGradient>
                        <radialGradient id="botGlowResetRight" cx="25%" cy="80%" r="50%">
                            <stop offset="0%" stop-color="#c084fc" stop-opacity="0.15" />
                            <stop offset="100%" stop-color="#c084fc" stop-opacity="0" />
                        </radialGradient>
                    </defs>
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#bgGradResetRight)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#topGlowResetRight)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#botGlowResetRight)" />
                </svg>
            </div>

            <!-- 2. LATAR BELAKANG MOBILE -->
            <div class="lg:hidden absolute inset-0 bg-gradient-to-b from-pink-50 via-rose-50/50 to-purple-50/30 rounded-t-[32px] pointer-events-none z-0"></div>

            <!-- Top Row: Pill Badge "Keamanan Rekam Medis Anak" -->
            <div class="relative z-10 flex items-center justify-end mb-2 sm:mb-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-100/90 border border-pink-200/90 text-brand-600 text-[11px] sm:text-xs font-bold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    <span>Keamanan Rekam Medis Anak</span>
                </div>
            </div>

            <!-- Center Content: Visual Illustration & Copy -->
            <div class="relative z-10 w-full max-w-[390px] xl:max-w-[420px] mx-auto text-center my-auto py-1 sm:py-2">

                <!-- Illustration Card with Floating Badges -->
                <div class="relative mx-auto w-full max-w-[340px] sm:max-w-[370px] bg-white rounded-[26px] sm:rounded-[28px] p-4 sm:p-5 shadow-xl shadow-pink-500/10 border border-white mb-4 sm:mb-5">

                    <!-- Floating Badge Top Left: Standar Keamanan Medis -->
                    <div class="absolute -top-3.5 -left-2 sm:-left-3 bg-white/95 backdrop-blur-md rounded-2xl px-3 py-1.5 sm:px-3.5 sm:py-2 border border-slate-100 shadow-md shadow-slate-200/70 flex items-center gap-2 z-20">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">Standar Keamanan Medis</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium leading-tight">Perlindungan Akun Ibu &amp; Bayi</div>
                        </div>
                    </div>

                    <!-- Mother & Child Illustration -->
                    <div class="relative w-full h-44 sm:h-48 lg:h-52 rounded-2xl overflow-hidden bg-gradient-to-b from-rose-50/50 via-pink-50/30 to-slate-50 flex items-center justify-center">
                        <img
                            src="{{ asset('images/register-mother-child.jpg') }}"
                            alt="NutriGrow Perlindungan Akun"
                            class="w-full h-full object-cover object-center"
                            onerror="this.onerror=null; this.src='{{ asset('images/forgot-password-hero.png') }}';"
                        />
                    </div>

                    <!-- Floating Badge Bottom Right: Kredensial Aman Terenkripsi -->
                    <div class="absolute -bottom-3.5 -right-2 sm:-right-3 bg-white/95 backdrop-blur-md rounded-2xl px-3 py-1.5 sm:px-3.5 sm:py-2 border border-slate-100 shadow-md shadow-pink-500/10 flex items-center gap-2 z-20">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-pink-50 text-brand-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">Kredensial Aman Terenkripsi</div>
                            <div class="text-[9px] sm:text-[10px] text-brand-600 font-semibold leading-tight">Aktif &bull; 2025</div>
                        </div>
                    </div>
                </div>

                <!-- Headline -->
                <h2 class="text-xl sm:text-2xl lg:text-[25px] font-extrabold text-slate-900 tracking-tight leading-snug mb-1.5 sm:mb-2">
                    Keamanan Akun untuk<br>
                    <span class="bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 bg-clip-text text-transparent">
                        Perlindungan Data Buah Hati
                    </span>
                </h2>

                <!-- Subtitle / Copy -->
                <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed max-w-sm mx-auto mb-3 sm:mb-4">
                    Memperbarui kata sandi secara berkala menjaga kerahasiaan rekam medis tumbuh kembang anak, pemantauan kurva WHO, serta rencana gizi keluarga tetap aman terlindungi.
                </p>

                <!-- 3 Feature Badges -->
                <div class="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs font-semibold text-slate-700">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <span>Enkripsi 256-bit</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Akses Terverifikasi</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Dukungan 24 Jam</span>
                    </span>
                </div>

            </div>

            <!-- Bottom Right Footer -->
            <div class="relative z-10 pt-3 border-t border-pink-100/60 flex items-center justify-between text-[11px] text-slate-400 font-medium">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>&copy; 2025 NutriGrow Indonesia &bull; Hak Cipta Dilindungi</span>
                </div>
                <div>
                    &bull; ISO 27001 Ready
                </div>
            </div>

        </div>

    </div>

    <!-- JAVASCRIPT: STRENGTH CHECKER, VISIBILITY TOGGLE, & SIMULATOR -->
    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.057 10.057 0 012.183-3.642m3.585-2.883A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.122-2.122L3 3m7.5 7.5a3 3 0 004.242 4.242"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        const passInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const bar1 = document.getElementById('barSegment1');
        const bar2 = document.getElementById('barSegment2');
        const bar3 = document.getElementById('barSegment3');
        const labelKekuatan = document.getElementById('labelKekuatan');
        const ruleLength = document.getElementById('ruleLength');
        const ruleLengthIcon = document.getElementById('ruleLengthIcon');
        const ruleAlphaNum = document.getElementById('ruleAlphaNum');
        const ruleAlphaNumIcon = document.getElementById('ruleAlphaNumIcon');
        const labelMatch = document.getElementById('labelMatch');

        function evaluatePassword() {
            if (!passInput) return;
            const val = passInput.value;

            const hasMin8 = val.length >= 8;
            const hasLetters = /[a-zA-Z]/.test(val);
            const hasNumbers = /[0-9]/.test(val);
            const hasSpecial = /[^a-zA-Z0-9]/.test(val);
            const hasAlphaNum = hasLetters && (hasNumbers || hasSpecial);

            // Update rule chips
            if (hasMin8) {
                ruleLength.className = 'flex items-center gap-1.5 text-emerald-600 font-semibold';
                ruleLengthIcon.textContent = '✓';
                ruleLengthIcon.className = 'w-3.5 h-3.5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold';
            } else {
                ruleLength.className = 'flex items-center gap-1.5 text-slate-500 font-medium';
                ruleLengthIcon.textContent = '○';
                ruleLengthIcon.className = 'w-3.5 h-3.5 rounded-full border border-slate-300 flex items-center justify-center text-[9px] text-slate-400';
            }

            if (hasAlphaNum) {
                ruleAlphaNum.className = 'flex items-center gap-1.5 text-emerald-600 font-semibold';
                ruleAlphaNumIcon.textContent = '✓';
                ruleAlphaNumIcon.className = 'w-3.5 h-3.5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold';
            } else {
                ruleAlphaNum.className = 'flex items-center gap-1.5 text-slate-500 font-medium';
                ruleAlphaNumIcon.textContent = '○';
                ruleAlphaNumIcon.className = 'w-3.5 h-3.5 rounded-full border border-slate-300 flex items-center justify-center text-[9px] text-slate-400';
            }

            // Strength calculation
            let score = 0;
            if (val.length > 0) score = 1;
            if (hasMin8 && (hasLetters || hasNumbers)) score = 2;
            if (hasMin8 && hasAlphaNum && (val.length >= 10 || hasSpecial)) score = 3;

            if (val.length === 0) {
                labelKekuatan.textContent = 'Belum diisi';
                labelKekuatan.className = 'font-semibold text-slate-400';
                bar1.className = 'h-full w-1/3 bg-slate-200 transition-colors duration-300';
                bar2.className = 'h-full w-1/3 bg-slate-200 transition-colors duration-300';
                bar3.className = 'h-full w-1/3 bg-slate-200 transition-colors duration-300';
            } else if (score === 1) {
                labelKekuatan.textContent = 'Lemah';
                labelKekuatan.className = 'font-semibold text-amber-500';
                bar1.className = 'h-full w-1/3 bg-amber-400 transition-colors duration-300';
                bar2.className = 'h-full w-1/3 bg-slate-200 transition-colors duration-300';
                bar3.className = 'h-full w-1/3 bg-slate-200 transition-colors duration-300';
            } else if (score === 2) {
                labelKekuatan.textContent = 'Sedang';
                labelKekuatan.className = 'font-semibold text-amber-600';
                bar1.className = 'h-full w-1/3 bg-amber-400 transition-colors duration-300';
                bar2.className = 'h-full w-1/3 bg-amber-400 transition-colors duration-300';
                bar3.className = 'h-full w-1/3 bg-slate-200 transition-colors duration-300';
            } else {
                labelKekuatan.textContent = 'Sangat Kuat ✓';
                labelKekuatan.className = 'font-semibold text-emerald-600';
                bar1.className = 'h-full w-1/3 bg-emerald-500 transition-colors duration-300';
                bar2.className = 'h-full w-1/3 bg-emerald-500 transition-colors duration-300';
                bar3.className = 'h-full w-1/3 bg-emerald-500 transition-colors duration-300';
            }

            evaluateMatch();
        }

        function evaluateMatch() {
            if (!confirmInput || !passInput) return;
            const p1 = passInput.value;
            const p2 = confirmInput.value;

            if (p2.length === 0) {
                labelMatch.textContent = 'Harus sama persis';
                labelMatch.className = 'text-[11px] text-slate-400 font-medium';
            } else if (p1 === p2) {
                labelMatch.textContent = 'Cocok ✓';
                labelMatch.className = 'text-[11px] text-emerald-600 font-bold';
            } else {
                labelMatch.textContent = 'Belum sama ✕';
                labelMatch.className = 'text-[11px] text-rose-500 font-bold';
            }
        }

        if (passInput) passInput.addEventListener('input', evaluatePassword);
        if (confirmInput) confirmInput.addEventListener('input', evaluateMatch);
    </script>

</body>
</html>
