<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Khusus Admin & Tenaga Kesehatan (Faskes).
     * URL: /admin/dashboard
     */
    public function index()
    {
        // Proteksi akses: Pastikan pengguna telah login
        if (!Auth::check()) {
            return redirect()->route('admin.login')->withErrors([
                'login_error' => 'Silakan masuk ke Portal Admin & Tenaga Kesehatan untuk mengakses Dashboard.',
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        // Validasi peran: Tolak jika merupakan akun pengguna biasa/orang tua
        if (method_exists($user, 'isStaffOrAdmin') && !$user->isStaffOrAdmin()) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors([
                'login_error' => 'Akses ditolak. Halaman ini khusus untuk Admin & Petugas Faskes.',
            ]);
        }

        // Data petugas yang sedang login
        $adminName = $user->name ?: 'dr. Siti Nurhaliza, Sp.A';
        $adminEmail = $user->email;
        $adminRole = $user->role === 'nakes' ? 'Tenaga Kesehatan (Bidan/Dokter)' : 'Administrator Faskes';
        $faskesName = $user->faskes_name ?: 'Puskesmas Gambir';
        $nipStr = $user->nip_str ?: 'STR-19880412-2023-019';

        Carbon::setLocale('id');
        $tanggalHariIni = Carbon::now()->translatedFormat('l, j F Y');

        // Statistik agregat pemantauan gizi & stunting faskes (Persis Mockup Dashboard)
        $statistics = [
            'total_pengguna' => [
                'val' => '1.428',
                'label' => 'Pasien & Wali',
                'badge' => '+12% dari bulan lalu',
                'subtext' => '892 Kepala Keluarga terdaftar',
            ],
            'ibu_hamil' => [
                'val' => '312',
                'label' => 'Ibu Hamil Terdata',
                'badge' => 'ANC K1-K6 Aktif: 284',
                'subtext' => '142 Ibu Hamil di Trimester 3',
            ],
            'balita' => [
                'val' => '1.116',
                'label' => 'Anak Usia 0-59 Bln',
                'badge' => 'Rutin Posyandu: 94.2%',
                'subtext' => '482 Baduta (0-23 Bulan)',
            ],
            'berisiko_stunting' => [
                'val' => '48',
                'label' => 'Balita Prioritas',
                'badge' => 'Perlu Intervensi Segera',
                'subtext' => 'Prevalensi: 4.3% (Target < 14%)',
            ],
        ];

        // Sebaran Status Gizi Balita WHO (Donut Data)
        $nutritionDistribution = [
            'total' => '1.116',
            'items' => [
                ['label' => 'Gizi Baik (Normal)', 'pct' => '82.3%', 'count' => '918', 'color' => '#0284c7'],
                ['label' => 'Berisiko Gizi Kurang', 'pct' => '11.1%', 'count' => '124', 'color' => '#f59e0b'],
                ['label' => 'Wasting / Gizi Kurang', 'pct' => '4.3%', 'count' => '48', 'color' => '#ef4444'],
                ['label' => 'Gizi Lebih (Overweight)', 'pct' => '2.3%', 'count' => '26', 'color' => '#ec4899'],
            ]
        ];

        // Kategori Risiko & Intervensi
        $riskCategories = [
            ['title' => 'Risiko Stunting TB/U < -2 SD', 'count' => '48 anak', 'badge_color' => 'rose', 'icon' => 'arrow-down'],
            ['title' => 'Weight Faltering BB Kurang', 'count' => '34 anak', 'badge_color' => 'amber', 'icon' => 'scale'],
            ['title' => 'Riwayat BBLR (< 2500 gr)', 'count' => '19 anak', 'badge_color' => 'sky', 'icon' => 'baby'],
            ['title' => 'Risiko KEK Ibu Hamil (LiLA < 23.5)', 'count' => '12 ibu', 'badge_color' => 'pink', 'icon' => 'heart'],
        ];

        // Data Balita Antropometri Terbaru (Tabel)
        $recentChildren = [
            [
                'id' => 'BLT-0821',
                'nama' => 'An. Muhammad Rayyan',
                'sub_info' => '18 Bulan • Posy. Melati 2',
                'tanggal' => '24 Okt 2025',
                'bb_tb' => '11.2 kg / 82.5 cm',
                'detail_ukur' => 'LK: 46.5 cm',
                'status_gizi' => 'Normal (Gizi Baik)',
                'badge' => 'emerald',
                'is_alert' => false,
            ],
            [
                'id' => 'BLT-0822',
                'nama' => 'An. Dimas Nugraha',
                'sub_info' => '14 Bulan • Posy. Melati 3',
                'tanggal' => '24 Okt 2025',
                'bb_tb' => '7.8 kg / 70.2 cm',
                'detail_ukur' => 'TB/U: -2.4 SD',
                'status_gizi' => 'Stunting Ringan',
                'badge' => 'rose',
                'is_alert' => true,
            ],
            [
                'id' => 'BLT-0823',
                'nama' => 'An. Alula Farzana',
                'sub_info' => '24 Bulan • Posy. Melati 1',
                'tanggal' => '23 Okt 2025',
                'bb_tb' => '12.0 kg / 86.4 cm',
                'detail_ukur' => 'LK: 47.0 cm',
                'status_gizi' => 'Normal (Gizi Baik)',
                'badge' => 'emerald',
                'is_alert' => false,
            ],
            [
                'id' => 'BLT-0824',
                'nama' => 'An. Keenan Danendra',
                'sub_info' => '6 Bulan • Pusk. Gambir',
                'tanggal' => '23 Okt 2025',
                'bb_tb' => '7.4 kg / 66.0 cm',
                'detail_ukur' => 'ASI Eksklusif',
                'status_gizi' => 'Normal (Gizi Baik)',
                'badge' => 'emerald',
                'is_alert' => false,
            ],
        ];

        // Data Pemeriksaan Kehamilan (ANC)
        $recentPregnancies = [
            [
                'id' => 'ANC-0412',
                'nama' => 'Ny. Linda Permata',
                'sub_info' => 'G1P0A0, 28 Minggu • Posy. Melati 3',
                'tanggal' => '24 Okt 2025',
                'bb_tb' => '54.5 kg / 155 cm',
                'detail_ukur' => 'LiLA: 21.5 cm (< 23.5 cm)',
                'status_gizi' => 'Risiko KEK (Perlu PMT)',
                'badge' => 'amber',
                'is_alert' => true,
            ],
            [
                'id' => 'ANC-0413',
                'nama' => 'Ny. Citra Dewi',
                'sub_info' => 'G2P1A0, 32 Minggu • Pusk. Gambir',
                'tanggal' => '23 Okt 2025',
                'bb_tb' => '62.0 kg / 160 cm',
                'detail_ukur' => 'LiLA: 26.0 cm (Normal)',
                'status_gizi' => 'Normal & Sehat',
                'badge' => 'emerald',
                'is_alert' => false,
            ],
        ];

        // Peringatan Klinis Mendesak (Alert List)
        $urgentAlerts = [
            [
                'type' => 'stunting',
                'tag' => 'STUNTING TB/U < -2.4 SD',
                'time' => 'Hari ini',
                'title' => 'An. Dimas Nugraha (14 Bulan)',
                'detail' => 'Posyandu Melati 3 • Rekomendasi: Konsul Dokter Spesialis Anak & PKMK.',
                'btn_primary' => 'Tindak Lanjut Rujukan',
                'btn_secondary' => 'Rekam Medis',
            ],
            [
                'type' => 'kek',
                'tag' => 'IBU HAMIL RISIKO KEK',
                'time' => 'Kemarin',
                'title' => 'Ny. Linda Permata (G1P0A0, 28 Mgg)',
                'detail' => 'LiLA: 21.5 cm (< 23.5 cm) • Rekomendasi: Distribusi biskuit PMT Pemulihan.',
                'btn_primary' => 'Jadwalkan PMT',
                'btn_secondary' => 'Buku KIA',
            ],
        ];

        return view('DashboardAdmin.index', compact(
            'adminName',
            'adminEmail',
            'adminRole',
            'faskesName',
            'nipStr',
            'tanggalHariIni',
            'statistics',
            'nutritionDistribution',
            'riskCategories',
            'recentChildren',
            'recentPregnancies',
            'urgentAlerts'
        ));
    }
}
