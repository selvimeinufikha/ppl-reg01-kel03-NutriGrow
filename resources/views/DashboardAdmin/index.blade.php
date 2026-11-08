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

    <!-- Mobile Top Navigation Bar (Admin Only) -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#0284c7] bg-sky-50 px-2 py-0.5 rounded-md">
                Admin
            </span>
        </div>
        <button
            type="button"
            onclick="toggleAdminSidebar()"
            class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer"
            aria-label="Buka Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Backdrop for Mobile Sidebar -->
    <div id="adminSidebarBackdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden"></div>

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- =============================================================== -->
        <!-- SIDEBAR NAVIGASI (KHUSUS ADMIN & NAKES)                         -->
        <!-- =============================================================== -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200/80 flex flex-col justify-between py-6 px-5 shrink-0 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand / Logo Admin -->
                <div class="mb-8 px-2 flex items-center justify-between">
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="block">
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

                <!-- Navigation Links (Admin Only) -->
                <nav class="space-y-1.5 text-xs font-semibold">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl bg-[#0284c7] text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard Utama</span>
                    </a>
                    <a href="#tabel-antropometri" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Data Tumbuh Kembang</span>
                    </a>
                    <a href="#tabel-antropometri" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Pencegahan Stunting</span>
                    </a>
                    <a href="javascript:void(0)" onclick="openMeasurementModal()" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Input Pengukuran Baru</span>
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
        <!-- MAIN CONTENT AREA (KHUSUS ADMIN)                                -->
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

                <!-- Admin Action Tools -->
                <div class="flex items-center gap-2.5">
                    <div class="px-3.5 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>SatuSehat Kemenkes Aktif</span>
                    </div>
                    <button
                        type="button"
                        onclick="openMeasurementModal()"
                        class="px-4 py-2 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>+ Input Pengukuran</span>
                    </button>
                </div>
            </div>

            <!-- Toast Notification -->
            <div id="toastSuccess" class="fixed top-5 right-5 z-50 p-4 rounded-2xl bg-emerald-600 text-white shadow-xl flex items-center gap-3 text-xs font-semibold hidden transform transition-all">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span id="toastMessage">Data pengukuran antropometri balita berhasil disimpan!</span>
            </div>

            <!-- 4 Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Card 1 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Balita Terdata</p>
                    <h3 id="statTotalBalita" class="text-3xl font-black text-slate-900 mt-2">1,248</h3>
                    <p class="text-xs text-emerald-600 font-bold mt-2 flex items-center gap-1">
                        <span>&uarr; 12 balita baru</span>
                        <span class="text-slate-400 font-normal">minggu ini</span>
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Gizi Baik &amp; Optimal</p>
                    <h3 id="statGiziOptimal" class="text-3xl font-black text-slate-900 mt-2">1,178</h3>
                    <p class="text-xs text-slate-500 font-medium mt-2">
                        <span class="font-bold text-emerald-600">94.4%</span> dari total populasi balita
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Risiko Stunting</p>
                    <h3 id="statStunting" class="text-3xl font-black text-slate-900 mt-2">42</h3>
                    <p class="text-xs text-amber-700 font-medium mt-2">
                        <span class="font-bold">3.4%</span> &bull; 18 anak program PMT
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-2xs">
                    <p class="text-xs font-bold uppercase tracking-wider text-rose-600">Gizi Kurang / Rentan</p>
                    <h3 id="statGiziKurang" class="text-3xl font-black text-slate-900 mt-2">28</h3>
                    <p class="text-xs text-rose-600 font-medium mt-2">
                        <span class="font-bold">2.2%</span> &bull; Pantauan intensif Puskesmas
                    </p>
                </div>
            </div>

            <!-- Table of Recent Children Antropometri Measurements -->
            <div id="tabel-antropometri" class="bg-white rounded-3xl border border-slate-200/80 shadow-2xs overflow-hidden mb-8">
                <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Pemeriksaan Antropometri Balita Terkini</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Riwayat penimbangan berat badan (BB) dan tinggi badan (TB) Posyandu</p>
                    </div>
                    <button
                        type="button"
                        onclick="openMeasurementModal()"
                        class="px-4 py-2 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold transition shadow-xs cursor-pointer flex items-center gap-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>+ Input Pengukuran Baru</span>
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
                        <tbody id="measurementTableBody" class="divide-y divide-slate-100 text-xs">
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

    <!-- =============================================================== -->
    <!-- MODAL FORM: INPUT PENGUKURAN ANTROPOMETRI BALITA                -->
    <!-- =============================================================== -->
    <div id="measurementModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0284c7] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Input Pengukuran Antropometri</h3>
                        <p class="text-xs text-slate-500">Standar Kurva Pertumbuhan Balita WHO 2006</p>
                    </div>
                </div>
                <button type="button" onclick="closeMeasurementModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formInputPengukuran" onsubmit="handleMeasurementSubmit(event)" class="mt-4 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Balita *</label>
                    <input type="text" id="m_nama" required placeholder="Contoh: Arka Daniswara" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Ibu / Wali *</label>
                        <input type="text" id="m_ibu" required placeholder="Contoh: Ibu Ratih" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Usia Balita (Bulan) *</label>
                        <input type="number" id="m_usia" min="0" max="60" required placeholder="Contoh: 12" oninput="calculateLiveZScore()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Berat Badan (kg) *</label>
                        <input type="number" step="0.1" id="m_bb" required placeholder="Contoh: 9.2" oninput="calculateLiveZScore()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tinggi / Panjang (cm) *</label>
                        <input type="number" step="0.1" id="m_tb" required placeholder="Contoh: 76.5" oninput="calculateLiveZScore()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Faskes / Posyandu *</label>
                    <select id="m_faskes" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 outline-none">
                        <option value="Posyandu Melati II">Posyandu Melati II</option>
                        <option value="Posyandu Mawar I">Posyandu Mawar I</option>
                        <option value="Puskesmas Kecamatan Tebet">Puskesmas Kecamatan Tebet</option>
                        <option value="Posyandu Teratai III">Posyandu Teratai III</option>
                    </select>
                </div>

                <!-- Live Antropometri / Z-Score Classification Badge -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <p class="text-[11px] font-bold text-slate-500 mb-1">Klasifikasi Status Gizi WHO:</p>
                    <div id="liveStatusBadge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-200 text-slate-700">
                        Masukkan BB, TB &amp; Usia
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeMeasurementModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold shadow-md cursor-pointer">
                        Simpan Hasil Pengukuran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT: TOGGLE SIDEBAR, MODAL & LIVE WHO CALCULATION -->
    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            if (!sidebar || !backdrop) return;

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function openMeasurementModal() {
            document.getElementById('measurementModal').classList.remove('hidden');
        }

        function closeMeasurementModal() {
            document.getElementById('measurementModal').classList.add('hidden');
        }

        // Live calculation estimation based on WHO child growth standards
        function calculateLiveZScore() {
            const usia = parseFloat(document.getElementById('m_usia').value) || 0;
            const bb = parseFloat(document.getElementById('m_bb').value) || 0;
            const tb = parseFloat(document.getElementById('m_tb').value) || 0;
            const badge = document.getElementById('liveStatusBadge');

            if (!usia || !bb || !tb) {
                badge.className = "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-200 text-slate-700";
                badge.innerText = "Masukkan BB, TB & Usia";
                return { status: "Belum lengkap", color: "slate" };
            }

            // Expected median height: ~50cm at birth + ~2.5cm/mo (1-6) + ~1.2cm/mo (7-12) + ~1cm/mo (>12)
            let medianTB = 50 + (usia <= 6 ? usia * 2.5 : (6 * 2.5) + (Math.min(usia, 12) - 6) * 1.5 + Math.max(0, usia - 12) * 0.9);
            let medianBB = 3.3 + (usia * 0.55);

            let isStunting = tb < (medianTB - 5);
            let isWasting = bb < (medianBB - 2);

            if (isStunting) {
                badge.className = "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300";
                badge.innerText = "⚠️ Risiko Stunting (Perlu PMT & Evaluasi Nakes)";
                return { status: "Risiko Stunting (Perlu PMT)", color: "amber" };
            } else if (isWasting) {
                badge.className = "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300";
                badge.innerText = "⚠️ Gizi Kurang (Intervensi Puskesmas)";
                return { status: "Gizi Kurang (Intervensi Puskesmas)", color: "rose" };
            } else {
                badge.className = "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300";
                badge.innerText = "✅ Optimal / Sesuai Kurva WHO";
                return { status: "Optimal / Sesuai Kurva WHO", color: "emerald" };
            }
        }

        function handleMeasurementSubmit(e) {
            e.preventDefault();
            const nama = document.getElementById('m_nama').value;
            const ibu = document.getElementById('m_ibu').value;
            const usia = document.getElementById('m_usia').value;
            const bb = document.getElementById('m_bb').value;
            const tb = document.getElementById('m_tb').value;
            const faskes = document.getElementById('m_faskes').value;
            const res = calculateLiveZScore();

            // Insert new row to the table
            const tableBody = document.getElementById('measurementTableBody');
            const randId = 'BLT-' + Math.floor(1000 + Math.random() * 9000);
            const badgeClass = res.color === 'emerald'
                ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                : (res.color === 'amber' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200');

            const newRow = document.createElement('tr');
            newRow.className = "hover:bg-sky-50/50 transition bg-emerald-50/30";
            newRow.innerHTML = `
                <td class="py-3.5 px-5 font-bold text-slate-900">
                    <span>${nama}</span>
                    <span class="block text-[10px] text-slate-400 font-mono">${randId}</span>
                </td>
                <td class="py-3.5 px-5 text-slate-600">${usia} Bulan</td>
                <td class="py-3.5 px-5 text-slate-600">${ibu}</td>
                <td class="py-3.5 px-5 font-bold text-slate-800">${bb} kg / ${tb} cm</td>
                <td class="py-3.5 px-5">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold ${badgeClass} border">
                        ${res.status}
                    </span>
                </td>
                <td class="py-3.5 px-5 text-slate-600">${faskes}</td>
                <td class="py-3.5 px-5 text-emerald-600 font-bold">Baru saja</td>
            `;

            tableBody.insertBefore(newRow, tableBody.firstChild);

            // Update Total Balita Stat
            const statTotal = document.getElementById('statTotalBalita');
            if (statTotal) {
                let current = parseInt(statTotal.innerText.replace(',', '')) || 1248;
                statTotal.innerText = (current + 1).toLocaleString('en-US');
            }

            // Close modal & reset
            closeMeasurementModal();
            document.getElementById('formInputPengukuran').reset();
            calculateLiveZScore();

            // Show toast notification
            const toast = document.getElementById('toastSuccess');
            const toastMsg = document.getElementById('toastMessage');
            if (toast && toastMsg) {
                toastMsg.innerText = `Data balita ${nama} berhasil disimpan ke sistem!`;
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 4000);
            }
        }
    </script>

</body>
</html>
