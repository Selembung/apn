<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $primaryKey = 'kode_jurusan';
    public $incrementing  = false;

    protected $fillable = ['kode_jurusan', 'nama_jurusan'];
}
