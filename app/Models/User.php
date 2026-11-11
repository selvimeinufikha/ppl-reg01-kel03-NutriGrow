<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telepon',
        'alamat',
        'kota',
        'kecamatan',
        'kelurahan',
        'nik',
        'tanggal_lahir',
        'foto_profil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke data Pasangan (Suami / Calon Ayah).
     */
    public function pasangan()
    {
        return $this->hasOne(Pasangan::class, 'user_id');
    }

    /**
     * Relasi ke seluruh riwayat Kehamilan pengguna.
     */
    public function kehamilans()
    {
        return $this->hasMany(Kehamilan::class, 'user_id')->orderBy('kehamilan_ke', 'desc');
    }

    /**
     * Relasi ke kehamilan aktif yang sedang berlangsung.
     */
    public function kehamilanAktif()
    {
        return $this->hasOne(Kehamilan::class, 'user_id')->where('status', 'berlangsung')->latestOfMany();
    }

    /**
     * Rekomendasi fasilitas kesehatan berdasarkan acuan alamat profil pengguna (Acceptance Criteria).
     */
    public function getRekomendasiFaskesAttribute(): array
    {
        return \App\Services\HealthFacilityRecommendationService::getRekomendasi(
            $this->alamat,
            $this->kota,
            $this->kecamatan
        );
    }

    /**
     * URL Foto Profil pengguna (terhubung dengan akun) atau null jika belum ada.
     */
    public function getFotoProfilUrlAttribute(): ?string
    {
        if ($this->foto_profil) {
            if (str_starts_with($this->foto_profil, 'http')) {
                return $this->foto_profil;
            }
            return asset('storage/' . $this->foto_profil);
        }

        return null;
    }
}
