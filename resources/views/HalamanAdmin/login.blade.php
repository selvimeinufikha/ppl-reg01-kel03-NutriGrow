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
    <title>Masuk Admin & Tenaga Kesehatan - NutriGrow | Cegah Stunting</title>

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
        /* Mobile background gradient fallback */
        .ambient-glow-mobile {
            background: radial-gradient(circle at 10% 15%, rgba(186, 230, 253, 0.5) 0%, transparent 45%),
                        radial-gradient(circle at 85% 75%, rgba(254, 205, 211, 0.35) 0%, transparent 40%),
                        linear-gradient(180deg, #f0f9ff 0%, #ffffff 50%, #f8fafc 100%);
        }
    </style>
</head>
<body class="min-h-screen bg-white font-sans antialiased text-slate-800 flex flex-col justify-between selection:bg-sky-500 selection:text-white">

    <!-- =================================================================== -->
    <!-- MAIN CONTAINER: SPLIT SCREEN (LEFT: BRAND & HERO, RIGHT: ADMIN FORM) -->
    <!-- =================================================================== -->
    <div class="min-h-screen w-full flex flex-col lg:flex-row bg-white relative overflow-x-hidden">

        <!-- =============================================================== -->
        <!-- DESKTOP BACKGROUND SVG: FULL-HEIGHT ORGANIC CURVE ON LEFT SIDE  -->
        <!-- =============================================================== -->
        <div class="hidden lg:block absolute inset-0 w-full h-full pointer-events-none z-0">
            <svg class="w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                <defs>
                    <!-- Linear Gradient Top Cyan to Bottom Pink matching user crop -->
                    <linearGradient id="heroGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#e0f2fe" stop-opacity="0.9" />
                        <stop offset="25%" stop-color="#f0f9ff" stop-opacity="0.75" />
                        <stop offset="55%" stop-color="#ffffff" stop-opacity="0.95" />
                        <stop offset="80%" stop-color="#fdf2f8" stop-opacity="0.85" />
                        <stop offset="92%" stop-color="#fce7f3" stop-opacity="0.7" />
                        <stop offset="100%" stop-color="#f8fafc" stop-opacity="0.9" />
                    </linearGradient>

                    <!-- Top-Left Cyan Ambient Glow -->
                    <radialGradient id="topCyanGlow" cx="12%" cy="10%" r="50%">
                        <stop offset="0%" stop-color="#bae6fd" stop-opacity="0.7" />
                        <stop offset="50%" stop-color="#e0f2fe" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                    </radialGradient>

                    <!-- Lower-Right Soft Pink Glow (Visible in media_1794108693047_4dbe61ec.png) -->
                    <radialGradient id="bottomPinkGlow" cx="44%" cy="72%" r="30%">
                        <stop offset="0%" stop-color="#fbcfe8" stop-opacity="0.7" />
                        <stop offset="50%" stop-color="#fce7f3" stop-opacity="0.4" />
                        <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                    </radialGradient>

                    <!-- Soft blur / glow along the dividing edge -->
                    <filter id="edgeGlow" x="-20%" y="-20%" width="140%" height="140%">
                        <feDropShadow dx="3" dy="0" stdDeviation="5" flood-color="#cbd5e1" flood-opacity="0.25" />
                    </filter>
                </defs>

                <!-- Organic Curved Shape: starts at x=440 at top, bows out to x=480 around y=480, tapers back to x=430 at bottom -->
                <path d="M 0,0 L 440,0 C 455,180 480,320 480,480 C 480,640 455,820 430,1000 L 0,1000 Z" fill="url(#heroGradient)" filter="url(#edgeGlow)" />
                <path d="M 0,0 L 440,0 C 455,180 480,320 480,480 C 480,640 455,820 430,1000 L 0,1000 Z" fill="url(#topCyanGlow)" />
                <path d="M 0,0 L 440,0 C 455,180 480,320 480,480 C 480,640 455,820 430,1000 L 0,1000 Z" fill="url(#bottomPinkGlow)" />

                <!-- Delicate Stroke along the Curve -->
                <path d="M 440,0 C 455,180 480,320 480,480 C 480,640 455,820 430,1000" fill="none" stroke="rgba(203, 213, 225, 0.9)" stroke-width="1.8" />
            </svg>
        </div>

        <!-- =============================================================== -->
        <!-- 1. LEFT COLUMN: HERO SHOWCASE (PORTAL FASKES & NAKES)           -->
        <!-- =============================================================== -->
        <div class="w-full lg:w-[44%] xl:w-[43%] min-h-[520px] lg:min-h-screen relative px-6 sm:px-10 lg:px-12 xl:px-14 py-6 sm:py-8 lg:py-10 flex flex-col justify-between ambient-glow-mobile lg:bg-transparent z-10">

            <!-- Top Row: Logo & Tenaga Kesehatan + Pill Badge (Didekatkan Bersebelahan) -->
            <div class="flex items-center gap-3.5 sm:gap-4 relative z-10">
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

                <!-- Pill Badge: Portal Khusus Faskes & Nakes (Posisi di samping NutriGrow) -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/95 border border-sky-100/90 shadow-2xs shrink-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-700 tracking-tight whitespace-nowrap">
                        Portal Khusus Faskes &amp; Nakes
                    </span>
                </div>
            </div>

            <!-- Middle Section: Image Showcase Card & Centered Typography (Persis Sesuai Gambar Referensi) -->
            <div class="my-auto py-4 sm:py-6 max-w-[420px] mx-auto w-full flex flex-col items-center justify-center relative z-10">

                <!-- Card Photo: Dokter Memeriksa Anak di Timbangan Digital -->
                <div class="relative w-full max-w-[340px] sm:max-w-[370px] rounded-[26px] sm:rounded-[30px] overflow-hidden shadow-xl shadow-slate-200/60 border border-white/90 bg-white group">
                    <img
                        src="{{ asset('images/growth-measurement-hd.png') }}"
                        alt="Pemantauan Gizi Anak & Pencegahan Stunting NutriGrow"
                        class="w-full h-[220px] sm:h-[250px] object-cover object-center transform group-hover:scale-105 transition-transform duration-700 ease-out"
                        onerror="this.onerror=null; this.src='{{ asset('images/growth-measurement.jpg') }}';"
                    />
                    <!-- Subtle Glass Highlight on Top -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 via-transparent to-white/10 pointer-events-none"></div>
                </div>

                <!-- Typography Under Photo: Rata Tengah & 3 Baris Rapi Sesuai Referensi -->
                <div class="text-center mt-5 sm:mt-6 w-full max-w-[420px] px-2">
                    <h2 class="text-lg sm:text-[21px] font-extrabold text-[#0f172a] tracking-tight leading-snug text-center">
                        Pemantauan Gizi Anak &amp; Pencegahan Stunting
                    </h2>
                    <p class="text-xs sm:text-[13px] text-slate-500 mt-2 sm:mt-2.5 leading-relaxed text-center font-normal">
                        Portal terpadu khusus admin dan tenaga kesehatan faskes untuk<br class="hidden sm:inline">
                        mengelola data tumbuh kembang, memantau riwayat gizi anak,<br class="hidden sm:inline">
                        serta pelaporan intervensi medis secara akurat.
                    </p>
                </div>

            </div>

            <!-- Bottom Left Footer: Standar Keamanan Data Medis -->
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

        <!-- =============================================================== -->
        <!-- 2. RIGHT COLUMN: ADMIN LOGIN FORM                               -->
        <!-- =============================================================== -->
        <div class="w-full lg:w-[56%] xl:w-[57%] min-h-screen bg-white lg:bg-transparent px-6 sm:px-10 lg:px-12 xl:px-16 py-6 sm:py-8 lg:py-10 flex flex-col justify-between relative z-10">

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

            <!-- Center Content: The Form Card -->
            <div class="w-full max-w-[420px] mx-auto my-auto py-2">

                <!-- Alert Messages: Success Logout / Session Message -->
                @if (session('success_logout'))
                    <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success_logout') }}</span>
                    </div>
                @endif

                @if (session('success_admin_login'))
                    <div class="mb-5 p-3.5 rounded-2xl bg-sky-50 border border-sky-200 text-xs text-sky-800 flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success_admin_login') }}</span>
                    </div>
                @endif

                <!-- Validation Error Alert -->
                @if ($errors->has('login_error'))
                    <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold">Gagal Masuk</p>
                            <p class="mt-0.5">{{ $errors->first('login_error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Form Heading & Subtitle -->
                <div class="mb-6 sm:mb-7">
                    <h1 class="text-2xl sm:text-[32px] font-extrabold text-slate-900 tracking-tight leading-tight">
                        Masuk Admin
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1.5 leading-relaxed">
                        Masuk untuk mengelola data kesehatan dan pemantauan keluarga.
                    </p>
                </div>

                <!-- Form Body -->
                <form action="{{ route('admin.login.submit') }}" method="POST" id="adminLoginForm" class="space-y-4 sm:space-y-4.5">
                    @csrf

                    <!-- Field 1: EMAIL PETUGAS / ADMIN -->
                    <div>
                        <label for="admin_email" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            EMAIL PETUGAS / ADMIN <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                                </svg>
                            </div>
                            <input
                                type="email"
                                id="admin_email"
                                name="email"
                                value="{{ old('email', 'admin@nutrigrow.id') }}"
                                required
                                autofocus
                                placeholder="nama@nutrigrow.id / puskesmas.go.id"
                                class="w-full pl-10 pr-4 py-3 sm:py-3.5 rounded-2xl bg-slate-50/50 hover:bg-slate-50 focus:bg-white border @error('email') border-rose-400 @else border-slate-200/90 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition shadow-2xs font-medium"
                            />
                        </div>
                        @error('email')
                            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Field 2: PASSWORD -->
                    <div>
                        <label for="admin_password" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            PASSWORD <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input
                                type="password"
                                id="admin_password"
                                name="password"
                                value="admin123"
                                required
                                placeholder="Masukkan kata sandi aman"
                                class="w-full pl-10 pr-10 py-3 sm:py-3.5 rounded-2xl bg-slate-50/50 hover:bg-slate-50 focus:bg-white border @error('password') border-rose-400 @else border-slate-200/90 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition shadow-2xs font-medium"
                            />
                            <!-- Toggle Password Visibility Button -->
                            <button
                                type="button"
                                id="toggleAdminPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none"
                                title="Tampilkan kata sandi"
                            >
                                <svg id="eyeAdminIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row: Ingat Perangkat & Lupa Password -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                checked
                                class="w-4 h-4 rounded text-[#0284c7] focus:ring-sky-500 border-slate-300 accent-[#0284c7] cursor-pointer"
                            />
                            <span class="text-xs text-slate-600 font-medium">Ingat perangkat faskes ini</span>
                        </label>

                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs font-semibold text-[#0284c7] hover:text-[#0369a1] hover:underline transition"
                        >
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button: Masuk -> -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="submitAdminLoginBtn"
                            class="w-full py-3.5 px-6 rounded-2xl text-sm sm:text-base font-bold text-white bg-[#0284c7] hover:bg-[#0369a1] active:bg-[#075985] shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span>Masuk</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>

                </form>

                <!-- Box Bawah: Penjelasan Portal & Bantuan Teknis IT Support -->
                <div class="mt-6 p-4 sm:p-4.5 rounded-2xl bg-slate-50/80 border border-slate-200/80 text-center shadow-2xs">
                    <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">
                        Portal terpadu khusus admin dan tenaga kesehatan faskes untuk mengelola data tumbuh kembang, memantau riwayat gizi anak, serta pelaporan intervensi medis secara akurat.
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

                <!-- Helper Pill: Akun Demo Praktikum (Dapat diklik langsung untuk autofill) -->
                <div class="mt-4 p-2.5 rounded-xl bg-sky-50/70 border border-sky-200/70 text-[11px] text-slate-600 flex items-center justify-between">
                    <div class="flex items-center gap-1.5 font-medium">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span>Akun Demo: <b>admin@nutrigrow.id</b> (admin123)</span>
                    </div>
                    <button
                        type="button"
                        onclick="fillDemoCredentials('admin@nutrigrow.id', 'admin123')"
                        class="text-[10px] font-bold text-sky-700 bg-white hover:bg-sky-100 px-2.5 py-1 rounded-lg border border-sky-300 transition cursor-pointer"
                    >
                        Auto-Fill
                    </button>
                </div>

            </div>

            <!-- Bottom Right Footer: Copyright & Links -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400 border-t border-slate-100/80 relative z-10">
                <div>
                    &copy; 2025 NutriGrow Health Platform. Hak Cipta Dilindungi.
                </div>
                <div class="flex items-center gap-2">
                    <a href="javascript:void(0)" onclick="openPrivacyModal()" class="hover:text-slate-600 transition">
                        Kebijakan Privasi Rekam Medis
                    </a>
                    <span>&bull;</span>
                    <a href="javascript:void(0)" onclick="openPanduanModal()" class="hover:text-slate-600 transition">
                        Panduan Nakes
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- =================================================================== -->
    <!-- MODAL 1: HUBUNGI IT SUPPORT FASKES                                   -->
    <!-- =================================================================== -->
    <div id="supportModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform transition-all">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Bantuan IT Support Faskes</h3>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                Jika faskes atau posyandu Anda belum terdaftar di jaringan SatuSehat NutriGrow, silakan hubungi tim helpdesk teknis:
            </p>
            <div class="mt-4 space-y-2 text-xs">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Email Dukungan IT:</span>
                    <span class="font-bold text-slate-800">support-nakes@nutrigrow.id</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                    <span class="text-slate-500 font-medium">WhatsApp Call Center:</span>
                    <span class="font-bold text-slate-800">+62 811-9234-5678</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Jam Operasional:</span>
                    <span class="font-bold text-emerald-600">24/7 Siaga Faskes</span>
                </div>
            </div>
            <div class="mt-5 flex justify-end">
                <button
                    type="button"
                    onclick="closeModal('supportModal')"
                    class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs cursor-pointer"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 2: KEBIJAKAN PRIVASI REKAM MEDIS                             -->
    <!-- =================================================================== -->
    <div id="privacyModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[85vh] overflow-y-auto">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Kebijakan Privasi &amp; Rekam Medis Elektronik</h3>
            <div class="mt-3 text-xs text-slate-600 space-y-2.5 leading-relaxed">
                <p>1. <b>Kepatuhan UU PDP &amp; Permenkes No. 24 Tahun 2022</b>: Seluruh data rekam medis antropometri, riwayat imunisasi, dan catatan gizi disimpan dengan enkripsi end-to-end berstandar medis.</p>
                <p>2. <b>Hak Akses Terbatas</b>: Hanya tenaga kesehatan terverifikasi dengan STR/SIP aktif atau admin faskes terdaftar yang memiliki izin melihat data lengkap pasien.</p>
                <p>3. <b>Interoperabilitas SatuSehat</b>: Pengiriman data dilakukan secara aman melalui protokol OAuth2 dan HL7 FHIR Kemenkes RI.</p>
            </div>
            <div class="mt-5 flex justify-end">
                <button
                    type="button"
                    onclick="closeModal('privacyModal')"
                    class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs cursor-pointer"
                >
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- MODAL 3: PANDUAN NAKES                                             -->
    <!-- =================================================================== -->
    <div id="panduanModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[85vh] overflow-y-auto">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Panduan Operasional Tenaga Kesehatan (Nakes)</h3>
            <div class="mt-3 text-xs text-slate-600 space-y-2.5 leading-relaxed">
                <p>• <b>Input Data Pengukuran</b>: Pastikan timbangan digital telah dikalibrasi sesuai standar antropometri balita WHO 2006.</p>
                <p>• <b>Pemberian PMT Pemulihan</b>: Balita dengan grafik berada di bawah -2 SD (Kuning/Merah) wajib dijadwalkan intervensi PMT selama 90 hari.</p>
                <p>• <b>Sinkronisasi Otomatis</b>: Data kunjungan Posyandu akan langsung tersinkron ke dashboard orang tua untuk edukasi gizi di rumah.</p>
            </div>
            <div class="mt-5 flex justify-end">
                <button
                    type="button"
                    onclick="closeModal('panduanModal')"
                    class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs cursor-pointer"
                >
                    Tutup Panduan
                </button>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- INTERACTIVE JAVASCRIPT: PASSWORD TOGGLE, AUTOFILL & MODALS          -->
    <!-- =================================================================== -->
    <script>
        // Toggle Password Visibility
        const toggleBtn = document.getElementById('toggleAdminPassword');
        const passwordInput = document.getElementById('admin_password');
        const eyeIcon = document.getElementById('eyeAdminIcon');

        if (toggleBtn && passwordInput && eyeIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';

                if (isPassword) {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                    `;
                    toggleBtn.title = 'Sembunyikan kata sandi';
                } else {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    `;
                    toggleBtn.title = 'Tampilkan kata sandi';
                }
            });
        }

        // Auto-fill Demo Credentials
        function fillDemoCredentials(email, password) {
            const emailField = document.getElementById('admin_email');
            const passwordField = document.getElementById('admin_password');
            if (emailField) emailField.value = email;
            if (passwordField) passwordField.value = password;
        }

        // Modal Helpers
        function openSupportModal() {
            document.getElementById('supportModal').classList.remove('hidden');
        }
        function openPrivacyModal() {
            document.getElementById('privacyModal').classList.remove('hidden');
        }
        function openPanduanModal() {
            document.getElementById('panduanModal').classList.remove('hidden');
        }
        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        }

        // Close on backdrop click
        window.addEventListener('click', function(e) {
            ['supportModal', 'privacyModal', 'panduanModal'].forEach(id => {
                const modal = document.getElementById(id);
                if (modal && e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>

</body>
</html>
