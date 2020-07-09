<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
        $nig = NULL;

        if ($this->teacher) {
            $teacher = $this->teacher->nig;
            $nig     = $teacher . ",nig";
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $nig        = 'required|min:5|unique:teachers,nig,' . $nig;
            $kode_guru  = 'required|min:3';
            $nama       = 'required|min:3';
            $no_telepon = 'required|min:10|max:12';
            $email      = 'required';
        } else {
            $nig        = 'required|min:5|unique:teachers';
            $kode_guru  = 'required|min:3';
            $nama       = 'required|min:3';
            $no_telepon = 'required|min:10|max:12';
            $email      = 'required';
        }

        return [
            'nig'        => $nig,
            'kode_guru'  => $kode_guru,
            'nama'       => $nama,
            'no_telepon' => $no_telepon,
            'email'      => $email,
        ];
    }
}
