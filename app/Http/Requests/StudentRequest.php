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
        $nisn = NULL;

        if ($this->student) {
            $student      = $this->student->nis;
            $student_nisn = $this->student->nisn;
            $nis  = $student . ",nis";
            $nisn = $student . ",nisn";
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $nis                 = 'required|min:2|unique:students,nis,' . $nis;
            $nama                = 'required|min:5|String';
            $nisn                = 'required|numeric|digits:10|unique:students,nisn,' . $nisn;
            $tempat_lahir        = 'required|String';
            $tanggal_lahir       = 'required|date';
            $jenis_kelamin       = 'required';
            $agama               = 'required';
            $email               = 'required|email';
            $kode_tahun_akademik = 'required';
            $semester_aktif      = 'required';
            $jurusan             = 'required';
            $alamat              = 'required|min:5|String';
        } else {
            $nis                 = 'required|min:2|unique:students';
            $nisn                = 'required|digits:10|numeric|unique:students';
            $tempat_lahir        = 'required|String';
            $tanggal_lahir       = 'required|date';
            $jenis_kelamin       = 'required';
            $agama               = 'required';
            $nama                = 'required|min:5|String';
            $email               = 'required|email|unique:students';
            $kode_tahun_akademik = 'required';
            $semester_aktif      = 'required';
            $jurusan             = 'required';
            $alamat              = 'required|min:5|String';
        }

        return [
            'nis'                 => $nis,
            'nama'                => $nama,
            'nisn'                => $nisn,
            'tempat_lahir'        => $tempat_lahir,
            'tanggal_lahir'       => $tanggal_lahir,
            'jenis_kelamin'       => $jenis_kelamin,
            'agama'               => $agama,
            'email'               => $email,
            'kode_tahun_akademik' => $kode_tahun_akademik,
            'semester_aktif'      => $semester_aktif,
            'alamat'              => $alamat,
            'kode_jurusan'        => $jurusan,
        ];
    }
}
