<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $primaryKey = 'kode_tahun_akademik';
    public $incrementing = false;

    protected $fillable = [
        'kode_tahun_akademik',
        'tahun_akademik',
        'tanggal_awal_sekolah',
        'tanggal_akhir_sekolah',
        'tanggal_awal_uts',
        'tanggal_akhir_uts',
        'tanggal_awal_uas',
        'tanggal_akhir_uas',
        'status',
    ];
}
