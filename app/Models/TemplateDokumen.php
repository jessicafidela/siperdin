<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateDokumen extends Model
{
    protected $table = 'template_dokumen';

    protected $primaryKey = 'id_template';

    protected $fillable = [
        'nama_template',
        'jenis_dokumen',
        'format_file',
        'struktur_dokumen',
        'aturan_penomoran',
        'lokasi_template',
    ];
}
