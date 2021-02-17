<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseHour extends Model
{
    protected $primaryKey = 'id_jam';

    protected $fillable = [
        'jam_masuk',
        'jam_keluar',
    ];
}
