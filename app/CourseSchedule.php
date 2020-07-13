<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    protected $fillable = [
        'hari',
        'kode_jurusan',
        'kode_mp',
        'user_id',
        'kode_ruangan',
        'jam',
        'semester',
        'kode_tahun_akademik'
    ];
}
