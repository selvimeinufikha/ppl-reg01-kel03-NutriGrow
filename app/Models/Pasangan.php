<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pasangan extends Model
{
    use HasFactory;

    protected $table = 'pasangans';

    protected $fillable = [
        'user_id',
        'nama',
        'tanggal_lahir',
        'pekerjaan',
        'golongan_darah',
        'status_pasangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Relasi ke User (pemilik akun).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return match ($this->status_pasangan) {
            'suami'        => 'Suami',
            'istri'        => 'Istri',
            'calon_suami'  => 'Calon Suami',
            'calon_istri'  => 'Calon Istri',
            default        => $this->status_pasangan,
        };
    }
}
