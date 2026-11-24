<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasangan extends Model
{
    use HasFactory;

    protected $table = 'pasangans';

    protected $fillable = [
        'user_id',
        'nama',
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'no_telepon',
        'golongan_darah',
        'status_pasangan',
        'hubungan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Relasi ke User (pemilik akun / istri).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hitung usia berdasarkan tanggal lahir.
     */
    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : 0;
    }

    /**
     * Format tanggal lahir Indonesia (contoh: "12 Mei 1990").
     */
    public function getTanggalLahirFormattedAttribute(): string
    {
        return $this->tanggal_lahir
            ? Carbon::parse($this->tanggal_lahir)->locale('id')->translatedFormat('j F Y')
            : '-';
    }

    /**
     * Label status pasangan yang ramah dibaca.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_pasangan ?? $this->hubungan) {
            'suami'        => 'Suami',
            'istri'        => 'Istri',
            'calon_suami'  => 'Calon Suami',
            'calon_istri'  => 'Calon Istri',
            default        => $this->status_pasangan ?? $this->hubungan ?? '-',
        };
    }

    /**
     * Relasi ke seluruh riwayat kehamilan pasangan.
     */
    public function kehamilans(): HasMany
    {
        return $this->hasMany(Kehamilan::class, 'pasangan_id');
    }
}
