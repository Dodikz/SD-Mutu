<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KaryaGuru extends Model
{
    protected $fillable = [
        'nama_karya_guru',
        'slug',
        'foto_karya_guru',
        'isi_karya',
        'user_id',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
