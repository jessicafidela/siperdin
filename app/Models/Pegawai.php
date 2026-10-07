<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'satker_id',
        'nip',
        'nama_pegawai',
        'jabatan',
        'golongan',
    ];

    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }
}
