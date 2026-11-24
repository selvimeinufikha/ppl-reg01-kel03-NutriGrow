<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Lengkap Audit & Log Aktivitas Administrator - NutriGrow</title>
    <link rel="icon" type="image/png" href="{{ asset('images/nutrigrow-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .page-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
            }
            @page {
                size: A4 landscape;
                margin: 12mm 15mm 15mm 15mm;
            }
            tr {
                page-break-inside: avoid;
            }
            thead {
                display: table-header-group;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-8 px-4 sm:px-6 antialiased">

    <!-- FLOATING ACTION BAR (HANYA MUNCUL DI LAYAR, OTOMATIS HILANG SAAT DI-PRINT / DI-SAVE KE PDF) -->
    <div class="no-print max-w-6xl mx-auto mb-6 bg-white p-4 rounded-2xl shadow-md border border-slate-200 flex flex-wrap items-center justify-between gap-4 sticky top-4 z-50">
        <div class="flex items-center gap-3">
            <a href="{{ request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.log.index') : route('admin.log.index') }}"
               class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Log Aktivitas</span>
            </a>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <p class="text-xs font-bold text-slate-800">Pratinjau Cetak / Ekspor PDF Resmi</p>
                <p class="text-[11px] text-slate-400">Total {{ $logs->count() }} rekaman aktivitas lengkap</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <!-- Download file binary .pdf langsung -->
            <a href="{{ (request()->routeIs('superadmin.*') || request()->is('superadmin/*') ? route('superadmin.log.export-pdf') : route('admin.log.export-pdf')) . '?format=pdf&' . http_build_query(request()->except('format')) }}"
               class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition flex items-center gap-2 shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Unduh File .PDF Langsung</span>
            </a>

            <!-- Tombol Cetak Browser -->
            <button onclick="window.print()"
                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold text-xs shadow-md shadow-sky-600/20 transition flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak / Simpan sebagai PDF</span>
            </button>
        </div>
    </div>

    <!-- HALAMAN DOKUMEN CETAK RESMI (A4 LANDSCAPE) -->
    <div class="page-container max-w-6xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-lg border border-slate-200">

        <!-- KOP SURAT RESMI -->
        <div class="border-b-4 border-slate-900 pb-4 mb-6">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/nutrigrow-logo.png') }}" alt="NutriGrow Logo" class="h-12 w-auto object-contain">
                    <div class="h-10 w-px bg-slate-300"></div>
                    <div>
                        <h2 class="text-xs font-black uppercase tracking-widest text-[#e11d48]">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</h2>
                        <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">SISTEM KESEHATAN IBU, ANAK &amp; GIZI NASIONAL (NUTRIGROW)</h3>
                        <p class="text-[10px] text-slate-500 font-medium">Jl. H.R. Rasuna Said Blok X-5 Kav. 4-9 Jakarta Selatan | Portal Super Administrator</p>
                    </div>
                </div>

                <div class="text-right">
                    <span class="inline-block px-3 py-1 rounded-md bg-rose-50 text-[#e11d48] border border-rose-200 text-[10px] font-black uppercase tracking-wider">
                        DOKUMEN RAHASIA &amp; TERBATAS
                    </span>
                    <p class="text-[9px] font-mono text-slate-400 mt-1">NO: AUDIT/NGW/{{ date('Ym') }}/{{ str_pad(rand(1, 999), 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <!-- JUDUL & INFORMASI LAPORAN -->
        <div class="text-center my-6">
            <h1 class="text-lg font-black text-slate-900 uppercase tracking-wide">
                LAPORAN LENGKAP AUDIT &amp; LOG AKTIVITAS ADMINISTRATOR
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Rekaman historis penambahan akun administrator, mutasi hak akses, dan audit keamanan sistem
            </p>
        </div>

        <!-- METADATA DOKUMEN AUDIT -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200 mb-6 text-xs">
            <div>
                <p class="text-[10px] text-slate-400 uppercase font-bold">Waktu Ekspor</p>
                <p class="font-extrabold text-slate-800 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 uppercase font-bold">Pejabat Pencetak</p>
                <p class="font-extrabold text-slate-800 mt-0.5">{{ $adminName }}</p>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 uppercase font-bold">Hak Akses Pencetak</p>
                <p class="font-extrabold text-[#e11d48] mt-0.5">Super Administrator</p>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 uppercase font-bold">Total Rekaman</p>
                <p class="font-extrabold text-emerald-700 mt-0.5">{{ $logs->count() }} Aktivitas Tercatat</p>
            </div>
        </div>

        <!-- TABEL LENGKAP LOG AKTIVITAS -->
        <div class="overflow-x-auto border border-slate-200 rounded-xl mb-8">
            <table class="w-full text-left text-[11px] border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-300 text-[10px] uppercase tracking-wider">
                        <th class="px-3 py-2.5 text-center w-10">No</th>
                        <th class="px-3 py-2.5 w-32">Waktu &amp; Tanggal</th>
                        <th class="px-3 py-2.5 w-44">Pelaku Aktivitas</th>
                        <th class="px-3 py-2.5 text-center w-28">Jenis Aksi</th>
                        <th class="px-3 py-2.5 w-40">Akun Sasaran (Target)</th>
                        <th class="px-3 py-2.5">Keterangan &amp; Rincian Mutasi</th>
                        <th class="px-3 py-2.5 text-center w-28">IP &amp; Device</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($logs as $index => $log)
                        @php
                            $badge = $log->action_badge;
                        @endphp
                        <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50/50' }}">
                            <td class="px-3 py-2.5 text-center font-bold text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-3 py-2.5 whitespace-nowrap">
                                <p class="font-bold text-slate-800">{{ $log->created_at->format('d/m/Y') }}</p>
                                <p class="text-[9.5px] text-slate-500 font-mono">{{ $log->created_at->format('H:i:s') }} WIB</p>
                            </td>
                            <td class="px-3 py-2.5">
                                <p class="font-bold text-slate-900">{{ $log->actor_name }}</p>
                                <p class="text-[9.5px] text-slate-500">{{ $log->actor_email ?? '-' }}</p>
                                <span class="text-[8.5px] font-bold text-rose-700 uppercase">[{{ $log->actor_role }}]</span>
                            </td>
                            <td class="px-3 py-2.5 text-center whitespace-nowrap">
                                <span class="inline-block px-2 py-0.5 rounded text-[9.5px] font-bold border {{ $badge['bg'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="px-3 py-2.5">
                                @if ($log->target_name)
                                    <p class="font-bold text-slate-800">{{ $log->target_name }}</p>
                                    <p class="text-[9.5px] text-slate-500">{{ $log->target_email ?? '-' }}</p>
                                @else
                                    <span class="text-slate-400 italic">Sistem / Portal</span>
                                @endif
                            </td>
                            <td class="px-3 py-2.5">
                                <p class="text-slate-700 leading-snug">{{ $log->description }}</p>
                                @if (!empty($log->old_values) && !empty($log->new_values))
                                    <div class="mt-1 text-[9px] text-slate-500 bg-slate-100 p-1.5 rounded font-mono">
                                        @if (isset($log->old_values['role']) && isset($log->new_values['role']) && $log->old_values['role'] !== $log->new_values['role'])
                                            <span>Peran: {{ $log->old_values['role'] }} → {{ $log->new_values['role'] }} | </span>
                                        @endif
                                        @if (isset($log->old_values['status']) && isset($log->new_values['status']) && $log->old_values['status'] !== $log->new_values['status'])
                                            <span>Status: {{ $log->old_values['status'] }} → {{ $log->new_values['status'] }}</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-2.5 text-center whitespace-nowrap">
                                <span class="font-mono text-[9.5px] bg-slate-100 px-1.5 py-0.5 rounded text-slate-600 font-bold border border-slate-200">
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400 italic">
                                Tidak ada rekaman audit log yang tersedia untuk dicetak.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- KOLOM TANDA TANGAN / PENGESAHAN DOKUMEN -->
        <div class="grid grid-cols-2 gap-8 pt-4 border-t border-slate-200 text-xs">
            <div>
                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Catatan Keamanan &amp; Integritas</p>
                <p class="text-[10.5px] text-slate-600 mt-1 leading-relaxed">
                    Dokumen ini digenerate secara otomatis oleh modul Audit Trail NutriGrow. Seluruh data waktu, alamat IP, dan jejak rekaman perubahan bersifat autentik dan diarsipkan untuk kebutuhan audit kepatuhan dan akreditasi faskes.
                </p>
            </div>
            <div class="text-right">
                <p class="text-slate-600">Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="font-extrabold text-slate-800 mt-0.5">Super Administrator Penanggung Jawab,</p>
                <div class="h-16"></div>
                <p class="font-black text-slate-900 underline text-sm">{{ $adminName }}</p>
                <p class="text-[10px] text-slate-500 font-mono">NIP/STR: {{ $currentAdmin->nip_str ?? 'STR-19880412-2023-019' }}</p>
            </div>
        </div>

        <!-- FOOTER HALAMAN -->
        <div class="mt-8 pt-3 border-t border-slate-100 flex items-center justify-between text-[9px] text-slate-400">
            <span>NutriGrow Healthcare Information System &copy; {{ date('Y') }} - Hak Cipta Dilindungi Undang-Undang.</span>
            <span>Dicetak secara elektronik pada {{ date('d/m/Y H:i:s') }}</span>
        </div>

    </div>

    <!-- Script auto print opsional jika dibuka dari tautan print -->
    <script>
        // Membuka dialog print otomatis jika ada query parameter auto=1
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('auto') === '1') {
            window.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => window.print(), 600);
            });
        }
    </script>
</body>
</html>
