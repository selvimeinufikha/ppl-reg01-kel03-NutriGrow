@php
    $active = $active ?? 'dashboard';
    $user = Auth::user();
    $isSuperAdmin = $user && method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin();
    $faskesName = ($user && $user->faskes_name) ? $user->faskes_name : 'Puskesmas Kecamatan Tebet & NutriGrow Health';

    $isDashboard = in_array($active, ['dashboard', 'admin.dashboard', 'superadmin.dashboard']);
    $isPengguna = in_array($active, ['pengguna', 'data-pengguna']);
    $isPemeriksaan = in_array($active, ['pemeriksaan-kehamilan', 'pemeriksaan']);
    $isTumbuhKembang = in_array($active, ['tumbuh-kembang', 'pengukuran-anak', 'pengukuran']);
    $isEdukasi = in_array($active, ['edukasi-gizi', 'edukasi']);
    $isLayanan = in_array($active, ['layanan-kesehatan', 'fasilitas']);
    $isNutrisi = in_array($active, ['informasi-nutrisi', 'nutrisi']);
    $isAkun = in_array($active, ['manajemen-akun', 'akun']);
    $isLog = in_array($active, ['log-aktivitas', 'log']);
@endphp

<!-- SIDEBAR NAVIGASI PORTAL ADMIN & TENAGA KESEHATAN (TERPUSAT & KONSISTEN) -->
<aside id="adminSidebar" 
       class="fixed inset-y-0 left-0 z-50 w-[260px] xl:w-[275px] border-r border-sky-200/80 shadow-xs flex flex-col justify-between py-4 px-3.5 shrink-0 transform -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen lg:max-h-screen lg:self-start lg:z-30 transition-transform duration-300 ease-in-out select-none" 
       style="background: linear-gradient(180deg, #e8f3fc 0%, #f1f7fd 35%, #e2eefa 70%, #d8e9f8 100%);">
    
    <div class="overflow-y-auto no-scrollbar flex-1 flex flex-col min-h-0">
        <!-- Brand Header -->
        <div class="px-2 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="block">
                <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 sm:h-8 w-auto object-contain">
                <div class="text-[9.5px] font-black uppercase tracking-widest text-[#e11d48] mt-1">
                    PORTAL ADMIN <span class="text-slate-500 font-normal">| TENAGA KESEHATAN</span>
                </div>
            </a>

            <!-- Verified Badge (Rounded Full dengan Border Halus) -->
            <div class="mt-3.5 inline-flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-xs border border-sky-200/90 shadow-2xs w-full">
                <svg class="w-4 h-4 text-[#0284c7] shrink-0 ml-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <div class="text-[10px] font-extrabold tracking-tight text-[#0369a1] leading-tight">
                    <div>TENAGA KESEHATAN</div>
                    <div>TERVERIFIKASI</div>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1 text-xs font-semibold">
            <!-- 1. Dashboard Admin -->
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $isDashboard ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                <svg class="w-4 h-4 transition-colors {{ $isDashboard ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                </svg>
                <span>Dashboard Admin</span>
            </a>

            <!-- 2. Data Pengguna -->
            <a href="javascript:void(0)" 
               onclick="if(typeof showFeatureNotice === 'function'){ showFeatureNotice('Data Pengguna'); } else { alert('Fitur Data Pengguna sedang dalam sinkronisasi dengan database terpusat.'); }" 
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $isPengguna ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                <svg class="w-4 h-4 transition-colors {{ $isPengguna ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Data Pengguna</span>
            </a>

            <!-- 3. Data Pemeriksaan Kehamilan -->
            <a href="{{ Route::has('admin.pemeriksaan.index') ? route('admin.pemeriksaan.index') : 'javascript:void(0)' }}" 
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $isPemeriksaan ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                <svg class="w-4 h-4 transition-colors {{ $isPemeriksaan ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Data Pemeriksaan Kehamilan</span>
            </a>

            <!-- 4. Data Tumbuh Kembang Anak -->
            <a href="{{ Route::has('admin.pengukuran.index') ? route('admin.pengukuran.index') : 'javascript:void(0)' }}" 
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $isTumbuhKembang ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                <svg class="w-4 h-4 transition-colors {{ $isTumbuhKembang ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Data Tumbuh Kembang Anak</span>
            </a>

            <!-- 5. Data Edukasi Gizi -->
            <a href="{{ Route::has('admin.edukasi.index') ? route('admin.edukasi.index') : 'javascript:void(0)' }}" 
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $isEdukasi ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                <svg class="w-4 h-4 transition-colors {{ $isEdukasi ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Data Edukasi Gizi</span>
            </a>

            <!-- 6. Data Layanan Kesehatan -->
            <a href="{{ Route::has('admin.fasilitas.index') ? route('admin.fasilitas.index') : 'javascript:void(0)' }}" 
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $isLayanan ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                <svg class="w-4 h-4 transition-colors {{ $isLayanan ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Data Layanan Kesehatan</span>
            </a>

            <!-- 7. Data Informasi Nutrisi -->
            <a href="{{ Route::has('admin.informasi-nutrisi.index') ? route('admin.informasi-nutrisi.index') : 'javascript:void(0)' }}" 
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $isNutrisi ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                <svg class="w-4 h-4 transition-colors {{ $isNutrisi ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                <span>Data Informasi Nutrisi</span>
            </a>

            @if($isSuperAdmin)
                <!-- 8. Manajemen Akun Admin (HANYA UNTUK SUPER ADMIN) -->
                <a href="{{ Route::has('admin.akun.index') ? route('admin.akun.index') : (Route::has('superadmin.akun.index') ? route('superadmin.akun.index') : 'javascript:void(0)') }}" 
                   class="group flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ $isAkun ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 transition-colors {{ $isAkun ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Manajemen Akun Admin</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded-md {{ $isAkun ? 'bg-white/20 text-white' : 'bg-rose-50 text-[#e11d48] border border-rose-100' }} text-[9px] font-black uppercase">
                        SUPER
                    </span>
                </a>

                <!-- 9. Log Aktivitas & Audit (HANYA UNTUK SUPER ADMIN) -->
                <a href="{{ Route::has('admin.log.index') ? route('admin.log.index') : (Route::has('superadmin.log.index') ? route('superadmin.log.index') : 'javascript:void(0)') }}" 
                   class="group flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ $isLog ? 'bg-[#0284c7] text-white shadow-xs font-bold' : 'text-slate-700 hover:text-sky-800 hover:bg-white/70 hover:shadow-2xs' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 transition-colors {{ $isLog ? 'text-white' : 'text-slate-400 group-hover:text-sky-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Log Aktivitas &amp; Audit</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded-md {{ $isLog ? 'bg-white/20 text-white' : 'bg-rose-50 text-[#e11d48] border border-rose-100' }} text-[9px] font-black uppercase">
                        AUDIT
                    </span>
                </a>
            @endif
        </nav>
    </div>

    <!-- Bottom Section of Sidebar -->
    <div class="pt-3 border-t border-sky-200/60 shrink-0 space-y-2 mt-auto">
        <!-- Faskes Card -->
        <div class="p-3 rounded-2xl bg-white/95 backdrop-blur-xs border border-sky-200/80 shadow-2xs flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center shrink-0 text-sky-600 shadow-2xs">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-800 truncate">{{ $faskesName }}</p>
                <p class="text-[10px] font-semibold text-[#e11d48]">Akreditasi Paripurna</p>
                <p class="text-[9.5px] text-slate-400 flex items-center gap-1 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                    <span>Faskes Wilayah 01</span>
                </p>
            </div>
        </div>

        <!-- Keluar Portal (Tombol Logout Admin/Nakes) -->
        <form method="POST" action="{{ route('admin.logout') }}" id="adminLogoutForm" class="m-0">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-[#e11d48] hover:bg-rose-50/80 hover:text-rose-700 transition cursor-pointer">
                <svg class="w-4 h-4 text-[#e11d48]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Keluar Portal</span>
            </button>
        </form>
    </div>
</aside>

<script>
    // Universal Admin Sidebar Toggle for Mobile View
    window.toggleAdminSidebar = window.toggleAdminSidebar || function() {
        const sidebar = document.getElementById('adminSidebar') || document.getElementById('sidebarMenu');
        const backdrop = document.getElementById('adminSidebarBackdrop') || document.getElementById('sidebarBackdrop');
        if (sidebar) sidebar.classList.toggle('-translate-x-full');
        if (backdrop) backdrop.classList.toggle('hidden');
    };
    window.toggleSidebar = window.toggleSidebar || window.toggleAdminSidebar;
</script>
