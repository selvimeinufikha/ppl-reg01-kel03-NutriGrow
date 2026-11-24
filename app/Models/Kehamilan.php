<?php

namespace App\Models;

use App\Services\PregnancyCalculatorService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kehamilan extends Model
{
    use HasFactory;

    protected $table = 'kehamilans';

    protected $fillable = [
        'user_id',
        'pasangan_id',
        'kehamilan_ke',
        'hpht',
        'hpl',
        'status',
        'gravida',
        'tanggal_persalinan',
        'status_persalinan',
        'nama_anak',
        'tinggi_badan',
        'berat_badan_pra_hamil',
        'lila_pra_hamil',
        'catatan',
        'faktor_risiko',
    ];

    protected function casts(): array
    {
        return [
            'hpht' => 'date',
            'hpl' => 'date',
            'tanggal_persalinan' => 'date',
            'kehamilan_ke' => 'integer',
            'tinggi_badan' => 'decimal:2',
            'berat_badan_pra_hamil' => 'decimal:2',
            'lila_pra_hamil' => 'decimal:1',
        ];
    }

    /**
     * Hitung HPL (Hari Perkiraan Lahir) berdasarkan rumus Naegele: HPHT + 280 hari (40 minggu).
     */
    public static function hitungHpl(string|Carbon $hpht): Carbon
    {
        return PregnancyCalculatorService::hitungHpl($hpht);
    }

    /**
     * Tanggal acuan perhitungan usia (hari ini atau saat melahirkan).
     */
    public function getTanggalAcuan(): Carbon
    {
        return ($this->status === 'melahirkan' && $this->tanggal_persalinan)
            ? Carbon::parse($this->tanggal_persalinan)
            : Carbon::now();
    }

    /**
     * Relasi ke User (Ibu Hamil / Pemilik Akun).
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
     * Relasi ke Data Pasangan (Suami / Calon Ayah).
     */
    public function pasangan(): BelongsTo
    {
        return $this->belongsTo(Pasangan::class, 'pasangan_id');
    }

    /**
     * Relasi ke data Anak yang lahir dari kehamilan ini.
     */
    public function anaks(): HasMany
    {
        return $this->hasMany(Anak::class, 'kehamilan_id');
    }

    /**
     * Relasi ke seluruh riwayat pemeriksaan kehamilan (ANC).
     */
    public function pemeriksaans(): HasMany
    {
        return $this->hasMany(PemeriksaanKehamilan::class, 'kehamilan_id')->orderBy('tgl_periksa', 'desc');
    }

    /**
     * Relasi ke rekam pemeriksaan terakhir.
     */
    public function pemeriksaanTerbaru(): HasOne
    {
        return $this->hasOne(PemeriksaanKehamilan::class, 'kehamilan_id')->latestOfMany('tgl_periksa');
    }

    /**
     * Label Gravida & HPL terformat (contoh: "G2P1A0 • HPL 28 Des 2025").
     */
    public function getGravidaHplFormattedAttribute(): string
    {
        $hplText = $this->hpl ? Carbon::parse($this->hpl)->translatedFormat('d M Y') : 'HPL Belum Ditentukan';
        return ($this->gravida ?: 'G1P0A0') . ' • HPL ' . $hplText;
    }

    /**
     * Estimasi usia gestasi saat ini dalam hitungan minggu (berdasarkan HPL atau HPHT).
     */
    public function getEstimasiGestasiMingguAttribute(): int
    {
        if ($this->hpl) {
            $hplDate = Carbon::parse($this->hpl);
            $now = Carbon::now();
            $diffDays = $now->diffInDays($hplDate, false);
            $gestasiHari = 280 - $diffDays;
            $gestasiMinggu = (int) floor($gestasiHari / 7);
            return max(1, min(42, $gestasiMinggu));
        }

        if ($this->hpht) {
            $hphtDate = Carbon::parse($this->hpht);
            $gestasiHari = Carbon::now()->diffInDays($hphtDate);
            return max(1, min(42, (int) floor($gestasiHari / 7)));
        }

        return 20;
    }

    /**
     * Label deskriptif kehamilan untuk dropdown / tampilan kartu.
     * Contoh: "Kehamilan Ke-1 (Sarah Rahmawati)"
     */
    public function getLabelAttribute(): string
    {
        $ibuName = $this->user ? $this->user->name : 'Ibu';
        $gravida = $this->gravida ?: ('Kehamilan Ke-' . $this->id);
        return "{$gravida} ({$ibuName})";
    }

    /**
     * Hitung usia kehamilan saat ini atau saat persalinan (Format: "X Minggu Y Hari").
     */
    public function getUsiaKehamilanAttribute(): string
    {
        if (!$this->hpht) {
            return '-';
        }

        $calc = PregnancyCalculatorService::hitungUsiaKehamilan($this->hpht, $this->getTanggalAcuan());
        return $calc['formatted'];
    }

    /**
     * Usia kehamilan dalam satuan minggu saja (integer).
     */
    public function getUsiaMingguAttribute(): int
    {
        if (!$this->hpht) {
            return 0;
        }

        $calc = PregnancyCalculatorService::hitungUsiaKehamilan($this->hpht, $this->getTanggalAcuan());
        return $calc['minggu'];
    }

    /**
     * Sisa hari usia kehamilan (integer).
     */
    public function getUsiaHariAttribute(): int
    {
        if (!$this->hpht) {
            return 0;
        }

        $calc = PregnancyCalculatorService::hitungUsiaKehamilan($this->hpht, $this->getTanggalAcuan());
        return $calc['hari'];
    }

    /**
     * Persentase perkembangan kehamilan menuju HPL (0 - 100%).
     */
    public function getPersentaseAttribute(): float
    {
        if (!$this->hpht) {
            return 0.0;
        }

        $calc = PregnancyCalculatorService::hitungUsiaKehamilan($this->hpht, $this->getTanggalAcuan());
        return $calc['persentase'];
    }

    /**
     * Sisa hari menuju HPL.
     */
    public function getSisaHariAttribute(): int
    {
        if (!$this->hpht) {
            return 0;
        }

        $calc = PregnancyCalculatorService::hitungUsiaKehamilan($this->hpht, $this->getTanggalAcuan());
        return $calc['sisa_hari'];
    }

    /**
     * Label Trimester lengkap (contoh: "Trimester 2 (14–27 Mg)").
     */
    public function getTrimesterAttribute(): string
    {
        $info = PregnancyCalculatorService::tentukanTrimester($this->usia_minggu);
        return $info['label'];
    }

    /**
     * Nomor Trimester (1, 2, atau 3).
     */
    public function getTrimesterNomorAttribute(): int
    {
        $info = PregnancyCalculatorService::tentukanTrimester($this->usia_minggu);
        return $info['nomor'];
    }

    /**
     * Badge Trimester singkat (contoh: "T1 Aktif", "T2 Aktif", "T3 Aktif").
     */
    public function getTrimesterBadgeAttribute(): string
    {
        $info = PregnancyCalculatorService::tentukanTrimester($this->usia_minggu);
        return $info['badge'];
    }

    /**
     * Deskripsi dan fokus kesehatan trimester saat ini.
     */
    public function getTrimesterInfoAttribute(): array
    {
        return PregnancyCalculatorService::tentukanTrimester($this->usia_minggu);
    }

    /**
     * Milestone ukuran & perkembangan janin saat ini.
     */
    public function getMilestoneJaninAttribute(): array
    {
        return PregnancyCalculatorService::getMilestoneJanin($this->usia_minggu);
    }

    /**
     * Rangkuman data kalkulasi lengkap.
     */
    public function getDetailKalkulasiAttribute(): array
    {
        return PregnancyCalculatorService::hitungLengkap($this->hpht, $this->getTanggalAcuan());
    }

    /**
     * Format tanggal HPHT berbahasa Indonesia (contoh: "23 Des 2023").
     */
    public function getHphtFormattedAttribute(): string
    {
        return $this->hpht ? Carbon::parse($this->hpht)->locale('id')->translatedFormat('j M Y') : '-';
    }

    /**
     * Format tanggal HPL berbahasa Indonesia (contoh: "28 Sep 2024").
     */
    public function getHplFormattedAttribute(): string
    {
        return $this->hpl ? Carbon::parse($this->hpl)->locale('id')->translatedFormat('j M Y') : '-';
    }

    /**
     * Format tanggal persalinan berbahasa Indonesia.
     */
    public function getTanggalPersalinanFormattedAttribute(): string
    {
        return $this->tanggal_persalinan ? Carbon::parse($this->tanggal_persalinan)->locale('id')->translatedFormat('j M Y') : '-';
    }

    /**
     * Tanggal pembaruan terakhir yang diformat.
     */
    public function getUpdatedFormattedAttribute(): string
    {
        return $this->updated_at ? Carbon::parse($this->updated_at)->locale('id')->translatedFormat('j M Y') : '-';
    }
}
