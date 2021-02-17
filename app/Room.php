<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'kode_ruangan';
    public $incrementing = false;

    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
    ];
}
