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
        return in_array($this->role, ['admin', 'nakes', 'petugas'])
            || str_ends_with($this->email, '@nutrigrow.id')
            || str_ends_with($this->email, '@puskesmas.go.id')
            || str_ends_with($this->email, '@kemkes.go.id')
            || str_ends_with($this->email, '@dinkes.go.id');
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
     * Data anak / balita yang terhubung dengan akun pengguna / orang tua ini.
     */
    public function anaks()
    {
        return $this->hasMany(Anak::class, 'user_id');
    }
}
