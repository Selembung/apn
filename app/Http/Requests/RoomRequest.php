<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        $kode_ruangan = null;

        if ($this->room) {
            $room = $this->room->kode_ruangan;
            $kode_ruangan = $room.',kode_ruangan';
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $kode_ruangan = 'required|min:3|unique:rooms,kode_ruangan,'.$kode_ruangan;
            $nama_ruangan = 'required|min:5';
        } else {
            $kode_ruangan = 'required|min:3|unique:rooms';
            $nama_ruangan = 'required|min:5';
        }

        return [
            'kode_ruangan' => $kode_ruangan,
            'nama_ruangan' => $nama_ruangan,
        ];
    }
}
