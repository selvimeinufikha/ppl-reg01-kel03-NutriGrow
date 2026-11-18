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
     * Check if user is an admin or healthcare worker (nakes / staff).
     */
    public function isStaffOrAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'nakes', 'petugas', 'dokter', 'bidan', 'ahli_gizi'])
            || str_ends_with($this->email, '@nutrigrow.id')
            || str_ends_with($this->email, '@puskesmas.go.id')
            || str_ends_with($this->email, '@kemkes.go.id')
            || str_ends_with($this->email, '@dinkes.go.id');
    }

    /**
     * Check if user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
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
     * Inisial nama untuk avatar.
     */
    public function getInisialAttribute(): string
    {
        $cleanName = preg_replace('/^(dr\.|drg\.|prof\.|dr\s+|drg\s+|prof\s+|bidan\s+|ibu\s+|bapak\s+)/i', '', trim($this->name));
        $words = preg_split('/\s+/', trim($cleanName));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $initials .= mb_strtoupper(mb_substr($w, 0, 1));
        }

        return $initials ?: 'A';
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin'
            || str_starts_with($this->email, 'admin@');
    }

    /**
     * Check if user is a healthcare worker (nakes).
     */
    public function isNakes(): bool
    {
        return in_array($this->role, ['nakes', 'petugas', 'admin']);
    }

    /**
     * Relasi ke data Pasangan milik pengguna ini.
     */
    public function pasangans()
    {
        return $this->hasMany(Pasangan::class);
    }
}
