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
     * Mutator untuk memastikan nilai kosong disimpan sebagai NULL di MySQL strict mode.
     */
    public function setKehamilanIdAttribute($value)
    {
        $this->attributes['kehamilan_id'] = ($value !== null && $value !== '') ? $value : null;
    }

    public function setAnakKeAttribute($value)
    {
        $this->attributes['anak_ke'] = ($value !== null && $value !== '') ? (int) $value : null;
    }

    public function setBeratLahirAttribute($value)
    {
        $this->attributes['berat_lahir'] = ($value !== null && $value !== '') ? (float) $value : null;
    }

    public function setPanjangLahirAttribute($value)
    {
        $this->attributes['panjang_lahir'] = ($value !== null && $value !== '') ? (float) $value : null;
    }

    public function setLingkarKepalaLahirAttribute($value)
    {
        $this->attributes['lingkar_kepala_lahir'] = ($value !== null && $value !== '') ? (float) $value : null;
    }

    public function setNikAttribute($value)
    {
        $this->attributes['nik'] = ($value !== null && trim($value) !== '') ? trim($value) : null;
    }

    public function setTempatLahirAttribute($value)
    {
        $this->attributes['tempat_lahir'] = ($value !== null && trim($value) !== '') ? trim($value) : null;
    }

    public function setGolonganDarahAttribute($value)
    {
        $this->attributes['golongan_darah'] = ($value !== null && trim($value) !== '') ? trim($value) : null;
    }

    public function setCatatanAttribute($value)
    {
        $this->attributes['catatan'] = ($value !== null && trim($value) !== '') ? trim($value) : null;
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
     * Format usia anak (e.g. "3 tahun 10 bulan", "6 bulan 14 hari", "14 hari").
     * Dihitung otomatis dari tanggal_lahir hingga hari ini.
     */
    public function getUsiaFormattedAttribute(): string
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }

        $birthDate = Carbon::parse($this->tanggal_lahir);
        $now       = Carbon::now();

        if ($birthDate->isFuture()) {
            return 'Belum lahir';
        }

        $years  = (int) $birthDate->diffInYears($now);
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
     * Total usia dalam bulan (berguna untuk grafik tumbuh kembang & standar WHO).
     */
    public function getUsiaBulanAttribute(): int
    {
        if (!$this->tanggal_lahir) {
            return 0;
        }
        return (int) Carbon::parse($this->tanggal_lahir)->diffInMonths(Carbon::now());
    }

    /**
     * Kategori usia anak berdasarkan rentang umur.
     * Referensi: WHO / Kemenkes RI.
     */
    public function getKategoriUsiaAttribute(): string
    {
        $bulan = $this->usia_bulan;

        if ($bulan < 1)   return 'Neonatus (0-28 hari)';
        if ($bulan < 12)  return 'Bayi (< 1 tahun)';
        if ($bulan < 36)  return 'Batita (1-3 tahun)';
        if ($bulan < 72)  return 'Balita (3-6 tahun)';
        if ($bulan < 144) return 'Anak (6-12 tahun)';
        return 'Remaja (> 12 tahun)';
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
