<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    //

    public function karya()
    {
        return $this->hasMany(KaryaGuru::class);
    }

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}
