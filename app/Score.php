<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'kode_tahun_akademik',
        'kode_mp',
        'user_id',
        'guru_id',
        'nilai_harian',
        'nilai_praktek',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'grade',
        'nilai_sikap',
    ];
}
