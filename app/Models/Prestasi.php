<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = [
        'jenis_prestasi',
        'nama_prestasi',
        'keterangan_prestasi',
        'penyelenggara',
        'peringkat',
        'bidang',
        'gambar_prestasi',
    ];
}
