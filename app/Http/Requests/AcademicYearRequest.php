<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicYearRequest extends FormRequest
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
        $kode_tahun_akademik = NULL;

        if ($this->academic_year) {
            $academicYear        = $this->academic_year->kode_tahun_akademik;
            $kode_tahun_akademik = $academicYear . ",kode_tahun_akademik";
        }

        // Cek apakah CREATE atau UPDATE
        if ($this->method() == 'PATCH') {
            $kode_tahun_akademik   = 'required|min:5|unique:academic_years,kode_tahun_akademik,' . $kode_tahun_akademik;
            $tahun_akademik        = 'required|min:5';
            $tanggal_awal_sekolah  = '';
            $tanggal_akhir_sekolah = '';
            $tanggal_awal_uts      = '';
            $tanggal_akhir_uts     = '';
            $tanggal_awal_uas      = '';
            $tanggal_akhir_uas     = '';
            $status                = '';
        } else {
            $kode_tahun_akademik   = 'required|min:5|unique:academic_years';
            $tahun_akademik        = 'required|min:5';
            $tanggal_awal_sekolah  = '';
            $tanggal_akhir_sekolah = '';
            $tanggal_awal_uts      = '';
            $tanggal_akhir_uts     = '';
            $tanggal_awal_uas      = '';
            $tanggal_akhir_uas     = '';
            $status                = '';
        }

        return [
            'kode_tahun_akademik'   => $kode_tahun_akademik,
            'tahun_akademik'        => $tahun_akademik,
            'tanggal_awal_sekolah'  => $tanggal_awal_sekolah,
            'tanggal_akhir_sekolah' => $tanggal_akhir_sekolah,
            'tanggal_awal_uts'      => $tanggal_awal_uts,
            'tanggal_akhir_uts'     => $tanggal_akhir_uts,
            'tanggal_awal_uas'      => $tanggal_awal_uas,
            'tanggal_akhir_uas'     => $tanggal_akhir_uas,
            'status'                => $status,
        ];
    }
}
