<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasKesehatan extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_kesehatans';

    protected $fillable = [
        'nama_fasilitas',
        'kode_faskes',
        'jenis',
        'akreditasi',
        'alamat',
        'wilayah',
        'jam_layanan',
        'layanan_tambahan',
        'kontak',
        'pic',
        'latitude',
        'longitude',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Label representasi jenis faskes
     */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'puskesmas' => 'Puskesmas',
            'posyandu' => 'Posyandu',
            'klinik' => 'Klinik Pratama',
            'rumah_sakit' => 'Rumah Sakit',
            default => ucfirst($this->jenis),
        };
    }

    /**
     * Styling badge warna untuk jenis faskes
     */
    public function getJenisBadgeAttribute(): string
    {
        return match ($this->jenis) {
            'puskesmas' => 'bg-sky-50 text-sky-700 border border-sky-200/60',
            'posyandu' => 'bg-pink-50 text-pink-700 border border-pink-200/60',
            'klinik' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/60',
            'rumah_sakit' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/60',
            default => 'bg-slate-50 text-slate-700 border border-slate-200/60',
        };
    }

    /**
     * Dot color untuk jenis faskes
     */
    public function getJenisDotColorAttribute(): string
    {
        return match ($this->jenis) {
            'puskesmas' => 'bg-sky-500',
            'posyandu' => 'bg-pink-500',
            'klinik' => 'bg-cyan-500',
            'rumah_sakit' => 'bg-indigo-500',
            default => 'bg-slate-400',
        };
    }

    /**
     * Format koordinat latitude & longitude
     */
    public function getKoordinatFormattedAttribute(): string
    {
        $lat = number_format((float)$this->latitude, 4);
        $lng = number_format((float)$this->longitude, 4);
        return "{$lat}, {$lng}";
    }

    /**
     * Link Google Maps
     */
    public function getMapsUrlAttribute(): string
    {
        return "https://www.google.com/maps/search/?api=1&query={$this->latitude},{$this->longitude}";
    }
}
