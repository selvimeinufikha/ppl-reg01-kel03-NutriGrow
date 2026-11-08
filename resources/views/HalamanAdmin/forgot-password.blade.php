<!DOCTYPE html>
@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password Admin & Nakes - NutriGrow | Pemulihan Akses Faskes</title>

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
                        medical: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
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
        .ambient-glow-mobile {
            background: radial-gradient(circle at 10% 15%, rgba(186, 230, 253, 0.45) 0%, transparent 45%),
                        radial-gradient(circle at 85% 75%, rgba(254, 205, 211, 0.35) 0%, transparent 40%),
                        linear-gradient(180deg, #f0f9ff 0%, #ffffff 50%, #f8fafc 100%);
        }
    </style>
</head>
<body class="min-h-screen lg:h-screen bg-white font-sans antialiased text-slate-800 flex flex-col justify-between selection:bg-sky-500 selection:text-white lg:overflow-hidden">

    <!-- =================================================================== -->
    <!-- MAIN CONTAINER: SPLIT SCREEN (LEFT: FORGOT FORM, RIGHT: HERO CURVE) -->
    <!-- =================================================================== -->
    <div class="min-h-screen lg:h-full w-full flex flex-col lg:flex-row bg-white relative overflow-x-hidden lg:overflow-hidden select-none">

        <!-- =============================================================== -->
        <!-- 1. LEFT COLUMN: FORGOT PASSWORD FORM CARD                      -->
        <!-- =============================================================== -->
        <div class="w-full lg:w-1/2 min-h-screen lg:min-h-0 lg:h-full bg-white px-6 sm:px-8 lg:px-10 xl:px-14 py-5 sm:py-6 lg:py-8 flex flex-col justify-between items-center relative z-10 overflow-y-auto no-scrollbar">

            <!-- Top Row: Logo & Tenaga Kesehatan + Pill Badge -->
            <div class="w-full flex items-center justify-between sm:justify-start gap-3.5 sm:gap-4 relative z-10 mb-4 sm:mb-6">
                <!-- Brand NutriGrow with Tenaga Kesehatan Subtitle -->
                <a href="{{ route('admin.login') }}" class="group block shrink-0">
                    <img
                        src="{{ asset('images/nutrigrow-logo.png') }}"
                        alt="NutriGrow Logo"
                        class="h-7 sm:h-8 w-auto object-contain transition-transform group-hover:scale-105"
                        onerror="this.onerror=null; this.src='{{ asset('images/nutrigrow-icon.png') }}';"
                    />
                    <span class="block text-[9.5px] sm:text-[10px] font-black uppercase tracking-wider text-[#0284c7] mt-0.5">
                        TENAGA KESEHATAN
                    </span>
                </a>

                <!-- Pill Badge: Portal Khusus Faskes & Nakes -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-50/90 border border-slate-200/90 shadow-2xs shrink-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-700 tracking-tight whitespace-nowrap">
                        Portal Khusus Faskes &amp; Nakes
                    </span>
                </div>
            </div>

            <!-- Center Content: The Forgot Password Form -->
            <div class="w-full max-w-[420px] mx-auto my-auto py-2">

                <!-- Pill Badge: RESET PASSWORD -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200/80 text-sky-700 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-2.5">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    <span>RESET PASSWORD</span>
                </div>

                <!-- Form Heading & Subtitle -->
                <div class="mb-5 sm:mb-6">
                    <h1 class="text-2xl sm:text-[32px] font-extrabold text-slate-900 tracking-tight leading-tight">
                        Lupa Password?
                    </h1>
                    <p class="text-xs sm:text-[13px] text-slate-500 mt-1.5 leading-relaxed">
                        Masukkan email akun admin Anda untuk menerima instruksi reset password.
                    </p>
                </div>

                <!-- Alert Messages: Success Sending Link -->
                @if (session('status'))
                    <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex flex-col gap-2">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="leading-relaxed font-medium">{{ session('status') }}</span>
                        </div>
                        @if (session('demo_reset_link'))
                            <div class="mt-1 pt-2 border-t border-emerald-200/70 flex items-center justify-between text-[11px]">
                                <span class="font-bold text-emerald-900">Simulasi Demo Praktikum:</span>
                                <a href="{{ session('demo_reset_link') }}" class="font-bold text-emerald-700 hover:text-emerald-900 underline">
                                    Buka Halaman Buat Sandi Baru &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Validation Error Alert -->
                @if ($errors->has('email'))
                    <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold">Gagal Mengirim</p>
                            <p class="mt-0.5">{{ $errors->first('email') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Form Body -->
                <form action="{{ route('admin.password.email') }}" method="POST" id="adminForgotForm" class="space-y-4">
                    @csrf

                    <!-- Field: EMAIL PETUGAS / ADMIN -->
                    <div>
                        <label for="admin_email" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            EMAIL PETUGAS / ADMIN <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative rounded-2xl shadow-2xs">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-semibold text-sm">
                                @
                            </div>
                            <input
                                type="email"
                                name="email"
                                id="admin_email"
                                value="{{ old('email', 'admin@nutrigrow.id') }}"
                                required
                                autofocus
                                placeholder="nama@nutrigrow.id / puskesmas.go.id"
                                class="block w-full pl-9 pr-4 py-3 sm:py-3.5 text-sm rounded-2xl bg-white border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-sky-100 focus:border-[#0284c7] transition"
                            />
                        </div>

                        <!-- Security Note below input (Privasi data medis) -->
                        <div class="flex items-start gap-1.5 text-[11px] text-slate-500 mt-2 leading-relaxed">
                            <svg class="w-3.5 h-3.5 text-[#0284c7] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Privasi data medis: Tautan reset memiliki masa aktif terbatas dan hanya dikirimkan ke email terverifikasi faskes.</span>
                        </div>
                    </div>

                    <!-- Submit Button: Kirim Instruksi Reset -> -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="submitForgotBtn"
                            class="w-full py-3.5 px-6 rounded-2xl text-sm sm:text-base font-bold text-white bg-[#0284c7] hover:bg-[#0369a1] active:bg-[#075985] shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span>Kirim Instruksi Reset</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>

                </form>

                <!-- Below Form Link: Ingat password Anda? Kembali ke Masuk Admin -> -->
                <div class="text-center mt-5 sm:mt-6">
                    <span class="text-xs text-slate-500">Ingat password Anda?</span>
                    <a
                        href="{{ route('admin.login') }}"
                        class="text-xs font-bold text-[#0284c7] hover:text-[#0369a1] hover:underline ml-1 inline-flex items-center gap-1 transition"
                    >
                        <span>Kembali ke Masuk Admin</span>
                        <svg class="w-3.5 h-3.5 transform hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Info Box: Pendaftaran mandiri dinonaktifkan -->
                <div class="mt-6 p-4 sm:p-4.5 rounded-2xl bg-slate-50/80 border border-slate-200/80 text-center shadow-2xs">
                    <p class="text-xs font-bold text-slate-800 leading-snug">
                        Pendaftaran mandiri dinonaktifkan.
                    </p>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1 leading-relaxed">
                        Akun tenaga kesehatan resmi dibuat dan dikelola oleh Administrator Sistem Faskes &amp; Dinas Kesehatan.
                    </p>
                    <div class="mt-2.5 pt-2 border-t border-slate-200/50 text-[11px] sm:text-xs text-slate-600">
                        <span>Butuh aktivasi atau bantuan teknis?</span>
                        <a
                            href="javascript:void(0)"
                            onclick="openSupportModal()"
                            class="font-bold text-[#0284c7] hover:text-[#0369a1] hover:underline ml-1 cursor-pointer"
                        >
                            Hubungi IT Support
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Left Footer: Copyright & Links -->
            <div class="w-full pt-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400 border-t border-slate-100/80 relative z-10">
                <div>
                    &copy; 2025 NutriGrow Health Platform. Hak Cipta Dilindungi.
                </div>
                <div class="flex items-center gap-2">
                    <a href="javascript:void(0)" onclick="openPrivacyModal()" class="hover:text-slate-600 transition cursor-pointer">Kebijakan Privasi Rekam Medis</a>
                    <span>&bull;</span>
                    <a href="javascript:void(0)" onclick="openGuideModal()" class="hover:text-slate-600 transition cursor-pointer">Panduan Nakes</a>
                </div>
            </div>

        </div>

        <!-- =============================================================== -->
        <!-- 2. RIGHT COLUMN: HERO SHOWCASE (ORGANIC CURVE FACING LEFT)     -->
        <!-- =============================================================== -->
        <div class="w-full lg:w-1/2 min-h-screen lg:min-h-0 lg:h-full relative px-6 sm:px-8 lg:px-10 xl:px-14 py-5 sm:py-6 lg:py-8 flex flex-col justify-between ambient-glow-mobile lg:bg-transparent z-20 overflow-visible">

            <!-- =========================================================== -->
            <!-- LATAR BELAKANG SEAMLESS DENGAN KURVA MENGHADAP KIRI (USER STYLE) -->
            <!-- =========================================================== -->
            <div class="hidden lg:block absolute inset-y-0 left-[-50px] xl:left-[-65px] right-0 pointer-events-none z-0">
                <svg class="w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <defs>
                        <!-- Linear Gradient Pastel Biru & Putih Khas Portal Faskes -->
                        <linearGradient id="adminBgGradRight" x1="100%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#f0f9ff" />
                            <stop offset="35%" stop-color="#f8fafc" />
                            <stop offset="70%" stop-color="#ffffff" />
                            <stop offset="100%" stop-color="#fdf2f8" stop-opacity="0.95" />
                        </linearGradient>

                        <!-- Top-Right Cyan Ambient Glow -->
                        <radialGradient id="adminTopGlowRight" cx="80%" cy="15%" r="55%">
                            <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.22" />
                            <stop offset="100%" stop-color="#38bdf8" stop-opacity="0" />
                        </radialGradient>

                        <!-- Lower-Left Soft Pink Glow -->
                        <radialGradient id="adminBotGlowRight" cx="25%" cy="80%" r="50%">
                            <stop offset="0%" stop-color="#f472b6" stop-opacity="0.18" />
                            <stop offset="100%" stop-color="#f472b6" stop-opacity="0" />
                        </radialGradient>
                    </defs>

                    <!-- Exact Mirrored Curve Path as User Login (d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z") -->
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#adminBgGradRight)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#adminTopGlowRight)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#adminBotGlowRight)" />
                </svg>
            </div>

            <!-- Top Right Bar: Switch to User / Parent Login -->
            <div class="w-full flex items-center justify-end relative z-10 mb-4 sm:mb-6">
                <div class="text-xs sm:text-[13px] text-slate-500 font-normal">
                    <span>Bukan tenaga medis?</span>
                    <a
                        href="{{ route('login') }}"
                        class="text-[#0284c7] hover:text-[#0369a1] font-bold ml-1 inline-flex items-center gap-1 hover:underline transition"
                    >
                        <span>Masuk Pengguna / Orang Tua</span>
                        <svg class="w-3.5 h-3.5 transform hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Middle Section: 3D Lock Illustration Card & Typography -->
            <div class="my-auto py-4 sm:py-6 max-w-[420px] mx-auto w-full flex flex-col items-center justify-center relative z-10">

                <!-- Card 3D Lock: Keamanan Akun & Pemulihan Password -->
                <div class="relative w-full max-w-[340px] sm:max-w-[370px] rounded-[26px] sm:rounded-[30px] overflow-hidden shadow-xl shadow-sky-100/60 border border-white/90 bg-white group">
                    <img
                        src="{{ asset('images/admin-security-lock.png') }}"
                        alt="Keamanan Akun & Pemulihan Password NutriGrow"
                        class="w-full h-[220px] sm:h-[250px] object-cover object-center transform group-hover:scale-105 transition-transform duration-700 ease-out"
                        onerror="this.onerror=null; this.src='{{ asset('images/forgot-password-hero.png') }}';"
                    />
                    <!-- Subtle Glass Highlight on Top -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 via-transparent to-white/10 pointer-events-none"></div>
                </div>

                <!-- Typography Under Photo (Rata Tengah Sesuai Gambar Referensi) -->
                <div class="text-center mt-5 sm:mt-6 w-full max-w-[420px] px-2">
                    <h2 class="text-lg sm:text-[21px] font-extrabold text-[#0f172a] tracking-tight leading-snug text-center">
                        Keamanan Akun &amp; Pemulihan Password
                    </h2>
                    <p class="text-xs sm:text-[13px] text-slate-500 mt-2 sm:mt-2.5 leading-relaxed text-center font-normal max-w-[380px] mx-auto">
                        Instruksi pemulihan kata sandi dikirimkan secara aman demi melindungi integritas data faskes dan kerahasiaan rekam medis pasien.
                    </p>
                </div>

            </div>

            <!-- Bottom Right Footer: Standar Keamanan Data Medis -->
            <div class="pt-4 flex flex-wrap items-center justify-between gap-3 text-[11px] sm:text-xs text-slate-400 border-t border-slate-200/50 relative z-10">
                <div class="flex items-center gap-1.5 text-slate-600 font-medium">
                    <svg class="w-4 h-4 text-[#0284c7] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Standar Keamanan Data Medis Terproteksi</span>
                </div>
                <div class="text-slate-400 font-medium">
                    NutriGrow Health v2.4
                </div>
            </div>

        </div>

    </div>

    <!-- =================================================================== -->
    <!-- MODAL 1: BANTUAN IT SUPPORT                                         -->
    <!-- =================================================================== -->
    <div id="supportModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300" id="supportModalBox">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">Pusat Bantuan &amp; IT Support</h3>
                        <p class="text-[11px] text-slate-400">NutriGrow Platform Faskes &amp; Dinkes</p>
                    </div>
                </div>
                <button type="button" onclick="closeSupportModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mt-4 space-y-3 text-xs text-slate-600">
                <p>Jika email faskes Anda belum terdaftar atau Anda membutuhkan aktivasi cepat, silakan hubungi saluran resmi berikut:</p>
                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Helpdesk Faskes:</span>
                        <span class="font-bold text-slate-800">helpdesk@nutrigrow.id</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">WhatsApp Siaga Nakes:</span>
                        <span class="font-bold text-emerald-600">+62 811-9824-7000</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Jam Layanan:</span>
                        <span class="font-bold text-slate-700">24 Jam / 7 Hari</span>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeSupportModal()" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 2: KEBIJAKAN PRIVASI REKAM MEDIS                             -->
    <!-- =================================================================== -->
    <div id="privacyModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base">Kebijakan Privasi Rekam Medis</h3>
                <button type="button" onclick="closePrivacyModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mt-4 text-xs text-slate-600 leading-relaxed space-y-2">
                <p>Data identitas balita, ibu hamil, serta riwayat gizi dan KMS digital dilindungi dengan standar enkripsi end-to-end setara perbankan.</p>
                <p>Akses akun faskes diaudit berkala sesuai regulasi Permenkes No. 24 Tahun 2022 tentang Rekam Medis Elektronik.</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closePrivacyModal()" class="px-5 py-2.5 rounded-xl bg-[#0284c7] text-white text-xs font-bold hover:bg-[#0369a1] transition">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 3: PANDUAN NAKES                                             -->
    <!-- =================================================================== -->
    <div id="guideModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base">Panduan Tenaga Kesehatan</h3>
                <button type="button" onclick="closeGuideModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mt-4 text-xs text-slate-600 leading-relaxed space-y-2">
                <p>Panduan pengoperasian portal faskes, sinkronisasi data SatuSehat, dan penginputan hasil penimbangan Posyandu:</p>
                <ul class="list-disc pl-5 space-y-1 text-slate-500">
                    <li>Gunakan email kedinasan atau email faskes resmi (@puskesmas.go.id atau @nutrigrow.id).</li>
                    <li>Pastikan STR / NIP aktif terdaftar di sistem faskes.</li>
                    <li>Jaga kerahasiaan kata sandi dan jangan membagikan kredensial akses.</li>
                </ul>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeGuideModal()" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Tutup Panduan
                </button>
            </div>
        </div>
    </div>

    <!-- Interactive Scripts -->
    <script>
        function openSupportModal() {
            const m = document.getElementById('supportModal');
            const b = document.getElementById('supportModalBox');
            m.classList.remove('opacity-0', 'pointer-events-none');
            b.classList.remove('scale-95');
            b.classList.add('scale-100');
        }
        function closeSupportModal() {
            const m = document.getElementById('supportModal');
            const b = document.getElementById('supportModalBox');
            m.classList.add('opacity-0', 'pointer-events-none');
            b.classList.remove('scale-100');
            b.classList.add('scale-95');
        }

        function openPrivacyModal() {
            const m = document.getElementById('privacyModal');
            m.classList.remove('opacity-0', 'pointer-events-none');
        }
        function closePrivacyModal() {
            const m = document.getElementById('privacyModal');
            m.classList.add('opacity-0', 'pointer-events-none');
        }

        function openGuideModal() {
            const m = document.getElementById('guideModal');
            m.classList.remove('opacity-0', 'pointer-events-none');
        }
        function closeGuideModal() {
            const m = document.getElementById('guideModal');
            m.classList.add('opacity-0', 'pointer-events-none');
        }
    </script>
</body>
</html>

