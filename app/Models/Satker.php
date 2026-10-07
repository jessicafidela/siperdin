<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    protected $fillable = [
        'kode_satker',
        'nama_satker',
    ];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
