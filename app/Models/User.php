<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'id_pegawai',
        'username',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function isActive(): bool
    {
        return strtolower((string) $this->status) === 'aktif';
    }

    /** Return the authenticated user's satker through the linked employee record. */
    public function satkerId(): ?int
    {
        $this->loadMissing('pegawai');

        $satkerId = $this->pegawai?->id_satker;

        return $satkerId === null ? null : (int) $satkerId;
    }

    /**
     * Check row-level access to a satker-scoped travel record.
     * Superadmin is global; Operator Satker and Admin Keuangan are restricted
     * to the satker linked to their own employee record.
     */
    public function canAccessSatker(int|string $satkerId): bool
    {
        if ($this->can('travel.monitor.all')) {
            return true;
        }

        if (! $this->can('travel.monitor.satker')) {
            return false;
        }

        $ownSatkerId = $this->satkerId();

        return $ownSatkerId !== null && $ownSatkerId === (int) $satkerId;
    }
}
