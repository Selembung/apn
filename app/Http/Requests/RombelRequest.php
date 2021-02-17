<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RombelRequest extends FormRequest
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
        $kode_rombel = null;

        if ($this->rombel) {
            $rombel = $this->rombel->kode_rombel;
            $kode_rombel = $rombel.',kode_rombel';
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $kode_rombel = 'required|min:3|unique:rombels,kode_rombel,'.$kode_rombel;
            $nama_rombel = 'required|min:5';
        } else {
            $kode_rombel = 'required|min:3|unique:rombels';
            $nama_rombel = 'required|min:5';
        }

        return [
            'kode_rombel'    => $kode_rombel,
            'nama_rombel'    => $nama_rombel,
        ];
    }
}
