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
                            50: '#fff0f6',
                            100: '#ffe4ee',
                            200: '#ffd0e2',
                            300: '#ffb0ce',
                            400: '#ff80b3',
                            500: '#ff539b',
                            600: '#e63b82',
                            700: '#c2246b',
                            800: '#991147',
                            900: '#7a0b38',
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
            background-color: #fdf7fb;
            color: #1e293b;
            overflow-x: clip;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* 1. Gentle Floating Hero Family */
        @keyframes heroFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-9px); }
        }
        .animate-hero-float {
            animation: heroFloat 5.5s ease-in-out infinite;
            will-change: transform;
        }

        /* Floating Micro-Widgets (Matching Reference Mockup) */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7px); }
        }
        @keyframes floatMedium {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-9px); }
        }
        @keyframes floatFast {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        .animate-float-slow {
            animation: floatSlow 6s ease-in-out infinite;
            will-change: transform;
        }
        .animate-float-medium {
            animation: floatMedium 5s ease-in-out infinite 0.6s;
            will-change: transform;
        }
        .animate-float-fast {
            animation: floatFast 5.5s ease-in-out infinite 1.2s;
            will-change: transform;
        }

        /* 3. Playful Floating & Tilting Heart */
        @keyframes heartFloat {
            0%, 100% { transform: translateY(0px) rotate(-14deg) scale(1); }
            35% { transform: translateY(-10px) rotate(-6deg) scale(1.08); }
            70% { transform: translateY(-4px) rotate(-18deg) scale(1.02); }
        }
        .animate-heart-float {
            animation: heartFloat 3.8s ease-in-out infinite;
            will-change: transform;
        }

        /* 4. Cute Beating Heart for Pill */
        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            14% { transform: scale(1.3); }
            28% { transform: scale(1); }
            42% { transform: scale(1.22); }
            70% { transform: scale(1); }
        }
        .animate-heartbeat {
            animation: heartBeat 2s ease-in-out infinite;
            display: inline-block;
            transform-origin: center;
        }

        /* 5. Twinkling Sparkle Rays */
        @keyframes sparkleTwinkle {
            0%, 100% { transform: scale(1) rotate(0deg); opacity: 1; }
            50% { transform: scale(1.2) rotate(8deg); opacity: 0.85; }
        }
        .animate-sparkle {
            animation: sparkleTwinkle 3.2s ease-in-out infinite;
            transform-origin: center;
            display: inline-block;
        }

        /* 6. Floating Twinkle Star */
        @keyframes twinkleStar {
            0%, 100% { opacity: 0.3; transform: scale(0.8) rotate(0deg); }
            50% { opacity: 1; transform: scale(1.2) rotate(45deg); }
        }
        .animate-twinkle {
            animation: twinkleStar 2.6s ease-in-out infinite;
        }

        /* 7. Playful Ringing Bell on Hover */
        @keyframes bellRing {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(18deg); }
            40% { transform: rotate(-16deg); }
            60% { transform: rotate(12deg); }
            80% { transform: rotate(-8deg); }
        }
        .group:hover .group-hover-bell-ring {
            animation: bellRing 0.8s ease-in-out;
            transform-origin: top center;
        }

        /* 8. Shimmer Gleam Effect on Primary Button */
        @keyframes buttonShimmer {
            0% { transform: translateX(-150%) skewX(-20deg); }
            25%, 100% { transform: translateX(250%) skewX(-20deg); }
        }
        .shimmer-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: buttonShimmer 4.5s infinite;
            pointer-events-none;
        }

        /* 9. Smooth Staggered Entrance Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .anim-fade-in-1 { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .anim-fade-in-2 { animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both; }
        .anim-fade-in-3 { animation: fadeInUp 0.75s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both; }
        .anim-fade-in-4 { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both; }
    </style>
</head>
<body class="text-slate-800 antialiased relative min-h-screen flex flex-col justify-between selection:bg-[#FF539B] selection:text-white overflow-x-clip">

    <!-- MAIN NAVBAR (Sticky Floating White Pill with Glass Effect on Scroll) -->
    <header class="sticky top-0 z-50 w-full pt-3 sm:pt-4 pb-2 px-4 sm:px-6 lg:px-8 xl:px-10 max-w-7xl xl:max-w-[1400px] 2xl:max-w-[1520px] mx-auto anim-fade-in-1 transition-all duration-300">
        <nav id="navbar-pill" class="bg-white/95 backdrop-blur-md rounded-full px-5 sm:px-8 lg:px-10 py-3 sm:py-3.5 shadow-sm hover:shadow-md transition-all duration-300 border border-pink-100/70 flex items-center justify-between">
            <!-- Brand / Logo (Left) -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 group flex-shrink-0">
                <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain transition-transform duration-300 group-hover:scale-105" onerror="this.onerror=null; this.src='{{ asset('images/nutrigrow-icon.png') }}';">
            </a>

            <!-- Right Group: Navigation Links (shifted to right near Masuk) + Action Buttons -->
            <div class="flex items-center gap-6 sm:gap-8 lg:gap-10">
                <!-- Navigation Links with Dynamic ScrollSpy Indicator -->
                <div class="hidden md:flex items-center gap-6 lg:gap-8 text-[14px]">
                    <a href="#beranda" id="nav-beranda" class="nav-item font-bold text-[#FF539B] relative py-1 transition-colors duration-200 group">
                        <span>Beranda</span>
                        <span class="indicator block h-[2.5px] w-6 bg-[#FF539B] rounded-full mx-auto mt-0.5 transition-all duration-300 origin-center"></span>
                    </a>
                    <a href="#fitur" id="nav-fitur" class="nav-item font-medium text-slate-700 hover:text-[#FF539B] relative py-1 transition-colors duration-200 group">
                        <span>Fitur</span>
                        <span class="indicator block opacity-0 scale-x-0 h-[2.5px] w-6 bg-[#FF539B] rounded-full mx-auto mt-0.5 transition-all duration-300 origin-center"></span>
                    </a>
                    <a href="#edukasi-gizi" id="nav-informasi" class="nav-item font-medium text-slate-700 hover:text-[#FF539B] relative py-1 transition-colors duration-200 group">
                        <span>Informasi</span>
                        <span class="indicator block opacity-0 scale-x-0 h-[2.5px] w-6 bg-[#FF539B] rounded-full mx-auto mt-0.5 transition-all duration-300 origin-center"></span>
                    </a>
                    <a href="#cara-kerja" id="nav-tentang" class="nav-item font-medium text-slate-700 hover:text-[#FF539B] relative py-1 transition-colors duration-200 group">
                        <span>Tentang</span>
                        <span class="indicator block opacity-0 scale-x-0 h-[2.5px] w-6 bg-[#FF539B] rounded-full mx-auto mt-0.5 transition-all duration-300 origin-center"></span>
                    </a>
                </div>

                <!-- Right Action Buttons: Masuk (Soft Pink Pill, Dark Pink on Hover) & Daftar -->
                <div class="flex items-center gap-2.5 sm:gap-3 flex-shrink-0">
                    <a href="{{ route('login') }}" class="font-bold text-[#FF539B] bg-pink-100/70 hover:bg-[#E63B82] hover:text-white border border-pink-200/60 hover:border-[#E63B82] text-xs sm:text-sm px-4 sm:px-5 py-2 sm:py-2.5 rounded-full transition-all duration-200 transform hover:-translate-y-0.5 shadow-2xs hover:shadow-md hover:shadow-pink-500/20">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="group relative overflow-hidden inline-flex items-center gap-1.5 px-5 sm:px-6 py-2 sm:py-2.5 rounded-full bg-[#FF539B] hover:bg-[#E63B82] text-white text-xs sm:text-sm font-bold shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-pink-500/30 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                        <span class="shimmer-glow"></span>
                        <span class="relative z-10">Daftar</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform duration-200 relative z-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- HERO SECTION (Matching Mockup with Engaging Micro-Interactions) -->
    <main id="beranda" class="relative z-10 w-full max-w-7xl xl:max-w-[1400px] 2xl:max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 pt-8 sm:pt-14 pb-12 flex-1 scroll-mt-28">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12 items-center">
            
            <!-- LEFT COLUMN: CONTENT -->
            <div class="lg:col-span-7 space-y-5 sm:space-y-6 text-left anim-fade-in-2">
                <!-- Badge Pill: Untuk Tumbuh Kembang Anak yang Lebih Baik (with Beating Heart) -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-pink-100/70 border border-pink-200/60 text-[#FF539B] text-xs sm:text-[13px] font-semibold shadow-2xs hover:bg-pink-100/90 transition-colors cursor-default">
                    <svg class="w-3.5 h-3.5 text-[#FF539B] fill-current animate-heartbeat" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span>Untuk Tumbuh Kembang Anak yang Lebih Baik</span>
                </div>

                <!-- Main Heading: Tumbuh Sehat, Bersama NutriGrow + Twinkling Sparkle Rays -->
                <h1 class="text-4xl sm:text-5xl lg:text-[54px] xl:text-[62px] font-extrabold text-slate-900 tracking-tight leading-[1.12]">
                    <span>Tumbuh Sehat,</span>
                    <!-- Sparkle Rays Accent with Twinkle Animation -->
                    <span class="inline-block relative ml-1.5 -top-2 align-middle text-[#FF539B] group/sparkle cursor-pointer">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 inline-block animate-sparkle group-hover/sparkle:rotate-45 transition-transform duration-300" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round">
                            <line x1="8" y1="22" x2="14" y2="8" />
                            <line x1="16" y1="24" x2="26" y2="14" />
                            <line x1="14" y1="28" x2="28" y2="24" />
                        </svg>
                    </span>
                    <br>
                    <span>Bersama </span>
                    <span class="text-[#FF539B] hover:text-[#E63B82] transition-colors">NutriGrow</span>
                </h1>

                <!-- Subtitle / Paragraph -->
                <p class="text-slate-500 text-sm sm:text-base lg:text-lg leading-relaxed max-w-xl">
                    Pantau kesehatan keluarga dan si kecil dengan mudah melalui informasi yang akurat dan terpercaya.
                </p>

                <!-- Action CTA Buttons (with Shimmer Gleam & Hover Slides) -->
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 pt-1">
                    <a href="{{ route('register') }}" class="group relative overflow-hidden inline-flex items-center gap-2 px-7 py-3.5 sm:px-8 sm:py-4 rounded-full text-sm sm:text-base font-bold text-white bg-[#FF539B] hover:bg-[#E63B82] shadow-md shadow-pink-500/25 hover:shadow-xl hover:shadow-pink-500/35 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                        <!-- Shimmer Light Gleam -->
                        <span class="shimmer-glow"></span>
                        <span class="relative z-10">Mulai Sekarang</span>
                        <svg class="w-4 h-4 relative z-10 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>

                    <a href="#fitur" class="group inline-flex items-center gap-1.5 text-sm sm:text-base font-bold text-slate-800 hover:text-[#FF539B] transition-colors py-2">
                        <span>Pelajari Lebih Lanjut</span>
                        <svg class="w-4 h-4 text-slate-600 group-hover:text-[#FF539B] transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- RIGHT COLUMN: ORGANIC FAMILY ILLUSTRATION (WITH FLOATING HEART & TWINKLE) -->
            <div class="lg:col-span-5 relative mt-6 lg:mt-0 flex justify-center items-center anim-fade-in-3">
                <!-- Tiny floating twinkle stars -->
                <div class="absolute -top-4 right-10 sm:right-16 text-[#FF539B] animate-twinkle pointer-events-none z-20">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5z"/>
                    </svg>
                </div>
                <div class="absolute top-16 -left-3 sm:-left-5 text-pink-400 animate-twinkle pointer-events-none z-20" style="animation-delay: 1.3s;">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5z"/>
                    </svg>
                </div>

                <!-- Family Photo with Soft Floating Animation -->
                <div class="relative w-full max-w-[460px] sm:max-w-[520px] lg:max-w-[580px] xl:max-w-[640px] animate-hero-float">
                    <img 
                        src="{{ asset('images/hero-family-organic.png') }}" 
                        alt="Tumbuh Sehat Bersama NutriGrow" 
                        class="w-full h-auto object-contain select-none pointer-events-none drop-shadow-xs transform hover:scale-[1.02] transition-transform duration-500"
                        onerror="this.onerror=null; this.src='{{ asset('images/family-hero.png') }}';"
                    />
                </div>
            </div>

        </div>

        <!-- 3 HIGHLIGHT FEATURE CARDS BAR (FLOATING WHITE CONTAINER WITH INTERACTIVE HOVERS) -->
        <section id="fitur" class="mt-14 sm:mt-20 pt-2 anim-fade-in-4 scroll-mt-28">
            <div class="bg-white rounded-[28px] sm:rounded-[36px] p-5 sm:p-7 lg:p-8 shadow-[0_10px_35px_rgba(225,29,72,0.05)] border border-pink-100/60 grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-8">
                
                <!-- Highlight 1: Pantau Kesehatan Keluarga (Playful Baby Wiggle on Hover) -->
                <div class="flex items-center gap-4 group p-3 sm:p-3.5 rounded-2xl hover:bg-pink-50/50 hover:shadow-xs transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-2xl bg-pink-50 text-[#FF539B] flex items-center justify-center flex-shrink-0 border border-pink-100/70 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300 shadow-2xs">
                        <svg class="w-6 h-6 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="13" r="8" />
                            <path d="M12 5c-1 0-2 .8-2 2a2 2 0 0 0 4 0c0-1.2-1-2-2-2z" />
                            <circle cx="9.5" cy="12.5" r="0.75" fill="currentColor" />
                            <circle cx="14.5" cy="12.5" r="0.75" fill="currentColor" />
                            <path d="M10 16a2.5 2.5 0 0 0 4 0" />
                            <path d="M4 13a2 2 0 0 1-2-2" />
                            <path d="M20 13a2 2 0 0 0 2-2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug group-hover:text-[#FF539B] transition-colors">
                            Pantau Kesehatan Keluarga
                        </h3>
                        <p class="text-xs sm:text-[13px] text-slate-500 mt-0.5 leading-relaxed">
                            Cek pertumbuhan dan kesehatan anak dengan mudah.
                        </p>
                    </div>
                </div>

                <!-- Highlight 2: Pengingat Pemeriksaan (Ringing Bell Animation on Hover) -->
                <div class="flex items-center gap-4 group p-3 sm:p-3.5 rounded-2xl hover:bg-sky-50/50 hover:shadow-xs transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center flex-shrink-0 border border-sky-100/70 group-hover:scale-110 transition-transform duration-300 shadow-2xs">
                        <svg class="w-6 h-6 group-hover-bell-ring" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug group-hover:text-sky-600 transition-colors">
                            Pengingat Pemeriksaan
                        </h3>
                        <p class="text-xs sm:text-[13px] text-slate-500 mt-0.5 leading-relaxed">
                            Dapatkan notifikasi untuk jadwal pemeriksaan.
                        </p>
                    </div>
                </div>

                <!-- Highlight 3: Informasi Gizi & Pertumbuhan (Chart Lift on Hover) -->
                <div class="flex items-center gap-4 group p-3 sm:p-3.5 rounded-2xl hover:bg-amber-50/50 hover:shadow-xs transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0 border border-amber-100/70 group-hover:scale-110 group-hover:-translate-y-1 transition-transform duration-300 shadow-2xs">
                        <svg class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <rect x="3" y="14" width="4" height="7" rx="1" />
                            <rect x="10" y="10" width="4" height="11" rx="1" />
                            <rect x="17" y="6" width="4" height="15" rx="1" />
                            <path d="M5 10l5-4 5 2 5-5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug group-hover:text-amber-600 transition-colors">
                            Informasi Gizi &amp; Pertumbuhan
                        </h3>
                        <p class="text-xs sm:text-[13px] text-slate-500 mt-0.5 leading-relaxed">
                            Akses panduan gizi dan tips perkembangan anak.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: FITUR UNGGULAN NUTRIGROW (DUKUNGAN MENYELURUH DI TIAP FASE KEHIDUPAN) -->
        <section id="fitur-unggulan" class="mt-20 pt-4">
            <!-- Section Header (Matching Mockup with Pink Sparkle Rays) -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-pink-100/70 border border-pink-200/60 text-[#FF539B] text-xs sm:text-[13px] font-bold mb-3 shadow-2xs">
                    Fitur Unggulan NutriGrow
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-slate-900 tracking-tight leading-tight">
                    <span>Dukungan Menyeluruh di </span>
                    <span class="text-[#FF539B]">Tiap Fase</span>
                    <span> Kehidupan</span>
                    <!-- Twinkling Sparkle Rays Accent -->
                    <span class="inline-block relative ml-1 -top-2 align-middle text-[#FF539B] group/sparkle cursor-pointer">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 inline-block animate-sparkle group-hover/sparkle:rotate-45 transition-transform duration-300" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round">
                            <line x1="8" y1="22" x2="14" y2="8" />
                            <line x1="16" y1="24" x2="26" y2="14" />
                            <line x1="14" y1="28" x2="28" y2="24" />
                        </svg>
                    </span>
                </h2>
                <p class="mt-3.5 text-slate-600 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                    Dari persiapan kehamilan hingga tumbuh kembang anak, NutriGrow membantu keluarga memahami informasi kesehatan dengan lebih mudah, akurat, dan terarah.
                </p>
            </div>

            <!-- Two Featured Cards Grid (Matching Mockup: Pure White Cards with Soft Borders & Micro-Animations) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-8">

                <!-- CARD 1: PEMANTAUAN KEHAMILAN TERPADU -->
                <div class="rounded-[32px] sm:rounded-[36px] bg-white border border-pink-100/80 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-1.5 group">
                    <div>
                        <!-- Icon (Pink rounded squircle with pregnant mother silhouette) -->
                        <div class="w-14 h-14 rounded-2xl bg-pink-100/80 text-[#FF539B] flex items-center justify-center border border-pink-200/60 shadow-2xs group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="4" r="2.2"/>
                                <path d="M14.2 8.2c-.3-.5-.9-.8-1.5-.8h-1.4c-.6 0-1.2.3-1.5.8L7.8 12.2c-.3.5-.2 1.1.3 1.4.5.3 1.1.2 1.4-.3l1.5-2.6v7.8c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-4.5h.6v4.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-6.2c1.2-.4 2-1.5 2-2.8 0-1.1-.6-2.1-1.5-2.6L14.2 8.2z"/>
                            </svg>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 mt-5 mb-2.5 tracking-tight group-hover:text-[#FF539B] transition-colors">
                            Pemantauan Kehamilan Terpadu
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                            Pantau usia gestasi, pertumbuhan berat badan ideal ibu hamil sesuai IMT pra-kehamilan, kepatuhan asupan 90 tablet tambah darah (TTD), serta jadwal USG trimester.
                        </p>

                        <!-- Two-Column Inner Widget: Timeline Box on Left & Pregnant Mother on Right -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-5 items-center my-6">
                            <!-- Left Column: Timeline & Checklist Widget -->
                            <div class="sm:col-span-7 bg-white rounded-2xl p-4 sm:p-5 border border-pink-100/80 shadow-xs space-y-3.5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#FF539B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span class="font-bold text-xs sm:text-sm text-slate-800">Timeline Trimester 2</span>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full bg-pink-100 text-[#FF539B] text-[11px] font-bold">
                                        Minggu 24
                                    </span>
                                </div>

                                <!-- Progress bar -->
                                <div class="w-full bg-pink-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-[#FF539B] to-pink-500 h-2 rounded-full w-[60%]"></div>
                                </div>

                                <!-- Checklist items -->
                                <div class="space-y-2 pt-1">
                                    <div class="flex items-center gap-2 text-xs sm:text-[13px] text-slate-700">
                                        <div class="w-4 h-4 rounded-full bg-[#FF539B] text-white flex items-center justify-center flex-shrink-0">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <span>Asupan TTD Hari Ini: <strong class="text-slate-900 font-bold">Tercatat</strong></span>
                                    </div>

                                    <div class="flex items-center gap-2 text-xs sm:text-[13px] text-slate-700">
                                        <div class="w-4 h-4 rounded-full bg-[#FF539B] text-white flex items-center justify-center flex-shrink-0">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <span>USG Anomali : <strong class="text-slate-900 font-bold">Terjadwal (Mg 26)</strong></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Cropped Pregnant Mother Image + Floating Heart -->
                            <div class="sm:col-span-5 relative flex items-center justify-center">
                                <!-- Floating Cute Pink Heart -->
                                <div class="absolute -top-3 left-2 sm:-left-1 animate-heart-float pointer-events-none">
                                    <svg class="w-6 h-6 text-pink-400 fill-current opacity-80" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </div>
                                <img 
                                    src="{{ asset('images/card-pregnant-mother.png') }}" 
                                    alt="Pemantauan Kehamilan Ibu" 
                                    class="w-auto h-44 sm:h-52 object-contain group-hover:scale-105 transition-transform duration-300"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Row -->
                    <div class="pt-4 border-t border-pink-100/70">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm sm:text-base font-bold text-[#FF539B] hover:text-[#E63B82] transition group/link">
                            <span>Pelajari Selengkapnya</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- CARD 2: TUMBUH KEMBANG ANAK -->
                <div class="rounded-[32px] sm:rounded-[36px] bg-white border border-sky-100/80 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-sky-500/10 hover:-translate-y-1.5 group">
                    <div>
                        <!-- Icon (Sky blue rounded squircle with smiling baby face) -->
                        <div class="w-14 h-14 rounded-2xl bg-sky-100/80 text-[#0284c7] flex items-center justify-center border border-sky-200/60 shadow-2xs group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M9 10h.01M15 10h.01"/>
                                <path d="M9.5 15a3.5 3.5 0 005 0"/>
                                <path d="M3 12c-1 0-1.5-.5-1.5-1.5S2 9 3 9M21 12c1 0 1.5-.5 1.5-1.5S22 9 21 9"/>
                                <path d="M12 3c0-1.5 1-2 2-2"/>
                            </svg>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 mt-5 mb-2.5 tracking-tight group-hover:text-[#0284c7] transition-colors">
                            Tumbuh Kembang Anak
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                            Visualisasi kurva KMS digital real-time: tinggi badan menurut umur (TB/U), berat badan (BB/U), dan lingkar kepala standar WHO 2006.
                        </p>

                        <!-- Two-Column Inner Widget: Height Ruler Photo on Left & Height/Z-Score Badges on Right -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-5 items-center my-6">
                            <!-- Left Column: Child Standing next to Height Ruler Image -->
                            <div class="sm:col-span-6 rounded-2xl overflow-hidden border border-slate-100 shadow-xs flex items-center justify-center bg-slate-50">
                                <img 
                                    src="{{ asset('images/card-child-height.png') }}" 
                                    alt="Pengukuran Tinggi Anak" 
                                    class="w-full h-44 sm:h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                            </div>

                            <!-- Right Column: Height Badge & Z-Score Normal Badge -->
                            <div class="sm:col-span-6 space-y-3.5">
                                <!-- Tinggi Terakhir Badge Card -->
                                <div class="bg-[#f0f9ff] border border-sky-200/70 rounded-2xl p-3.5 sm:p-4 flex items-center gap-3 shadow-2xs group-hover:translate-x-1 transition-transform duration-300">
                                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-[#0284c7] flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-semibold text-slate-500 block leading-tight">Tinggi Terakhir</span>
                                        <span class="text-base sm:text-lg font-extrabold text-slate-900 block leading-tight mt-0.5">89 cm</span>
                                    </div>
                                </div>

                                <!-- Normal Z-Score Badge Card -->
                                <div class="bg-[#ecfdf5] border border-emerald-200/70 rounded-2xl p-3.5 sm:p-4 flex items-center gap-3 shadow-2xs group-hover:translate-x-1 transition-transform duration-300">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm sm:text-[15px] font-extrabold text-emerald-800 block">Normal (Z -0.4)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Row -->
                    <div class="pt-4 border-t border-sky-100/70">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm sm:text-base font-bold text-[#0284c7] hover:text-[#0369a1] transition group/link">
                            <span>Pelajari Selengkapnya</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- CARD 3: MONITORING RISIKO STUNTING (TRIAGE CERDAS) -->
                <div class="rounded-[32px] sm:rounded-[36px] bg-white border border-emerald-100/80 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1.5 group">
                    <div>
                        <!-- Top Row (Icon & Badge) -->
                        <div class="flex items-center justify-between">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-100/80 text-emerald-600 flex items-center justify-center border border-emerald-200/60 shadow-2xs group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <span class="px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200/60 text-xs font-bold tracking-tight">
                                Deteksi Dini Cerdas
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 mt-5 mb-2.5 tracking-tight group-hover:text-emerald-600 transition-colors">
                            Monitoring Risiko Stunting
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            Algoritma skrining awal mengevaluasi tren berat badan dan tinggi secara periodik untuk mencegah kondisi faltering growth:
                        </p>

                        <!-- 3 Triage Status Boxes with Interactive Hover Feedback -->
                        <div class="space-y-3 mb-6">
                            <!-- Green Box -->
                            <div class="rounded-2xl bg-emerald-50/70 hover:bg-emerald-50 border border-emerald-200/70 p-3.5 sm:p-4 flex items-start gap-3 transition-transform duration-200 hover:translate-x-1 cursor-default">
                                <span class="w-3 h-3 rounded-full bg-emerald-500 flex-shrink-0 mt-1 shadow-xs animate-pulse"></span>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900">Risiko Rendah / Pertumbuhan Optimal</h4>
                                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                        Kenaikan tinggi & berat anak berada dalam rentang persentil hijau kurva WHO.
                                    </p>
                                </div>
                            </div>

                            <!-- Yellow Box -->
                            <div class="rounded-2xl bg-amber-50/70 hover:bg-amber-50 border border-amber-200/70 p-3.5 sm:p-4 flex items-start gap-3 transition-transform duration-200 hover:translate-x-1 cursor-default">
                                <span class="w-3 h-3 rounded-full bg-amber-500 flex-shrink-0 mt-1 shadow-xs"></span>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900">Risiko Sedang / Butuh Asupan Tambahan</h4>
                                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                        Berat badan melandai (weight faltering) 2 bulan berturut-turut, evaluasi menu MPASI.
                                    </p>
                                </div>
                            </div>

                            <!-- Red Box -->
                            <div class="rounded-2xl bg-rose-50/70 hover:bg-rose-50 border border-rose-200/70 p-3.5 sm:p-4 flex items-start gap-3 transition-transform duration-200 hover:translate-x-1 cursor-default">
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
                    <div class="pt-4 border-t border-emerald-100/70">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm sm:text-base font-bold text-emerald-600 hover:text-emerald-700 transition group/link">
                            <span>Pelajari Alur Skrining Medis</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- CARD 4: REKOMENDASI NUTRISI SESUAI USIA -->
                <div id="rekomendasi-nutrisi" class="rounded-[32px] sm:rounded-[36px] bg-white border border-pink-100/80 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-1.5 group">
                    <div>
                        <!-- Top Row (Icon) -->
                        <div class="flex items-center justify-between">
                            <div class="w-14 h-14 rounded-2xl bg-pink-100/80 text-[#FF539B] flex items-center justify-center border border-pink-200/60 shadow-2xs group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
                                </svg>
                            </div>
                            <span class="px-3.5 py-1 rounded-full bg-pink-50 text-[#FF539B] border border-pink-200/60 text-xs font-bold tracking-tight">
                                Gizi 1.000 HPK
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 mt-5 mb-2.5 tracking-tight group-hover:text-[#FF539B] transition-colors">
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

                            <!-- Right: 3 Phases with Interactive Hover Feedback -->
                            <div class="sm:col-span-7 space-y-2.5">
                                <!-- Fase Pra-Hamil -->
                                <div class="rounded-xl bg-pink-50/50 hover:bg-pink-50 transition-all duration-200 p-2.5 sm:p-3 border border-pink-100/70 hover:translate-x-1 cursor-default">
                                    <span class="text-[10px] font-bold text-[#FF539B] uppercase tracking-wider block">
                                        FASE PRA-HAMIL
                                    </span>
                                    <span class="text-xs sm:text-[13px] font-bold text-slate-800 block mt-0.5">
                                        Asam Folat 400 mcg & Zat Besi
                                    </span>
                                </div>

                                <!-- Fase Kehamilan -->
                                <div class="rounded-xl bg-rose-50/50 hover:bg-rose-50 transition-all duration-200 p-2.5 sm:p-3 border border-rose-100/70 hover:translate-x-1 cursor-default">
                                    <span class="text-[10px] font-bold text-[#FF539B] uppercase tracking-wider block">
                                        FASE KEHAMILAN
                                    </span>
                                    <span class="text-xs sm:text-[13px] font-bold text-slate-800 block mt-0.5">
                                        Protein Hewani Ganda & Kalsium
                                    </span>
                                </div>

                                <!-- Fase 6-23 Bulan -->
                                <div class="rounded-xl bg-emerald-50/50 hover:bg-emerald-50 transition-all duration-200 p-2.5 sm:p-3 border border-emerald-100/70 hover:translate-x-1 cursor-default">
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
                    <div class="pt-4 border-t border-pink-100/70">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm sm:text-base font-bold text-[#FF539B] hover:text-[#E63B82] transition group/link">
                            <span>Akses Katalog Menu Gizi Lengkap</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: ALUR MUDAH & TERARAH (CARA KERJA 4 LANGKAH) -->
        <section id="cara-kerja" class="mt-24 pt-8 scroll-mt-28">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block px-4 py-1.5 rounded-full bg-pink-100/70 border border-pink-200/60 text-[#FF539B] text-xs sm:text-[13px] font-bold mb-3 shadow-2xs">
                    Alur Mudah &amp; Terarah
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-slate-900 tracking-tight leading-tight">
                    <span>Mulai dari </span>
                    <span class="text-[#FF539B]">Langkah Sederhana</span>
                </h2>
                <p class="text-slate-500 text-sm sm:text-base mt-3 leading-relaxed">
                    Hanya butuh beberapa menit untuk mengamankan data dan memantau masa depan tumbuh kembang buah hati Anda.
                </p>
            </div>

            <!-- 4 Step Cards with Micro-Interactions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                
                <!-- STEP 01 -->
                <div class="bg-white rounded-[28px] sm:rounded-[32px] p-6 sm:p-7 border border-pink-100/60 shadow-md shadow-pink-500/5 flex flex-col justify-between hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300 relative group">
                    <div>
                        <!-- Number Badge with Hover Tilt -->
                        <div class="w-12 h-12 rounded-2xl bg-[#FF539B] text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-pink-500/25 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                            01
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5 group-hover:text-[#FF539B] transition-colors">
                            Buat Akun
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Daftar gratis hanya dengan nomor ponsel atau email. Akun keluarga terenkripsi dan terlindungi penuh.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-[#FF539B]">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Aman &amp; Gratis</span>
                    </div>
                </div>

                <!-- STEP 02 -->
                <div class="bg-white rounded-[28px] sm:rounded-[32px] p-6 sm:p-7 border border-sky-100/60 shadow-md shadow-sky-500/5 flex flex-col justify-between hover:shadow-2xl hover:shadow-sky-500/10 hover:-translate-y-2 transition-all duration-300 relative group">
                    <div>
                        <!-- Number Badge with Hover Tilt -->
                        <div class="w-12 h-12 rounded-2xl bg-[#0284c7] text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-sky-500/25 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                            02
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5 group-hover:text-[#0284c7] transition-colors">
                            Lengkapi Profil
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Masukkan data fase keluarga: perencanaan pra-hamil, trimester kehamilan ibu, atau identitas anak balita.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-[#0284c7]">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Kustomisasi Fase</span>
                    </div>
                </div>

                <!-- STEP 03 -->
                <div class="bg-white rounded-[28px] sm:rounded-[32px] p-6 sm:p-7 border border-amber-100/60 shadow-md shadow-amber-500/5 flex flex-col justify-between hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-2 transition-all duration-300 relative group">
                    <div>
                        <!-- Number Badge with Hover Tilt -->
                        <div class="w-12 h-12 rounded-2xl bg-[#d97706] text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                            03
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5 group-hover:text-[#d97706] transition-colors">
                            Pantau Pemeriksaan
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Catat atau sinkronkan hasil pengukuran Posyandu, Puskesmas, atau dokter spesialis anak ke dalam buku KIA digital.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-[#d97706]">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Update Rutin Tiap Bulan</span>
                    </div>
                </div>

                <!-- STEP 04 -->
                <div class="bg-white rounded-[28px] sm:rounded-[32px] p-6 sm:p-7 border border-emerald-100/60 shadow-md shadow-emerald-500/5 flex flex-col justify-between hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-300 relative group">
                    <div>
                        <!-- Number Badge with Hover Tilt -->
                        <div class="w-12 h-12 rounded-2xl bg-[#059669] text-white font-extrabold text-base flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                            04
                        </div>

                        <h3 class="font-bold text-slate-900 text-lg sm:text-xl mt-5 mb-2.5 group-hover:text-[#059669] transition-colors">
                            Dapatkan Informasi
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                            Terima rekomendasi gizi personal, visualisasi kurva KMS WHO, serta notifikasi pencegahan risiko stunting otomatis.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/80 flex items-center gap-1.5 text-xs font-semibold text-[#059669]">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>Deteksi Dini Cepat</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: EDUKASI GIZI KELUARGA (ARTIKEL & PANDUAN DOKTER) -->
        <section id="edukasi-gizi" class="mt-28 pt-8 scroll-mt-28">
            <!-- Header Row with Title on Left and "Lihat Semua" Toggle Button on Right -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-pink-100/70 border border-pink-200/60 text-[#FF539B] text-xs sm:text-[13px] font-bold mb-3 shadow-2xs">
                        Edukasi Gizi Keluarga
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-slate-900 tracking-tight leading-tight">
                        <span>Belajar Gizi, </span>
                        <span class="text-[#FF539B]">Mulai dari Sekarang</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-base mt-2.5 max-w-2xl leading-relaxed">
                        Kumpulan panduan teruji klinis yang disusun bersama dokter spesialis gizi klinik dan dokter spesialis anak untuk mendampingi setiap tahapan 1.000 HPK.
                    </p>
                </div>

                <!-- Interactive Button to Toggle / View All Articles -->
                <button type="button" id="btn-toggle-all-articles" onclick="toggleAllArticles()" class="inline-flex items-center gap-2.5 text-sm font-bold text-[#FF539B] hover:text-white bg-pink-50 hover:bg-[#FF539B] border border-pink-200/80 hover:border-[#FF539B] px-5 py-2.5 rounded-full transition-all duration-200 flex-shrink-0 group shadow-2xs hover:shadow-md cursor-pointer">
                    <span id="btn-toggle-text">Lihat Semua Edukasi Gizi</span>
                    <span id="article-count-badge" class="px-2 py-0.5 rounded-full bg-white text-[#FF539B] text-xs font-extrabold shadow-2xs group-hover:bg-pink-100/30 group-hover:text-white">6 Panduan</span>
                    <svg id="btn-toggle-icon" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

            <!-- Dynamic Category Filter Tabs (Appears when expanded or clicked) -->
            <div id="article-filter-tabs" class="hidden flex-wrap items-center gap-2 sm:gap-2.5 mb-8 anim-fade-in-1">
                <button type="button" onclick="filterArticles('all', this)" class="filter-tab-btn px-4 py-1.5 rounded-full text-xs sm:text-sm font-bold bg-[#FF539B] text-white shadow-xs transition-all">Semua (6)</button>
                <button type="button" onclick="filterArticles('pra-hamil', this)" class="filter-tab-btn px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium bg-white text-slate-600 hover:text-[#FF539B] border border-pink-100 shadow-2xs transition-all">Pra-Hamil</button>
                <button type="button" onclick="filterArticles('hamil', this)" class="filter-tab-btn px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium bg-white text-slate-600 hover:text-[#FF539B] border border-pink-100 shadow-2xs transition-all">Kehamilan</button>
                <button type="button" onclick="filterArticles('anak', this)" class="filter-tab-btn px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium bg-white text-slate-600 hover:text-[#FF539B] border border-pink-100 shadow-2xs transition-all">Anak (0-2 Tahun)</button>
                <button type="button" onclick="filterArticles('mpasi', this)" class="filter-tab-btn px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium bg-white text-slate-600 hover:text-[#FF539B] border border-pink-100 shadow-2xs transition-all">Panduan MPASI</button>
            </div>

            <!-- Article Cards Grid -->
            <div id="articles-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-7">
                
                <!-- ARTICLE 1: PRA-HAMIL (REAL PHOTO) -->
                <article data-category="pra-hamil" class="article-item bg-white rounded-[28px] sm:rounded-[32px] p-5 sm:p-6 border border-pink-100/60 shadow-md shadow-pink-500/5 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group cursor-pointer" onclick="openArticleModal('pra-hamil')">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-sky-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/edukasi-pra-hamil.jpg') }}" 
                                alt="Mengenal Persiapan Gizi Sebelum Kehamilan" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-500 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-[#0284c7] text-xs font-bold border border-sky-100 shadow-xs">
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
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-[#FF539B] transition-colors">
                            Mengenal Persiapan Gizi Sebelum Kehamilan
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Pentingnya cadangan asam folat dan kadar hemoglobin normal untuk mempersiapkan sel telur berkualitas dan mencegah cacat tabung saraf janin.
                        </p>
                    </div>

                    <!-- Read Link / Button -->
                    <button type="button" class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-[#FF539B] group-hover:text-[#E63B82] transition w-full text-left cursor-pointer">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </article>

                <!-- ARTICLE 2: HAMIL (REAL PHOTO) -->
                <article data-category="hamil" class="article-item bg-white rounded-[28px] sm:rounded-[32px] p-5 sm:p-6 border border-pink-100/60 shadow-md shadow-pink-500/5 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group cursor-pointer" onclick="openArticleModal('hamil')">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-rose-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/edukasi-hamil.jpg') }}" 
                                alt="Memahami Kebutuhan Gizi Selama Kehamilan" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-500 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-[#FF539B] text-xs font-bold border border-rose-100 shadow-xs">
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
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-[#FF539B] transition-colors">
                            Memahami Kebutuhan Gizi Selama Kehamilan
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Mengapa protein hewani ganda (seperti telur dan ikan laut) sangat krusial dalam pembentukan sel saraf dan plasenta di trimester 1 hingga 3.
                        </p>
                    </div>

                    <!-- Read Link / Button -->
                    <button type="button" class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-[#FF539B] group-hover:text-[#E63B82] transition w-full text-left cursor-pointer">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </article>

                <!-- ARTICLE 3: ANAK (0-2 TAHUN) (REAL PHOTO) -->
                <article data-category="anak" class="article-item bg-white rounded-[28px] sm:rounded-[32px] p-5 sm:p-6 border border-pink-100/60 shadow-md shadow-pink-500/5 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group cursor-pointer" onclick="openArticleModal('anak')">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-pink-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/edukasi-anak.jpg') }}" 
                                alt="Mengenal Pertumbuhan dan Gizi Anak" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-500 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-[#FF539B] text-xs font-bold border border-pink-100 shadow-xs">
                                Anak (0 - 2 Tahun)
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
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-[#FF539B] transition-colors">
                            Mengenal Pertumbuhan dan Gizi Anak
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Panduan tekstur dan makronutrien MPASI padat energi untuk memastikan berat badan anak naik sesuai kurva tanpa mengalami stunting.
                        </p>
                    </div>

                    <!-- Read Link / Button -->
                    <button type="button" class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-[#FF539B] group-hover:text-[#E63B82] transition w-full text-left cursor-pointer">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </article>

                <!-- ARTICLE 4: PANDUAN MPASI (EXPANDED CATALOG) -->
                <article data-category="mpasi" class="article-item extra-article hidden bg-white rounded-[28px] sm:rounded-[32px] p-5 sm:p-6 border border-pink-100/60 shadow-md shadow-pink-500/5 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group cursor-pointer anim-fade-in-1" onclick="openArticleModal('mpasi')">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-amber-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/konsultasi-bidan-anak.jpg') }}" 
                                alt="Menu MPASI Kaya Protein Hewani untuk Mencegah Stunting" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-500 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-amber-700 text-xs font-bold border border-amber-100 shadow-xs">
                                Panduan MPASI
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
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-[#FF539B] transition-colors">
                            Menu MPASI Kaya Protein Hewani untuk Mencegah Stunting
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Strategi praktis penyusunan menu harian balita dengan kombinasi telur, hati ayam, dan ikan laut lokal kaya zat besi.
                        </p>
                    </div>

                    <!-- Read Link / Button -->
                    <button type="button" class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-[#FF539B] group-hover:text-[#E63B82] transition w-full text-left cursor-pointer">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </article>

                <!-- ARTICLE 5: KEHAMILAN - ANEMIA (EXPANDED CATALOG) -->
                <article data-category="hamil" class="article-item extra-article hidden bg-white rounded-[28px] sm:rounded-[32px] p-5 sm:p-6 border border-pink-100/60 shadow-md shadow-pink-500/5 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group cursor-pointer anim-fade-in-2" onclick="openArticleModal('anemia')">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-rose-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/register-mother-child-hd.jpg') }}" 
                                alt="Tanda Bahaya Anemia pada Ibu Hamil dan Solusi Nutrisinya" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-500 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-[#FF539B] text-xs font-bold border border-rose-100 shadow-xs">
                                Kehamilan
                            </span>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium mb-2.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                            </svg>
                            <span>6 Menit Baca • Dr. dr. Anita Sp.GK</span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-[#FF539B] transition-colors">
                            Tanda Bahaya Anemia pada Ibu Hamil dan Solusi Nutrisinya
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Mengenali gejala 5L (Lesu, Lelah, Letih, Lemah, Lunglai) dan cara meningkatkan penyerapan tablet tambah darah bersama vitamin C.
                        </p>
                    </div>

                    <!-- Read Link / Button -->
                    <button type="button" class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-[#FF539B] group-hover:text-[#E63B82] transition w-full text-left cursor-pointer">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </article>

                <!-- ARTICLE 6: TUMBUH KEMBANG - KURVA WHO (EXPANDED CATALOG) -->
                <article data-category="anak" class="article-item extra-article hidden bg-white rounded-[28px] sm:rounded-[32px] p-5 sm:p-6 border border-pink-100/60 shadow-md shadow-pink-500/5 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group cursor-pointer anim-fade-in-3" onclick="openArticleModal('kurva-who')">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10.5] mb-4 bg-indigo-50/50 border border-slate-100/80">
                            <img 
                                src="{{ asset('images/fetus-24-weeks.jpg') }}" 
                                alt="Membaca Kurva Pertumbuhan WHO Digital untuk Deteksi Dini" 
                                class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-500 ease-out"
                            />
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-xs text-indigo-700 text-xs font-bold border border-indigo-100 shadow-xs">
                                Tumbuh Kembang
                            </span>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium mb-2.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                            </svg>
                            <span>4 Menit Baca • dr. Budi Santoso Sp.A</span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug group-hover:text-[#FF539B] transition-colors">
                            Membaca Kurva Pertumbuhan WHO Digital untuk Deteksi Dini
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                            Cara memahami garis persentil berat dan tinggi badan si kecil agar orang tua tanggap sebelum terlambat.
                        </p>
                    </div>

                    <!-- Read Link / Button -->
                    <button type="button" class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-semibold text-[#FF539B] group-hover:text-[#E63B82] transition w-full text-left cursor-pointer">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </article>

            </div>
        </section>

        <!-- FINAL CTA SECTION: LANGKAH KECIL HARI INI (Matching Reference with Left Pink & Right Blue Glows) -->
        <section id="cta-final" class="mt-24 pb-12">
            <div class="relative rounded-[36px] sm:rounded-[44px] overflow-hidden bg-white/70 backdrop-blur-md border border-slate-200/80 shadow-2xl shadow-slate-900/5 p-8 sm:p-14 lg:p-16 text-center">
                <!-- Left Vibrant Pink Glow Orb (Visible & Colorful as Reference Mockup) -->
                <div class="absolute -left-12 sm:-left-20 top-1/2 -translate-y-1/2 w-72 sm:w-[420px] h-72 sm:h-[420px] bg-[#fbcfe8] opacity-75 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Right Vibrant Sky Blue Glow Orb (Visible & Colorful as Reference Mockup) -->
                <div class="absolute -right-12 sm:-right-20 bottom-0 sm:bottom-4 w-72 sm:w-[420px] h-72 sm:h-[420px] bg-[#bae6fd] opacity-80 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <!-- Badge: Bergabung Dengan 10.000+ Keluarga Sehat with Sparkle -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/90 border border-pink-200/60 text-[#FF539B] text-xs font-bold uppercase tracking-wider mb-6 shadow-2xs">
                        <span class="text-amber-400">✨</span>
                        <span>BERGABUNG DENGAN 10.000+ KELUARGA SEHAT</span>
                    </div>

                    <!-- Headline: Solid Dark Slate (Matching Mockup) -->
                    <h2 class="text-3xl sm:text-4xl lg:text-[46px] font-extrabold text-slate-900 tracking-tight leading-[1.18] mb-5">
                        Langkah Kecil Hari Ini, untuk<br class="hidden sm:inline"> Keluarga yang Lebih Sehat
                    </h2>

                    <!-- Subtext -->
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8 max-w-xl mx-auto">
                        Mulai pantau kesehatan keluarga dan temukan informasi yang mendukung pencegahan stunting sejak dini. Gratis, mudah, dan didukung standar medis terpercaya.
                    </p>

                    <!-- Buttons Row -->
                    <div class="flex flex-wrap items-center justify-center gap-4 mb-6">
                        <a href="{{ route('register') }}" class="group relative overflow-hidden inline-flex items-center gap-2.5 px-8 sm:px-9 py-3.5 sm:py-4 rounded-full text-sm sm:text-base font-bold text-white bg-[#FF539B] hover:bg-[#E63B82] shadow-xl shadow-pink-500/25 hover:shadow-2xl hover:shadow-pink-500/35 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            <span class="shimmer-glow"></span>
                            <span class="relative z-10">Daftar Sekarang &mdash; Gratis</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200 relative z-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <a href="#fitur" class="px-8 py-3.5 sm:py-4 rounded-full text-sm sm:text-base font-semibold text-slate-800 bg-white hover:bg-slate-50 border border-slate-200 shadow-2xs hover:shadow-md transition-all">
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

    <!-- FOOTER (VIBRANT & BOLD PINK GRADIENT / MENYALA & PEKAT) -->
    <footer class="relative z-10 bg-gradient-to-br from-[#FF539B] via-[#E63B82] to-[#991147] text-white mt-24 pt-16 pb-12 overflow-hidden shadow-2xl shadow-rose-950/20">
        <!-- Luminous Ambient Background Glows -->
        <div class="absolute -top-32 left-1/4 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 right-1/4 w-[500px] h-[500px] bg-pink-400/25 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl xl:max-w-[1400px] 2xl:max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
            <!-- Top Footer Grid: 4 Clean Columns (4 + 2 + 3 + 3 = 12 Columns) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 mb-14">

                <!-- Col 1: Brand (spans 4) -->
                <div class="lg:col-span-4 space-y-4">
                    <!-- Logo inside crisp white pill badge -->
                    <div class="inline-flex items-center gap-2 bg-white rounded-2xl px-4 py-2 shadow-lg shadow-rose-950/20">
                        <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                    </div>
                    <p class="text-[11px] font-extrabold tracking-widest text-pink-200 uppercase">MATERNAL &amp; CHILD HEALTH CARE</p>
                    <p class="text-sm text-pink-100/90 leading-relaxed max-w-sm">
                        Platform terpadu pemantauan gizi, kehamilan, dan tumbuh kembang anak berbasis standar WHO dan Kemenkes RI demi mewujudkan generasi bebas stunting di Indonesia.
                    </p>
                    <!-- Social Icons (Frosted Glass Pills) -->
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-white/15 hover:bg-white text-white hover:text-[#FF539B] border border-white/20 flex items-center justify-center transition-all duration-300 shadow-md hover:scale-110" title="Website">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/15 hover:bg-white text-white hover:text-[#FF539B] border border-white/20 flex items-center justify-center transition-all duration-300 shadow-md hover:scale-110" title="Bagikan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </a>
                        <a href="mailto:halo@nutrigrow.id" class="w-9 h-9 rounded-full bg-white/15 hover:bg-white text-white hover:text-[#FF539B] border border-white/20 flex items-center justify-center transition-all duration-300 shadow-md hover:scale-110" title="Email">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigasi (spans 2) -->
                <div class="lg:col-span-2">
                    <h4 class="font-extrabold text-xs tracking-wider uppercase text-white mb-5 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-pink-300"></span>
                        NAVIGASI
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Beranda</a></li>
                        <li><a href="#fitur" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Fitur Utama</a></li>
                        <li><a href="#fitur-unggulan" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Fase Kehidupan</a></li>
                        <li><a href="#cara-kerja" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Cara Kerja</a></li>
                        <li><a href="#edukasi-gizi" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Edukasi Gizi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan NutriGrow (spans 3) -->
                <div class="lg:col-span-3">
                    <h4 class="font-extrabold text-xs tracking-wider uppercase text-white mb-5 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-pink-300"></span>
                        LAYANAN NUTRIGROW
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('register') }}" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Pemantauan Kehamilan (ANC)</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Kurva Pertumbuhan WHO Digital</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Monitoring Risiko Stunting</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Katalog Menu MPASI Bergizi</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-pink-100 hover:text-white hover:translate-x-1 transition-all inline-block">Sinkronisasi Posyandu</a></li>
                    </ul>
                </div>

                <!-- Col 4: Bantuan & Regulasi (spans 3) -->
                <div class="lg:col-span-3">
                    <h4 class="font-extrabold text-xs tracking-wider uppercase text-white mb-5 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-pink-300"></span>
                        BANTUAN &amp; REGULASI
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="mailto:halo@nutrigrow.id" class="flex items-center gap-3 p-2.5 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/15 transition-all text-white group">
                                <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-sm font-semibold text-pink-100 group-hover:text-white">halo@nutrigrow.id</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-white/10 border border-white/15 text-white">
                                <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-sm font-semibold text-pink-100">0800-123-GROW (Bebas Pulsa)</span>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-start gap-3 p-2.5 rounded-2xl bg-white/10 border border-white/15 text-white">
                                <div class="w-7 h-7 rounded-lg bg-emerald-400/25 flex items-center justify-center flex-shrink-0 text-emerald-300 mt-0.5">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-pink-100 leading-snug">Pedoman Antropometri Kemenkes RI No. 2 Th 2020</span>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Footer Bar -->
            <div class="border-t border-white/20 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-pink-200">
                <span>&copy; 2025 NutriGrow Indonesia. Hak Cipta Dilindungi.</span>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat &amp; Ketentuan</a>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#FF539B] font-extrabold text-[11px] shadow-md">
                        <span>✨</span>
                        <span>Menuju Generasi Emas Bebas Stunting 2045</span>
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ARTICLE READER MODAL (Interactive "Baca Selengkapnya") -->
    <div id="article-reader-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 overflow-y-auto bg-slate-900/60 backdrop-blur-sm transition-all duration-300 opacity-0" role="dialog" aria-modal="true" aria-labelledby="modal-article-title">
        <div class="relative w-full max-w-2xl bg-white rounded-[28px] sm:rounded-[36px] shadow-2xl border border-pink-100 overflow-hidden transform scale-95 transition-all duration-300 my-8">
            
            <!-- Modal Sticky Header -->
            <div class="sticky top-0 z-20 bg-white/95 backdrop-blur-md px-6 sm:px-8 py-4 border-b border-pink-100/70 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span id="modal-category-badge" class="px-3.5 py-1 rounded-full text-xs font-bold border shadow-2xs">
                        Kategori
                    </span>
                    <span id="modal-read-time" class="text-xs text-slate-500 font-medium">
                        4 Menit Baca
                    </span>
                </div>
                <button type="button" onclick="closeArticleModal()" class="w-9 h-9 rounded-full bg-pink-50 hover:bg-pink-100 text-slate-600 hover:text-[#FF539B] flex items-center justify-center transition-colors duration-200 cursor-pointer focus:outline-none" aria-label="Tutup Artikel">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Scrollable Content -->
            <div class="px-6 sm:px-8 py-6 max-h-[70vh] overflow-y-auto space-y-5">
                <!-- Cover Image Container -->
                <div class="rounded-2xl overflow-hidden aspect-[16/9] w-full bg-slate-100 border border-slate-100 shadow-xs relative">
                    <img id="modal-cover-image" src="" alt="" class="w-full h-full object-cover object-center">
                </div>

                <!-- Doctor / Medical Reviewer Meta Badge -->
                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-pink-50/60 border border-pink-100/80">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#FF539B] to-[#E63B82] text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-xs">
                        Dr
                    </div>
                    <div class="text-xs">
                        <div class="font-bold text-slate-900 flex items-center gap-1.5">
                            <span id="modal-doctor-name">Dr. dr. Anita Sp.GK</span>
                            <span class="inline-flex items-center text-emerald-600" title="Ditinjau Medis Klinis">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                        </div>
                        <span class="text-slate-500">Ditinjau oleh Dokter Spesialis • Sesuai Standar Kemenkes RI</span>
                    </div>
                </div>

                <!-- Title -->
                <h2 id="modal-article-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                    Judul Artikel
                </h2>

                <!-- Article Content Body -->
                <div id="modal-article-content" class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-4">
                    <!-- Dynamic HTML Content -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-slate-50/80 border-t border-slate-100 px-6 sm:px-8 py-4 flex flex-wrap items-center justify-between gap-3">
                <button type="button" onclick="shareArticle()" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#FF539B] transition py-2 px-3 rounded-xl hover:bg-white border border-transparent hover:border-slate-200 cursor-pointer">
                    <svg class="w-4 h-4 text-[#FF539B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    <span id="share-btn-text">Bagikan Artikel</span>
                </button>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeArticleModal()" class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 transition cursor-pointer">
                        Tutup
                    </button>
                    <a href="{{ route('register') }}" class="px-5 sm:px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold text-white bg-[#FF539B] hover:bg-[#E63B82] shadow-sm hover:shadow-md transition">
                        Daftar untuk Pantau Gizi
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- STICKY NAVBAR SCROLL INTERACTION & SCROLLSPY SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navbar = document.getElementById('navbar-pill');

            const navItems = [
                { nav: document.getElementById('nav-beranda'), id: 'beranda' },
                { nav: document.getElementById('nav-fitur'), id: 'fitur' },
                { nav: document.getElementById('nav-informasi'), id: 'edukasi-gizi' },
                { nav: document.getElementById('nav-tentang'), id: 'cara-kerja' }
            ];

            const secFitur = document.getElementById('fitur');
            const secCara = document.getElementById('cara-kerja');
            const secEdu = document.getElementById('edukasi-gizi');

            const handleScroll = () => {
                const scrollY = window.scrollY;

                // 1. Navbar floating elevation on scroll
                if (navbar) {
                    if (scrollY > 20) {
                        navbar.classList.add('shadow-md', 'shadow-pink-500/10', 'border-pink-200/90');
                        navbar.classList.remove('shadow-sm', 'border-pink-100/70');
                    } else {
                        navbar.classList.remove('shadow-md', 'shadow-pink-500/10', 'border-pink-200/90');
                        navbar.classList.add('shadow-sm', 'border-pink-100/70');
                    }
                }

                // 2. Dynamic ScrollSpy Active Section Indicator
                const scrollPos = scrollY + 220;
                let activeId = 'beranda';

                if (secEdu && scrollPos >= secEdu.offsetTop) {
                    activeId = 'edukasi-gizi';
                } else if (secCara && scrollPos >= secCara.offsetTop) {
                    activeId = 'cara-kerja';
                } else if (secFitur && scrollPos >= secFitur.offsetTop) {
                    activeId = 'fitur';
                } else {
                    activeId = 'beranda';
                }

                navItems.forEach(({ nav, id }) => {
                    if (!nav) return;
                    const ind = nav.querySelector('.indicator');
                    if (id === activeId) {
                        nav.classList.add('font-bold', 'text-[#FF539B]');
                        nav.classList.remove('font-medium', 'text-slate-700');
                        if (ind) {
                            ind.classList.remove('opacity-0', 'scale-x-0');
                            ind.classList.add('opacity-100', 'scale-x-100');
                        }
                    } else {
                        nav.classList.remove('font-bold', 'text-[#FF539B]');
                        nav.classList.add('font-medium', 'text-slate-700');
                        if (ind) {
                            ind.classList.add('opacity-0', 'scale-x-0');
                            ind.classList.remove('opacity-100', 'scale-x-100');
                        }
                    }
                });
            };

            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll(); // Initial check on page load
        });

        // ==========================================
        // EDUKASI GIZI: ARTIKEL MODAL & EXPAND LOGIC
        // ==========================================
        const articlesData = {
            'pra-hamil': {
                category: 'Pra-Hamil',
                categoryClass: 'bg-sky-50 text-[#0284c7] border-sky-200',
                title: 'Mengenal Persiapan Gizi Sebelum Kehamilan',
                doctor: 'Dr. dr. Anita Sp.GK (Spesialis Gizi Klinik)',
                time: '4 Menit Baca',
                image: "{{ asset('images/edukasi-pra-hamil.jpg') }}",
                content: `
                    <p class="font-medium text-slate-800 text-base leading-relaxed">
                        Persiapan kehamilan sehat idealnya dimulai <strong>minimal 3 hingga 6 bulan sebelum konsepsi</strong> (pembuahan). Status gizi calon ibu saat sebelum hamil menentukan kualitas sel telur, implantasi awal embrio, dan perkembangan organ vital janin di trimester pertama.
                    </p>
                    
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">1. Asam Folat: Nutrisi Utama Pencegah Cacat Tabung Saraf</h3>
                    <p class="text-slate-600 mb-3">
                        Asam folat (Vitamin B9) sebanyak <strong>400 mikrogram (mcg) per hari</strong> dianjurkan diminum sejak program hamil. Tabung saraf janin menutup sempurna pada hari ke-28 setelah pembuahan—kerap kali terjadi sebelum calon ibu mengetahui bahwa dirinya sudah positif hamil. Asupan asam folat yang cukup memangkas risiko <em>Neural Tube Defects (NTD)</em> hingga 70%.
                    </p>
                    <div class="bg-sky-50/70 border-l-4 border-sky-400 p-3.5 rounded-r-xl my-4 text-xs sm:text-sm text-sky-950">
                        <strong>Sumber Alami:</strong> Sayuran hijau gelap (bayam, brokoli, asparagus), kacang-kacangan, telur, buah jeruk, alpukat, serta suplemen asam folat sesuai anjuran faskes.
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">2. Skrining Anemia & Optimalisasi Zat Besi</h3>
                    <p class="text-slate-600 mb-3">
                        Kadar hemoglobin (Hb) ideal sebelum hamil adalah <strong>&ge; 12 g/dL</strong>. Ibu yang memasuki kehamilan dalam kondisi anemia memiliki risiko lebih tinggi melahirkan bayi berat lahir rendah (BBLR), persalinan prematur, dan perdarahan pasca-salin.
                    </p>

                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">3. Pertahankan Indeks Massa Tubuh (IMT) Normal</h3>
                    <p class="text-slate-600 mb-2">
                        IMT ideal sebelum hamil berada pada rentang <strong>18,5 - 24,9 kg/m&sup2;</strong>. Kurang gizi kronis (KEK) maupun kelebihan berat badan dapat mengganggu keseimbangan hormon reproduksi dan ovulasi.
                    </p>
                `
            },
            'hamil': {
                category: 'Hamil',
                categoryClass: 'bg-rose-50 text-[#FF539B] border-rose-200',
                title: 'Memahami Kebutuhan Gizi Selama Kehamilan',
                doctor: 'dr. Maya Sp.OG (Spesialis Kebidanan & Kandungan)',
                time: '6 Menit Baca',
                image: "{{ asset('images/edukasi-hamil.jpg') }}",
                content: `
                    <p class="font-medium text-slate-800 text-base leading-relaxed">
                        Prinsip nutrisi kehamilan bukan berarti porsi makan harus dilipatgandakan untuk "dua orang", melainkan menekankan <strong>kepadatan gizi mikro dan makro</strong> untuk mendukung organogenesis janin serta kesehatan plasenta.
                    </p>
                    
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">1. Protein Hewani Ganda: Membentuk Jaringan & Otak</h3>
                    <p class="text-slate-600 mb-3">
                        Kebutuhan protein meningkat drastis terutama mulai trimester kedua. Konsumsi <strong>dua variasi protein hewani berbeda setiap hari</strong> (misalnya kombinasi telur rebus saat sarapan dan ikan kembung/ayam saat makan siang) memastikan profil asam amino esensial lengkap terpenuhi.
                    </p>
                    <div class="bg-rose-50/70 border-l-4 border-[#FF539B] p-3.5 rounded-r-xl my-4 text-xs sm:text-sm text-rose-950">
                        <strong>Fakta Medis:</strong> Ikan kembung lokal memiliki kandungan asam lemak omega-3 (DHA &amp; EPA) yang sangat tinggi, krusial bagi pembentukan jutaan sel saraf dan retina mata janin.
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">2. Kalsium &amp; Vitamin D untuk Tulang Janin</h3>
                    <p class="text-slate-600 mb-3">
                        Janin membutuhkan kalsium dalam jumlah besar untuk pembentukan kerangka tulang. Jika asupan kalsium ibu kurang (&lt; 1.000 - 1.200 mg/hari), tubuh janin akan menyerap kalsium dari simpanan tulang ibu, meningkatkan risiko kram dan osteoporosis dini.
                    </p>

                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">3. Hidrasi Cukup &amp; Serat untuk Mencegah Konstipasi</h3>
                    <p class="text-slate-600 mb-2">
                        Peningkatan hormon progesteron memperlambat gerak usus. Minum air putih <strong>2,5 hingga 3 liter per hari</strong> disertai sayur dan buah kaya serat mencegah dehidrasi, infeksi saluran kemih, dan wasir saat hamil.
                    </p>
                `
            },
            'anak': {
                category: 'Anak (0 - 2 Tahun)',
                categoryClass: 'bg-emerald-50 text-[#059669] border-emerald-200',
                title: 'Mengenal Pertumbuhan dan Gizi Anak',
                doctor: 'dr. Budi Santoso Sp.A (Spesialis Anak)',
                time: '5 Menit Baca',
                image: "{{ asset('images/edukasi-anak.jpg') }}",
                content: `
                    <p class="font-medium text-slate-800 text-base leading-relaxed">
                        Rentang usia 0 hingga 2 tahun (730 hari) adalah periode emas di mana <strong>80% pertumbuhan otak manusia berlangsung</strong>. Gangguan gizi kronis atau stunting pada fase ini memiliki dampak jangka panjang terhadap kecerdasan kognitif dan imunitas anak.
                    </p>
                    
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">1. ASI Eksklusif Selama 6 Bulan Pertama</h3>
                    <p class="text-slate-600 mb-3">
                        ASI adalah makanan dan minuman terbaik bagi bayi tanpa perlu tambahan air putih atau makanan padat apapun sebelum genap usia 6 bulan. ASI mengandung antibodi bioaktif spesifik yang melindungi bayi dari diare dan pneumonia.
                    </p>

                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">2. Transisi MPASI Padat Energi &amp; Protein Hewani</h3>
                    <p class="text-slate-600 mb-3">
                        Tepat di usia 6 bulan, cadangan zat besi bawaan bayi mulai habis dan kebutuhan kalori meningkat pesat. Berikan Makanan Pendamping ASI (MPASI) yang mengandung <strong>protein hewani di setiap jadwal makan</strong> (seperti telur, hati ayam, daging, atau ikan), bukan hanya menu buah atau karbohidrat murni.
                    </p>
                    <div class="bg-emerald-50/70 border-l-4 border-emerald-500 p-3.5 rounded-r-xl my-4 text-xs sm:text-sm text-emerald-950">
                        <strong>Panduan Tekstur Bertahap:</strong><br>
                        &bull; Usia 6-8 bulan: Bubur saring lumat kental (tidak mudah jatuh saat sendok dimiringkan).<br>
                        &bull; Usia 9-11 bulan: Makanan cincang halus dan finger food lembut.<br>
                        &bull; Usia 12 bulan ke atas: Makanan keluarga gizi seimbang.
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">3. Pemantauan Kurva WHO Rutin Setiap Bulan</h3>
                    <p class="text-slate-600 mb-2">
                        Timbang berat badan dan ukur panjang/tinggi badan si kecil secara berkala di Posyandu atau aplikasi NutriGrow. Waspadai bila kenaikan berat badan tidak mencapai garis kenaikan minimal (KBM) untuk intervensi sebelum terjadi stunting.
                    </p>
                `
            },
            'mpasi': {
                category: 'Panduan MPASI',
                categoryClass: 'bg-amber-50 text-amber-700 border-amber-200',
                title: 'Menu MPASI Kaya Protein Hewani untuk Mencegah Stunting',
                doctor: 'dr. Budi Santoso Sp.A & dr. Maya Sp.OG',
                time: '5 Menit Baca',
                image: "{{ asset('images/konsultasi-bidan-anak.jpg') }}",
                content: `
                    <p class="font-medium text-slate-800 text-base leading-relaxed">
                        Data Kemenkes RI menunjukkan bahwa intervensi paling efektif menekan angka stunting adalah memastikan asupan protein hewani terpenuhi sejak hari pertama bayi mengonsumsi MPASI.
                    </p>
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">1. Hati Ayam &amp; Telur: Superfood Terjangkau</h3>
                    <p class="text-slate-600 mb-3">
                        Hati ayam mengandung zat besi heme konsentrasi tinggi yang sangat mudah diserap saluran cerna bayi. Satu butir telur per hari terbukti secara klinis menurunkan risiko gagal tumbuh hingga 47%.
                    </p>
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">2. Jangan Lupakan Lemak Tambahan</h3>
                    <p class="text-slate-600 mb-2">
                        Lambung bayi berukuran kecil sehingga membutuhkan makanan dengan densitas kalori tinggi. Tambahkan 1 sendok teh minyak kelapa, santan, atau unsalted butter pada mangkuk MPASI untuk memenuhi kebutuhan energi perkembangan otaknya.
                    </p>
                `
            },
            'anemia': {
                category: 'Kehamilan',
                categoryClass: 'bg-rose-50 text-[#FF539B] border-rose-200',
                title: 'Tanda Bahaya Anemia pada Ibu Hamil dan Solusi Nutrisinya',
                doctor: 'Dr. dr. Anita Sp.GK (Spesialis Gizi Klinik)',
                time: '6 Menit Baca',
                image: "{{ asset('images/register-mother-child-hd.jpg') }}",
                content: `
                    <p class="font-medium text-slate-800 text-base leading-relaxed">
                        Anemia pada kehamilan bukan sekadar kelelahan biasa. Kurangnya kadar hemoglobin mengurangi suplai oksigen dan nutrisi yang dialirkan plasenta ke otak janin.
                    </p>
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">1. Waspadai Gejala 5L</h3>
                    <p class="text-slate-600 mb-3">
                        Gejala meliputi Lemah, Letih, Lesu, Lelah, dan Lunglai, disertai pusing berkunang-kunang dan kelopak mata pucat. Pastikan cek laboratorium Hb di awal kehamilan.
                    </p>
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">2. Aturan Minum Tablet Tambah Darah (TTD)</h3>
                    <p class="text-slate-600 mb-2">
                        Minum TTD bersama air perasan jeruk atau sumber vitamin C untuk melipatgandakan penyerapan zat besi. <strong>Hindari minum TTD bersama teh, kopi, atau susu</strong> karena kandungan tanin dan kalsium menghambat penyerapan zat besi hingga 80%.
                    </p>
                `
            },
            'kurva-who': {
                category: 'Tumbuh Kembang',
                categoryClass: 'bg-indigo-50 text-indigo-700 border-indigo-200',
                title: 'Membaca Kurva Pertumbuhan WHO Digital untuk Deteksi Dini',
                doctor: 'dr. Budi Santoso Sp.A (Spesialis Anak)',
                time: '4 Menit Baca',
                image: "{{ asset('images/fetus-24-weeks.jpg') }}",
                content: `
                    <p class="font-medium text-slate-800 text-base leading-relaxed">
                        Aplikasi NutriGrow menggunakan standar kurva pertumbuhan WHO (World Health Organization) yang menjadi standar resmi Kemenkes RI untuk evaluasi status gizi anak.
                    </p>
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">1. Indikator Standar Antropometri</h3>
                    <p class="text-slate-600 mb-3">
                        Kurva WHO mengevaluasi tiga parameter: Berat Badan menurut Umur (BB/U), Panjang/Tinggi Badan menurut Umur (PB/U atau TB/U - deteksi stunting), dan Berat Badan menurut Panjang Badan (BB/PB - deteksi gizi kurang/wasting).
                    </p>
                    <h3 class="text-lg font-bold text-slate-900 mt-5 mb-2">2. Kapan Harus Mengambil Tindakan Cepat?</h3>
                    <p class="text-slate-600 mb-2">
                        Bila kurva berat badan mendatar selama 2 bulan berturut-turut (tidak naik), jangan tunggu hingga anak tampak kurus. Segera periksakan ke dokter spesialis anak untuk mendeteksi infeksi tersembunyi (seperti ISK atau TBC) sebelum terjadi gangguan tinggi badan.
                    </p>
                `
            }
        };

        // Open Modal Reader
        window.openArticleModal = function(slug) {
            const article = articlesData[slug];
            if (!article) return;

            const modal = document.getElementById('article-reader-modal');
            const badge = document.getElementById('modal-category-badge');
            const readTime = document.getElementById('modal-read-time');
            const cover = document.getElementById('modal-cover-image');
            const doctor = document.getElementById('modal-doctor-name');
            const title = document.getElementById('modal-article-title');
            const content = document.getElementById('modal-article-content');

            badge.textContent = article.category;
            badge.className = `px-3.5 py-1 rounded-full text-xs font-bold border shadow-2xs ${article.categoryClass}`;
            readTime.textContent = article.time;
            cover.src = article.image;
            cover.alt = article.title;
            doctor.textContent = article.doctor;
            title.textContent = article.title;
            content.innerHTML = article.content;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const modalBox = modal.querySelector('div');
                if (modalBox) {
                    modalBox.classList.remove('scale-95');
                    modalBox.classList.add('scale-100');
                }
            }, 10);

            document.body.style.overflow = 'hidden';
        };

        // Close Modal Reader
        window.closeArticleModal = function() {
            const modal = document.getElementById('article-reader-modal');
            modal.classList.add('opacity-0');
            const modalBox = modal.querySelector('div');
            if (modalBox) {
                modalBox.classList.add('scale-95');
                modalBox.classList.remove('scale-100');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }, 250);
        };

        // Close on ESC or Backdrop Click
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeArticleModal();
        });
        document.getElementById('article-reader-modal')?.addEventListener('click', (e) => {
            if (e.target.id === 'article-reader-modal') closeArticleModal();
        });

        // Share Article Feedback
        window.shareArticle = function() {
            if (navigator.share) {
                navigator.share({
                    title: document.getElementById('modal-article-title').textContent,
                    text: 'Panduan Edukasi Gizi NutriGrow Teruji Klinis',
                    url: window.location.href
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    const btnText = document.getElementById('share-btn-text');
                    const orig = btnText.textContent;
                    btnText.textContent = '✓ Tautan Disalin!';
                    setTimeout(() => { btnText.textContent = orig; }, 2000);
                });
            }
        };

        // Toggle All Articles
        let isAllArticlesExpanded = false;
        window.toggleAllArticles = function() {
            const extraArticles = document.querySelectorAll('.extra-article');
            const filterTabs = document.getElementById('article-filter-tabs');
            const toggleText = document.getElementById('btn-toggle-text');
            const toggleIcon = document.getElementById('btn-toggle-icon');

            isAllArticlesExpanded = !isAllArticlesExpanded;

            if (isAllArticlesExpanded) {
                extraArticles.forEach(el => el.classList.remove('hidden'));
                if (filterTabs) {
                    filterTabs.classList.remove('hidden');
                    filterTabs.classList.add('flex');
                }
                toggleText.textContent = 'Tampilkan Lebih Sedikit';
                toggleIcon.style.transform = 'rotate(180deg)';
                document.getElementById('article-count-badge').textContent = 'Semua Terbuka';
            } else {
                extraArticles.forEach(el => el.classList.add('hidden'));
                if (filterTabs) {
                    filterTabs.classList.add('hidden');
                    filterTabs.classList.remove('flex');
                }
                toggleText.textContent = 'Lihat Semua Edukasi Gizi';
                toggleIcon.style.transform = 'rotate(0deg)';
                document.getElementById('article-count-badge').textContent = '6 Panduan';

                // Smooth scroll back to Edukasi Gizi section header
                document.getElementById('edukasi-gizi')?.scrollIntoView({ behavior: 'smooth' });
            }
        };

        // Filter Articles by Category
        window.filterArticles = function(category, btnEl) {
            // Update active tab button style
            document.querySelectorAll('.filter-tab-btn').forEach(btn => {
                btn.classList.remove('bg-[#FF539B]', 'text-white', 'font-bold');
                btn.classList.add('bg-white', 'text-slate-600', 'font-medium', 'border', 'border-pink-100');
            });
            if (btnEl) {
                btnEl.classList.add('bg-[#FF539B]', 'text-white', 'font-bold');
                btnEl.classList.remove('bg-white', 'text-slate-600', 'font-medium', 'border-pink-100');
            }

            // Filter items
            const allItems = document.querySelectorAll('.article-item');
            allItems.forEach(item => {
                const itemCat = item.getAttribute('data-category');
                if (category === 'all' || itemCat === category) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        };
    </script>

</body>
</html>
