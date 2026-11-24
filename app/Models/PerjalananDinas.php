<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PerjalananDinas extends Model
{
    protected $table = 'perjalanan_dinas';

    protected $primaryKey = 'id_perjalanan';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'id_satker',
        'created_by',
        'nomor_pengajuan',
        'tanggal_pengajuan',
        'kegiatan',
        'misi_perjalanan',
        'status_pengajuan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'date',
        ];
    }

    public function satuanKerja()
    {
        return $this->belongsTo(SatuanKerja::class, 'id_satker', 'id_satker');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    /**
     * Restrict list queries to the user's authorized satker scope.
     * Always use this scope for non-global travel lists.
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->can('travel.monitor.all')) {
            return $query;
        }

        if (! $user->can('travel.monitor.satker')) {
            return $query->whereRaw('1 = 0');
        }

        $satkerId = $user->satkerId();

        if ($satkerId === null) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('id_satker', $satkerId);
    }
}
