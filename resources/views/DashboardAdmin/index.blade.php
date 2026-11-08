<!DOCTYPE html>
@php
    $adminName = $adminName ?? (Auth::check() ? Auth::user()->name : 'dr. Sarah Nakes (Admin Faskes)');
    $adminEmail = $adminEmail ?? (Auth::check() ? Auth::user()->email : 'admin@nutrigrow.id');
    $adminRole = $adminRole ?? (Auth::check() && Auth::user()->role === 'nakes' ? 'Tenaga Kesehatan (Bidan/Dokter)' : 'Administrator Faskes');
    $faskesName = $faskesName ?? (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Puskesmas Kecamatan Tebet & Posyandu Melati');
    $nipStr = $nipStr ?? (Auth::check() && Auth::user()->nip_str ? Auth::user()->nip_str : 'STR-19880412-2023-019');
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin & Tenaga Kesehatan - NutriGrow | SatuSehat Faskes</title>

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
</head>
<body class="min-h-screen bg-slate-50 font-sans antialiased text-slate-800">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- =============================================================== -->
        <!-- SIDEBAR NAVIGASI                                                -->
        <!-- =============================================================== -->
        <aside class="w-full lg:w-72 bg-white border-r border-slate-200/80 flex flex-col justify-between py-6 px-5 shrink-0">
            <div>
                <!-- Brand / Logo -->
                <div class="mb-8 px-2 flex items-center justify-between">
                    <div>
                        <a href="{{ route('dashboard.admin') }}" class="block">
                            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-8 w-auto">
                            <span class="block text-[10px] font-black uppercase tracking-widest text-[#0284c7] mt-1">
                                PORTAL ADMIN &amp; NAKES
                            </span>
                        </a>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                        Online
                    </span>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1.5 text-xs font-semibold">
                    <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl bg-[#0284c7] text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard Utama</span>
                    </a>
                    <a href="#data-balita" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Data Tumbuh Kembang</span>
                    </a>
                    <a href="#pemantauan-stunting" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Pencegahan Stunting</span>
                    </a>
                    <a href="#posyandu" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Jadwal Posyandu &amp; Faskes</span>
                    </a>
                    <a href="#satusehat" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Sinkronisasi SatuSehat</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Sidebar: User Profile & Logout -->
            <div class="pt-6 border-t border-slate-200/80">
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/60 mb-3">
                    <p class="text-xs font-bold text-slate-800 truncate">{{ $adminName }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ $adminRole }}</p>
                    <p class="text-[10px] text-sky-700 font-medium truncate mt-0.5">{{ $nipStr }}</p>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar Portal Admin</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- =============================================================== -->
        <!-- MAIN CONTENT AREA                                               -->
        <!-- =============================================================== -->
        <main class="flex-1 p-6 lg:p-10 max-w-7xl mx-auto w-full">

            <!-- Top Header Banner -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200/80 mb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-bold mb-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>{{ $faskesName }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Dashboard Pemantauan Gizi &amp; Intervensi Stunting
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        {{ $tanggalHariIni }} &bull; Data Terhubung Langsung ke Sistem Informasi Posyandu Terintegrasi
                    </p>
                </div>

                <div class="flex items-center gap-2.5">
                    <a
                        href="{{ route('home') }}"
                        target="_blank"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs"
                    >
                        <span>Lihat Beranda</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 4 Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Card 1 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Balita Terdata</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-2">1,248</h3>
                    <p class="text-xs text-emerald-600 font-bold mt-2 flex items-center gap-1">
                        <span>&uarr; 12 balita baru</span>
                        <span class="text-slate-400 font-normal">minggu ini</span>
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Gizi Baik &amp; Optimal</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-2">1,178</h3>
                    <p class="text-xs text-slate-500 font-medium mt-2">
                        <span class="font-bold text-emerald-600">94.4%</span> dari total populasi balita
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Risiko Stunting</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-2">42</h3>
                    <p class="text-xs text-amber-700 font-medium mt-2">
                        <span class="font-bold">3.4%</span> &bull; 18 anak program PMT
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-rose-600">Gizi Kurang / Rentan</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-2">28</h3>
                    <p class="text-xs text-rose-600 font-medium mt-2">
                        <span class="font-bold">2.2%</span> &bull; Pantauan intensif Puskesmas
                    </p>
                </div>
            </div>

            <!-- Table of Recent Children Antropometri Measurements -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xs overflow-hidden mb-8">
                <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Pemeriksaan Antropometri Balita Terkini</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Riwayat penimbangan berat badan (BB) dan tinggi badan (TB) Posyandu</p>
                    </div>
                    <button class="px-4 py-2 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold transition shadow-xs">
                        + Input Pengukuran Baru
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                                <th class="py-3 px-5">ID &amp; Nama Balita</th>
                                <th class="py-3 px-5">Usia</th>
                                <th class="py-3 px-5">Ibu / Wali</th>
                                <th class="py-3 px-5">BB / TB</th>
                                <th class="py-3 px-5">Status Gizi (WHO)</th>
                                <th class="py-3 px-5">Lokasi Faskes</th>
                                <th class="py-3 px-5">Waktu Periksa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-900">
                                    <span>Muhammad Kenzo Ardiansyah</span>
                                    <span class="block text-[10px] text-slate-400 font-mono">BLT-0821</span>
                                </td>
                                <td class="py-3.5 px-5 text-slate-600">14 Bulan</td>
                                <td class="py-3.5 px-5 text-slate-600">Ibu Rina Sastrawan</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">10.2 kg / 78.5 cm</td>
                                <td class="py-3.5 px-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Optimal / Sesuai Kurva WHO
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-slate-600">Posyandu Mawar I</td>
                                <td class="py-3.5 px-5 text-slate-400">Hari ini, 08:45 WIB</td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-900">
                                    <span>Aisyah Putri Azzahra</span>
                                    <span class="block text-[10px] text-slate-400 font-mono">BLT-0822</span>
                                </td>
                                <td class="py-3.5 px-5 text-slate-600">9 Bulan</td>
                                <td class="py-3.5 px-5 text-slate-600">Ibu Siti Aminah</td>
                                <td class="py-3.5 px-5 font-bold text-amber-700">6.8 kg / 66.0 cm</td>
                                <td class="py-3.5 px-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Risiko Stunting (Perlu PMT)
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-slate-600">Posyandu Melati II</td>
                                <td class="py-3.5 px-5 text-slate-400">Hari ini, 09:15 WIB</td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-900">
                                    <span>Zhafira Humaira</span>
                                    <span class="block text-[10px] text-slate-400 font-mono">BLT-0824</span>
                                </td>
                                <td class="py-3.5 px-5 text-slate-600">6 Bulan</td>
                                <td class="py-3.5 px-5 text-slate-600">Ibu Anita Wijaya</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">7.4 kg / 64.8 cm</td>
                                <td class="py-3.5 px-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                        Optimal (Transisi MPASI)
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-slate-600">Posyandu Melati II</td>
                                <td class="py-3.5 px-5 text-slate-400">Kemarin, 10:30 WIB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

    </div>

</body>
</html>

