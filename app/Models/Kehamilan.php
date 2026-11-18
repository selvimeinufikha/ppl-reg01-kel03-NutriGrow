<?php

namespace App\Models;

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
        'gravida',
        'hpht',
        'hpl',
        'tinggi_badan',
        'berat_badan_pra_hamil',
        'lila_pra_hamil',
        'faktor_risiko',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'hpht' => 'date',
            'hpl' => 'date',
            'tinggi_badan' => 'decimal:2',
            'berat_badan_pra_hamil' => 'decimal:2',
            'lila_pra_hamil' => 'decimal:1',
        ];
    }

    /**
     * Relasi ke User (Ibu Hamil).
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
            // Standar kehamilan 280 hari (40 minggu)
            $gestasiHari = 280 - $diffDays;
            $gestasiMinggu = (int) floor($gestasiHari / 7);
            return max(1, min(42, $gestasiMinggu));
        }

        if ($this->hpht) {
            $hphtDate = Carbon::parse($this->hpht);
            $gestasiHari = Carbon::now()->diffInDays($hphtDate);
            return max(1, min(42, (int) floor($gestasiHari / 7)));
        }

        return 20; // Default estimasi trimester 2 jika tidak ada data
    }
}

