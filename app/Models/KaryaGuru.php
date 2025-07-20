<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KaryaGuru extends Model
{
    //

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
