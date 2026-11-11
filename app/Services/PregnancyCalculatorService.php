<?php

namespace App\Services;

use Carbon\Carbon;

class PregnancyCalculatorService
{
    /**
     * Hitung Hari Perkiraan Lahir (HPL) dari tanggal HPHT menggunakan Rumus Naegele.
     * Standar klinis: HPHT + 280 hari (40 minggu).
     */
    public static function hitungHpl(string|Carbon $hpht): Carbon
    {
        return Carbon::parse($hpht)->copy()->addDays(280);
    }

    /**
     * Hitung usia kehamilan (minggu dan hari) dari tanggal HPHT.
     *
     * @param string|Carbon $hpht
     * @param string|Carbon|null $referenceDate Tanggal acuan (default hari ini)
     * @return array [
     *    'total_hari' => int,
     *    'minggu' => int,
     *    'hari' => int,
     *    'formatted' => string,
     *    'persentase' => float,
     *    'sisa_hari' => int,
     *    'sisa_minggu' => int
     * ]
     */
    public static function hitungUsiaKehamilan(string|Carbon $hpht, string|Carbon|null $referenceDate = null): array
    {
        $hphtDate = Carbon::parse($hpht)->startOfDay();
        $targetDate = $referenceDate ? Carbon::parse($referenceDate)->startOfDay() : Carbon::now()->startOfDay();

        // Jika HPHT mendahului targetDate
        if ($targetDate->lt($hphtDate)) {
            return [
                'total_hari' => 0,
                'minggu' => 0,
                'hari' => 0,
                'formatted' => '0 Minggu 0 Hari',
                'persentase' => 0.0,
                'sisa_hari' => 280,
                'sisa_minggu' => 40,
            ];
        }

        $totalDays = (int) $hphtDate->diffInDays($targetDate);
        $weeks = (int) floor($totalDays / 7);
        $days = (int) ($totalDays % 7);

        // Progres kehamilan menuju 280 hari (40 minggu)
        $progress = min(100.0, max(0.0, round(($totalDays / 280) * 100, 1)));
        $remainingDays = max(0, 280 - $totalDays);
        $remainingWeeks = (int) ceil($remainingDays / 7);

        return [
            'total_hari' => $totalDays,
            'minggu' => $weeks,
            'hari' => $days,
            'formatted' => "{$weeks} Minggu {$days} Hari",
            'persentase' => $progress,
            'sisa_hari' => $remainingDays,
            'sisa_minggu' => $remainingWeeks,
        ];
    }

    /**
     * Tentukan Trimester kehamilan berdasarkan usia dalam minggu.
     * Kategori standar medis Kemenkes RI / WHO:
     * - Trimester 1: Minggu 1 s.d. 13 (1–13 Mg)
     * - Trimester 2: Minggu 14 s.d. 27 (14–27 Mg)
     * - Trimester 3: Minggu 28 s.d. 40+ (28–40 Mg)
     *
     * @param int $minggu
     * @return array [
     *    'nomor' => int,
     *    'nama' => string,
     *    'rentang' => string,
     *    'label' => string,
     *    'badge' => string,
     *    'deskripsi' => string,
     *    'fokus_kesehatan' => string,
     *    'asupan_nutrisi' => array
     * ]
     */
    public static function tentukanTrimester(int $minggu): array
    {
        if ($minggu <= 13) {
            return [
                'nomor' => 1,
                'nama' => 'Trimester 1',
                'rentang' => '1–13 Minggu',
                'label' => 'Trimester 1 (1–13 Mg)',
                'badge' => 'T1 Aktif',
                'deskripsi' => 'Fase pembentukan awal organ-organ vital janin (otak, jantung, dan sistem saraf). Ibu sering mengalami morning sickness.',
                'fokus_kesehatan' => 'Pencegahan cacat tabung saraf (neural tube defect), pemenuhan asam folat, dan hidrasi optimal.',
                'asupan_nutrisi' => [
                    'Asam Folat 400 mcg/hari (bayam, alpukat, brokoli)',
                    'Vitamin B6 untuk mengurangi mual',
                    'Protein berkualitas tinggi (telur, ikan, tahu/tempe)',
                    'Air mineral minimal 2.5 - 3 liter per hari',
                ],
            ];
        } elseif ($minggu <= 27) {
            return [
                'nomor' => 2,
                'nama' => 'Trimester 2',
                'rentang' => '14–27 Minggu',
                'label' => 'Trimester 2 (14–27 Mg)',
                'badge' => 'T2 Aktif',
                'deskripsi' => 'Fase pertumbuhan pesat janin. Gerakan janin mulai terasa jelas, pendengaran berkembang, dan energi ibu umumnya meningkat.',
                'fokus_kesehatan' => 'Pencegahan anemia defisiensi besi dan pemantauan kenaikan berat badan ibu secara bertahap.',
                'asupan_nutrisi' => [
                    'Zat Besi (Fe) & Tablet Tambah Darah (TTD) rutin',
                    'Kalsium 1.200 mg/hari (susu, keju, ikan teri)',
                    'Vitamin D untuk penyerapan kalsium tulang janin',
                    'Asam lemak Omega-3 / DHA untuk perkembangan retina dan otak',
                ],
            ];
        } else {
            return [
                'nomor' => 3,
                'nama' => 'Trimester 3',
                'rentang' => '28–40 Minggu',
                'label' => 'Trimester 3 (28–40 Mg)',
                'badge' => 'T3 Aktif',
                'deskripsi' => 'Fase pematangan akhir organ (terutama paru-paru) dan penumpukan lemak subkutan janin sebagai persiapan persalinan.',
                'fokus_kesehatan' => 'Persiapan persalinan aman, pemantauan gerakan janin (kick count), dan pencegahan preeklamsia.',
                'asupan_nutrisi' => [
                    'Kalori tambahan berkualitas (+450 kkal/hari)',
                    'Serat pangan tinggi untuk mencegah konstipasi',
                    'Vitamin K untuk proses pembekuan darah normal saat melahirkan',
                    'Zinc / Seng untuk memperkuat imunitas ibu dan bayi',
                ],
            ];
        }
    }

    /**
     * Dapatkan analogi ukuran dan berat janin berdasarkan usia minggu.
     */
    public static function getMilestoneJanin(int $minggu): array
    {
        if ($minggu <= 4) {
            return ['nama' => 'Biji Poppy', 'panjang' => '< 1 mm', 'berat' => '< 1 gram', 'deskripsi' => 'Sel-sel sedang membelah aktif dan menempel pada dinding rahim.'];
        } elseif ($minggu <= 8) {
            return ['nama' => 'Buah Raspberry', 'panjang' => '±1.6 cm', 'berat' => '±1 gram', 'deskripsi' => 'Detak jantung janin mulai terdeteksi melalui USG dini.'];
        } elseif ($minggu <= 12) {
            return ['nama' => 'Buah Plum', 'panjang' => '±5.4 cm', 'berat' => '±14 gram', 'deskripsi' => 'Struktur wajah terbentuk, jari tangan dan kaki mulai memisah.'];
        } elseif ($minggu <= 16) {
            return ['nama' => 'Buah Alpukat', 'panjang' => '±11.6 cm', 'berat' => '±100 gram', 'deskripsi' => 'Janin mulai dapat mengisap jempol dan merespons cahaya samar.'];
        } elseif ($minggu <= 20) {
            return ['nama' => 'Pisang', 'panjang' => '±25 cm', 'berat' => '±300 gram', 'deskripsi' => 'Pemeriksaan USG anomali (tengah kehamilan), jenis kelamin tampak jelas.'];
        } elseif ($minggu <= 24) {
            return ['nama' => 'Jagung Manis', 'panjang' => '±30 cm', 'berat' => '±600 gram', 'deskripsi' => 'Janin berukuran sebesar jagung manis. Pendengaran aktif dan merespons suara ibu.'];
        } elseif ($minggu <= 28) {
            return ['nama' => 'Terong Ungu', 'panjang' => '±37 cm', 'berat' => '±1.000 gram', 'deskripsi' => 'Kelopak mata janin mulai terbuka dan bulu mata tumbuh.'];
        } elseif ($minggu <= 32) {
            return ['nama' => 'Labu Madu (Butternut Squash)', 'panjang' => '±42 cm', 'berat' => '±1.700 gram', 'deskripsi' => 'Tulang mengeras namun tengkorak tetap fleksibel untuk jalan lahir.'];
        } elseif ($minggu <= 36) {
            return ['nama' => 'Pepaya', 'panjang' => '±47 cm', 'berat' => '±2.600 gram', 'deskripsi' => 'Posisi kepala janin mulai turun menuju pintu atas panggul (PAP).'];
        } else {
            return ['nama' => 'Semangka Kecil', 'panjang' => '±50 cm', 'berat' => '±3.200 gram', 'deskripsi' => 'Janin telah matang (aterm) dan siap menyapa dunia kapan saja!'];
        }
    }

    /**
     * Hitung rangkuman komprehensif kehamilan dari HPHT.
     */
    public static function hitungLengkap(string|Carbon $hpht, string|Carbon|null $referenceDate = null): array
    {
        Carbon::setLocale('id');
        $hphtDate = Carbon::parse($hpht);
        $hpl = self::hitungHpl($hpht);
        $usia = self::hitungUsiaKehamilan($hpht, $referenceDate);
        $trimester = self::tentukanTrimester($usia['minggu']);
        $milestone = self::getMilestoneJanin($usia['minggu']);

        return [
            'hpht' => $hphtDate->format('Y-m-d'),
            'hpht_formatted' => $hphtDate->translatedFormat('d M Y'),
            'hpht_lengkap' => $hphtDate->translatedFormat('l, d F Y'),
            'hpl' => $hpl->format('Y-m-d'),
            'hpl_formatted' => $hpl->translatedFormat('d M Y'),
            'hpl_lengkap' => $hpl->translatedFormat('l, d F Y'),
            'usia_kehamilan' => $usia['formatted'],
            'usia_minggu' => $usia['minggu'],
            'usia_hari' => $usia['hari'],
            'total_hari' => $usia['total_hari'],
            'persentase' => $usia['persentase'],
            'sisa_hari' => $usia['sisa_hari'],
            'sisa_minggu' => $usia['sisa_minggu'],
            'trimester' => $trimester,
            'milestone' => $milestone,
        ];
    }
}
