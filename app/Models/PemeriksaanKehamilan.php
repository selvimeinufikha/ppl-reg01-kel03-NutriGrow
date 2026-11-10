<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemeriksaanKehamilan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_kehamilans';

    protected $fillable = [
        'kehamilan_id',
        'user_id',
        'nakes_id',
        'tgl_periksa',
        'jam_periksa',
        'usia_gestasi_minggu',
        'trimester',
        'berat_badan',
        'perubahan_bb',
        'tekanan_darah',
        'sistol',
        'diastol',
        'lila',
        'hb',
        'tfu',
        'djj',
        'status_kek',
        'status_anemia',
        'status_tekanan_darah',
        'kesimpulan_risiko',
        'catatan_klinis',
        'tgl_kontrol_berikutnya',
    ];

    protected $appends = [
        'lila_risk',
        'hb_risk',
        'gestasi_badge',
    ];

    protected function casts(): array
    {
        return [
            'tgl_periksa' => 'date',
            'tgl_kontrol_berikutnya' => 'date',
            'berat_badan' => 'decimal:2',
            'perubahan_bb' => 'decimal:2',
            'lila' => 'decimal:1',
            'hb' => 'decimal:1',
            'tfu' => 'decimal:1',
            'usia_gestasi_minggu' => 'integer',
            'trimester' => 'integer',
            'sistol' => 'integer',
            'diastol' => 'integer',
            'djj' => 'integer',
        ];
    }

    /**
     * Relasi ke Data Kehamilan.
     */
    public function kehamilan(): BelongsTo
    {
        return $this->belongsTo(Kehamilan::class, 'kehamilan_id');
    }

    /**
     * Relasi ke Pengguna (Ibu Hamil).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias relasi ke Ibu Hamil.
     */
    public function ibu(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Petugas Tenaga Kesehatan yang memeriksa.
     */
    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    /**
     * PBI-014: Fungsi Pengecekan Nilai LiLA (Lingkar Lengan Atas)
     * Standar Kemenkes RI: LiLA < 23.5 cm menunjukkan Risiko KEK (Kekurangan Energi Kronis).
     */
    public static function cekRisikoLila(float $lila): array
    {
        $threshold = 23.5;
        $isKek = $lila < $threshold;

        if ($lila < 21.0) {
            $status = 'kek_berat';
            $kategori = 'KEK Berat';
            $badgeClass = 'bg-red-50 text-red-700 border border-red-200';
            $icon = '🚨';
            $rekomendasi = 'Prioritas tinggi: Rujuk segera ke dokter spesialis gizi klinis / Sp.OG dan jadwalkan PMT pemulihan intensif.';
        } elseif ($lila < 23.5) {
            $status = 'risiko_kek';
            $kategori = 'Risiko KEK';
            $badgeClass = 'bg-rose-50 text-rose-700 border border-rose-200';
            $icon = '⚠️';
            $rekomendasi = 'Intervensi PMT biskuit/pangan lokal kaya protein hewani (telur, hati ayam, ikan) dan pantau kenaikan BB tiap 2 minggu.';
        } else {
            $status = 'normal';
            $kategori = 'Nutrisi Cukup';
            $badgeClass = 'bg-emerald-50 text-emerald-700 border border-emerald-200';
            $icon = '✓';
            $rekomendasi = 'Status gizi baik (LiLA ≥ 23.5 cm). Pertahankan asupan makanan bergizi seimbang kaya protein & mikronutrien.';
        }

        return [
            'is_kek' => $isKek,
            'status' => $status,
            'kategori' => $kategori,
            'threshold' => $threshold,
            'selisih' => $isKek ? round($threshold - $lila, 1) : 0,
            'badge_class' => $badgeClass,
            'icon' => $icon,
            'rekomendasi' => $rekomendasi,
        ];
    }

    /**
     * PBI-014: Fungsi Pengecekan Kadar Hemoglobin (Hb)
     * Standar WHO & Kemenkes RI:
     * - Trimester 1 & 3: Hb < 11.0 g/dL -> Anemia
     * - Trimester 2: Hb < 10.5 g/dL -> Anemia
     */
    public static function cekRisikoHb(float $hb, int $gestasi = 20): array
    {
        $threshold = ($gestasi >= 14 && $gestasi <= 27) ? 10.5 : 11.0;
        $isAnemia = $hb < $threshold;

        if ($hb < 7.0) {
            $status = 'anemia_berat';
            $kategori = 'Anemia Berat';
            $badgeClass = 'bg-red-100 text-red-800 border border-red-300 font-black';
            $icon = '🚨';
            $rekomendasi = 'Kondisi darurat obstetri (Hb < 7.0 g/dL): Rujuk segera ke Rumah Sakit untuk evaluasi transfusi darah / terapi besi parenteral.';
        } elseif ($hb < 10.0) {
            $status = 'anemia_sedang';
            $kategori = 'Anemia Sedang';
            $badgeClass = 'bg-red-50 text-red-700 border border-red-200 font-bold';
            $icon = '⚠️';
            $rekomendasi = 'Berikan terapi Tablet Tambah Darah (TTD) dosis ganda 2x1 tablet/hari disertai konsumsi buah tinggi vitamin C untuk absorpsi optimal.';
        } elseif ($hb < $threshold) {
            $status = 'anemia_ringan';
            $kategori = 'Anemia Ringan';
            $badgeClass = 'bg-rose-50 text-rose-700 border border-rose-200 font-bold';
            $icon = '⚠️';
            $rekomendasi = 'Tingkatkan kepatuhan minum 1 tablet TTD setiap malam hari dan evaluasi ulang kadar Hb dalam 4 minggu ke depan.';
        } else {
            $status = 'normal';
            $kategori = 'Normal';
            $badgeClass = 'bg-emerald-50 text-emerald-700 border border-emerald-200';
            $icon = '✓';
            $rekomendasi = 'Kadar hemoglobin optimal (Hb ≥ ' . number_format($threshold, 1) . ' g/dL). Lanjutkan suplementasi 90 tablet TTD profilaksis rutin.';
        }

        return [
            'is_anemia' => $isAnemia,
            'status' => $status,
            'kategori' => $kategori,
            'threshold' => $threshold,
            'selisih' => $isAnemia ? round($threshold - $hb, 1) : 0,
            'badge_class' => $badgeClass,
            'icon' => $icon,
            'rekomendasi' => $rekomendasi,
        ];
    }

    /**
     * Evaluasi Klinis Standar Kemenkes RI & WHO.
     * Mengintegrasikan deteksi risiko KEK, Anemia, Tekanan Darah, dan kesimpulan.
     */
    public static function evaluateKlinis(
        float $lila,
        ?float $hb = null,
        ?int $sistol = null,
        ?int $diastol = null,
        int $gestasi = 20
    ): array {
        // 1. Deteksi Risiko KEK
        $lilaResult = self::cekRisikoLila($lila);
        $statusKek = $lilaResult['status'];
        $isKek = $lilaResult['is_kek'];

        // 2. Deteksi Risiko Anemia
        $hbResult = $hb !== null ? self::cekRisikoHb($hb, $gestasi) : [
            'is_anemia' => false,
            'status' => 'normal',
            'kategori' => 'Normal',
            'threshold' => 11.0,
            'selisih' => 0,
            'badge_class' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
            'icon' => '✓',
            'rekomendasi' => 'Pemeriksaan laboratorium Hb disarankan.',
        ];
        $statusAnemia = $hbResult['status'];
        $isAnemia = $hbResult['is_anemia'];

        // 3. Status Tekanan Darah
        $statusTd = 'optimal';
        if ($sistol !== null && $diastol !== null) {
            if ($sistol >= 140 || $diastol >= 90) {
                $statusTd = 'hipertensi';
            } elseif ($sistol >= 120 || $diastol >= 80) {
                $statusTd = 'pra_hipertensi';
            } elseif ($sistol < 100 || $diastol < 65) {
                $statusTd = 'normal_rendah';
            } else {
                $statusTd = 'optimal';
            }
        }

        // 4. Kesimpulan Risiko Gabungan
        $risikoLabels = [];
        if ($isKek) {
            $risikoLabels[] = $lilaResult['kategori'];
        }
        if ($isAnemia) {
            $risikoLabels[] = $hbResult['kategori'];
        }
        if ($statusTd === 'hipertensi') {
            $risikoLabels[] = 'Hipertensi';
        } elseif ($statusTd === 'pra_hipertensi') {
            $risikoLabels[] = 'Pra-Hipertensi';
        }

        $kesimpulan = empty($risikoLabels) ? 'Normal' : implode(', ', $risikoLabels);

        // Tingkat prioritas intervensi klinis
        $tingkatRisiko = 'Normal';
        if ($statusKek === 'kek_berat' || $statusAnemia === 'anemia_berat' || $statusTd === 'hipertensi') {
            $tingkatRisiko = 'Tinggi';
        } elseif ($isKek || $isAnemia || $statusTd === 'pra_hipertensi') {
            $tingkatRisiko = 'Sedang';
        }

        return [
            'status_kek' => $statusKek,
            'status_anemia' => $statusAnemia,
            'status_tekanan_darah' => $statusTd,
            'kesimpulan_risiko' => $kesimpulan,
            'tingkat_risiko' => $tingkatRisiko,
            'is_kek' => $isKek,
            'is_anemia' => $isAnemia,
            'is_hipertensi' => in_array($statusTd, ['pra_hipertensi', 'hipertensi']),
            'lila_info' => $lilaResult,
            'hb_info' => $hbResult,
        ];
    }

    /**
     * Accessor detail risiko LiLA.
     */
    public function getLilaRiskAttribute(): array
    {
        return self::cekRisikoLila((float) $this->lila);
    }

    /**
     * Accessor detail risiko Hb.
     */
    public function getHbRiskAttribute(): array
    {
        if ($this->hb === null || (float)$this->hb <= 0) {
            return [
                'is_anemia' => false,
                'status' => 'belum_diperiksa',
                'kategori' => 'Belum Diperiksa',
                'threshold' => 11.0,
                'selisih' => 0,
                'badge_class' => 'bg-slate-100 text-slate-600 border border-slate-200',
                'icon' => 'ℹ️',
                'rekomendasi' => 'Pemeriksaan laboratorium hemoglobin (Hb) disarankan untuk skrining anemia prenatal.',
            ];
        }

        return self::cekRisikoHb((float) $this->hb, (int) $this->usia_gestasi_minggu);
    }

    /**
     * Label Trimester terformat (contoh: "32 mgg Trimester 3" atau "38 mgg Siap Salin").
     */
    public function getGestasiBadgeAttribute(): array
    {
        $mgg = $this->usia_gestasi_minggu;
        if ($mgg >= 37) {
            return [
                'minggu' => "{$mgg} mgg",
                'label' => 'Siap Salin',
                'badge' => 'text-teal-700 bg-teal-50 border border-teal-200/80',
            ];
        } elseif ($mgg >= 28) {
            return [
                'minggu' => "{$mgg} mgg",
                'label' => 'Trimester 3',
                'badge' => 'text-sky-700 bg-sky-50 border border-sky-200/80',
            ];
        } elseif ($mgg >= 14) {
            return [
                'minggu' => "{$mgg} mgg",
                'label' => 'Trimester 2',
                'badge' => 'text-cyan-700 bg-cyan-50 border border-cyan-200/80',
            ];
        } else {
            return [
                'minggu' => "{$mgg} mgg",
                'label' => 'Trimester 1',
                'badge' => 'text-amber-700 bg-amber-50 border border-amber-200/80',
            ];
        }
    }

    /**
     * Label Perubahan Berat Badan terformat (contoh: "↑ +1.2 kg" atau "↓ -0.3 kg").
     */
    public function getPerubahanBbFormattedAttribute(): ?string
    {
        if ($this->perubahan_bb === null) {
            return null;
        }

        $val = (float) $this->perubahan_bb;
        if ($val > 0) {
            return "↑ +" . number_format($val, 1) . " kg";
        } elseif ($val < 0) {
            return "↓ " . number_format($val, 1) . " kg";
        } else {
            return "0.0 kg";
        }
    }
}
