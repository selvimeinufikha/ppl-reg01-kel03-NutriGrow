<!DOCTYPE html>
@php
    $adminName = $adminName ?? (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
    $adminRole = $adminRole ?? (Auth::check() ? Auth::user()->role_label : 'Super Administrator');
    $faskesName = $faskesName ?? (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Puskesmas Gambir');
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Akun Administrator - NutriGrow | Portal Admin Faskes</title>

    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
<body class="min-h-screen bg-[#f8fafc] font-sans antialiased text-slate-800">

    <!-- Mobile Top Navigation Bar -->
    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto">
            <span class="text-[10px] font-black uppercase tracking-wider text-[#0284c7] bg-sky-50 px-2 py-0.5 rounded-md">
                PORTAL ADMIN
            </span>
        </div>
        <button type="button" onclick="toggleAdminSidebar()" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div id="adminSidebarBackdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden"></div>

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- SIDEBAR NAVIGASI TERPUSAT -->
        @include('components.admin-sidebar', ['active' => 'manajemen-akun'])

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header Bar -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button type="button" onclick="toggleAdminSidebar()" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-sky-600 transition">Portal Admin</a>
                            <span>/</span>
                            <span class="text-slate-800 font-bold">Manajemen Akun Administrator (PBI-028)</span>
                        </div>
                        <h1 class="text-base font-extrabold text-slate-900 tracking-tight">Kelola Akun Administrator &amp; Tenaga Kesehatan</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500 font-medium bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>{{ $tanggalHariIni }}</span>
                    </div>

                    <!-- TOMBOL TAMBAH AKUN (PBI-028) - BIRU SOLID PILL -->
                    <a href="{{ route('admin.akun.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold shadow-xs hover:shadow transition cursor-pointer">
                        <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                        </svg>
                        <span>Tambah Akun Administrator</span>
                    </a>
                </div>
            </header>

            <div class="p-6 md:p-8 max-w-7xl w-full mx-auto space-y-6">

                <!-- Flash Success Notification -->
                @if (session('success'))
                    <div id="alertSuccessBannerAkun" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-xs transition-all duration-500 animate-scale-up">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="font-bold">Pendaftaran Akun Berhasil!</p>
                                <p class="text-emerald-700">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-100/50 transition cursor-pointer" aria-label="Tutup notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                <!-- SUMMARY METRICS -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Akun Admin</p>
                            <p class="text-2xl font-black text-slate-800 mt-1">{{ $totalAdmin }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tenaga Medis &amp; Nakes</p>
                            <p class="text-2xl font-black text-emerald-600 mt-1">{{ $totalNakes }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Super Administrator</p>
                            <p class="text-2xl font-black text-purple-600 mt-1">{{ $totalSuper }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Akun Aktif</p>
                            <p class="text-2xl font-black text-sky-700 mt-1">{{ $totalAktif }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                </div>

                <!-- FILTER BAR -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <form action="{{ route('admin.akun.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-1">
                        <!-- Search Box -->
                        <div class="relative flex-1">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="{{ $filterSearch }}" placeholder="Cari nama, email dinas, NIP/STR, atau faskes..." class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                        </div>

                        <!-- Role Filter -->
                        <select name="role" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                            <option value="all" {{ $filterRole == 'all' ? 'selected' : '' }}>Semua Hak Akses (Role)</option>
                            <option value="superadmin" {{ $filterRole == 'superadmin' ? 'selected' : '' }}>Super Administrator</option>
                            <option value="admin" {{ $filterRole == 'admin' ? 'selected' : '' }}>Administrator Faskes</option>
                            <option value="dokter" {{ $filterRole == 'dokter' ? 'selected' : '' }}>Dokter Spesialis / Umum</option>
                            <option value="bidan" {{ $filterRole == 'bidan' ? 'selected' : '' }}>Bidan Koordinator</option>
                            <option value="ahli_gizi" {{ $filterRole == 'ahli_gizi' ? 'selected' : '' }}>Nutrisionis / Gizi</option>
                        </select>

                        <!-- Status Filter -->
                        <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                            <option value="all" {{ $filterStatus == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="active" {{ $filterStatus == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $filterStatus == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>

                        <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold hover:bg-slate-900 transition">
                            Cari
                        </button>
                        @if ($filterSearch || $filterRole !== 'all' || $filterStatus !== 'all')
                            <a href="{{ route('admin.akun.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 text-center transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- TABLE DAFTAR AKUN ADMINISTRATOR -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="px-5 py-3.5">Nama &amp; Email</th>
                                    <th class="px-5 py-3.5">Hak Akses (Role)</th>
                                    <th class="px-5 py-3.5">Instansi Faskes &amp; Jabatan</th>
                                    <th class="px-5 py-3.5">NIP / STR</th>
                                    <th class="px-5 py-3.5 text-center">Status</th>
                                    <th class="px-5 py-3.5 text-right">Didaftarkan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($adminList as $adm)
                                    @php
                                        $badgeClasses = match($adm->role) {
                                            'superadmin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'admin' => 'bg-sky-50 text-sky-700 border-sky-200',
                                            'dokter' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'bidan' => 'bg-teal-50 text-teal-700 border-teal-200',
                                            'ahli_gizi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200',
                                        };
                                    @endphp
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <!-- Nama & Avatar -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-600 to-blue-700 text-white flex items-center justify-center font-black text-xs shadow-xs shrink-0">
                                                    {{ $adm->inisial }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-extrabold text-slate-900 text-xs truncate">{{ $adm->name }}</p>
                                                    <p class="text-slate-400 text-[11px] font-mono truncate">{{ $adm->email }}</p>
                                                    @if ($adm->phone)
                                                        <p class="text-slate-400 text-[10px]">{{ $adm->phone }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Hak Akses (Role Badge) -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10.5px] font-bold border {{ $badgeClasses }}">
                                                {{ $adm->role_label }}
                                            </span>
                                        </td>

                                        <!-- Faskes & Jabatan -->
                                        <td class="px-5 py-4">
                                            <p class="font-bold text-slate-800 text-xs">{{ $adm->faskes_name ?? 'Faskes Pusat' }}</p>
                                            <p class="text-slate-500 text-[11px] truncate max-w-xs">{{ $adm->jabatan ?? '-' }}</p>
                                        </td>

                                        <!-- NIP / STR -->
                                        <td class="px-5 py-4 whitespace-nowrap font-mono text-[11px] text-slate-600">
                                            {{ $adm->nip_str ?? '-' }}
                                        </td>

                                        <!-- Status (PBI-029: Toggle Cepat) -->
                                        <td class="px-5 py-4 text-center whitespace-nowrap">
                                            <form action="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.akun.toggle-status', $adm->id) : route('admin.akun.toggle-status', $adm->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Ubah status keaktifan akun {{ $adm->name }}?')">
                                                @csrf
                                                @if (($adm->status ?? 'active') === 'active')
                                                    <button type="submit" title="Klik untuk menonaktifkan akun langsung" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-200 transition cursor-pointer">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        <span>Aktif</span>
                                                    </button>
                                                @else
                                                    <button type="submit" title="Klik untuk mengaktifkan akun langsung" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-700 text-[10px] font-bold border border-rose-200 transition cursor-pointer">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        <span>Nonaktif</span>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>

                                        <!-- Aksi Ubah Hak Akses (PBI-029) -->
                                        <td class="px-5 py-4 text-right whitespace-nowrap">
                                            <a href="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.akun.edit', $adm->id) : route('admin.akun.edit', $adm->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-[#0284c7] font-bold text-xs transition border border-sky-200 shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Ubah Akses</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                            <p class="font-bold text-slate-700 text-sm">Tidak ada akun administrator yang sesuai kriteria pencarian.</p>
                                            <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain atau daftarkan akun administrator baru.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        // Auto-dismiss banner notifikasi setelah 3 detik
        document.addEventListener('DOMContentLoaded', function() {
            const alertBanner = document.getElementById('alertSuccessBannerAkun');
            if (alertBanner) {
                setTimeout(function() {
                    alertBanner.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alertBanner.style.opacity = '0';
                    alertBanner.style.transform = 'translateY(-10px)';
                    setTimeout(function() {
                        alertBanner.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
</body>
</html>
