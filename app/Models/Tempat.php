<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    protected $table = 'tempat';

    protected $primaryKey = 'id_tempat';

    public $timestamps = false;

    protected $fillable = [
        'nama_tempat',
        'jenis_tempat',
        'wilayah',
        'keterangan',
        'status',
    ];
}
