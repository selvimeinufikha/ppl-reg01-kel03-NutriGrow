<!DOCTYPE html>
@php
    $userName = $user->name ?? 'Keluarga Pratama';
    $userId = 'NGW-' . str_pad($user->id ?? 1, 5, '0', STR_PAD_LEFT) . '-JKT';
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
    $faskesInfo = $faskesInfo ?? 'Posyandu Mawar 1 & Puskesmas Sejahtera';
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Data Anak - NutriGrow | Pemantauan Kesehatan Ibu & Anak</title>

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
            <div class="flex items-center justify-between mb-7 pl-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow" class="h-7 w-auto object-contain">
                </a>
            </div>

            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">UTAMA</span>
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="mb-5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 block">DATA KELUARGA &amp; PROFIL</span>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard.pengguna') }}#data-pasangan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Data Pasangan</span>
                    </a>
                    <a href="{{ route('dashboard.pengguna') }}#data-kehamilan" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand-600 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Kehamilan</span>
                    </a>
                    <a href="{{ route('data-anak.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl bg-brand-800 text-white font-bold text-xs shadow-md shadow-brand-900/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data Anak</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="p-4 border-t border-sky-100/60 bg-transparent">
            <a href="{{ route('data-anak.index') }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-white/80 transition">
                <span>&larr; Kembali ke Data Anak</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- TOP HEADER -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <div class="flex items-center gap-3">
                <a href="{{ route('data-anak.index') }}" class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <span class="text-sm font-bold text-slate-800">Tambah Data Anak Baru</span>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200 text-brand-800 text-xs font-bold">
                <span>{{ $namaKeluarga }}</span>
            </div>
        </header>

        <!-- MAIN SCROLLABLE FORM -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6 max-w-4xl w-full mx-auto">
            
            <!-- BREADCRUMB -->
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('dashboard.pengguna') }}" class="hover:text-brand-600">Dashboard</a>
                <span>&gt;</span>
                <a href="{{ route('data-anak.index') }}" class="hover:text-brand-600">Data Anak</a>
                <span>&gt;</span>
                <span class="text-brand-700 font-semibold">Formulir Tambah Anak</span>
            </div>

            <!-- Validation Error Alert -->
            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-xs">
                    <div class="font-bold flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>Periksa kembali data yang dimasukkan:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM CARD -->
            <div class="rounded-3xl bg-white border border-pink-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-pink-50 via-rose-50 to-white border-b border-pink-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-brand-800 text-white flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Formulir Tambah Data Anak</h2>
                        <p class="text-xs text-slate-500">Isi identitas anak dan hubungkan dengan data kehamilan.</p>
                    </div>
                </div>

                <form id="formCreateAnak" action="{{ route('data-anak.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    <!-- SECTION 1: IDENTITAS UTAMA (ACCEPTANCE CRITERIA) -->
                    <div>
                        <span class="text-xs uppercase font-extrabold tracking-wider text-brand-700 block mb-3">
                            1. Identitas Pokok Anak (Wajib)
                        </span>

                        <div class="space-y-4">
                            <!-- Nama Lengkap Anak -->
                            <div>
                                <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Nama Lengkap Anak <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: Kinan Pratama" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('nama') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                                @error('nama')
                                    <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Jenis Kelamin -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Jenis Kelamin <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-sky-50/50 cursor-pointer transition has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50">
                                            <input type="radio" name="jenis_kelamin" value="Laki-laki" required {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} class="text-sky-600 focus:ring-sky-500">
                                            <span class="text-xs font-bold text-slate-800">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-pink-50/50 cursor-pointer transition has-[:checked]:border-brand-500 has-[:checked]:bg-pink-50">
                                            <input type="radio" name="jenis_kelamin" value="Perempuan" required {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500">
                                            <span class="text-xs font-bold text-slate-800">Perempuan</span>
                                        </label>
                                    </div>
                                    @error('jenis_kelamin')
                                        <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Lahir (Acceptance Criteria: Ditolak jika melebihi hari ini) -->
                                <div>
                                    <label for="tanggal_lahir" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Tanggal Lahir <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required max="{{ $maxDate }}" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border @error('tanggal_lahir') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                                    <p class="text-[10px] text-slate-400 mt-1">
                                        Batas maksimal adalah hari ini ({{ date('d F Y') }}). Tanggal melebihi hari ini akan ditolak.
                                    </p>
                                    @error('tanggal_lahir')
                                        <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Hubungan ke Data Kehamilan (Acceptance Criteria) -->
                            <div>
                                <label for="kehamilan_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Hubungkan ke Data Kehamilan
                                </label>
                                <select id="kehamilan_id" name="kehamilan_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition cursor-pointer">
                                    <option value="">-- Tidak Terhubung / Tanpa Data Kehamilan --</option>
                                    @foreach($kehamilans as $khm)
                                        <option value="{{ $khm->id }}" {{ old('kehamilan_id') == $khm->id ? 'selected' : '' }}>
                                            {{ $khm->label }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] text-slate-400 mt-1">
                                    Pilih catatan kehamilan ibu jika kelahiran anak ini tercatat dalam modul antenatal care (ANC).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: INFORMASI KELAHIRAN & KESEHATAN (OPSIONAL) -->
                    <div class="border-t border-slate-100 pt-5">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-slate-400 block mb-3">
                            2. Data Tambahan &amp; Rekam Lahir (Opsional)
                        </span>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1">NIK Anak</label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="30" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="tempat_lahir" class="block text-xs font-semibold text-slate-700 mb-1">Tempat Lahir</label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota / Faskes Lahir" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="anak_ke" class="block text-xs font-semibold text-slate-700 mb-1">Anak Ke-</label>
                                <input type="number" id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" min="1" max="20" placeholder="Contoh: 1" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4">
                            <div>
                                <label for="berat_lahir" class="block text-xs font-semibold text-slate-700 mb-1">Berat Lahir (kg)</label>
                                <input type="number" step="0.01" id="berat_lahir" name="berat_lahir" value="{{ old('berat_lahir') }}" placeholder="Contoh: 3.20" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="panjang_lahir" class="block text-xs font-semibold text-slate-700 mb-1">Panjang Lahir (cm)</label>
                                <input type="number" step="0.1" id="panjang_lahir" name="panjang_lahir" value="{{ old('panjang_lahir') }}" placeholder="Contoh: 49.0" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="lingkar_kepala_lahir" class="block text-xs font-semibold text-slate-700 mb-1">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" id="lingkar_kepala_lahir" name="lingkar_kepala_lahir" value="{{ old('lingkar_kepala_lahir') }}" placeholder="Contoh: 33.5" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                            </div>
                            <div>
                                <label for="golongan_darah" class="block text-xs font-semibold text-slate-700 mb-1">Golongan Darah</label>
                                <select id="golongan_darah" name="golongan_darah" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                                    <option value="">Pilih Golongan</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="catatan" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan (Kondisi Lahir / Alergi)</label>
                            <textarea id="catatan" name="catatan" rows="3" placeholder="Tuliskan catatan riwayat lahir, alergi, atau pesan dokter..." class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <!-- FOOTER ACTIONS -->
                    <div class="border-t border-slate-100 pt-5 flex items-center justify-end gap-3">
                        <a href="{{ route('data-anak.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-7 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-900/20 transition cursor-pointer">
                            Simpan Data Anak
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const tglInput = document.getElementById('tanggal_lahir');
        if (tglInput) {
            tglInput.addEventListener('change', function() {
                const selected = new Date(this.value);
                const today = new Date();
                today.setHours(0,0,0,0);
                if (selected > today) {
                    alert('Tanggal lahir yang melebihi hari ini ditolak! Silakan masukkan tanggal yang valid.');
                    this.value = '';
                }
            });
        }
    </script>
</body>
</html>
