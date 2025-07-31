<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarSarana extends Model
{
protected $fillable = [
    'sarana_id',
    'gambar',
    'judul',
];

public function sarana()
{
    return $this->belongsTo(Sarana::class);
}

}
