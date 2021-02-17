<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $primaryKey = 'kode_rombel';
    public $incrementing = false;

    protected $fillable = [
        'kode_rombel',
        'nama_rombel',
    ];
}
