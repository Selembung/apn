<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeroomTeacherRequest extends FormRequest
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
        $kode_rombel = NULL;

        if ($this->homeroom_teacher) {
            $rombel       = $this->homeroom_teacher->kode_rombel;
            $kode_rombel  = $rombel . ",kode_rombel";
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $kode_rombel = 'required|min:5|unique:homeroom_teachers,kode_rombel,' .  $kode_rombel;
            $kode_guru   = 'required|min:5|unique:homeroom_teachers,kode_guru,';
        } else {
            $kode_rombel = 'required|min:5|unique:homeroom_teachers';
            $kode_guru   = 'required|min:5|unique:homeroom_teachers';
        }

        return [
            'kode_rombel' => $kode_rombel,
            'kode_guru'   => $kode_guru,
        ];
    }
}
