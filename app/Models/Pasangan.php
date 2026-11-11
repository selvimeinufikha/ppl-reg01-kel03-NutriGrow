<?php

namespace App\Models;

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
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'no_telepon',
        'golongan_darah',
        'hubungan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Relasi ke User (Istri / Akun Pengguna).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke seluruh riwayat kehamilan pasangan.
     */
    public function kehamilans(): HasMany
    {
        return $this->hasMany(Kehamilan::class, 'pasangan_id');
    }
}
