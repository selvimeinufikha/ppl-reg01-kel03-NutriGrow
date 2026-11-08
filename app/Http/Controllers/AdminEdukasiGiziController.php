<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminEdukasiGiziController extends Controller
{
    /**
     * Data artikel bawaan (default) jika belum ada di session.
     */
    private function getDefaultArticles(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Panduan MPASI Kaya Protein Hewani untuk Mencegah Stunting',
                'full_title' => 'Panduan MPASI Kaya Protein Hewani untuk Mencegah Stunting Pada Anak',
                'read_time' => '5 mnt baca',
                'author' => 'dr. Siti Nurhaliza, Sp.A',
                'phase' => 'anak',
                'phase_label' => 'Anak',
                'phase_icon' => '👶',
                'phase_badge' => 'bg-sky-50 text-sky-700 border border-sky-200/60',
                'publish_date' => '24 Okt 2025',
                'publish_time' => '09:30 WIB',
                'status' => 'terbit',
                'status_label' => 'Terbit',
                'status_note' => 'Tampil ke aplikasi',
                'image' => asset('images/nutrition-food.jpg'),
                'views' => '4.210',
                'summary' => 'Pedoman komprehensif pemberian MPASI kaya asam amino esensial hewani seperti telur, hati ayam, dan ikan kembung untuk mendorong laju pertambahan tinggi badan optimal pada usia 6–23 bulan.',
            ],
            [
                'id' => 2,
                'title' => 'Pentingnya Asupan Tablet Tambah Darah (TTD) & Asam Folat Tr...',
                'full_title' => 'Pentingnya Asupan Tablet Tambah Darah (TTD) & Asam Folat Trimester Pertama',
                'read_time' => '4 mnt baca',
                'author' => 'Bidan Rina Marlina, S.Tr.Keb',
                'phase' => 'hamil',
                'phase_label' => 'Hamil',
                'phase_icon' => '🤰',
                'phase_badge' => 'bg-pink-50 text-pink-700 border border-pink-200/60',
                'publish_date' => '22 Okt 2025',
                'publish_time' => '14:15 WIB',
                'status' => 'terbit',
                'status_label' => 'Terbit',
                'status_note' => 'Tampil ke aplikasi',
                'image' => asset('images/konsultasi-bidan-anak.jpg'),
                'views' => '3.150',
                'summary' => 'Panduan pencegahan anemia defisiensi besi dan neural tube defect (NTD) pada janin melalui kepatuhan konsumsi 90 butir TTD dan suplementasi folat tepat waktu.',
            ],
            [
                'id' => 3,
                'title' => 'Menu Gizi Seimbang Calon Ibu: Persiapan 1000 HPK Sejak Masa...',
                'full_title' => 'Menu Gizi Seimbang Calon Ibu: Persiapan 1000 HPK Sejak Masa Prakonsepsi',
                'read_time' => '6 mnt baca',
                'author' => 'Nurul Fitriani, S.Gz (Nutrisionis)',
                'phase' => 'pra-hamil',
                'phase_label' => 'Pra-Hamil',
                'phase_icon' => '💙',
                'phase_badge' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/60',
                'publish_date' => '19 Okt 2025',
                'publish_time' => '11:00 WIB',
                'status' => 'terbit',
                'status_label' => 'Terbit',
                'status_note' => 'Tampil ke aplikasi',
                'image' => asset('images/article-pra-hamil-hd.png'),
                'views' => '2.840',
                'summary' => 'Edukasi kesiapan status gizi wanita usia subur (WUS) dan calon pengantin untuk mencegah Kurang Energi Kronis (KEK) sebelum memasuki masa kehamilan.',
            ],
            [
                'id' => 4,
                'title' => "Mengenal 'Weight Faltering' dan Bahayanya Jika Berat Badan Ba...",
                'full_title' => "Mengenal 'Weight Faltering' dan Bahayanya Jika Berat Badan Balita Mandek",
                'read_time' => '7 mnt baca',
                'author' => 'dr. Siti Nurhaliza, Sp.A',
                'phase' => 'anak',
                'phase_label' => 'Anak',
                'phase_icon' => '👶',
                'phase_badge' => 'bg-sky-50 text-sky-700 border border-sky-200/60',
                'publish_date' => '15 Okt 2025',
                'publish_time' => '10:45 WIB',
                'status' => 'terbit',
                'status_label' => 'Terbit',
                'status_note' => 'Tampil ke aplikasi',
                'image' => asset('images/growth-measurement.jpg'),
                'views' => '3.920',
                'summary' => 'Deteksi dini perlambatan kenaikan berat badan (weight faltering) pada kurva KMS sebagai sinyal bahaya utama sebelum anak jatuh ke kondisi gizi kurang, wasting, dan stunting.',
            ],
            [
                'id' => 5,
                'title' => 'Panduan Mengatasi Morning Sickness Tanpa Kehilangan Nutrisi',
                'full_title' => 'Panduan Mengatasi Morning Sickness Tanpa Kehilangan Nutrisi Esensial Janin',
                'read_time' => '5 mnt baca',
                'author' => 'dr. Siti Nurhaliza, Sp.A',
                'phase' => 'hamil',
                'phase_label' => 'Hamil',
                'phase_icon' => '🤰',
                'phase_badge' => 'bg-pink-50 text-pink-700 border border-pink-200/60',
                'publish_date' => '-',
                'publish_time' => 'Belum Terbit',
                'status' => 'draft',
                'status_label' => 'Draft',
                'status_note' => 'Hanya tim nakes',
                'image' => asset('images/register-mother-child.jpg'),
                'views' => '-',
                'summary' => 'Trik praktis pola makan porsi kecil frekuensi sering (small frequent feeds) dan hidrasi elektrolit seimbang bagi ibu hamil dengan keluhan mual muntah trimester pertama.',
            ],
            [
                'id' => 6,
                'title' => 'Peran Mikronutrien Zinc dan Zat Besi dalam Pertumbuhan Tulan...',
                'full_title' => 'Peran Mikronutrien Zinc dan Zat Besi dalam Pertumbuhan Tulang & Imunitas Balita',
                'read_time' => '4 mnt baca',
                'author' => 'Tim Gizi Puskesmas Gambir',
                'phase' => 'anak',
                'phase_label' => 'Anak',
                'phase_icon' => '👶',
                'phase_badge' => 'bg-sky-50 text-sky-700 border border-sky-200/60',
                'publish_date' => '-',
                'publish_time' => 'Belum Terbit',
                'status' => 'draft',
                'status_label' => 'Draft',
                'status_note' => 'Hanya tim nakes',
                'image' => asset('images/nutrition-food-hd.png'),
                'views' => '-',
                'summary' => 'Ulasan mekanisme biologis zinc terhadap proliferasi osteoblas dan sintesis hormon pertumbuhan (GH-IGF-1) serta peran zat besi dalam mencegah hipoksia seluler.',
            ],
        ];
    }

    /**
     * Tampilkan Halaman Data Edukasi Gizi (Portal Admin & Faskes).
     * URL: /admin/edukasi-gizi
     */
    public function index(Request $request)
    {
        // Proteksi akses: Pastikan pengguna telah login
        if (!Auth::check()) {
            return redirect()->route('admin.login')->withErrors([
                'login_error' => 'Silakan masuk ke Portal Admin & Tenaga Kesehatan untuk mengakses Data Edukasi Gizi.',
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

        // Ambil artikel dari session atau inisialisasi default
        if (!session()->has('admin_articles')) {
            session()->put('admin_articles', $this->getDefaultArticles());
        }
        $articles = session()->get('admin_articles');

        // Hitung statistik dinamis berdasarkan artikel yang ada
        $totalCount = count($articles);
        $terbitCount = count(array_filter($articles, fn($a) => ($a['status'] ?? '') === 'terbit'));
        $draftCount = count(array_filter($articles, fn($a) => ($a['status'] ?? '') === 'draft'));

        $praHamilCount = count(array_filter($articles, fn($a) => ($a['phase'] ?? '') === 'pra-hamil'));
        $hamilCount = count(array_filter($articles, fn($a) => ($a['phase'] ?? '') === 'hamil'));
        $anakCount = count(array_filter($articles, fn($a) => ($a['phase'] ?? '') === 'anak'));

        $statistics = [
            'total_artikel' => [
                'val' => (string) ($totalCount > 0 ? $totalCount : '0'),
                'change' => '+3 artikel ditambahkan bulan ini',
                'sub' => 'Koleksi publikasi faskes',
            ],
            'artikel_terbit' => [
                'val' => (string) ($terbitCount > 0 ? $terbitCount : '0'),
                'note' => 'Aktif di aplikasi NutriGrow Pengguna',
                'sub' => 'Dapat diakses seluruh keluarga sasaran',
            ],
            'draft_disimpan' => [
                'val' => (string) ($draftCount > 0 ? $draftCount : '0'),
                'note' => 'Tahap telaah nakes & dokter spesialis',
                'sub' => 'Menunggu verifikasi klinis',
            ],
            'pembaca_bulan_ini' => [
                'val' => '14.820',
                'note' => 'Fase Anak terbanyak (58%)',
                'sub' => 'Total pembaca terverifikasi',
            ],
        ];

        // Kategori Fase Sasaran
        $faseCategories = [
            ['key' => 'semua', 'label' => 'Semua Fase', 'count' => $totalCount],
            ['key' => 'pra-hamil', 'label' => 'Pra-Hamil', 'count' => $praHamilCount],
            ['key' => 'hamil', 'label' => 'Hamil', 'count' => $hamilCount],
            ['key' => 'anak', 'label' => 'Anak & Balita', 'count' => $anakCount],
        ];

        return view('DashboardAdmin.edukasi-gizi', compact(
            'adminName',
            'adminEmail',
            'adminRole',
            'faskesName',
            'nipStr',
            'tanggalHariIni',
            'statistics',
            'faseCategories',
            'articles'
        ));
    }

    /**
     * Helper konfigurasi badge dan ikon fase.
     */
    private function getPhaseConfig(string $phase): array
    {
        $configs = [
            'anak' => ['label' => 'Anak', 'icon' => '👶', 'badge' => 'bg-sky-50 text-sky-700 border border-sky-200/60'],
            'hamil' => ['label' => 'Hamil', 'icon' => '🤰', 'badge' => 'bg-pink-50 text-pink-700 border border-pink-200/60'],
            'pra-hamil' => ['label' => 'Pra-Hamil', 'icon' => '💙', 'badge' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/60'],
        ];

        return $configs[$phase] ?? ['label' => 'Umum', 'icon' => '🌿', 'badge' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'];
    }

    /**
     * Simpan Artikel Baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'phase' => 'required|string|in:pra-hamil,hamil,anak',
            'author' => 'required|string|max:255',
            'read_time' => 'required|string|max:50',
            'status' => 'required|string|in:terbit,draft',
            'summary' => 'required|string|max:1500',
        ]);

        $articles = session()->get('admin_articles', $this->getDefaultArticles());
        $newId = count($articles) > 0 ? max(array_column($articles, 'id')) + 1 : 1;

        $phase = $validated['phase'];
        $phaseConfig = $this->getPhaseConfig($phase);
        $isPublished = $validated['status'] === 'terbit';

        Carbon::setLocale('id');

        $newArticle = [
            'id' => $newId,
            'title' => $validated['title'],
            'full_title' => $validated['title'],
            'read_time' => $validated['read_time'],
            'author' => $validated['author'],
            'phase' => $phase,
            'phase_label' => $phaseConfig['label'],
            'phase_icon' => $phaseConfig['icon'],
            'phase_badge' => $phaseConfig['badge'],
            'publish_date' => $isPublished ? Carbon::now()->translatedFormat('d M Y') : '-',
            'publish_time' => $isPublished ? Carbon::now()->format('H:i') . ' WIB' : 'Belum Terbit',
            'status' => $validated['status'],
            'status_label' => $isPublished ? 'Terbit' : 'Draft',
            'status_note' => $isPublished ? 'Tampil ke aplikasi' : 'Hanya tim nakes',
            'image' => asset('images/nutrition-food.jpg'),
            'views' => $isPublished ? '1' : '-',
            'summary' => $validated['summary'],
        ];

        array_unshift($articles, $newArticle);
        session()->put('admin_articles', $articles);

        return redirect()->route('admin.edukasi.index')->with('success', 'Artikel edukasi gizi baru berhasil ditambahkan.');
    }

    /**
     * Perbarui Artikel Edukasi Gizi.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'phase' => 'required|string|in:pra-hamil,hamil,anak',
            'author' => 'required|string|max:255',
            'read_time' => 'required|string|max:50',
            'status' => 'required|string|in:terbit,draft',
            'summary' => 'required|string|max:1500',
        ]);

        $articles = session()->get('admin_articles', $this->getDefaultArticles());
        $phase = $validated['phase'];
        $phaseConfig = $this->getPhaseConfig($phase);
        $isPublished = $validated['status'] === 'terbit';

        Carbon::setLocale('id');

        $updated = false;
        foreach ($articles as &$art) {
            if ($art['id'] == $id) {
                $art['title'] = $validated['title'];
                $art['full_title'] = $validated['title'];
                $art['phase'] = $phase;
                $art['phase_label'] = $phaseConfig['label'];
                $art['phase_icon'] = $phaseConfig['icon'];
                $art['phase_badge'] = $phaseConfig['badge'];
                $art['author'] = $validated['author'];
                $art['read_time'] = $validated['read_time'];
                $art['status'] = $validated['status'];
                $art['status_label'] = $isPublished ? 'Terbit' : 'Draft';
                $art['status_note'] = $isPublished ? 'Tampil ke aplikasi' : 'Hanya tim nakes';
                if ($isPublished && ($art['publish_date'] === '-' || empty($art['publish_date']))) {
                    $art['publish_date'] = Carbon::now()->translatedFormat('d M Y');
                    $art['publish_time'] = Carbon::now()->format('H:i') . ' WIB';
                }
                $art['summary'] = $validated['summary'];
                $updated = true;
                break;
            }
        }

        if ($updated) {
            session()->put('admin_articles', $articles);
            return redirect()->route('admin.edukasi.index')->with('success', 'Artikel edukasi gizi berhasil diperbarui.');
        }

        return redirect()->route('admin.edukasi.index')->withErrors(['error' => 'Artikel tidak ditemukan.']);
    }

    /**
     * Hapus Artikel Edukasi Gizi.
     */
    public function destroy($id)
    {
        $articles = session()->get('admin_articles', $this->getDefaultArticles());
        $newArticles = array_values(array_filter($articles, fn($art) => $art['id'] != $id));

        session()->put('admin_articles', $newArticles);

        return redirect()->route('admin.edukasi.index')->with('success', 'Artikel berhasil dihapus dari sistem edukasi gizi.');
    }
}
