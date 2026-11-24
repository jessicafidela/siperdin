<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'id_satker',
        'nip',
        'nip_baru',
        'nama_lengkap',
        'pangkat',
        'gol_ruang',
        'tipe_jabatan',
        'tampil_jabatan',
        'keterangan',
    ];

    public function satuanKerja()
    {
        return $this->belongsTo(
            SatuanKerja::class,
            'id_satker',
            'id_satker'
        );
    }

    public function user()
    {
        return $this->hasOne(
            User::class,
            'id_pegawai'
        );
    }
}
