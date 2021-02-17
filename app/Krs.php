<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $fillable = [
        'user_id',
        'guru_id',
        'kode_mp',
        'kode_tahun_akademik',
        'semester',
    ];
}
