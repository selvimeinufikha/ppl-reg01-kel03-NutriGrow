<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTumbuhKembang extends Model
{
    use HasFactory;

    protected $table = 'riwayat_tumbuh_kembang';

    protected $fillable = [
        'anak_id',
        'tanggal_pemeriksaan',
        'usia_bulan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan_atas',
        'z_score_bb_u',
        'z_score_tb_u',
        'z_score_bb_tb',
        'status_pertumbuhan',
        'status_type',
        'catatan_klinis',
        'nama_nakes',
        'faskes_pemeriksa',
        'kpsp_status',
        'imunisasi',
        'vitamin_a',
        'obat_cacing',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'berat_badan' => 'float',
        'tinggi_badan' => 'float',
        'lingkar_kepala' => 'float',
        'lingkar_lengan_atas' => 'float',
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'anak_id');
    }
}
