<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NutriGrow - Bersama Cegah Stunting | Maternal & Child Health Care</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN for instant styling without local build dependencies -->
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
                            50: '#fff1f4',
                            100: '#ffe4e8',
                            200: '#fecdd6',
                            300: '#fda4b5',
                            400: '#fb718e',
                            500: '#f43f68',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                        }
                    },
                    animation: {
                        'float-slow': 'float 6s ease-in-out infinite',
                        'float-reverse': 'floatRev 7s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        floatRev: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Optional Vite support if compiled -->
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fbfbfc;
            overflow-x: hidden;
        }

        /* Ambient background glow matching mockup */
        .hero-glow-1 {
            position: absolute;
            width: 650px;
            height: 650px;
            left: -150px;
            top: -150px;
            background: radial-gradient(circle, rgba(254, 205, 214, 0.45) 0%, rgba(255, 241, 244, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .hero-glow-2 {
            position: absolute;
            width: 750px;
            height: 750px;
            right: -100px;
            top: -80px;
            background: radial-gradient(circle, rgba(255, 215, 225, 0.45) 0%, rgba(240, 245, 255, 0.2) 50%, rgba(255, 255, 255, 0) 75%);
            pointer-events: none;
            z-index: 0;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="text-slate-800 antialiased relative min-h-screen flex flex-col justify-between">

    <!-- Ambient background glows -->
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <!-- MAIN NAVBAR -->
    <header class="relative z-50 w-full pt-4 sm:pt-6 px-4 sm:px-6 lg:px-12 max-w-7xl mx-auto">
        <nav class="flex items-center justify-between py-2 sm:py-3">
            <!-- Left Brand / Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <!-- Brand Pill Badge (matching image design) -->
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-pink-100/70 border border-pink-200/80 shadow-xs transition group-hover:bg-pink-100">
                        <img src="{{ asset('images/nutrigrow-icon.png') }}" alt="NutriGrow" class="h-6 w-auto object-contain flex-shrink-0">
                        <span class="font-extrabold text-sm sm:text-base tracking-tight text-brand-600">NutriGrow</span>
                        <span class="text-[10px] uppercase font-bold tracking-wider text-brand-600/90 pl-1.5 border-l border-pink-300 hidden sm:inline">
                            Maternal &amp; Child Health Care
                        </span>
                    </div>
                </a>
            </div>

            <!-- Center Navigation Links -->
            <div class="hidden md:flex items-center gap-7 text-sm font-medium text-slate-600">
                <a href="#fitur" class="hover:text-brand-600 transition-colors py-1">Fitur</a>
                <a href="#dashboard-preview" class="hover:text-brand-600 transition-colors py-1">Aplikasi</a>
                <a href="#cara-kerja" class="hover:text-brand-600 transition-colors py-1">Cara Kerja</a>
                <a href="#edukasi-gizi" class="hover:text-brand-600 transition-colors py-1">Edukasi Gizi</a>
            </div>

            <!-- Right Action Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-brand-600 px-3.5 py-2 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-brand-600 via-pink-600 to-rose-500 hover:from-brand-700 hover:to-rose-600 px-5 py-2.5 rounded-full shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-pink-500/30 transition-all transform hover:-translate-y-0.5">
                    <span>Daftar Akun</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </nav>
    </header>

    <!-- HERO SECTION -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pt-8 sm:pt-14 pb-12 flex-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
            
            <!-- LEFT COLUMN: CONTENT -->
            <div class="lg:col-span-6 space-y-6 sm:space-y-7 text-left">
                <!-- Badge Pill -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-pink-100/60 border border-pink-200/80 text-brand-700 text-xs sm:text-sm font-semibold shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                    <span>Mulai Cegah Stunting Sejak Dini</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-[54px] font-extrabold text-slate-900 tracking-tight leading-[1.12]">
                    Tumbuh Sehat,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 via-pink-600 to-purple-600">
                        Bersama Cegah Stunting
                    </span>
                </h1>

                <!-- Subtitle / Paragraph -->
                <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-xl">
                    Pantau kesehatan keluarga sejak sebelum kehamilan hingga tumbuh kembang anak melalui informasi dan pemantauan kesehatan dalam satu platform terpadu.
                </p>

                <!-- Action CTA Buttons -->
                <div class="flex flex-wrap items-center gap-4 pt-1">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full text-base font-semibold text-white bg-gradient-to-r from-brand-600 to-pink-600 hover:from-brand-700 hover:to-pink-700 shadow-lg shadow-pink-500/25 hover:shadow-xl hover:shadow-pink-500/35 transition-all transform hover:-translate-y-0.5">
                        <span>Mulai Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>

                    <a href="#fitur" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full text-base font-semibold text-slate-700 bg-white/90 hover:bg-white border border-slate-200 shadow-xs hover:shadow-md transition-all">
                        <span>Jelajahi Fitur</span>
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>

                <!-- Medical Standard Note -->
                <div class="flex items-center gap-2.5 pt-2 text-xs sm:text-sm text-slate-600">
                    <div class="w-4 h-4 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span>Mendukung standar panduan gizi dan antropometri <strong class="text-slate-800 font-semibold">Kemenkes RI & WHO</strong></span>
                </div>

                <!-- Stats Counters -->
                <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-4 border-t border-slate-200/60 max-w-lg">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-brand-600">98%</div>
                        <div class="text-xs sm:text-sm text-slate-500 mt-0.5 font-medium">Orang Tua Terbantu</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-blue-600">10.000+</div>
                        <div class="text-xs sm:text-sm text-slate-500 mt-0.5 font-medium">Anak Terpantau</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-purple-600">100%</div>
                        <div class="text-xs sm:text-sm text-slate-500 mt-0.5 font-medium">Standar Medis</div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: 3D ILLUSTRATION & FLOATING CARDS -->
            <div class="lg:col-span-6 relative mt-8 lg:mt-0 flex justify-center">
                <!-- Ambient Backdrop Aura for the Hero Frame -->
                <div class="absolute inset-0 bg-gradient-to-tr from-pink-200/50 via-rose-100/30 to-blue-100/40 rounded-[44px] filter blur-xl transform scale-105 pointer-events-none"></div>

                <!-- Central Image Wrapper with outer rounded frame -->
                <div class="relative w-full max-w-[490px] rounded-[36px] bg-gradient-to-b from-white/80 to-pink-50/50 p-3 sm:p-4 border border-white/80 shadow-2xl shadow-pink-500/10">
                    
                    <!-- Main 3D Family Image Container -->
                    <div class="relative w-full aspect-[4/4.1] sm:aspect-[4/4.2] rounded-[28px] overflow-hidden bg-gradient-to-br from-amber-50/30 via-pink-50/20 to-blue-50/30 shadow-inner">
                        <img 
                            src="{{ asset('images/family-hero.png') }}" 
                            alt="NutriGrow - Keluarga Sehat Bebas Stunting" 
                            class="w-full h-full object-cover object-center transform hover:scale-102 transition duration-700 ease-out"
                            onerror="this.onerror=null; this.src='{{ asset('images/family-cropped.jpg') }}';"
                        />
                    </div>

                    <!-- FLOATING CARD 1: TOP LEFT (Usia Janin) -->
                    <div class="absolute -top-4 -left-3 sm:-top-5 sm:-left-6 glass-card rounded-2xl p-3 sm:p-3.5 shadow-xl shadow-pink-900/5 border border-pink-100/80 animate-float-slow max-w-[190px] sm:max-w-[210px] z-20">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-pink-100 text-brand-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-xs sm:text-sm text-slate-800 leading-tight">Usia Janin: Mg 24</div>
                                <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Trimester 2 (60% tercapai)</div>
                            </div>
                        </div>
                        <!-- Mini Progress Bar -->
                        <div class="w-full bg-pink-100/80 rounded-full h-1.5 mt-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-brand-500 to-pink-500 h-1.5 rounded-full w-[60%]"></div>
                        </div>
                    </div>

                    <!-- FLOATING CARD 2: TOP RIGHT (Kurva WHO) -->
                    <div class="absolute -top-4 -right-3 sm:-top-5 sm:-right-6 glass-card rounded-2xl p-3 sm:p-3.5 shadow-xl shadow-slate-900/5 border border-emerald-100/80 animate-float-reverse max-w-[170px] sm:max-w-[190px] z-20">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">KURVA WHO</span>
                            <span class="w-2 h-2 rounded bg-emerald-500"></span>
                        </div>
                        <div class="font-bold text-xs sm:text-sm text-slate-800">Tinggi: 83,5 cm</div>
                        <div class="mt-1.5 inline-block px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-semibold border border-emerald-200/50">
                            Z-Score : +0.2 SD (Normal)
                        </div>
                    </div>

                    <!-- FLOATING CARD 3: BOTTOM LEFT (Jadwal ANC) -->
                    <div class="absolute -bottom-4 -left-3 sm:-bottom-5 sm:-left-6 glass-card rounded-2xl p-3 sm:p-3.5 shadow-xl shadow-slate-900/5 border border-sky-100/80 animate-float-reverse max-w-[185px] sm:max-w-[205px] z-20">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-sky-50 text-sky-600 text-[10px] font-bold border border-sky-200/60">
                                4 Hari Lagi
                            </span>
                        </div>
                        <div class="mt-1.5">
                            <div class="font-bold text-xs sm:text-sm text-slate-800 leading-tight">Jadwal ANC Ke-4</div>
                            <div class="text-[11px] text-slate-500 font-medium">di: Linda Sp.OG</div>
                        </div>
                    </div>

                    <!-- FLOATING CARD 4: BOTTOM RIGHT (Tablet Tambah Darah) -->
                    <div class="absolute -bottom-4 -right-3 sm:-bottom-5 sm:-right-6 glass-card rounded-2xl p-3 sm:p-3.5 shadow-xl shadow-pink-900/5 border border-pink-100/80 animate-float-slow max-w-[190px] sm:max-w-[210px] z-20">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-pink-100 text-brand-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-xs sm:text-sm text-slate-800 leading-tight">Tablet Tambah Darah</div>
                                <div class="text-[11px] text-brand-600 font-semibold mt-0.5">21/30 Tercatat bulan ini</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- 3 HIGHLIGHT FEATURE CARDS -->
        <section id="fitur" class="mt-14 sm:mt-18 pt-4">
            <div class="rounded-3xl bg-white/95 border border-slate-100 shadow-xl shadow-slate-900/5 p-6 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 backdrop-blur-sm">
                
                <!-- Highlight 1: Pantau Kesehatan Keluarga -->
                <div class="flex items-start gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-pink-100/80 text-brand-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-1 group-hover:text-brand-600 transition-colors">
                            Pantau Kesehatan Keluarga
                        </h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Integrasi data kehamilan ibu dan riwayat tumbuh kembang seluruh anak dalam satu akun terenkripsi aman.
                        </p>
                    </div>
                </div>

                <!-- Highlight 2: Pengingat Pemeriksaan -->
                <div class="flex items-start gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100/80 text-sky-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-1 group-hover:text-sky-600 transition-colors">
                            Pengingat Pemeriksaan
                        </h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Notifikasi otomatis jadwal ANC, imunisasi wajib, dan penimbangan posyandu agar tidak ada fase yang terlewat.
                        </p>
                    </div>
                </div>

                <!-- Highlight 3: Informasi Gizi & Pertumbuhan -->
                <div class="flex items-start gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100/80 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-1 group-hover:text-amber-600 transition-colors">
                            Informasi Gizi & Pertumbuhan
                        </h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Panduan menu MPASI kaya protein hewani ganda, kalori ibu hamil, serta evaluasi kurva WHO real-time.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: FITUR UNGGULAN NUTRIGROW (DUKUNGAN MENYELURUH DI TIAP FASE KEHIDUPAN) -->
        <section id="fitur-unggulan" class="mt-20 pt-4">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-pink-100/80 border border-pink-200/90 text-brand-600 text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                    FITUR UNGGULAN NUTRIGROW
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-tight">
                    Dukungan Menyeluruh di Tiap Fase Kehidupan
                </h2>
                <p class="mt-3.5 text-slate-600 text-base sm:text-lg leading-relaxed">
                    Dari persiapan kehamilan hingga tumbuh kembang anak, NutriGrow membantu keluarga memahami informasi kesehatan dengan lebih mudah, akurat, dan terarah.
                </p>
            </div>

            <!-- Two Featured Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-8">

                <!-- CARD 1: PEMANTAUAN KEHAMILAN TERPADU -->
                <div class="rounded-[36px] bg-[#fff3f5] border border-pink-100/90 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-pink-500/5 group">
                    <div>
                        <!-- Icon (Pink rounded box with pregnant mother silhouette) -->
                        <div class="w-12 h-12 rounded-2xl bg-brand-500 text-white flex items-center justify-center shadow-md shadow-brand-500/25 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="4" r="2.2"/>
                                <path d="M14.2 8.2c-.3-.5-.9-.8-1.5-.8h-1.4c-.6 0-1.2.3-1.5.8L7.8 12.2c-.3.5-.2 1.1.3 1.4.5.3 1.1.2 1.4-.3l1.5-2.6v7.8c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-4.5h.6v4.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-6.2c1.2-.4 2-1.5 2-2.8 0-1.1-.6-2.1-1.5-2.6L14.2 8.2z"/>
                            </svg>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-bold text-slate-900 mt-6 mb-3 tracking-tight">
                            Pemantauan Kehamilan Terpadu
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            Pantau usia gestasi, pertambahan berat badan ideal ibu hamil sesuai IMT pra-kehamilan, kepatuhan asupan 90 tablet tambah darah (TTD), serta jadwal USG trimester.
                        </p>

                        <!-- Inner White Card Widget -->
                        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-pink-100/80 shadow-xs flex flex-col sm:flex-row items-center gap-5 sm:gap-6 mb-6">
                            <!-- Left illustration -->
                            <div class="w-28 sm:w-32 flex-shrink-0 flex items-center justify-center bg-pink-50/40 rounded-xl p-2">
                                <img 
                                    src="{{ asset('images/mother-child-illustration.png') }}" 
                                    alt="Ibu dan Anak" 
                                    class="w-full h-auto object-contain max-h-24 sm:max-h-28"
                                />
                            </div>

                            <!-- Right details -->
                            <div class="flex-1 w-full space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-xs sm:text-sm text-slate-900">Timeline Trimester 2</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-pink-100 text-brand-600 text-[11px] font-bold">
                                        Minggu 24
                                    </span>
                                </div>

                                <!-- Progress bar -->
                                <div class="w-full bg-pink-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-brand-500 to-pink-500 h-2 rounded-full w-[60%]"></div>
                                </div>

                                <!-- Checklist items -->
                                <div class="space-y-1.5 pt-1">
                                    <div class="flex items-center gap-2 text-xs sm:text-[13px] text-slate-700">
                                        <div class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <span>Asupan TTD Hari Ini: <strong class="text-slate-800 font-semibold">Tercatat</strong></span>
                                    </div>

                                    <div class="flex items-center gap-2 text-xs sm:text-[13px] text-slate-700">
                                        <div class="w-4 h-4 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span>USG Anomali : <strong class="text-slate-800 font-semibold">Terjadwal (Mg 26)</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Row -->
                    <div class="flex items-center justify-between pt-2 border-t border-pink-200/50">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-600 hover:text-brand-700 transition group/link">
                            <span>Pelajari Selengkapnya</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <span class="text-xs font-semibold text-slate-400">Modul KIA Digital Ibu</span>
                    </div>
                </div>

                <!-- CARD 2: TUMBUH KEMBANG ANAK -->
                <div class="rounded-[36px] bg-[#f0f7ff] border border-sky-100/90 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-sky-500/5 group">
                    <div>
                        <!-- Icon (Blue rounded box with growth scale icon) -->
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-600/25 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M3 8h6M3 12h12M3 16h6M3 20h18"/>
                            </svg>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-bold text-slate-900 mt-6 mb-3 tracking-tight">
                            Tumbuh Kembang Anak
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            Visualisasi kurva KMS digital real-time: tinggi badan menurut umur (TB/U), berat badan (BB/U), dan lingkar kepala standar WHO 2006.
                        </p>

                        <!-- Inner Photo Widget -->
                        <div class="relative rounded-2xl overflow-hidden border border-sky-100/80 shadow-xs mb-6 aspect-[16/10] bg-slate-100">
                            <img 
                                src="{{ asset('images/growth-measurement-hd.png') }}" 
                                alt="Pengukuran Pertumbuhan Anak" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-102 transition duration-700 ease-out"
                                onerror="this.onerror=null; this.src='{{ asset('images/growth-measurement.jpg') }}';"
                            />

                            <!-- Floating Bottom Info Pill Bar -->
                            <div class="absolute bottom-3 left-3 right-3 glass-card rounded-xl px-4 py-2.5 flex items-center justify-between shadow-md border border-white/80">
                                <span class="font-bold text-xs sm:text-sm text-slate-800">
                                    Tinggi Terakhir: 89 cm
                                </span>
                                <span class="px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/50">
                                    Normal (Z: +0.4)
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Row -->
                    <div class="flex items-center justify-between pt-2 border-t border-sky-200/50">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-600 hover:text-blue-700 transition group/link">
                            <span>Pelajari Selengkapnya</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <span class="text-xs font-semibold text-slate-400">Standar WHO & Kemenkes</span>
                    </div>
                </div>

                <!-- CARD 3: MONITORING RISIKO STUNTING (TRIAGE CERDAS) -->
                <div class="rounded-[36px] bg-white border border-slate-100 shadow-xl shadow-slate-900/5 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/5 group">
                    <div>
                        <!-- Top Row (Icon & Badge) -->
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100/80 shadow-xs group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <span class="px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200/60 text-xs font-bold tracking-tight">
                                Deteksi Dini Cerdas
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-bold text-slate-900 mt-6 mb-3 tracking-tight">
                            Monitoring Risiko Stunting (Triage Cerdas)
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            Algoritma skrining awal mengevaluasi tren berat badan dan tinggi secara periodik untuk mencegah kondisi faltering growth:
                        </p>

                        <!-- 3 Triage Status Boxes -->
                        <div class="space-y-3 mb-6">
                            <!-- Green Box -->
                            <div class="rounded-2xl bg-emerald-50/70 border border-emerald-200/70 p-3.5 sm:p-4 flex items-start gap-3">
                                <span class="w-3 h-3 rounded-full bg-emerald-500 flex-shrink-0 mt-1 shadow-xs"></span>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900">Risiko Rendah / Pertumbuhan Optimal</h4>
                                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                        Kenaikan tinggi & berat anak berada dalam rentang persentil hijau kurva WHO.
                                    </p>
                                </div>
                            </div>

                            <!-- Yellow Box -->
                            <div class="rounded-2xl bg-amber-50/70 border border-amber-200/70 p-3.5 sm:p-4 flex items-start gap-3">
                                <span class="w-3 h-3 rounded-full bg-amber-500 flex-shrink-0 mt-1 shadow-xs"></span>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900">Risiko Sedang / Butuh Asupan Tambahan</h4>
                                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                        Berat badan melandai (weight faltering) 2 bulan berturut-turut, evaluasi menu MPASI.
                                    </p>
                                </div>
                            </div>

                            <!-- Red Box -->
                            <div class="rounded-2xl bg-rose-50/70 border border-rose-200/70 p-3.5 sm:p-4 flex items-start gap-3">
                                <span class="w-3 h-3 rounded-full bg-rose-500 flex-shrink-0 mt-1 shadow-xs"></span>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900">Risiko Tinggi / Perlu Evaluasi Faskes Segera</h4>
                                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                        Garis kurva memotong batas merah (-2 SD), rujukan konsultasi dokter spesialis anak.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer link -->
                    <div class="pt-2 border-t border-slate-100">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-900 hover:text-brand-600 transition group/link">
                            <span>Pelajari Alur Skrining Medis</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- CARD 4: REKOMENDASI NUTRISI SESUAI USIA -->
                <div id="rekomendasi-nutrisi" class="rounded-[36px] bg-white border border-slate-100 shadow-xl shadow-slate-900/5 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-brand-500/5 group">
                    <div>
                        <!-- Top Row (Icon) -->
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-pink-50 text-brand-600 flex items-center justify-center border border-pink-100/80 shadow-xs group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-bold text-slate-900 mt-6 mb-3 tracking-tight">
                            Rekomendasi Nutrisi Sesuai Usia
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            Panduan menu gizi seimbang dengan fokus zat gizi mikro dan makro esensial di 1.000 Hari Pertama Kehidupan (HPK):
                        </p>

                        <!-- Middle Content Widget: Photo on left, 3 phases on right -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center mb-6">
                            <!-- Left photo -->
                            <div class="sm:col-span-5 rounded-2xl overflow-hidden border border-slate-100 shadow-xs relative aspect-[4/3] sm:aspect-auto sm:h-[195px] bg-slate-50">
                                <img 
                                    src="{{ asset('images/nutrition-food-hd.png') }}" 
                                    alt="Nutrisi Seimbang Ibu & Anak" 
                                    class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-700 ease-out"
                                    onerror="this.onerror=null; this.src='{{ asset('images/nutrition-food.jpg') }}';"
                                />
                            </div>

                            <!-- Right: 3 Phases -->
                            <div class="sm:col-span-7 space-y-2.5">
                                <!-- Fase Pra-Hamil -->
                                <div class="rounded-xl bg-slate-50/90 hover:bg-slate-100/90 transition p-2.5 sm:p-3 border border-slate-100">
                                    <span class="text-[10px] font-bold text-sky-600 uppercase tracking-wider block">
                                        FASE PRA-HAMIL
                                    </span>
                                    <span class="text-xs sm:text-[13px] font-bold text-slate-800 block mt-0.5">
                                        Asam Folat 400 mcg & Zat Besi
                                    </span>
                                </div>

                                <!-- Fase Kehamilan -->
                                <div class="rounded-xl bg-slate-50/90 hover:bg-slate-100/90 transition p-2.5 sm:p-3 border border-slate-100">
                                    <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider block">
                                        FASE KEHAMILAN
                                    </span>
                                    <span class="text-xs sm:text-[13px] font-bold text-slate-800 block mt-0.5">
                                        Protein Hewani Ganda & Kalsium
                                    </span>
                                </div>

                                <!-- Fase 6-23 Bulan -->
                                <div class="rounded-xl bg-slate-50/90 hover:bg-slate-100/90 transition p-2.5 sm:p-3 border border-slate-100">
                                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">
                                        FASE 6-23 BULAN
                                    </span>
                                    <span class="text-xs sm:text-[13px] font-bold text-slate-800 block mt-0.5">
                                        MPASI Padat Gizi (Telur, Ikan, Hati Ayam)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer link -->
                    <div class="pt-2 border-t border-slate-100">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-600 hover:text-brand-700 transition group/link">
                            <span>Akses Katalog Menu Gizi Lengkap</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: ANTARMUKA MODERN & RAMAH KELUARGA (PREVIEW DASHBOARD) -->
        <section id="dashboard-preview" class="mt-24 pt-4">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-blue-100/70 border border-blue-200/80 text-blue-600 text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                    ANTARMUKA MODERN & RAMAH KELUARGA
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-tight">
                    Semua Informasi Keluarga dalam Satu Tempat
                </h2>
                <p class="mt-3.5 text-slate-600 text-base sm:text-lg leading-relaxed">
                    Dashboard intuitif yang dirancang untuk kenyamanan orang tua: dari riwayat pemeriksaan antenatal care (ANC) hingga kurva perkembangan buah hati tercinta.
                </p>
            </div>

            <!-- Browser Window Mockup -->
            <div class="relative max-w-5xl mx-auto">
                <!-- Ambient aura glow behind window -->
                <div class="absolute inset-0 bg-gradient-to-r from-pink-200/40 via-purple-100/30 to-blue-200/40 rounded-[44px] filter blur-2xl transform scale-95 pointer-events-none"></div>

                <!-- Window Frame -->
                <div class="relative rounded-[32px] sm:rounded-[38px] bg-white border border-slate-200/90 shadow-2xl shadow-indigo-950/10 overflow-hidden">
                    
                    <!-- Browser Title Bar -->
                    <div class="px-5 py-3.5 bg-slate-50/90 border-b border-slate-200/70 flex items-center justify-between">
                        <!-- Traffic lights -->
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        </div>

                        <!-- URL Address Bar -->
                        <div class="flex items-center justify-center gap-2 px-4 py-1.5 bg-white border border-slate-200/80 rounded-full text-xs text-slate-500 font-medium max-w-sm w-full shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="truncate">app.nutrigrow.id/dashboard/keluarga-sarah</span>
                        </div>

                        <!-- Right User avatar icon -->
                        <div class="w-7 h-7 rounded-full bg-slate-200/70 text-slate-600 flex items-center justify-center text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Dashboard Inner View -->
                    <div class="p-6 sm:p-9 bg-[#fafbfc] space-y-6">
                        
                        <!-- Top Banner / Greeting -->
                        <div class="rounded-3xl bg-white border border-slate-200/70 p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <span class="text-[11px] font-bold text-brand-600 uppercase tracking-wider block mb-1">
                                    PORTAL KESEHATAN KELUARGA
                                </span>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-2">
                                    <span>Selamat Pagi, Ibu Sarah Permata</span>
                                    <span>👋</span>
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
                                    Status Profil: <strong class="text-slate-700">1 Kehamilan Aktif</strong> • <strong class="text-slate-700">1 Balita (Arkan, 24 Bulan)</strong>
                                </p>
                            </div>

                            <!-- Badges on Right -->
                            <div class="flex items-center gap-2.5">
                                <div class="px-3 py-1.5 rounded-full bg-pink-50 border border-pink-200/60 text-brand-600 text-xs font-semibold flex items-center gap-1.5">
                                    <span>🤰</span>
                                    <span>Janin (Mg 24)</span>
                                </div>
                                <div class="px-3 py-1.5 rounded-full bg-sky-50 border border-sky-200/60 text-sky-600 text-xs font-semibold flex items-center gap-1.5">
                                    <span>👶</span>
                                    <span>Arkan (24 Bln)</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3 Dashboard Metric Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            
                            <!-- Card 1: Perkembangan Janin -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-xs flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-bold text-slate-700">Perkembangan Janin</span>
                                        <span class="text-sm">❤️❤️</span>
                                    </div>
                                    <div class="text-2xl sm:text-[26px] font-extrabold text-slate-900 leading-tight">
                                        24 Minggu <span class="text-base text-slate-400 font-normal">/ 40 Mg</span>
                                    </div>
                                    <div class="text-xs text-rose-500 font-semibold mt-1">
                                        Perkiraan Lahir: 14 Juli 2025
                                    </div>
                                    <div class="w-full bg-pink-100 rounded-full h-2 mt-3 overflow-hidden">
                                        <div class="bg-gradient-to-r from-brand-500 to-pink-500 h-2 rounded-full w-[60%]"></div>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-medium">
                                    <span class="text-slate-500">Kenaikan BB Ibu:</span>
                                    <span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded">+6.5 kg (Ideal)</span>
                                </div>
                            </div>

                            <!-- Card 2: Tumbuh Kembang: Arkan -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-xs flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-bold text-slate-700">Tumbuh Kembang: Arkan</span>
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-200/60">
                                            Optimal
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <span class="text-[11px] text-slate-400 block font-medium">Tinggi Badan</span>
                                            <span class="text-xl font-extrabold text-slate-900 block mt-0.5">89.0 cm</span>
                                            <span class="text-[11px] text-emerald-600 font-semibold block mt-0.5">+1.5 cm bln ini</span>
                                        </div>
                                        <div>
                                            <span class="text-[11px] text-slate-400 block font-medium">Berat Badan</span>
                                            <span class="text-xl font-extrabold text-slate-900 block mt-0.5">12.2 kg</span>
                                            <span class="text-[11px] text-emerald-600 font-semibold block mt-0.5">Gizi Baik (KMS Hijau)</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-medium">
                                    <span class="text-slate-500">Lingkar Kepala:</span>
                                    <span class="text-slate-800 font-bold">48.2 cm (Normal)</span>
                                </div>
                            </div>

                            <!-- Card 3: Pemeriksaan Mendatang -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-xs flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-bold text-slate-700">Pemeriksaan Mendatang</span>
                                        <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Event Box -->
                                    <div class="rounded-xl bg-sky-50/80 border border-sky-100 p-3">
                                        <div class="font-bold text-xs sm:text-sm text-slate-900">🏥 Posyandu Mawar Melati</div>
                                        <div class="text-[11px] text-slate-500 mt-1 font-medium">Sabtu, 12 April 2025 • 08:30 WIB</div>
                                        <div class="text-[11px] text-sky-700 font-semibold mt-1">
                                            Agenda: Vitamin A & Imunisasi DPT Lanjutan
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('dashboard.pengguna') }}" class="w-full py-2.5 px-4 rounded-xl bg-pink-100/80 hover:bg-pink-200 text-brand-700 font-bold text-xs sm:text-sm text-center transition block">
                                    Buka Buku KIA Digital
                                </a>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- 2 FLOATING TRUST BADGES AT BOTTOM -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 max-w-4xl mx-auto">
                    <!-- Badge 1: Enkripsi Medis Terstandar -->
                    <div class="glass-card rounded-2xl p-3.5 sm:p-4 border border-pink-100/80 shadow-lg shadow-pink-900/5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-pink-100 text-brand-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900 leading-tight">Enkripsi Medis Terstandar</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                                Data kesehatan keluarga tersimpan aman sesuai regulasi Kemenkes.
                            </p>
                        </div>
                    </div>

                    <!-- Badge 2: Sinkronisasi Posyandu & PKM -->
                    <div class="glass-card rounded-2xl p-3.5 sm:p-4 border border-sky-100/80 shadow-lg shadow-sky-900/5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900 leading-tight">Sinkronisasi Posyandu & PKM</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                                Dapat ditautkan dengan catatan buku KIA cetak dan bidan desa.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: ALUR MUDAH & TERARAH (CARA KERJA 4 LANGKAH) -->
        <section id="cara-kerja" class="mt-24 pt-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block px-4 py-1.5 rounded-full bg-pink-100/70 border border-pink-200/80 text-brand-600 text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                    ALUR MUDAH & TERARAH
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-tight">
                    Mulai dari Langkah Sederhana
                </h2>
                <p class="text-slate-500 text-sm sm:text-base mt-3 leading-relaxed">
                    Hanya butuh beberapa menit untuk mengamankan data dan memantau masa depan tumbuh kembang buah hati Anda.
                </p>
            </div>

            <!-- 4 Step Cards with Subtle Flow Connectors -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                
                <!-- STEP 01 -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-xl shadow-slate-900/5 flex flex-col justify-between hover:shadow-2xl hover:-translate-y-1 transition duration-300 relative group">
                    <div>
                        <!-- Number Badge -->
                        <div class="w-12 h-12 rounded-2xl bg-brand-500 text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-pink-500/25 group-hover:scale-105 transition-transform duration-300">
                            01
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5">
                            Buat Akun
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Daftar gratis hanya dengan nomor ponsel atau email. Akun keluarga terenkripsi dan terlindungi penuh.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-rose-500">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Aman & Gratis</span>
                    </div>
                </div>

                <!-- STEP 02 -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-xl shadow-slate-900/5 flex flex-col justify-between hover:shadow-2xl hover:-translate-y-1 transition duration-300 relative group">
                    <div>
                        <!-- Number Badge -->
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-105 transition-transform duration-300">
                            02
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5">
                            Lengkapi Profil
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Masukkan data fase keluarga: perencanaan pra-hamil, trimester kehamilan ibu, atau identitas anak balita.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-blue-600">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Kustomisasi Fase</span>
                    </div>
                </div>

                <!-- STEP 03 -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-xl shadow-slate-900/5 flex flex-col justify-between hover:shadow-2xl hover:-translate-y-1 transition duration-300 relative group">
                    <div>
                        <!-- Number Badge -->
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:scale-105 transition-transform duration-300">
                            03
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5">
                            Pantau Pemeriksaan
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Catat atau sinkronkan hasil pengukuran Posyandu, Puskesmas, atau dokter spesialis anak ke dalam buku KIA digital.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Update Rutin Tiap Bulan</span>
                    </div>
                </div>

                <!-- STEP 04 -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-xl shadow-slate-900/5 flex flex-col justify-between hover:shadow-2xl hover:-translate-y-1 transition duration-300 relative group">
                    <div>
                        <!-- Number Badge -->
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-105 transition-transform duration-300">
                            04
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5">
                            Dapatkan Informasi
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Terima rekomendasi gizi personal, visualisasi kurva KMS WHO, serta notifikasi pencegahan risiko stunting otomatis.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>Deteksi Dini Cepat</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: EDUKASI GIZI KELUARGA (ARTIKEL & PANDUAN DOKTER) -->
        <section id="edukasi-gizi" class="mt-28 pt-8">
            <!-- Header Row with Title on Left and "Lihat Semua" Link on Right -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-pink-100/70 border border-pink-200/80 text-brand-600 text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                        EDUKASI GIZI KELUARGA
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-tight">
                        Belajar Gizi, Mulai dari Sekarang
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-base mt-2.5 max-w-2xl leading-relaxed">
                        Kumpulan panduan teruji klinis yang disusun bersama dokter spesialis gizi klinik dan dokter spesialis anak untuk mendampingi setiap tahapan 1.000 HPK.
                    </p>
                </div>

                <a href="#edukasi-gizi" class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-600 hover:text-brand-700 transition flex-shrink-0 group">
                    <span>Lihat Semua Edukasi Gizi</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

            <!-- 3 Article Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-7">
                
                <!-- ARTICLE 1: PRA-HAMIL -->
                <article class="bg-white rounded-[28px] sm:rounded-[32px] p-4 sm:p-5 border border-slate-100 shadow-xl shadow-slate-900/5 hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-sky-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/edukasi-pra-hamil.jpg') }}" 
                                alt="Mengenal Persiapan Gizi Sebelum Kehamilan" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-103 transition duration-700 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-sky-600 text-xs font-bold border border-sky-100 shadow-xs">
                                Pra-Hamil
                            </span>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium mb-2.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                            </svg>
                            <span>4 Menit Baca • Dr. dr. Anita Sp.GK</span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-brand-600 transition-colors">
                            Mengenal Persiapan Gizi Sebelum Kehamilan
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Pentingnya cadangan asam folat dan kadar hemoglobin normal untuk mempersiapkan sel telur berkualitas dan mencegah cacat tabung saraf janin.
                        </p>
                    </div>

                    <!-- Read Link -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-brand-600 group-hover:text-brand-700 transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </article>

                <!-- ARTICLE 2: HAMIL -->
                <article class="bg-white rounded-[28px] sm:rounded-[32px] p-4 sm:p-5 border border-slate-100 shadow-xl shadow-slate-900/5 hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-rose-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/edukasi-hamil.jpg') }}" 
                                alt="Memahami Kebutuhan Gizi Selama Kehamilan" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-103 transition duration-700 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-rose-600 text-xs font-bold border border-rose-100 shadow-xs">
                                Hamil
                            </span>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center gap-2 text-xs text-slate-400 font-medium mb-2.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                            <span>6 Menit Baca • dr. Maya Sp.OG</span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-brand-600 transition-colors">
                            Memahami Kebutuhan Gizi Selama Kehamilan
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Mengapa protein hewani ganda (seperti telur dan ikan laut) sangat krusial dalam pembentukan sel saraf dan plasenta di trimester 1 hingga 3.
                        </p>
                    </div>

                    <!-- Read Link -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-brand-600 group-hover:text-brand-700 transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </article>

                <!-- ARTICLE 3: ANAK (0-2 TAHUN) -->
                <article class="bg-white rounded-[28px] sm:rounded-[32px] p-4 sm:p-5 border border-slate-100 shadow-xl shadow-slate-900/5 hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-emerald-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/edukasi-anak.jpg') }}" 
                                alt="Mengenal Pertumbuhan dan Gizi Anak" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-103 transition duration-700 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-emerald-700 text-xs font-bold border border-emerald-100 shadow-xs">
                                Anak (0-2 Tahun)
                            </span>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium mb-2.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                            </svg>
                            <span>5 Menit Baca • dr. Budi Santoso Sp.A</span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-brand-600 transition-colors">
                            Mengenal Pertumbuhan dan Gizi Anak
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Panduan tekstur dan makronutrien MPASI padat energi untuk memastikan berat badan anak naik sesuai kurva tanpa mengalami stunting.
                        </p>
                    </div>

                    <!-- Read Link -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-brand-600 group-hover:text-brand-700 transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </article>

            </div>
        </section>

        <!-- FINAL CTA SECTION: LANGKAH KECIL HARI INI -->
        <section id="cta-final" class="mt-24 pb-12">
            <div class="relative rounded-[36px] sm:rounded-[44px] overflow-hidden bg-white/80 backdrop-blur-md border border-slate-200/80 shadow-2xl shadow-slate-900/5 p-8 sm:p-14 lg:p-16 text-center">
                <!-- Ambient background glows inside the CTA card -->
                <div class="absolute -top-12 -left-12 w-80 h-80 bg-gradient-to-br from-pink-200/70 via-rose-100/50 to-transparent rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -right-16 w-96 h-96 bg-gradient-to-bl from-blue-200/60 via-sky-100/40 to-transparent rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-1/2 right-16 w-48 h-48 bg-purple-100/40 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-50/90 border border-amber-200/70 text-amber-600 text-xs font-bold uppercase tracking-wider mb-6 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-amber-500 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/>
                        </svg>
                        <span>BERGABUNG DENGAN 10.000+ KELUARGA SEHAT</span>
                    </div>

                    <!-- Headline -->
                    <h2 class="text-3xl sm:text-4xl lg:text-[46px] font-extrabold text-slate-900 tracking-tight leading-[1.18] mb-5">
                        Langkah Kecil Hari Ini, untuk<br class="hidden sm:inline"> Keluarga yang Lebih Sehat
                    </h2>

                    <!-- Subtext -->
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8 max-w-xl mx-auto">
                        Mulai pantau kesehatan keluarga dan temukan informasi yang mendukung pencegahan stunting sejak dini. Gratis, mudah, dan didukung standar medis terpercaya.
                    </p>

                    <!-- Buttons Row -->
                    <div class="flex flex-wrap items-center justify-center gap-4 mb-6">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 sm:py-4 rounded-full text-sm sm:text-base font-bold text-white bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 hover:from-brand-700 hover:to-pink-600 shadow-xl shadow-pink-500/25 hover:shadow-2xl hover:shadow-pink-500/35 transition-all transform hover:-translate-y-0.5">
                            <span>Daftar Sekarang &mdash; Gratis</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <a href="#fitur" class="px-8 py-3.5 sm:py-4 rounded-full text-sm sm:text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 shadow-2xs hover:shadow-md transition-all">
                            Konsultasi Fitur
                        </a>
                    </div>

                    <!-- Fine print -->
                    <p class="text-xs text-slate-400 font-medium">
                        Tanpa biaya berlangganan. Akses penuh grafik tumbuh kembang anak dan reminder kehamilan.
                    </p>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 bg-white border-t border-slate-200/80 mt-20 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <!-- Top Footer Grid: 4 columns -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 mb-16">

                <!-- Col 1: Brand (spans 4) -->
                <div class="lg:col-span-4">
                    <!-- Logo -->
                    <div class="flex items-center gap-2 mb-2">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-8 sm:h-9 w-auto object-contain">
                    </div>
                    <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase mb-4">MATERNAL &amp; CHILD HEALTH CARE</p>
                    <p class="text-sm text-slate-500 leading-relaxed mb-6 max-w-sm">
                        Platform terpadu pemantauan gizi, kehamilan, dan tumbuh kembang anak berbasis standar WHO dan Kemenkes RI demi mewujudkan generasi bebas stunting di Indonesia.
                    </p>
                    <!-- Social Icons -->
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 rounded-full bg-pink-50 border border-pink-100/90 text-brand-500 hover:bg-brand-500 hover:text-white flex items-center justify-center transition shadow-2xs" title="Website">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-pink-50 border border-pink-100/90 text-brand-500 hover:bg-brand-500 hover:text-white flex items-center justify-center transition shadow-2xs" title="Bagikan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </a>
                        <a href="mailto:halo@nutrigrow.id" class="w-9 h-9 rounded-full bg-pink-50 border border-pink-100/90 text-brand-500 hover:bg-brand-500 hover:text-white flex items-center justify-center transition shadow-2xs" title="Email">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigasi (spans 2, col-start-6) -->
                <div class="lg:col-span-2 lg:col-start-6">
                    <h4 class="font-bold text-xs tracking-wider uppercase text-slate-900 mb-5">NAVIGASI</h4>
                    <ul class="space-y-3.5">
                        <li><a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Fitur Utama</a></li>
                        <li><a href="#dashboard-preview" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Aplikasi Digital</a></li>
                        <li><a href="#cara-kerja" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Cara Kerja</a></li>
                        <li><a href="#edukasi-gizi" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Edukasi Gizi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan NutriGrow (spans 3) -->
                <div class="lg:col-span-3">
                    <h4 class="font-bold text-xs tracking-wider uppercase text-slate-900 mb-5">LAYANAN NUTRIGROW</h4>
                    <ul class="space-y-3.5">
                        <li><a href="{{ route('register') }}" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Pemantauan Kehamilan (ANC)</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Kurva Pertumbuhan WHO Digital</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Monitoring Risiko Stunting</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Katalog Menu MPASI Bergizi</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-slate-500 hover:text-brand-600 transition-colors">Sinkronisasi Posyandu</a></li>
                    </ul>
                </div>

                <!-- Col 4: Bantuan & Regulasi (spans 3) -->
                <div class="lg:col-span-3">
                    <h4 class="font-bold text-xs tracking-wider uppercase text-slate-900 mb-5">BANTUAN &amp; REGULASI</h4>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded bg-pink-50 text-brand-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <a href="mailto:halo@nutrigrow.id" class="text-sm text-slate-600 hover:text-brand-600 transition-colors">halo@nutrigrow.id</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded bg-pink-50 text-brand-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-slate-600">0800&ndash;123&ndash;GROW (Bebas Pulsa)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm text-slate-600 leading-snug">Sesuai Pedoman Antropometri Kemenkes RI No. 2 Tahun 2020</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Footer Bar -->
            <div class="border-t border-slate-200/80 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <span>&copy; 2025 NutriGrow Indonesia. Hak Cipta Dilindungi.</span>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="#" class="hover:text-brand-600 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-brand-600 transition-colors">Syarat &amp; Ketentuan</a>
                    <span class="font-semibold text-brand-600">Menuju Generasi Emas Bebas Stunting 2045</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>