<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        $nis = NULL;

        if ($this->student) {
            $student = $this->student->nis;
            $nis     = $student . ",nis";
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $nis                 = 'required|min:2|unique:students,nis,' . $nis;
            $nama                = 'required|min:5';
            $email               = 'required|email';
            $kode_tahun_akademik = 'required';
            $semester_aktif      = 'required';
            // $password = 'sometimes|nullable|min:5';
            $jurusan             = 'required';
            $alamat              = 'required|min:5';
        } else {
            $nis                 = 'required|min:2|unique:students';
            $nama                = 'required|min:5';
            $email               = 'required|email|unique:students';
            $kode_tahun_akademik = 'required';
            $semester_aktif      = 'required';
            // $password = 'required|min:5';
            $jurusan             = 'required';
            $alamat              = 'required|min:5';
        }

        return [
            'nis'                 => $nis,
            'nama'                => $nama,
            'email'               => $email,
            'kode_tahun_akademik' => $kode_tahun_akademik,
            'semester_aktif'      => $semester_aktif,
            // 'password'     => $password,
            'alamat'              => $alamat,
            'kode_jurusan'        => $jurusan,
        ];
    }
}
