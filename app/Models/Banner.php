<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'judul_banner',
        'gambar_banner',
        'deskripsi_banner',
        'link_banner',
    ];

    
}
