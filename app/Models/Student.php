<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'nis';
    public $incrementing = false;

    protected $fillable = [
        'nis',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'user_id',
        'kode_tahun_akademik',
        'nama',
        'email',
        'kode_jurusan',
        'semester_aktif',
        'alamat',
    ];
}
