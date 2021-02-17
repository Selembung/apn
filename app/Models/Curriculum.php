<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculums';

    protected $fillable = ['kode_jurusan', 'kode_mp', 'semester'];

    public function pelajaran()
    {
        return $this->belongsTo(\App\Models\Course::class, 'kode_mp');
    }
}
