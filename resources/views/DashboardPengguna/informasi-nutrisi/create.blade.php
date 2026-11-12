<!DOCTYPE html>
@php
    $userName = auth()->user()->name ?? 'Administrator NutriGrow';
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Informasi Nutrisi - NutriGrow Admin</title>

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
                        brand: {
                            50: '#fff1f2', 100: '#ffe4e6', 200: '#fecdd3', 300: '#fda4af',
                            400: '#fb7185', 500: '#f43f5e', 600: '#e11d48', 700: '#be123c',
                            800: '#9f1239', 900: '#881337',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden">

    <!-- LEFT SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 border-r border-pink-100/70 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-sm" style="background: linear-gradient(180deg, #fff0f3 0%, #fdf2f6 30%, #f3f3fc 70%, #eaf3ff 100%);">
        <div class="p-5 overflow-y-auto flex-1 bg-transparent">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between mb-7 pl-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain">
                </a>
            </div>

            <!-- MENU UTAMA -->
            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">UTAMA</span>
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('data-anak.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 hover:bg-white/70 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Data Anak</span>
                </a>
                <a href="{{ route('informasi-nutrisi.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-brand-800 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Rekomendasi Nutrisi</span>
                </a>
            </div>
        </div>

        <div class="p-4 border-t border-sky-100/60 bg-transparent">
            <a href="{{ route('informasi-nutrisi.index') }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-white/80 transition">
                <span>&larr; Kembali ke Rekomendasi Nutrisi</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- TOP HEADER -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <div class="flex items-center gap-3">
                <a href="{{ route('informasi-nutrisi.index') }}" class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <span class="text-sm font-bold text-slate-800">Formulir Tambah Informasi Nutrisi</span>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200 text-brand-800 text-xs font-bold">
                <span>{{ $userName }}</span>
            </div>
        </header>

        <!-- SCROLLABLE CONTAINER -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6 max-w-4xl w-full mx-auto">
            
            <!-- BREADCRUMB -->
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-brand-600">Dashboard</a>
                <span>&gt;</span>
                <a href="{{ route('informasi-nutrisi.index') }}" class="hover:text-brand-600">Rekomendasi Nutrisi</a>
                <span>&gt;</span>
                <span class="text-brand-700 font-semibold">Tambah Informasi Nutrisi</span>
            </div>

            <!-- ERROR ALERT -->
            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-xs">
                    <div class="font-bold flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>Gagal Menyimpan! Periksa isian berikut:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- CARD FORM -->
            <div class="rounded-3xl bg-white border border-pink-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-pink-50 via-rose-50 to-white border-b border-pink-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-brand-800 text-white flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900">Tambah Informasi &amp; Rekomendasi Nutrisi</h2>
                            <p class="text-xs text-slate-500">Isi lengkap bahan/menu, kandungan gizi, kategori fase &amp; kondisi, serta saran penggunaan.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('informasi-nutrisi.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    <!-- 1. Nama Bahan / Menu Makanan (Required) -->
                    <div>
                        <label for="nama_bahan_menu" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Bahan / Menu Makanan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_bahan_menu" name="nama_bahan_menu" required value="{{ old('nama_bahan_menu') }}"
                               placeholder="Contoh: Ikan Kembung & Telur Ayam: Sumber Protein Hewani Terjangkau"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('nama_bahan_menu') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                        @error('nama_bahan_menu')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. Grid Kategori Fase & Kategori Kondisi (Required) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kategori Fase -->
                        <div>
                            <label for="kategori_fase" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kategori Fase Kehidupan <span class="text-rose-500">*</span>
                            </label>
                            <select id="kategori_fase" name="kategori_fase" required
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('kategori_fase') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition cursor-pointer">
                                <option value="">-- Pilih Kategori Fase --</option>
                                @foreach($daftarFase as $key => $label)
                                    <option value="{{ $key }}" {{ old('kategori_fase') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_fase')
                                <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori Kondisi -->
                        <div>
                            <label for="kategori_kondisi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kategori Kondisi / Edukasi <span class="text-rose-500">*</span>
                            </label>
                            <select id="kategori_kondisi" name="kategori_kondisi" required
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('kategori_kondisi') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition cursor-pointer">
                                <option value="">-- Pilih Kategori Kondisi --</option>
                                @foreach($daftarKondisi as $key => $label)
                                    <option value="{{ $key }}" {{ old('kategori_kondisi') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_kondisi')
                                <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 3. Kandungan Gizi (Required) -->
                    <div>
                        <label for="kandungan_gizi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kandungan Gizi Utama <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="kandungan_gizi" name="kandungan_gizi" required value="{{ old('kandungan_gizi') }}"
                               placeholder="Contoh: DHA, Protein 18g, Omega-3, Zat Besi, Kalsium"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('kandungan_gizi') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                        <p class="text-[11px] text-slate-400 mt-1">Sebutkan kandungan nutrisi mikro dan makro penting yang terkandung.</p>
                        @error('kandungan_gizi')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 4. Saran Penggunaan / Anjuran Konsumsi (Required) -->
                    <div>
                        <label for="saran_penggunaan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Saran Penggunaan &amp; Anjuran Konsumsi <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="saran_penggunaan" name="saran_penggunaan" rows="3" required
                                  placeholder="Contoh: Konsumsi 2-3 kali seminggu bersama sayur bayam untuk memaksimalkan penyerapan zat besi. Masak dengan cara kukus atau sup agar nutrisi tidak rusak."
                                  class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('saran_penggunaan') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('saran_penggunaan') }}</textarea>
                        @error('saran_penggunaan')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 5. Deskripsi Manfaat Detail (Opsional) -->
                    <div>
                        <label for="deskripsi_manfaat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi &amp; Manfaat Bagi Ibu / Anak (Opsional)
                        </label>
                        <textarea id="deskripsi_manfaat" name="deskripsi_manfaat" rows="3"
                                  placeholder="Jelaskan peran menu/bahan ini dalam pencegahan stunting, pembentukan sel otak janin, atau pemulihan ibu melahirkan..."
                                  class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('deskripsi_manfaat') }}</textarea>
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="border-t border-slate-100 pt-5 flex items-center justify-end gap-3">
                        <a href="{{ route('informasi-nutrisi.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-7 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-900/20 transition cursor-pointer">
                            Simpan Informasi Nutrisi
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
