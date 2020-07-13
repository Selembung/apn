<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey = 'kode_mp';
    public $incrementing  = false;

    protected $fillable = [
        'kode_mp',
        'nama_mp',
        'jumlah_sks'
    ];
}
