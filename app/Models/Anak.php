<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'anaks';

    protected $fillable = [
        'user_id',
        'kehamilan_id',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'anak_ke',
        'berat_lahir',
        'panjang_lahir',
        'lingkar_kepala_lahir',
        'golongan_darah',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'anak_ke' => 'integer',
            'berat_lahir' => 'decimal:2',
            'panjang_lahir' => 'decimal:2',
            'lingkar_kepala_lahir' => 'decimal:1',
        ];
    }

    /**
     * Relasi ke Akun Pengguna / Keluarga (Orang Tua).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias relasi orang tua.
     */
    public function orangTua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Data Kehamilan terkait.
     */
    public function kehamilan(): BelongsTo
    {
        return $this->belongsTo(Kehamilan::class, 'kehamilan_id');
    }

    /**
     * Format usia anak (e.g. "3 tahun 10 bulan", "6 bulan", "14 hari").
     */
    public function getUsiaFormattedAttribute(): string
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }

        $birthDate = Carbon::parse($this->tanggal_lahir);
        $now = Carbon::now();

        if ($birthDate->isFuture()) {
            return 'Belum lahir';
        }

        $years = (int) $birthDate->diffInYears($now);
        $months = (int) $birthDate->copy()->addYears($years)->diffInMonths($now);

        if ($years > 0) {
            return $months > 0 ? "{$years} tahun {$months} bulan" : "{$years} tahun";
        }

        if ($months > 0) {
            $days = (int) $birthDate->copy()->addMonths($months)->diffInDays($now);
            return $days > 0 ? "{$months} bulan {$days} hari" : "{$months} bulan";
        }

        $days = (int) $birthDate->diffInDays($now);
        return "{$days} hari";
    }

    /**
     * Tanggal lahir terformat dalam Bahasa Indonesia (contoh: "22 Desember 2022").
     */
    public function getTanggalLahirFormattedAttribute(): string
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }
        Carbon::setLocale('id');
        return Carbon::parse($this->tanggal_lahir)->translatedFormat('d F Y');
    }

    /**
     * Label data kehamilan terkait (contoh: "Kehamilan Ke-1 (Sarah Rahmawati)" atau "Tidak ada data terkait").
     */
    public function getKehamilanTerkaitLabelAttribute(): string
    {
        if ($this->kehamilan) {
            return $this->kehamilan->label;
        }

        return 'Tidak ada data terkait';
    }
}
