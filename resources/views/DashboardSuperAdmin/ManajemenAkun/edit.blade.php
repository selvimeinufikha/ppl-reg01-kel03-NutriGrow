<!DOCTYPE html>
@php
    $adminName = $adminName ?? (Auth::check() ? Auth::user()->name : 'dr. Siti Nurhaliza, Sp.A');
    $adminRole = $adminRole ?? (Auth::check() ? Auth::user()->role_label : 'Super Administrator');
    $faskesName = $faskesName ?? (Auth::check() && Auth::user()->faskes_name ? Auth::user()->faskes_name : 'Puskesmas Gambir');
    \Carbon\Carbon::setLocale('id');
    $tanggalHariIni = $tanggalHariIni ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y');
    $target = $admin ?? $targetUser;
@endphp
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ubah Hak Akses Administrator - NutriGrow | Portal Admin</title>

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
                        brand: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
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
            <span class="text-[10px] font-black uppercase tracking-wider text-[#e11d48] bg-pink-50 px-2 py-0.5 rounded-md">
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-sky-600 transition">Portal Admin</a>
                    <span>/</span>
                    <a href="{{ route('admin.akun.index') }}" class="hover:text-sky-600 transition">Manajemen Akun</a>
                    <span>/</span>
                    <span class="text-slate-800 font-bold">Ubah Hak Akses &amp; Status (PBI-029)</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>{{ $tanggalHariIni }}</span>
                </div>
            </header>

            <div class="p-6 md:p-8 max-w-5xl w-full mx-auto space-y-6">

                <!-- Banner Header - BIRU ACCENT -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-sky-600 via-sky-700 to-blue-800 p-6 md:p-8 text-white shadow-lg shadow-sky-600/15">
                    <div class="relative z-10 max-w-2xl space-y-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-[11px] font-bold text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            PBI-029: Mengelola Akun dan Hak Akses Administrator
                        </span>
                        <h1 class="text-xl md:text-2xl font-black tracking-tight">Ubah Hak Akses &amp; Status Akun Administrator</h1>
                        <p class="text-xs md:text-sm text-sky-100 leading-relaxed">
                            Perbarui peran akses klinis atau ubah status keaktifan akun petugas <strong>{{ $target->name }}</strong> agar kontrol otoritas sistem NutriGrow tetap terjaga.
                        </p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                        <p class="font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            Mohon perbaiki kesalahan berikut:
                        </p>
                        <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Form Edit (2 cols) -->
                    <div class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 border border-slate-200 shadow-xs">
                        <form action="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.akun.update', $target->id) : route('admin.akun.update', $target->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- SECTION 1: PROFIL & IDENTITAS -->
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-700 mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-sky-600"></span>
                                    <span>Identitas Petugas / Nakes</span>
                                </h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Nama Lengkap &amp; Gelar
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name', $target->name) }}" required oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                                Alamat Email Resmi <span class="text-[10px] text-slate-400 font-normal">(Tidak dapat diubah)</span>
                                            </label>
                                            <input type="email" value="{{ $target->email }}" disabled class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-100 text-slate-500 font-mono cursor-not-allowed">
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-xs font-bold text-slate-700 mb-1.5">
                                                No. Telepon / WhatsApp
                                            </label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $target->phone) }}" placeholder="Contoh: 081298765432" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-mono">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="nip_str" class="block text-xs font-bold text-slate-700 mb-1.5">
                                                Nomor Induk Pegawai (NIP) / Nomor STR
                                            </label>
                                            <input type="text" id="nip_str" name="nip_str" value="{{ old('nip_str', $target->nip_str) }}" placeholder="Contoh: STR-19880412-2023-019" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-mono">
                                        </div>

                                        <div>
                                            <label for="jabatan" class="block text-xs font-bold text-slate-700 mb-1.5">
                                                Jabatan Struktural / Fungsional
                                            </label>
                                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $target->jabatan) }}" placeholder="Contoh: Bidan Koordinator / Kepala Poli KIA" oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 2: HAK AKSES & FASILITAS KESEHATAN (PBI-029 INTI) -->
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-700 mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-sky-600"></span>
                                    <span>Hak Akses &amp; Penugasan Fasilitas Kesehatan (PBI-029)</span>
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="role" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Peran / Hak Akses Sistem <span class="text-rose-500">*</span>
                                        </label>
                                        <select id="role" name="role" required onchange="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-semibold text-slate-800">
                                            <option value="admin" {{ old('role', $target->role) === 'admin' ? 'selected' : '' }}>Administrator Faskes / Puskesmas</option>
                                            <option value="dokter" {{ old('role', $target->role) === 'dokter' ? 'selected' : '' }}>Dokter Spesialis Anak / Umum</option>
                                            <option value="bidan" {{ old('role', $target->role) === 'bidan' ? 'selected' : '' }}>Bidan Koordinator KIA</option>
                                            <option value="ahli_gizi" {{ old('role', $target->role) === 'ahli_gizi' ? 'selected' : '' }}>Nutrisionis / Ahli Gizi</option>
                                            <option value="superadmin" {{ old('role', $target->role) === 'superadmin' ? 'selected' : '' }}>Super Administrator</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="faskes_name" class="block text-xs font-bold text-slate-700 mb-1.5">
                                            Fasilitas Kesehatan Penugasan <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" id="faskes_name" name="faskes_name" list="faskesList" value="{{ old('faskes_name', $target->faskes_name) }}" required placeholder="Pilih atau ketik nama faskes..." oninput="updateAdminPreview()" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                        <datalist id="faskesList">
                                            @foreach ($daftarFaskes ?? ['Puskesmas Gambir', 'Puskesmas Menteng', 'RSUD Tarakan Jakarta', 'RSIA Bunda Sehat'] as $f)
                                                <option value="{{ $f }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3: STATUS AKUN (PBI-029 INTI) -->
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-700 mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-sky-600"></span>
                                    <span>Status Keaktifan Akun (PBI-029)</span>
                                </h3>

                                <div class="p-4 rounded-2xl bg-slate-50/60 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-xs text-slate-900">Kontrol Status Akses Login</p>
                                        <p class="text-[11px] text-slate-500">Akun nonaktif tidak akan dapat masuk ke portal tenaga kesehatan NutriGrow.</p>
                                    </div>

                                    <div class="flex items-center gap-4 text-xs font-bold">
                                        <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white border border-slate-200 cursor-pointer hover:border-emerald-300 transition">
                                            <input type="radio" name="status" value="active" {{ old('status', $target->status) === 'active' ? 'checked' : '' }} onchange="updateAdminPreview()" class="text-emerald-600 focus:ring-emerald-500">
                                            <span class="text-emerald-700">Aktif</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white border border-slate-200 cursor-pointer hover:border-slate-300 transition">
                                            <input type="radio" name="status" value="inactive" {{ old('status', $target->status) === 'inactive' ? 'checked' : '' }} onchange="updateAdminPreview()" class="text-slate-600 focus:ring-slate-500">
                                            <span class="text-slate-700">Nonaktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- BUTTON AKSI - BIRU GRADIENT -->
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.akun.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold text-xs shadow-md shadow-sky-600/20 hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Simpan Perubahan Hak Akses</span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- Live Preview Card (1 col) - BIRU -->
                    <div class="space-y-4">
                        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Pratinjau Hasil Perubahan</h3>
                                <span class="px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[10px] font-bold">Preview Live</span>
                            </div>

                            <div class="p-5 rounded-2xl bg-gradient-to-br from-sky-50/70 via-white to-blue-50/60 border border-sky-100 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div id="previewAvatar" class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-600 to-blue-700 text-white flex items-center justify-center font-black text-base shadow-sm">
                                        {{ $target->inisial }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p id="previewName" class="font-black text-slate-900 text-sm truncate">{{ $target->name }}</p>
                                        <span id="previewRoleBadge" class="inline-block mt-0.5 px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-800 text-[10px] font-bold">
                                            {{ $target->role_label }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-2 text-xs border-t border-sky-100/70 pt-3">
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>Status Akses:</span>
                                        <span id="previewStatus" class="font-bold text-emerald-600">{{ $target->status === 'inactive' ? 'Nonaktif' : 'Aktif' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>Fasilitas Kesehatan:</span>
                                        <span id="previewFaskes" class="font-semibold text-slate-800 truncate max-w-[150px]">{{ $target->faskes_name ?? 'Puskesmas Gambir' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>NIP / STR:</span>
                                        <span id="previewNip" class="font-semibold text-slate-800 font-mono">{{ $target->nip_str ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-500">
                                        <span>Jabatan:</span>
                                        <span id="previewJabatan" class="font-semibold text-slate-800 truncate max-w-[150px]">{{ $target->jabatan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-200 text-emerald-900 text-[11px] flex gap-2">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Perubahan hak akses dan status akan langsung diterapkan secara instan ke akun tersebut di seluruh sistem NutriGrow.</span>
                            </div>
                        </div>
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

        function updateAdminPreview() {
            const name = document.getElementById('name').value.trim() || 'Nama Administrator';
            const role = document.getElementById('role').value;
            const faskes = document.getElementById('faskes_name').value.trim() || '-';
            const nip = document.getElementById('nip_str').value.trim() || '-';
            const jabatan = document.getElementById('jabatan').value.trim() || '-';
            const statusRadio = document.querySelector('input[name="status"]:checked');
            const status = statusRadio ? statusRadio.value : 'active';

            document.getElementById('previewName').textContent = name;
            document.getElementById('previewFaskes').textContent = faskes;
            document.getElementById('previewNip').textContent = nip;
            document.getElementById('previewJabatan').textContent = jabatan;

            const statusEl = document.getElementById('previewStatus');
            if (status === 'active') {
                statusEl.textContent = 'Aktif';
                statusEl.className = 'font-bold text-emerald-600';
            } else {
                statusEl.textContent = 'Nonaktif';
                statusEl.className = 'font-bold text-rose-600';
            }

            const roleLabels = {
                'superadmin': 'Super Administrator',
                'admin': 'Administrator Faskes',
                'dokter': 'Dokter Spesialis Anak / Umum',
                'bidan': 'Bidan Koordinator KIA',
                'ahli_gizi': 'Nutrisionis / Ahli Gizi'
            };
            document.getElementById('previewRoleBadge').textContent = roleLabels[role] || 'Administrator Faskes';

            // Inisial
            const clean = name.replace(/^(dr\.|drg\.|prof\.|dr\s+|drg\s+|prof\s+|bidan\s+|bdn\.\s*)/i, '').trim();
            const words = clean.split(/\s+/);
            let inisial = words[0] ? words[0][0] : 'A';
            if (words[1]) inisial += words[1][0];
            document.getElementById('previewAvatar').textContent = inisial.toUpperCase();
        }

        document.addEventListener('DOMContentLoaded', updateAdminPreview);
    </script>
</body>
</html>
