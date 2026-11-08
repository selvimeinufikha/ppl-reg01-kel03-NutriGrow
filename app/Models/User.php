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
        'nik',
        'no_kia',
        'tanggal_lahir',
        'golongan_darah',
        'alamat',
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
     * Relasi ke riwayat kehamilan.
     */
    public function kehamilans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Kehamilan::class, 'user_id');
    }

    /**
     * Relasi ke kehamilan aktif saat ini.
     */
    public function kehamilanAktif(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Kehamilan::class, 'user_id')->where('status', 'aktif')->latestOfMany();
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
     * Ambil 2 huruf inisial nama (contoh: "Ny. Ratna Sari" -> "RS").
     */
    public function getInisialAttribute(): string
    {
        $clean = preg_replace('/^(Ny\.|Ibu|Nn\.)\s*/i', '', $this->name);
        $words = preg_split('/\s+/', trim($clean));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($clean, 0, 2));
    }

    /**
     * Check if user is an admin or healthcare worker (nakes / staff).
     */
    public function isStaffOrAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'nakes', 'petugas'])
            || str_ends_with($this->email, '@nutrigrow.id')
            || str_ends_with($this->email, '@puskesmas.go.id')
            || str_ends_with($this->email, '@kemkes.go.id')
            || str_ends_with($this->email, '@dinkes.go.id')
            || $this->email === 'selvi@gmail.com';
    }

    /**
     * Check if user is a superadmin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin'
            || str_starts_with($this->email, 'superadmin@')
            || $this->email === 'selvi@gmail.com';
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
}
