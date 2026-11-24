<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformasiNutrisi extends Model
{
    use HasFactory;

    protected $table = 'informasi_nutrisis';

    protected $fillable = [
        'nama_bahan_menu',
        'kategori_fase',
        'kategori_kondisi',
        'kandungan_gizi',
        'saran_penggunaan',
        'foto',
        'deskripsi_manfaat',
        'created_by',
    ];

    /**
     * Daftar opsi standar Kategori Fase Kehidupan (Kemenkes & NutriGrow).
     */
    public const DAFTAR_FASE = [
        'Persiapan Kehamilan' => 'Fase 1: Persiapan Kehamilan (Prakonsepsi & Calon Ibu)',
        'Masa Kehamilan' => 'Fase 2: Masa Kehamilan (Trimester 1, 2, & 3)',
        'Ibu Menyusui' => 'Fase 3: Ibu Menyusui (Masa Laktasi / ASI Eksklusif)',
        'Tumbuh Kembang Anak' => 'Fase 4: Tumbuh Kembang Anak (MPASI & Balita 0-5 Tahun)',
    ];

    /**
     * Daftar opsi standar Kategori Kondisi / Edukasi.
     */
    public const DAFTAR_KONDISI = [
        'Makanan Bergizi' => 'Makanan Bergizi (Tinggi Protein/Zat Aktif)',
        'Zat Gizi' => 'Zat Gizi Mikro (Asam Folat, Kalsium, Zat Besi, DHA)',
        'Edukasi Gizi' => 'Edukasi Gizi & Panduan Porsi (Isi Piringku)',
        'Pencegahan Stunting' => 'Pencegahan Stunting & Gizi Buruk',
    ];

    /**
     * Relasi ke Admin pembuat konten.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Badge visual color helper berdasarkan fase.
     */
    public function getFaseBadgeColorAttribute(): string
    {
        return match($this->kategori_fase) {
            'Persiapan Kehamilan' => 'bg-amber-50 text-amber-700 border-amber-200',
            'Masa Kehamilan' => 'bg-rose-50 text-rose-700 border-rose-200',
            'Ibu Menyusui' => 'bg-sky-50 text-sky-700 border-sky-200',
            'Tumbuh Kembang Anak' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            default => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }
}
