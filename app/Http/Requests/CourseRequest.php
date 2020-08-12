<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
        $kode_mp = NULL;

        if ($this->course) {
            $course   = $this->course->kode_mp;
            $kode_mp  = $course . ",kode_mp";
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $kode_mp    = 'required|min:5|unique:courses,kode_mp,' . $kode_mp;
            $nama_mp    = 'required|min:3';
            $jumlah_sks = 'required';
        } else {
            $kode_mp    = 'required|min:5|unique:courses';
            $nama_mp    = 'required|min:3';
            $jumlah_sks = 'required';
        }

        return [
            'kode_mp'    => $kode_mp,
            'nama_mp'    => $nama_mp,
            'jumlah_sks' => $jumlah_sks,
        ];
    }
}
