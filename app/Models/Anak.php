<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'anaks';

    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'status_gizi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riwayatTumbuhKembang()
    {
        return $this->hasMany(RiwayatTumbuhKembang::class, 'anak_id')->orderBy('tanggal_pemeriksaan', 'desc');
    }
}
