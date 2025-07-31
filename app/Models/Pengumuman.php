<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = [
        'nama_pengumumen',
        'file_pengumumen',
    ];
}
