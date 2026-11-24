<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandarBiayaMasukan extends Model
{
    protected $table = 'standar_biaya_masukan';

    protected $primaryKey = 'id_sbm';

    protected $fillable = [
        'tahun_berlaku',
        'jenis_biaya',
        'gol_ruang',
        'lokasi',
        'nilai_biaya',
        'keterangan',
    ];
}
