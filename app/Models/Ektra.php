<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ektra extends Model
{

    protected $fillable = [
        'judul_ektra',
        'isi_ektra',
        'pembina',
        'hari',
        'gambar_ektra',
    ];

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

}
