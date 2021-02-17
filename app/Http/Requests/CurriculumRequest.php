<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
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
            $kode_jurusan = 'required';
            $kode_mp = 'required';
            $semester = 'required';
        } else {
            $kode_jurusan = 'required';
            $kode_mp = 'required';
            $semester = 'required';
        }

        return [
            'kode_jurusan' => $kode_jurusan,
            'kode_mp'      => $kode_mp,
            'semester'     => $semester,
        ];
    }
}
