<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PATCH') {
            $hari                = 'required';
            $kode_jurusan        = 'required';
            $kode_mp             = 'required';
            $kode_tahun_akademik = 'required';
            $user_id             = 'required';
            $kode_ruangan        = 'required';
            $jam                 = 'required';
            $semester            = 'required';
        } else {
            $hari                = 'required';
            $kode_jurusan        = 'required';
            $kode_mp             = 'required';
            $kode_tahun_akademik = 'required';
            $user_id             = 'required';
            $kode_ruangan        = 'required';
            $jam                 = 'required';
            $semester            = 'required';
        }

        return [
            'hari'                => $hari,
            'kode_jurusan'        => $kode_jurusan,
            'kode_mp'             => $kode_mp,
            'user_id'             => $user_id,
            'kode_ruangan'        => $kode_ruangan,
            'jam'                 => $jam,
            'semester'            => $semester,
            'kode_tahun_akademik' => $kode_tahun_akademik,
        ];
    }
}
