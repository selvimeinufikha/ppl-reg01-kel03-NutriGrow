@props(['active' => 'dashboard'])

<!-- ========================================== -->
<!-- LEFT SIDEBAR: NAVIGASI UTAMA (GRADASI PINK KE BIRU) -->
<!-- ========================================== -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
    
    <!-- Sidebar Top: Brand & Menu -->
    <div class="p-5 overflow-y-auto no-scrollbar flex-1 bg-transparent">
        <!-- Brand Logo -->
        <div class="flex items-center justify-between mb-7 pl-1">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain transition group-hover:scale-102">
            </a>
            <button type="button" onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-white/80" title="Tutup Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Group: UTAMA -->
        <div class="mb-5">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                UTAMA
            </span>
            <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? 'dashboard') === 'dashboard' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                <svg class="w-4 h-4 {{ ($active ?? 'dashboard') === 'dashboard' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Group: DATA KELUARGA -->
        <div class="mb-5">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                DATA KELUARGA
            </span>
            <nav class="space-y-1">
                <!-- Data Kehamilan -->
                <a href="{{ Route::has('kehamilan.index') ? route('kehamilan.index') : route('dashboard.pengguna') . '#data-kehamilan' }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'kehamilan' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'kehamilan' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Data Kehamilan</span>
                </a>

                <!-- Data Pasangan -->
                <a href="{{ Route::has('pasangan.index') ? route('pasangan.index') : route('dashboard.pengguna') . '#data-pasangan' }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'pasangan' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'pasangan' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span>Data Pasangan</span>
                </a>

                <!-- Data Anak -->
                <a href="{{ Route::has('data-anak.index') ? route('data-anak.index') : route('dashboard.pengguna') . '#data-anak' }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ in_array(($active ?? ''), ['data-anak', 'anak']) ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ in_array(($active ?? ''), ['data-anak', 'anak']) ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Data Anak</span>
                </a>
            </nav>
        </div>

        <!-- Group: REKAM MEDIS -->
        <div class="mb-5">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                REKAM MEDIS
            </span>
            <nav class="space-y-1">
                <!-- Pemeriksaan Kehamilan -->
                <a href="{{ route('dashboard.pengguna') }}#pemeriksaan-kehamilan" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'pemeriksaan-kehamilan' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'pemeriksaan-kehamilan' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Pemeriksaan Kehamilan</span>
                </a>

                <!-- Tumbuh Kembang Anak -->
                <a href="{{ Route::has('tumbuh-kembang.index') ? route('tumbuh-kembang.index') : route('dashboard.pengguna') . '#tumbuh-kembang' }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'tumbuh-kembang' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'tumbuh-kembang' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>Tumbuh Kembang Anak</span>
                </a>

                <!-- Reminder Pemeriksaan -->
                <a href="{{ route('dashboard.pengguna') }}#reminder-pemeriksaan" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'reminder' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'reminder' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Reminder Pemeriksaan</span>
                </a>

                <!-- Layanan Kesehatan -->
                <a href="{{ route('dashboard.pengguna') }}#layanan-kesehatan" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'layanan-kesehatan' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'layanan-kesehatan' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Layanan Kesehatan</span>
                </a>
            </nav>
        </div>

        <!-- Group: NUTRISI & PANTAUAN -->
        <div class="mb-4">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">
                NUTRISI &amp; PANTAUAN
            </span>
            <nav class="space-y-1">
                <!-- Rekomendasi Nutrisi -->
                <a href="{{ Route::has('informasi-nutrisi.index') ? route('informasi-nutrisi.index') : route('dashboard.pengguna') . '#rekomendasi-nutrisi' }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ in_array(($active ?? ''), ['rekomendasi-nutrisi', 'nutrisi']) ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ in_array(($active ?? ''), ['rekomendasi-nutrisi', 'nutrisi']) ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Rekomendasi Nutrisi</span>
                </a>

                <!-- Risiko Stunting -->
                <a href="{{ route('dashboard.pengguna') }}#risiko-stunting" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'risiko-stunting' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'risiko-stunting' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Risiko Stunting</span>
                </a>

                <!-- Edukasi Gizi -->
                <a href="{{ route('dashboard.pengguna') }}#edukasi-gizi" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl {{ ($active ?? '') === 'edukasi-gizi' ? 'bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20' : 'text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 font-semibold text-xs transition' }}">
                    <svg class="w-4 h-4 {{ ($active ?? '') === 'edukasi-gizi' ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Edukasi Gizi</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Sidebar Bottom: Sync Status & Logout -->
    <div class="p-4 border-t border-sky-100/60 bg-transparent space-y-2">
        <!-- Sync Pill: Posyandu Melati II -->
        <div class="px-3.5 py-2.5 rounded-2xl bg-white/90 backdrop-blur-xs border border-sky-200/70 flex items-center justify-between text-[11px] shadow-2xs">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                <div class="text-left">
                    <div class="font-bold text-slate-800 leading-tight">Posyandu Melati II</div>
                    <div class="text-[10px] text-slate-400 font-medium leading-tight">Tersinkronisasi</div>
                </div>
            </div>
            <button type="button" class="text-sky-500 hover:text-sky-700 transition" title="Sinkronisasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
        </div>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-rose-50/60 transition cursor-pointer">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

<!-- Overlay backdrop for mobile sidebar -->
<div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 hidden lg:hidden"></div>

<script>
    if (typeof window.toggleSidebar !== 'function') {
        window.toggleSidebar = function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop') || document.getElementById('sidebarOverlay');
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
            if (backdrop) backdrop.classList.toggle('hidden');
        };
    }
</script>
