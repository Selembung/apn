<?php

namespace App\Http\Requests;

use App\CourseHour;

use Illuminate\Foundation\Http\FormRequest;

class CourseHourRequest extends FormRequest
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
        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $jam_masuk  = 'required|min:5';
            $jam_keluar = 'required|min:5';
        } else {
            $jam_masuk  = 'required|min:5';
            $jam_keluar = 'required|min:5';
        }

        return [
            'jam_masuk'  => $jam_masuk,
            'jam_keluar' => $jam_keluar,
        ];
    }
}
