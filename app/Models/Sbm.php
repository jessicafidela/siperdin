<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sbm extends Model
{
    protected $fillable = [
        'kode_sbm',
        'kategori',
        'nama_biaya',
        'satuan',
        'nilai',
        'jenis_batas',
        'tahun_anggaran',
        'status',
    ];
}
