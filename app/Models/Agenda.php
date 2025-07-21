<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'judul_agenda',
        'lokasi_agenda',
        'jam_mulai_agenda',
        'jam_selesai_agenda',
        'tanggal_agenda',
    ];
}