<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AdminActivityLog extends Model
{
    use HasFactory;

    protected $table = 'admin_activity_logs';

    protected $fillable = [
        'user_id',
        'actor_name',
        'actor_email',
        'actor_role',
        'action',
        'description',
        'target_user_id',
        'target_name',
        'target_email',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke pelaku aktivitas.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke user target yang terkena aktivitas.
     */
    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    /**
     * Helper cepat untuk mencatat log aktivitas admin & audit trail.
     * PBI-030 (AC 1): Log mencatat penambahan akun dan perubahan hak akses beserta waktu dan pelakunya.
     */
    public static function record(
        string $action,
        string $description,
        ?User $targetUser = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?User $actor = null
    ): self {
        $actor = $actor ?? Auth::user();

        return static::create([
            'user_id' => $actor?->id,
            'actor_name' => $actor?->name ?? 'Super Administrator (Sistem)',
            'actor_email' => $actor?->email ?? 'admin@nutrigrow.id',
            'actor_role' => $actor?->role ?? 'superadmin',
            'action' => strtoupper($action),
            'description' => $description,
            'target_user_id' => $targetUser?->id,
            'target_name' => $targetUser?->name,
            'target_email' => $targetUser?->email,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip() ?? '127.0.0.1',
            'user_agent' => request()->userAgent() ?? 'NutriGrow System Client',
        ]);
    }

    /**
     * Badge visual status / tipe aksi untuk frontend.
     */
    public function getActionBadgeAttribute(): array
    {
        return match ($this->action) {
            'TAMBAH_AKUN' => [
                'label' => 'Tambah Akun',
                'bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'dot' => 'bg-emerald-500',
                'icon' => 'user-plus',
            ],
            'UBAH_HAK_AKSES' => [
                'label' => 'Ubah Hak Akses',
                'bg' => 'bg-sky-50 text-sky-700 border-sky-200',
                'dot' => 'bg-sky-500',
                'icon' => 'shield-check',
            ],
            'TOGGLE_STATUS' => [
                'label' => 'Ubah Status',
                'bg' => 'bg-amber-50 text-amber-700 border-amber-200',
                'dot' => 'bg-amber-500',
                'icon' => 'toggle-right',
            ],
            'LOGIN_ADMIN' => [
                'label' => 'Login Super Admin',
                'bg' => 'bg-blue-50 text-blue-700 border-blue-200',
                'dot' => 'bg-blue-500',
                'icon' => 'login',
            ],
            default => [
                'label' => $this->action,
                'bg' => 'bg-gray-50 text-gray-700 border-gray-200',
                'dot' => 'bg-gray-500',
                'icon' => 'activity',
            ],
        };
    }
}
