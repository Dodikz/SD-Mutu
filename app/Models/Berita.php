<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_berita',
        'slug',
        'isi_berita',
        'gambar_berita',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
