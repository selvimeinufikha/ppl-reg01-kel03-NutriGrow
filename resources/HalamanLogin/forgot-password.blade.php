<!DOCTYPE html>
@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - NutriGrow | Pemulihan Akses Akun</title>

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
        <!-- LEFT COLUMN: BRANDING & ASSISTANCE SHOWCASE-->
        <!-- ========================================== -->
        <div class="w-full lg:w-[48%] xl:w-[47%] bg-transparent px-6 sm:px-8 lg:px-10 xl:px-12 py-4 sm:py-5 lg:py-6 flex flex-col justify-between relative overflow-visible flex-shrink-0 z-10 lg:h-full">

            <!-- 1. LATAR BELAKANG VEKTOR MELENGKUNG: 100% BEBAS DARI GARIS LURUS -->
            <div class="hidden lg:block absolute inset-y-0 left-0 right-[-50px] xl:right-[-65px] pointer-events-none z-0">
                <svg class="w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="leftBgGradForgot" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#fff1f2" />
                            <stop offset="35%" stop-color="#fdf2f4" />
                            <stop offset="70%" stop-color="#fae8ed" />
                            <stop offset="100%" stop-color="#f5f3ff" stop-opacity="0.95" />
                        </linearGradient>
                        <radialGradient id="topGlowForgot" cx="20%" cy="15%" r="55%">
                            <stop offset="0%" stop-color="#fb7185" stop-opacity="0.18" />
                            <stop offset="100%" stop-color="#fb7185" stop-opacity="0" />
                        </radialGradient>
                        <radialGradient id="botGlowForgot" cx="75%" cy="80%" r="50%">
                            <stop offset="0%" stop-color="#c084fc" stop-opacity="0.15" />
                            <stop offset="100%" stop-color="#c084fc" stop-opacity="0" />
                        </radialGradient>
                    </defs>
                    <path d="M 0,0 L 910,0 C 970,300 1000,550 900,1000 L 0,1000 Z" fill="url(#leftBgGradForgot)" />
                    <path d="M 0,0 L 910,0 C 970,300 1000,550 900,1000 L 0,1000 Z" fill="url(#topGlowForgot)" />
                    <path d="M 0,0 L 910,0 C 970,300 1000,550 900,1000 L 0,1000 Z" fill="url(#botGlowForgot)" />
                </svg>
            </div>

            <!-- 2. LATAR BELAKANG MOBILE -->
            <div class="lg:hidden absolute inset-0 bg-gradient-to-b from-pink-50 via-rose-50/50 to-purple-50/30 rounded-b-[32px] pointer-events-none z-0"></div>

            <!-- Top Row: Logo with Subtitle & Back Link -->
            <div class="relative z-10 flex items-center justify-between mb-3 sm:mb-4">
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain transition transform group-hover:scale-102">
                    </a>
                    <span class="hidden sm:inline-block text-[11px] text-slate-400 font-medium pl-2 border-l border-slate-200">
                        Maternal & Child Health Care
                    </span>
                </div>

                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 hover:bg-white border border-slate-200/90 text-[11px] sm:text-xs font-semibold text-slate-600 hover:text-brand-600 shadow-2xs hover:shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Masuk</span>
                </a>
            </div>

            <!-- Center Content: Visual Illustration & Copy -->
            <div class="relative z-10 w-full max-w-[390px] xl:max-w-[420px] mx-auto text-center my-auto py-1 sm:py-2">

                <!-- Badge: Bantuan Akses Akun Keluarga -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-100/90 border border-pink-200/90 text-brand-600 text-[11px] sm:text-xs font-bold mb-3 sm:mb-3.5 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    <span>Bantuan Akses Akun Keluarga</span>
                </div>

                <!-- Illustration Card with Floating Badges -->
                <div class="relative mx-auto w-full max-w-[340px] sm:max-w-[370px] bg-white rounded-[26px] sm:rounded-[28px] p-4 sm:p-5 shadow-xl shadow-pink-500/10 border border-white mb-4 sm:mb-5">

                    <!-- Floating Badge Top Left: Keamanan Data Terlindungi -->
                    <div class="absolute -top-3.5 -left-2 sm:-left-3 bg-white/95 backdrop-blur-md rounded-2xl px-3 py-1.5 sm:px-3.5 sm:py-2 border border-slate-100 shadow-md shadow-slate-200/70 flex items-center gap-2 z-20">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">Keamanan Data Terlindungi</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium leading-tight">Enkripsi Standar Medis</div>
                        </div>
                    </div>

                    <!-- Mother on Smartphone Illustration -->
                    <div class="relative w-full h-44 sm:h-48 lg:h-52 rounded-2xl overflow-hidden bg-gradient-to-b from-rose-50/50 via-pink-50/30 to-slate-50 flex items-center justify-center">
                        <img
                            src="{{ asset('images/forgot-password-hero.png') }}"
                            alt="Pemulihan Akses NutriGrow"
                            class="w-full h-full object-cover object-center"
                            onerror="this.onerror=null; this.src='{{ asset('images/register-mother-child.jpg') }}';"
                        />
                    </div>

                    <!-- Floating Badge Bottom Right: Verifikasi Email Resmi -->
                    <div class="absolute -bottom-3.5 -right-2 sm:-right-3 bg-white/95 backdrop-blur-md rounded-2xl px-3 py-1.5 sm:px-3.5 sm:py-2 border border-slate-100 shadow-md shadow-pink-500/10 flex items-center gap-2 z-20">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-pink-50 text-brand-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">Verifikasi Email Resmi</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium leading-tight">Tautan Aman Langsung</div>
                        </div>
                    </div>
                </div>

                <!-- Big Headline -->
                <h2 class="text-xl sm:text-2xl lg:text-[25px] font-extrabold text-slate-900 tracking-tight leading-snug mb-1.5 sm:mb-2">
                    Kemudahan Akses Kembali<br>
                    <span class="bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 bg-clip-text text-transparent">
                        untuk Kesehatan Si Kecil
                    </span>
                </h2>

                <!-- Subtitle -->
                <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed max-w-sm mx-auto mb-3 sm:mb-4">
                    Jangan khawatir jika lupa kata sandi. Masukkan email Anda dan ikuti langkah mudah untuk memulihkan akses buku catatan kesehatan keluarga.
                </p>

                <!-- 3 Feature Badges -->
                <div class="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs font-semibold text-slate-700">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>Proses Cepat &lt; 2 Menit</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Enkripsi Tautan</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 border border-slate-200/80 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Layanan 24/7</span>
                    </span>
                </div>

            </div>

            <!-- Bottom Left Footer -->
            <div class="relative z-10 pt-3 border-t border-pink-100/60 flex flex-col sm:flex-row items-center justify-between gap-1 text-[11px] text-slate-400 font-medium">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Data terenkripsi & privasi keluarga terjamin</span>
                </div>
                <div>
                    &copy; 2025 NutriGrow Indonesia
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN: FORGOT PASSWORD FORM         -->
        <!-- ========================================== -->
        <div class="w-full lg:w-[52%] xl:w-[53%] bg-white px-6 sm:px-8 lg:px-10 xl:px-14 py-6 sm:py-8 lg:py-8 flex flex-col justify-center items-center relative lg:h-full lg:overflow-y-auto no-scrollbar">

            <div class="w-full max-w-[390px] sm:max-w-[420px] mx-auto my-auto py-1">

                <!-- Pill Badge: Pemulihan Kata Sandi -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200/80 text-brand-600 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    <span>PEMULIHAN KATA SANDI</span>
                </div>

                <!-- Heading & Subtitle -->
                <h1 class="text-2xl sm:text-[28px] font-extrabold text-slate-900 tracking-tight mb-1">
                    Lupa Password?
                </h1>
                <p class="text-xs sm:text-[13px] text-slate-500 mb-4 leading-relaxed">
                    Masukkan email yang terdaftar. Kami akan membantu Anda mengatur ulang kata sandi.
                </p>

                <!-- Alert Message: Error jika email tidak ditemukan -->
                @if ($errors->has('email'))
                    <div class="mb-3.5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <span class="font-medium">{{ $errors->first('email') }}</span>
                    </div>
                @endif

                <!-- FORGOT PASSWORD FORM -->
                <form action="{{ route('password.email') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <!-- Field: Email Akun NutriGrow -->
                    <div>
                        <div class="flex items-center justify-between mb-0.5">
                            <label for="email" class="text-xs font-bold text-slate-700">
                                Email Akun NutriGrow <span class="text-brand-600">*</span>
                            </label>
                            <span class="text-[11px] text-slate-400 font-medium">Sesuai pendaftaran</span>
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
                                autofocus
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                class="w-full pl-10 pr-3.5 py-2.5 sm:py-3 rounded-xl bg-slate-50/70 border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-3 focus:ring-brand-500/10 transition"
                            />
                        </div>
                    </div>

                    <!-- Submit Button: Kirim Tautan Reset -->
                    <div class="pt-1">
                        <button
                            type="submit"
                            class="w-full py-2.5 sm:py-3 px-5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 hover:from-brand-700 hover:to-pink-600 shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-pink-500/30 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span>Kirim Tautan Reset</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Secondary Button: Kembali ke Masuk -->
                    <div class="pt-0.5">
                        <a
                            href="{{ route('login') }}"
                            class="w-full py-2 sm:py-2.5 px-4 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-all flex items-center justify-center gap-2"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Kembali ke Masuk</span>
                        </a>
                    </div>
                </form>

                <!-- Prototype Note -->
                <div class="mt-4 pt-1 flex items-start gap-2 text-[10px] text-slate-400 leading-relaxed text-left border-t border-slate-100/80">
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>
                        <strong class="font-semibold text-slate-500">Catatan Prototipe:</strong> Sistem dirancang untuk mengirimkan tautan reset kata sandi ke email terdaftar secara aman tanpa pengiriman email nyata.
                    </span>
                </div>

            </div>

        </div>

    </div>

    <!-- ========================================== -->
    <!-- INTERACTIVE RESET MODAL (Local Simulator)   -->
    <!-- ========================================== -->
    @if (session('reset_modal'))
    <div id="resetModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-[28px] p-6 sm:p-7 max-w-sm w-full text-center shadow-2xl border border-slate-100 animate-fadeIn">
            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h3 class="text-lg font-extrabold text-slate-900 mb-1">Tautan Reset Dihasilkan!</h3>
            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                Token reset kata sandi telah tersimpan aman di database NutriGrow. Silakan lanjutkan untuk mengatur kata sandi baru Anda.
            </p>

            <div class="bg-slate-50 rounded-2xl p-3.5 text-left text-xs mb-4 space-y-1.5 border border-slate-100">
                <div class="flex justify-between">
                    <span class="text-slate-400">Nama:</span>
                    <strong class="text-slate-800">{{ session('reset_modal')['name'] }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Email:</span>
                    <strong class="text-slate-800">{{ session('reset_modal')['email'] }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Dibuat:</span>
                    <span class="text-slate-600">{{ session('reset_modal')['created_at'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Status DB:</span>
                    <span class="inline-flex items-center gap-1 text-emerald-600 font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Token Tersimpan di SQLite
                    </span>
                </div>
            </div>

            <div class="space-y-2">
                <a href="{{ session('reset_modal')['reset_url'] }}" class="block w-full py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 hover:from-brand-700 hover:to-pink-600 shadow-md transition">
                    Atur Ulang Sandi Baru Sekarang &rarr;
                </a>
                <button type="button" onclick="document.getElementById('resetModal').remove()" class="block w-full py-2 rounded-xl text-xs font-semibold text-slate-500 hover:text-slate-800 transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

</body>
</html>
