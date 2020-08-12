<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Khs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use Fpdf;


class KhsController extends Controller
{
    public function ajax()
    {
        $user_id = Auth::user()->id;
        \DB::table('khs')
            // ->join('teachers', 'teachers.guru_id', '=', 'khs.guru_id')  
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->where('khs.user_id', $user_id)
            ->get();

        return view('khs.ajax');
    }

    public function datatable()
    {
        $user_id = Auth::user()->id;
        $khs = \DB::table('khs')
            // ->join('teachers', 'teachers.guru_id', '=', 'khs.guru_id')  
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->where('khs.user_id', $user_id)
            ->get();

        return DataTables::of($khs)
            ->addIndexColumn()
            ->addColumn('action', function ($khs) {
                return view('layouts.action._action', [
                    'khs'         => $khs,
                    'url_edit'    => route('khs.edit', $khs->id),
                    'url_destroy' => route('khs.show', $khs->id),
                ]);
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $data['khs'] = \DB::table('khs')
            ->join('teachers', 'teachers.guru_id', '=', 'khs.guru_id')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('khs.user_id', $user_id)
            ->orderBy('academic_years.kode_tahun_akademik', 'desc')
            ->get();

        $data['academicYear'] = AcademicYear::orderBy('kode_tahun_akademik', 'desc')->pluck('tahun_akademik', 'kode_tahun_akademik');

        return view('khs.index', $data);
    }


    public function KHSpdf()
    {
        $user_id = Auth::user()->id;
        $khs = \DB::table('khs')
            ->join('teachers', 'teachers.guru_id', '=', 'khs.guru_id')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->where('khs.user_id', $user_id)
            ->get();

        Fpdf::AddPage();
        Fpdf::SetFont('Courier', 'B', 12);
        // Fpdf::Cell(50, 25, 'Hello World!');


        Fpdf::Cell(30, 7, 'NIS', 0, 0);
        Fpdf::Cell(10, 7, ':' . $khs[0]->nis, 0, 1);
        Fpdf::Cell(30, 7, 'Nama', 0, 0);
        Fpdf::Cell(10, 7, ':'  . $khs[0]->nama, 0, 1);
        Fpdf::SetFont('Courier', 'B', 12);

        Fpdf::Cell(10, 5, '', 0, 1);

        Fpdf::Cell(7, 7, 'No', 1, 0);
        Fpdf::Cell(25, 7, 'Kode MP', 1, 0);
        Fpdf::Cell(70, 7, 'Mata Pelajaran', 1, 0);
        Fpdf::Cell(25, 7, 'Nilai', 1, 0);
        Fpdf::Cell(25, 7, 'Grade', 1, 1);
        Fpdf::SetFont('Courier', '', 12);
        $no = 1;

        foreach ($khs as $row) {
            Fpdf::Cell(7, 7, $no, 1, 0);
            Fpdf::Cell(25, 7, $row->kode_mp, 1, 0);
            Fpdf::Cell(70, 7, $row->nama_mp, 1, 0);
            Fpdf::Cell(25, 7, $row->nilai_akhir, 1, 0);
            Fpdf::Cell(25, 7, $row->grade, 1, 1);
            $no++;
        }

        Fpdf::Output();
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
    public function show($id)
    {
        //
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
