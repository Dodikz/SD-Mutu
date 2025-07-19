<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KaryaGuru extends Model
{
    //

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
