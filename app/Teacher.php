<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $primaryKey = 'nig';
    public $incrementing  = false;

    protected $fillable = [
        'nig',
        'guru_id',
        'kode_guru',
        'nama',
        'no_telepon',
        'email'
    ];
}
