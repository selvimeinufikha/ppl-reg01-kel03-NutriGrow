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
     * Evaluasi Klinis Standar Kemenkes RI & WHO.
     * Menghitung status risiko KEK, Anemia, Tekanan Darah, dan kesimpulan.
     */
    public static function evaluateKlinis(
        float $lila,
        ?float $hb = null,
        ?int $sistol = null,
        ?int $diastol = null,
        int $gestasi = 20
    ): array {
        // 1. Status KEK berdasarkan Lingkar Lengan Atas (LiLA)
        // Standar Kemenkes: LiLA < 23.5 cm menunjukkan Kurang Energi Kronis (KEK)
        $isKek = $lila < 23.5;
        $statusKek = $isKek ? 'risiko_kek' : 'normal';

        // 2. Status Anemia berdasarkan Hemoglobin (Hb)
        // Standar WHO/Kemenkes:
        // Trimester 1 & 3: Hb < 11.0 g/dL -> Anemia
        // Trimester 2: Hb < 10.5 g/dL -> Anemia
        $statusAnemia = 'normal';
        $anemiaThreshold = ($gestasi >= 14 && $gestasi <= 27) ? 10.5 : 11.0;

        if ($hb !== null && $hb > 0) {
            if ($hb < 7.0) {
                $statusAnemia = 'anemia_berat';
            } elseif ($hb < 10.0) {
                $statusAnemia = 'anemia_sedang';
            } elseif ($hb < $anemiaThreshold) {
                $statusAnemia = 'anemia_ringan';
            } else {
                $statusAnemia = 'normal';
            }
        }

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
            $risikoLabels[] = 'Risiko KEK';
        }
        if (str_starts_with($statusAnemia, 'anemia_')) {
            $risikoLabels[] = $statusAnemia === 'anemia_berat' ? 'Anemia Berat' : ($statusAnemia === 'anemia_sedang' ? 'Anemia Sedang' : 'Anemia Ringan');
        }
        if ($statusTd === 'hipertensi') {
            $risikoLabels[] = 'Hipertensi';
        } elseif ($statusTd === 'pra_hipertensi') {
            $risikoLabels[] = 'Pra-Hipertensi';
        }

        $kesimpulan = empty($risikoLabels) ? 'Normal' : implode(', ', $risikoLabels);

        return [
            'status_kek' => $statusKek,
            'status_anemia' => $statusAnemia,
            'status_tekanan_darah' => $statusTd,
            'kesimpulan_risiko' => $kesimpulan,
            'is_kek' => $isKek,
            'is_anemia' => str_starts_with($statusAnemia, 'anemia_'),
            'is_hipertensi' => in_array($statusTd, ['pra_hipertensi', 'hipertensi']),
        ];
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

