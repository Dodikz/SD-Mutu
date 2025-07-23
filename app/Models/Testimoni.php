<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $fillable = [
        'isi_testimoni',
        'penulis',
        'status',
    ];

}
