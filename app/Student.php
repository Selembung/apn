<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'nis';
    public $incrementing  = false;

    protected $fillable = [
        'nis',
        'user_id',
        'kode_tahun_akademik',
        'nama',
        'email',
        'kode_jurusan',
        'semester_aktif',
        'alamat'
    ];
}
