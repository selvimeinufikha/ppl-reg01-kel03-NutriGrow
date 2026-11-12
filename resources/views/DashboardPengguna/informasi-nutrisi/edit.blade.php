<!DOCTYPE html>
@php
    $userName = auth()->user()->name ?? 'Administrator NutriGrow';
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Informasi Nutrisi - {{ $nutrisi->nama_bahan_menu }}</title>

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
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <a href="{{ route('informasi-nutrisi.index') }}" class="hover:text-brand-600 font-medium">Rekomendasi Nutrisi</a>
                <span>/</span>
                <span class="text-brand-600 font-bold">Edit Informasi Nutrisi</span>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-50 border border-rose-100 text-xs font-semibold text-rose-700">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>{{ $userName }}</span>
                </div>
            </div>
        </header>

        <!-- MAIN SCROLLABLE -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto w-full space-y-6">

            <!-- ERROR ALERT -->
            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <div class="font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Mohon periksa kembali isian formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 pl-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- CARD FORM EDIT -->
            <div class="rounded-3xl bg-white border border-pink-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-pink-50 via-rose-50 to-white border-b border-pink-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900">Edit Informasi Nutrisi</h2>
                            <p class="text-xs text-slate-500">Perbarui data bahan pangan, kandungan gizi, fase/kondisi, atau anjuran konsumsi.</p>
                        </div>
                    </div>

                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                        Mode Edit
                    </span>
                </div>

                <form action="{{ route('informasi-nutrisi.update', $nutrisi->id) }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- 1. Nama Bahan / Menu Makanan (Required) -->
                    <div>
                        <label for="nama_bahan_menu" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Bahan / Menu Makanan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_bahan_menu" name="nama_bahan_menu" required
                               value="{{ old('nama_bahan_menu', $nutrisi->nama_bahan_menu) }}"
                               placeholder="Contoh: Ikan Kembung &amp; Telur Ayam"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('nama_bahan_menu') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                        @error('nama_bahan_menu')
                            <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. Kategori Fase & Kategori Kondisi (Grid 2 Kolom) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kategori Fase (Required) -->
                        <div>
                            <label for="kategori_fase" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kategori Fase Kehidupan <span class="text-rose-500">*</span>
                            </label>
                            <select id="kategori_fase" name="kategori_fase" required
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('kategori_fase') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                                <option value="">-- Pilih Fase Kehidupan --</option>
                                @foreach($daftarFase as $fKey => $fLabel)
                                    <option value="{{ $fKey }}" {{ old('kategori_fase', $nutrisi->kategori_fase) === $fKey ? 'selected' : '' }}>
                                        {{ $fLabel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_fase')
                                <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori Kondisi (Required) -->
                        <div>
                            <label for="kategori_kondisi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kategori Sasaran &amp; Kondisi <span class="text-rose-500">*</span>
                            </label>
                            <select id="kategori_kondisi" name="kategori_kondisi" required
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('kategori_kondisi') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                                <option value="">-- Pilih Kategori Sasaran --</option>
                                @foreach($daftarKondisi as $kKey => $kLabel)
                                    <option value="{{ $kKey }}" {{ old('kategori_kondisi', $nutrisi->kategori_kondisi) === $kKey ? 'selected' : '' }}>
                                        {{ $kLabel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_kondisi')
                                <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 3. Kandungan Gizi (Required) -->
                    <div>
                        <label for="kandungan_gizi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kandungan Gizi Utama <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="kandungan_gizi" name="kandungan_gizi" required
                               value="{{ old('kandungan_gizi', $nutrisi->kandungan_gizi) }}"
                               placeholder="Contoh: DHA, Protein 18g, Omega-3, Zat Besi, Kalsium"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('kandungan_gizi') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                        @error('kandungan_gizi')
                            <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 4. Saran Penggunaan / Anjuran Konsumsi (Required) -->
                    <div>
                        <label for="saran_penggunaan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Saran Penggunaan &amp; Anjuran Konsumsi <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="saran_penggunaan" name="saran_penggunaan" rows="3" required
                                  placeholder="Contoh: Konsumsi 2-3 kali seminggu bersama sayur bayam untuk memaksimalkan penyerapan zat besi."
                                  class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('saran_penggunaan') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('saran_penggunaan', $nutrisi->saran_penggunaan) }}</textarea>
                        @error('saran_penggunaan')
                            <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 5. Deskripsi Manfaat Detail (Opsional) -->
                    <div>
                        <label for="deskripsi_manfaat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi &amp; Manfaat Bagi Ibu / Anak (Opsional)
                        </label>
                        <textarea id="deskripsi_manfaat" name="deskripsi_manfaat" rows="3"
                                  placeholder="Jelaskan peran menu/bahan ini dalam pencegahan stunting..."
                                  class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('deskripsi_manfaat', $nutrisi->deskripsi_manfaat) }}</textarea>
                    </div>

                    <!-- 6. URL Foto (Opsional) -->
                    <div>
                        <label for="foto" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            URL Gambar / Foto Bahan (Opsional)
                        </label>
                        <input type="text" id="foto" name="foto"
                               value="{{ old('foto', $nutrisi->foto) }}"
                               placeholder="https://images.unsplash.com/..."
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="border-t border-slate-100 pt-5 flex items-center justify-between">
                        <!-- Tombol Hapus dengan Dialog Konfirmasi -->
                        <button type="button" onclick="confirmDeleteNutrisi({{ $nutrisi->id }}, '{{ addslashes($nutrisi->nama_bahan_menu) }}')" class="px-4 py-2.5 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs sm:text-sm font-bold transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Hapus Data Ini</span>
                        </button>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('informasi-nutrisi.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-7 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-900/20 transition cursor-pointer">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- DIALOG KONFIRMASI PENGHAPUSAN -->
    <div id="delete-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto text-xl">
                🗑️
            </div>

            <div class="text-center space-y-1">
                <h3 class="text-base font-extrabold text-slate-900">Konfirmasi Penghapusan</h3>
                <p class="text-xs text-slate-500">
                    Apakah Anda yakin ingin menghapus informasi nutrisi <strong id="delete-item-name" class="text-slate-800"></strong>? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <button type="button" onclick="closeDeleteModal()" class="w-full py-2.5 px-4 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT KONFIRMASI PENGHAPUSAN -->
    <script>
        function confirmDeleteNutrisi(id, name) {
            document.getElementById('delete-item-name').textContent = '"' + name + '"';
            document.getElementById('delete-form').action = '/informasi-nutrisi/' + id;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
