<!DOCTYPE html>
@php
    $userName = Auth::check() ? Auth::user()->name : 'Pengguna';
    \Carbon\Carbon::setLocale('id');
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Data Pasangan - NutriGrow</title>
    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        brand: { 50:'#fff1f2',100:'#ffe4e6',200:'#fecdd3',300:'#fda4af',400:'#fb7185',500:'#f43f5e',600:'#e11d48',700:'#be123c',800:'#9f1239',900:'#881337' }
                    }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
        <div class="p-5 overflow-y-auto no-scrollbar flex-1">
            <div class="flex items-center justify-between mb-7 pl-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain">
                </a>
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-white/80">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">UTAMA</span>
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-pink-50/60 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">DATA KELUARGA</span>
                <nav class="space-y-1">
                    <a href="{{ route('pasangan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-gradient-to-r from-brand-600 via-rose-500 to-pink-500 text-white font-bold text-xs shadow-md shadow-pink-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Data Pasangan</span>
                    </a>
                </nav>
            </div>
        </div>
        <div class="p-4 border-t border-sky-100/60 space-y-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-white/80 transition cursor-pointer">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 hidden lg:hidden"></div>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50/80 border border-pink-200/80 text-brand-700 text-xs font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>Tambah Data Pasangan</span>
                </div>
            </div>
            <a href="#" class="w-9 h-9 rounded-full bg-gradient-to-tr from-brand-600 to-pink-500 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                {{ strtoupper(substr($userName, 0, 1)) }}
            </a>
        </header>

        <main class="flex-1 overflow-y-auto no-scrollbar p-4 sm:p-6 lg:p-8 space-y-6 max-w-3xl w-full mx-auto">
            <!-- Breadcrumb & Title -->
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                    <a href="{{ route('pasangan.index') }}" class="hover:text-brand-600 transition">Data Pasangan</a>
                    <span>/</span>
                    <span class="text-brand-600">Form Tambah</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Data Pasangan</h1>
                <p class="text-sm text-slate-500 mt-1">Lengkapi informasi calon ayah atau calon ibu untuk integrasi data kehamilan dan pemantauan gizi keluarga.</p>
            </div>

            <!-- Error Banner -->
            @if ($errors->any())
                <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-rose-800">Mohon periksa kembali isian formulir:</h4>
                            <ul class="mt-1 list-disc list-inside text-xs text-rose-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm p-6 sm:p-8">
                <form action="{{ route('pasangan.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nama Pasangan -->
                    <div>
                        <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Pasangan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                            placeholder="Contoh: Budi Santoso"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nama') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500' }} text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 transition">
                        @error('nama')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Tanggal Lahir <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('tanggal_lahir') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500' }} text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 transition">
                        @error('tanggal_lahir')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Pasangan -->
                    <div>
                        <label for="status_pasangan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Status Pasangan <span class="text-rose-500">*</span>
                        </label>
                        <select name="status_pasangan" id="status_pasangan" required
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('status_pasangan') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500' }} text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 transition bg-white">
                            <option value="">-- Pilih Status Hubungan --</option>
                            <option value="suami" {{ old('status_pasangan') === 'suami' ? 'selected' : '' }}>Suami</option>
                            <option value="istri" {{ old('status_pasangan') === 'istri' ? 'selected' : '' }}>Istri</option>
                            <option value="calon_suami" {{ old('status_pasangan') === 'calon_suami' ? 'selected' : '' }}>Calon Suami</option>
                            <option value="calon_istri" {{ old('status_pasangan') === 'calon_istri' ? 'selected' : '' }}>Calon Istri</option>
                        </select>
                        @error('status_pasangan')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Golongan Darah -->
                    <div>
                        <label for="golongan_darah" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Golongan Darah
                        </label>
                        <select name="golongan_darah" id="golongan_darah"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('golongan_darah') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500' }} text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 transition bg-white">
                            <option value="">-- Pilih Golongan Darah (Opsional) --</option>
                            <option value="A" {{ old('golongan_darah') === 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') === 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') === 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') === 'O' ? 'selected' : '' }}>O</option>
                        </select>
                        @error('golongan_darah')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pekerjaan -->
                    <div>
                        <label for="pekerjaan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pekerjaan
                        </label>
                        <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}"
                            placeholder="Contoh: Karyawan Swasta, Wiraswasta, PNS"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('pekerjaan') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500' }} text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 transition">
                        @error('pekerjaan')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('pasangan.index') }}"
                            class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-rose-600 hover:from-brand-700 hover:to-rose-700 text-white font-bold text-xs shadow-md shadow-pink-500/20 hover:shadow-lg transition">
                            Simpan Data Pasangan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebarBackdrop').classList.toggle('hidden');
        }
    </script>
</body>
</html>
