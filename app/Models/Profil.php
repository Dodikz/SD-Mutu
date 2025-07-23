<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = [
        'kepala_sekolah',
        'foto_kepala_sekolah',
        'sambutan_kepala_sekolah',
        'sejarah',
        'visi',
        'misi',
        'akreditasi',
    ];
}
