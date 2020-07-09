<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MajorRequest extends FormRequest
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
        $kode_jurusan = NULL;

        if ($this->major) {
            $major        = $this->major->kode_jurusan;
            $kode_jurusan = $major . ",kode_jurusan";
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $kode_jurusan = 'required|min:2|unique:majors,kode_jurusan,' . $kode_jurusan;
            $nama_jurusan = 'required|min:5';
        } else {
            $kode_jurusan = 'required|min:2|unique:majors';
            $nama_jurusan = 'required|min:5';
        }

        return [
            'kode_jurusan' => $kode_jurusan,
            'nama_jurusan' => $nama_jurusan,

        ];
    }
}
