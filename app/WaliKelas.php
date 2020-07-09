<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'homeroom_teachers';

    protected $fillable = ['kode_rombel', 'kode_guru'];
}
