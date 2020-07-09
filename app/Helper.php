<?php

function get_tahun_akademik($field)
{
    $academic_year = \DB::table('academic_years')
        ->where('status', 'Aktif')
        ->first();
    return $academic_year->$field;
}
