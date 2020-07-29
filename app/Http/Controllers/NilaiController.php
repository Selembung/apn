<?php

namespace App\Http\Controllers;

use DB;
use App\Khs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fpdf;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['siswa'] = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('teachers.guru_id', Auth::user()->id)
            ->where('status', 'Aktif')
            ->select('students.nama AS nama_siswa', 'students.nis', 'khs.*', 'courses.kode_mp', 'courses.nama_mp')
            ->groupBy('nis')
            ->orderBy('nis', 'asc')
            ->get();

        // SELECT *, students.nama as nama_siswa FROM `khs`JOIN students ON students.user_id = khs.user_id JOIN homeroom_teachers on homeroom_teachers.kode_rombel = students.kode_rombel JOIN teachers ON teachers.kode_guru = homeroom_teachers.kode_guru JOIN courses on courses.kode_mp = khs.kode_mp WHERE teachers.guru_id = 4

        return view('nilai.index', $data);
    }

    public function KHSpdf()
    {
        $data = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('teachers.guru_id', Auth::user()->id)
            ->where('status', 'aktif')
            ->select('students.nama AS nama_siswa', 'students.nis', 'khs.*', 'courses.kode_mp', 'courses.nama_mp')
            ->get();

        Fpdf::AddPage();
        Fpdf::SetFont('Times', 'B', 12);

        Fpdf::Cell(7, 7, 'No', 1, 0);
        Fpdf::Cell(50, 7, 'Nama', 1, 0);
        Fpdf::Cell(70, 7, 'Mata Pelajaran', 1, 0);
        Fpdf::Cell(15, 7, 'P', 1, 0);
        Fpdf::Cell(15, 7, 'K', 1, 0);
        Fpdf::Cell(15, 7, 'S', 1, 1);
        Fpdf::SetFont('Times', '', 12);
        $no = 1;

        foreach ($data as $row) {
            Fpdf::Cell(7, 7, $no, 1, 0);
            Fpdf::Cell(50, 7, $row->nama_siswa, 1, 0);
            Fpdf::Cell(70, 7, $row->nama_mp, 1, 0);
            Fpdf::Cell(15, 7, $row->nilai_akhir, 1, 0);
            Fpdf::Cell(15, 7, $row->nilai_praktek, 1, 0);
            Fpdf::Cell(15, 7, $row->nilai_sikap, 1, 1);
            $no++;
        }

        Fpdf::Output();
        exit();
    }

    public function KHSpdfSiswa($nis)
    {
        $khs = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('status', 'aktif')
            ->where('nis', $nis)
            ->select('students.nama AS nama_siswa', 'students.nis', 'khs.*', 'courses.kode_mp', 'courses.nama_mp')
            ->get();

        Fpdf::AddPage();
        Fpdf::SetFont('Times', 'B', 12);

        Fpdf::Cell(30, 7, 'NIS', 0, 0);
        Fpdf::Cell(10, 7, ': ' . $khs[0]->nis, 0, 1);
        Fpdf::Cell(30, 7, 'Nama', 0, 0);
        Fpdf::Cell(10, 7, ': '  . $khs[0]->nama_siswa, 0, 1);
        Fpdf::SetFont('Times', 'B', 12);

        Fpdf::Cell(10, 5, '', 0, 1);

        Fpdf::Cell(10, 21, 'No', 1, 0, 'C');
        Fpdf::Cell(70, 21, 'Mata Pelajaran', 1, 0, 'C');
        Fpdf::Cell(15, 21, 'Nilai', 1, 0, 'C');
        Fpdf::Cell(47.5, 21, 'Kompetensi', 1, 0, 'C');
        Fpdf::Cell(47.5, 21, 'Catatan', 1, 1, 'C');
        Fpdf::SetFont('Times', '', 12);
        $no = 1;

        foreach ($khs as $row) {
            Fpdf::Cell(10, 15, $no . '.', 1, 0, 'C');
            if ($row->nama_mp == 'Agama' or $row->nama_mp == 'Pendidikan Kewarganegaraan') {
                Fpdf::Cell(70, 15, $row->nama_mp, 1, 0);
                Fpdf::Cell(15, 5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(47.5, 5, 'Pengetahuan', 1, 0);

                if ($row->nilai_akhir >= 88 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(47.5, 5, 'Sangat Baik', 1, 0);
                } else if ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 87) {
                    Fpdf::Cell(47.5, 5, 'Baik', 1, 0);
                } else if ($row->nilai_akhir >= 75) {
                    Fpdf::Cell(47.5, 5, 'Cukup Baik', 1, 0);
                } else {
                    Fpdf::Cell(47.5, 5, 'Kurang Baik', 1, 0);
                }
                Fpdf::Cell(0, 5, '', 1, 1);


                Fpdf::Cell(80, 5, '', 0, 0);
                Fpdf::Cell(15, 5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(47.5, 5, 'Keterampilan', 1, 0);

                if ($row->nilai_praktek >= 88 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(47.5, 5, 'Sangat Baik', 1, 1);
                } else if ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 87) {
                    Fpdf::Cell(47.5, 5, 'Baik', 1, 1);
                } else if ($row->nilai_praktek >= 75) {
                    Fpdf::Cell(47.5, 5, 'Cukup Baik', 1, 1);
                } else {
                    Fpdf::Cell(47.5, 5, 'Kurang Baik', 1, 1);
                }

                Fpdf::Cell(80, 5, '', 0, 0);
                Fpdf::Cell(15, 5, $row->nilai_sikap, 1, 0, 'C');
                Fpdf::Cell(47.5, 5, 'Sosial & Spiritual', 1, 0);

                if ($row->nilai_sikap == 'A') {
                    Fpdf::Cell(47.5, 5, 'Sangat Baik', 1, 1);
                } else if ($row->nilai_sikap == 'B') {
                    Fpdf::Cell(47.5, 5, 'Baik', 1, 1);
                } else if ($row->nilai_sikap == 'C') {
                    Fpdf::Cell(47.5, 5, 'Cukup Baik', 1, 1);
                } else {
                    Fpdf::Cell(47.5, 5, 'Kurang Baik', 1, 1);
                }
            } else {
                Fpdf::Cell(70, 15, $row->nama_mp, 1, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(47.5, 7.5, 'Pengetahuan', 1, 0);

                if ($row->nilai_akhir >= 88 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(47.5, 7.5, 'Sangat Baik', 1, 0);
                } else if ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 87) {
                    Fpdf::Cell(47.5, 7.5, 'Baik', 1, 0);
                } else if ($row->nilai_akhir >= 75) {
                    Fpdf::Cell(47.5, 7.5, 'Cukup Baik', 1, 0);
                } else {
                    Fpdf::Cell(47.5, 7.5, 'Kurang Baik', 1, 0);
                }
                Fpdf::Cell(0, 7.5, '', 1, 1);


                Fpdf::Cell(80, 7.5, '', 0, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(47.5, 7.5, 'Keterampilan', 1, 0);

                if ($row->nilai_praktek >= 88 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(47.5, 7.5, 'Sangat Baik', 1, 1);
                } else if ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 87) {
                    Fpdf::Cell(47.5, 7.5, 'Baik', 1, 1);
                } else if ($row->nilai_praktek >= 75) {
                    Fpdf::Cell(47.5, 7.5, 'Cukup Baik', 1, 1);
                } else {
                    Fpdf::Cell(47.5, 7.5, 'Kurang Baik', 1, 1);
                }
            }

            $no++;
        }

        Fpdf::Output($khs[0]->nis . ' - ' . $khs[0]->nama_siswa . ".pdf", 'D');
        exit();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nis)
    {
        $data['student'] = \DB::table('students')->get();

        $data['siswa'] = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('nis', $nis)
            ->where('status', 'Aktif')
            ->select('students.nama AS nama_siswa', 'students.nis', 'khs.*', 'homeroom_teachers.*', 'teachers.*', 'courses.*')
            ->get();

        return view('nilai.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
