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
    <title>Buat Password Baru Admin & Nakes - NutriGrow</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="min-h-screen lg:h-screen bg-white font-sans antialiased text-slate-800 flex flex-col justify-between selection:bg-sky-500 selection:text-white lg:overflow-hidden">

    <div class="min-h-screen lg:h-full w-full flex flex-col lg:flex-row bg-white relative overflow-x-hidden lg:overflow-hidden select-none">

        <!-- LEFT COLUMN: RESET FORM -->
        <div class="w-full lg:w-1/2 min-h-screen lg:min-h-0 lg:h-full bg-white px-6 sm:px-8 lg:px-10 xl:px-14 py-5 sm:py-6 lg:py-8 flex flex-col justify-between items-center relative z-10 overflow-y-auto no-scrollbar">

            <!-- Top Row: Logo -->
            <div class="w-full flex items-center justify-between sm:justify-start gap-3.5 sm:gap-4 relative z-10 mb-4 sm:mb-6">
                <a href="{{ route('admin.login') }}" class="group block shrink-0">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain transition-transform group-hover:scale-105" onerror="this.onerror=null; this.src='{{ asset('images/nutrigrow-icon.png') }}';" />
                    <span class="block text-[9.5px] sm:text-[10px] font-black uppercase tracking-wider text-[#0284c7] mt-0.5">TENAGA KESEHATAN</span>
                </a>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-50/90 border border-slate-200/90 shadow-2xs shrink-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-700 tracking-tight whitespace-nowrap">Portal Khusus Faskes &amp; Nakes</span>
                </div>
            </div>

            <!-- Center Content: Reset Form -->
            <div class="w-full max-w-[420px] mx-auto my-auto py-2">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200/80 text-sky-700 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-2.5">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>KATA SANDI BARU</span>
                </div>

                <h1 class="text-2xl sm:text-[30px] font-extrabold text-slate-900 tracking-tight leading-tight mb-1.5">
                    Buat Password Baru
                </h1>
                <p class="text-xs sm:text-[13px] text-slate-500 mb-5 leading-relaxed">
                    Silakan masukkan kata sandi baru untuk akun resmi admin/nakes Anda.
                </p>

                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div class="flex-1">
                            <p class="font-bold">Gagal Menyimpan Sandi</p>
                            <p class="mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token ?? '' }}">

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">EMAIL PETUGAS / ADMIN <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $email ?? 'admin@nutrigrow.id') }}" required readonly class="block w-full px-4 py-3 sm:py-3.5 text-sm rounded-2xl bg-slate-100 border border-slate-200 text-slate-600 cursor-not-allowed" />
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">KATA SANDI BARU <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter kombinasi aman" class="block w-full px-4 py-3 sm:py-3.5 text-sm rounded-2xl bg-white border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-sky-100 focus:border-[#0284c7] transition" />
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">KONFIRMASI KATA SANDI BARU <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi baru" class="block w-full px-4 py-3 sm:py-3.5 text-sm rounded-2xl bg-white border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-sky-100 focus:border-[#0284c7] transition" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-6 rounded-2xl text-sm sm:text-base font-bold text-white bg-[#0284c7] hover:bg-[#0369a1] active:bg-[#075985] shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer">
                            <span>Simpan Kata Sandi Baru &amp; Masuk</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>

                <div class="text-center mt-5">
                    <a href="{{ route('admin.login') }}" class="text-xs font-bold text-[#0284c7] hover:underline">&larr; Batalkan &amp; Kembali ke Masuk Admin</a>
                </div>
            </div>

            <div class="w-full pt-4 text-center text-[11px] text-slate-400 border-t border-slate-100">
                &copy; 2025 NutriGrow Health Platform. Hak Cipta Dilindungi.
            </div>
        </div>

        <!-- RIGHT COLUMN: HERO -->
        <div class="w-full lg:w-1/2 min-h-screen lg:min-h-0 lg:h-full relative px-6 sm:px-8 lg:px-10 xl:px-14 py-5 sm:py-6 lg:py-8 flex flex-col justify-between ambient-glow-mobile lg:bg-transparent z-20 overflow-visible">
            <div class="hidden lg:block absolute inset-y-0 left-[-50px] xl:left-[-65px] right-0 pointer-events-none z-0">
                <svg class="w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="adminBgGradReset" x1="100%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#f0f9ff" /><stop offset="35%" stop-color="#f8fafc" /><stop offset="70%" stop-color="#ffffff" /><stop offset="100%" stop-color="#fdf2f8" stop-opacity="0.95" />
                        </linearGradient>
                        <radialGradient id="adminTopGlowReset" cx="80%" cy="15%" r="55%"><stop offset="0%" stop-color="#38bdf8" stop-opacity="0.22" /><stop offset="100%" stop-color="#38bdf8" stop-opacity="0" /></radialGradient>
                        <radialGradient id="adminBotGlowReset" cx="25%" cy="80%" r="50%"><stop offset="0%" stop-color="#f472b6" stop-opacity="0.18" /><stop offset="100%" stop-color="#f472b6" stop-opacity="0" /></radialGradient>
                    </defs>
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#adminBgGradReset)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#adminTopGlowReset)" />
                    <path d="M 1000,0 L 90,0 C 30,300 0,550 100,1000 L 1000,1000 Z" fill="url(#adminBotGlowReset)" />
                </svg>
            </div>
            <div class="w-full flex items-center justify-end relative z-10 mb-4">
                <a href="{{ route('login') }}" class="text-xs text-[#0284c7] font-bold hover:underline">Masuk Pengguna / Orang Tua &rarr;</a>
            </div>
            <div class="my-auto py-4 max-w-[420px] mx-auto w-full flex flex-col items-center justify-center relative z-10">
                <div class="relative w-full max-w-[340px] sm:max-w-[370px] rounded-[26px] overflow-hidden shadow-xl shadow-sky-100/60 border border-white/90 bg-white">
                    <img src="{{ asset('images/admin-security-lock.png') }}" alt="Keamanan Akun" class="w-full h-[220px] sm:h-[250px] object-cover" onerror="this.onerror=null; this.src='{{ asset('images/forgot-password-hero.png') }}';" />
                </div>
                <div class="text-center mt-5 w-full max-w-[420px] px-2">
                    <h2 class="text-lg sm:text-[21px] font-extrabold text-[#0f172a] text-center">Keamanan Akun &amp; Pemulihan Password</h2>
                    <p class="text-xs sm:text-[13px] text-slate-500 mt-2 text-center">Instruksi pemulihan kata sandi dikirimkan secara aman demi melindungi integritas data faskes dan kerahasiaan rekam medis pasien.</p>
                </div>
            </div>
            <div class="pt-4 flex items-center justify-between text-[11px] text-slate-400 border-t border-slate-200/50 relative z-10">
                <span class="flex items-center gap-1.5 text-slate-600 font-medium">Standar Keamanan Data Medis Terproteksi</span>
                <span>NutriGrow Health v2.4</span>
            </div>
        </div>
    </div>
</body>
</html>

