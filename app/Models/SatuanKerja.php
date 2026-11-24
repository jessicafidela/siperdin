<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatuanKerja extends Model
{
    protected $table = 'satuan_kerja';

    protected $primaryKey = 'id_satker';

    protected $fillable = [
        'kode_satker',
        'nama_satker',
        'keterangan',
        'status',
    ];

    public function pegawai()
    {
        return $this->hasMany(
            Pegawai::class,
            'id_satker',
            'id_satker'
        );
    }
}
