<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Relasi ke User (Ibu Hamil / Akun Keluarga).
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
     * Relasi ke data Anak yang lahir dari kehamilan ini.
     */
    public function anaks(): HasMany
    {
        return $this->hasMany(Anak::class, 'kehamilan_id');
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
}
