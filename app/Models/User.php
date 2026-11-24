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
        'role',
        'faskes_name',
        'nip_str',
        'phone',
        'status',
        'jabatan',
        'no_telepon',
        'alamat',
        'kota',
        'kecamatan',
        'kelurahan',
        'nik',
        'no_kia',
        'tanggal_lahir',
        'golongan_darah',
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
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Relasi ke seluruh riwayat Kehamilan pengguna.
     */
    public function kehamilans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Kehamilan::class, 'user_id')->orderBy('kehamilan_ke', 'desc');
    }

    /**
     * Relasi ke kehamilan aktif yang sedang berlangsung.
     */
    public function kehamilanAktif(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Kehamilan::class, 'user_id')->where('status', 'berlangsung')->latestOfMany();
    }

    /**
     * Relasi ke rekam pemeriksaan kehamilan (ANC).
     */
    public function pemeriksaanKehamilans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PemeriksaanKehamilan::class, 'user_id')->orderBy('tgl_periksa', 'desc');
    }

    /**
     * Hitung usia ibu dalam tahun.
     */
    public function getUsiaTahunAttribute(): ?int
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        return (int) \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }

    /**
     * Inisial nama untuk avatar.
     */
    public function getInisialAttribute(): string
    {
        $cleanName = preg_replace('/^(dr\.|drg\.|prof\.|dr\s+|drg\s+|prof\s+|bidan\s+|ibu\s+|bapak\s+|ny\.|nn\.)/i', '', trim($this->name));
        $words = preg_split('/\s+/', trim($cleanName));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $initials .= mb_strtoupper(mb_substr($w, 0, 1));
        }

        return $initials ?: 'A';
    }

    /**
     * Check if user is an admin or healthcare worker (nakes / staff).
     */
    public function isStaffOrAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'nakes', 'petugas', 'dokter', 'bidan', 'ahli_gizi'])
            || str_ends_with($this->email, '@nutrigrow.id')
            || str_ends_with($this->email, '@puskesmas.go.id')
            || str_ends_with($this->email, '@kemkes.go.id')
            || str_ends_with($this->email, '@dinkes.go.id')
            || $this->email === 'selvi@gmail.com';
    }

    /**
     * Check if user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin'
            || str_starts_with($this->email, 'superadmin@')
            || $this->email === 'selvi@gmail.com';
    }

    /**
     * Label peran admin yang ramah dibaca.
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'superadmin' => 'Super Administrator (Kemenkes/Dinkes)',
            'admin' => 'Administrator Faskes / Puskesmas',
            'nakes' => 'Tenaga Kesehatan (Bidan / Dokter)',
            'dokter' => 'Dokter Spesialis Anak / Umum',
            'bidan' => 'Bidan Koordinator',
            'ahli_gizi' => 'Nutrisionis / Ahli Gizi',
            default => 'Pengguna Keluarga / Orang Tua',
        };
    }

    /**
     * Check if user is an admin or superadmin.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin'])
            || str_starts_with($this->email, 'admin@')
            || str_starts_with($this->email, 'superadmin@')
            || $this->email === 'selvi@gmail.com';
    }

    /**
     * Check if user is a healthcare worker (nakes).
     */
    public function isNakes(): bool
    {
        return in_array($this->role, ['nakes', 'petugas', 'admin']);
    }

    /**
     * Relasi ke data Pasangan milik pengguna ini (hasMany).
     */
    public function pasangans()
    {
        return $this->hasMany(Pasangan::class);
    }

    /**
     * Relasi ke data Pasangan (hasOne).
     */
    public function pasangan()
    {
        return $this->hasOne(Pasangan::class, 'user_id');
    }

    /**
     * Rekomendasi fasilitas kesehatan berdasarkan acuan alamat profil pengguna.
     */
    public function getRekomendasiFaskesAttribute(): array
    {
        if (class_exists(\App\Services\HealthFacilityRecommendationService::class)) {
            return \App\Services\HealthFacilityRecommendationService::getRekomendasi(
                $this->alamat,
                $this->kota,
                $this->kecamatan
            );
        }
        return [];
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

    /**
     * Data anak / balita yang terhubung dengan akun pengguna / orang tua ini.
     */
    public function anaks()
    {
        return $this->hasMany(Anak::class, 'user_id');
    }
}
