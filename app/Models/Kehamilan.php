<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return Carbon::parse($hpht)->copy()->addDays(280);
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
     * Hitung usia kehamilan saat ini atau saat persalinan (Format: "X Minggu Y Hari").
     */
    public function getUsiaKehamilanAttribute(): string
    {
        if (!$this->hpht) {
            return '-';
        }

        $endDate = ($this->status === 'melahirkan' && $this->tanggal_persalinan)
            ? Carbon::parse($this->tanggal_persalinan)
            : Carbon::now();

        $hphtDate = Carbon::parse($this->hpht);

        // Jika HPHT di masa depan, kembalikan 0
        if ($endDate->lt($hphtDate)) {
            return '0 Minggu 0 Hari';
        }

        $totalDays = $hphtDate->diffInDays($endDate);
        $weeks = (int) floor($totalDays / 7);
        $days = (int) ($totalDays % 7);

        return "{$weeks} Minggu {$days} Hari";
    }

    /**
     * Usia kehamilan dalam satuan minggu saja.
     */
    public function getUsiaMingguAttribute(): int
    {
        if (!$this->hpht) {
            return 0;
        }

        $endDate = ($this->status === 'melahirkan' && $this->tanggal_persalinan)
            ? Carbon::parse($this->tanggal_persalinan)
            : Carbon::now();

        $hphtDate = Carbon::parse($this->hpht);

        if ($endDate->lt($hphtDate)) {
            return 0;
        }

        return (int) floor($hphtDate->diffInDays($endDate) / 7);
    }

    /**
     * Mendapatkan kategori Trimester kehamilan.
     */
    public function getTrimesterAttribute(): string
    {
        $weeks = $this->usia_minggu;

        if ($weeks <= 13) {
            return 'Trimester 1 (1–13 Mg)';
        } elseif ($weeks <= 27) {
            return 'Trimester 2 (14–27 Mg)';
        } else {
            return 'Trimester 3 (28–40 Mg)';
        }
    }

    /**
     * Badge Trimester singkat (contoh: "T1 Aktif", "T2 Aktif", "T3 Aktif").
     */
    public function getTrimesterBadgeAttribute(): string
    {
        $weeks = $this->usia_minggu;

        if ($weeks <= 13) {
            return 'T1 Aktif';
        } elseif ($weeks <= 27) {
            return 'T2 Aktif';
        } else {
            return 'T3 Aktif';
        }
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
