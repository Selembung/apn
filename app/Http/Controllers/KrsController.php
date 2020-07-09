<?php

namespace App\Http\Controllers;

use App\Course;
use App\Krs;
use App\Khs;
use App\Major;
use App\Student;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    public function ajax()
    {
        \DB::table('courses')
            ->join('course_schedules', 'course_schedules.kode_mp', '=', 'courses.kode_mp')
            ->all();;

        return view('krs.ajax');
    }

    public function datatable()
    {
        $courses = \DB::table('courses')
            ->join('course_schedules', 'course_schedules.kode_mp', '=', 'courses.kode_mp')
            ->where('kode_jurusan', '=', Auth::user()->kode_jurusan)
            ->get();

        return DataTables::of($courses)
            ->addColumn('action', function ($krs) {
                $action = '<button class="btn btn-sm btn-neutral btn-round btn-icon" onClick="tambah_krs(\'' . $krs->kode_mp . '\')" data-toggle="tooltip" data-original-title="Ambil">
                <i class="fas fa-user-edit"></i>
                </button>';
                return $action;
            })
            ->make(true);
    }

    public function check_semester()
    {
        $user_id = Auth::user()->id;
        $khs = \DB::table('khs')->where('user_id', $user_id);
        if ($khs->count() > 0) {
            $student = \DB::table('students')->where('user_id', $user_id)->first();

            return $student->semester_aktif + 1;
        } else {
            return 1;
        }
    }

    function get_jadwal($kode_mp, $kode_jurusan)
    {
        $schedule = \DB::table('course_schedules')
            ->where('kode_mp', $kode_mp)
            ->where('kode_tahun_akademik', get_tahun_akademik('kode_tahun_akademik'))
            ->where('kode_jurusan', $kode_jurusan)
            ->first();

        return $schedule->user_id;
        // return $schedule->user_id;
    }

    public function hapusKrs(Request $request)
    {
        $krs = Krs::find($request->id);
        $krs->delete();
    }

    public function tambahKrs(Request $request)
    {
        $student = \DB::table('students')->first();
        $tahun_akademik = \DB::table('academic_years')->where('status', 'Aktif')->first();

        $krs = new Krs;
        $krs->kode_mp             = $request->kode_mp;
        $krs->user_id             = Auth::user()->id;
        $krs->kode_tahun_akademik = $tahun_akademik->kode_tahun_akademik;
        $krs->semester            = $this->check_semester();
        $krs->guru_id             = $this->get_jadwal($request->kode_mp, Auth::user()->kode_jurusan);
        // $krs->guru_id             = $this->get_jadwal($request->kode_mp, $student->kode_jurusan);
        $krs->save();
    }

    public function selesai()
    {
        $user_id        = Auth::user()->id;
        $krs            = \DB::table('krs')->where('user_id', $user_id)->get();
        $tahun_akademik = \DB::table('academic_years')->where('status', 'Aktif')->first();

        foreach ($krs as $row) {
            $khs                      = new Khs;
            $khs->kode_tahun_akademik = $tahun_akademik->kode_tahun_akademik;
            $khs->user_id             = $user_id;
            $khs->guru_id             = $row->guru_id;
            $khs->kode_mp             = $row->kode_mp;
            $khs->nilai_harian        = 0;
            $khs->nilai_praktek       = 0;
            $khs->nilai_uts           = 0;
            $khs->nilai_uas           = 0;
            $khs->nilai_akhir         = 0;
            $khs->grade               = '';
            $khs->nilai_sikap         = '';
            $khs->semester            = $row->semester;
            $khs->save();
        }

        return redirect('khs');
    }

    public function tampilKrs()
    {
        $result = ' <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode MP</th>
                                <th>Mata Pelajaran</th>
                                <th>SKS</th>
                                <th>Action</th>
                            </tr>
                        </thead>';

        $krs = \DB::table('krs')
            ->join('courses', 'krs.kode_mp', '=', 'courses.kode_mp')
            ->where('user_id', Auth::user()->id)
            ->get();

        foreach ($krs as $row) {
            $result .= '<tr>
                            <td>' . $row->kode_mp . '</td>
                            <td>' . $row->nama_mp . '</td>
                            <td>' . $row->jumlah_sks . '</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onClick="hapus_krs(' . $row->id . ')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>';
        }
        $result .= '<tr>
                        <td>
                            <a class="btn btn-success" href="/krs/selesai"><i class="fas fa-cart-plus"></i> Saya Selesai Mengisi KRS</a>
                        </td>
                    </tr>';
        $result .= '</table>';
        return $result;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user'] = \DB::table('users')
            ->where('id', Auth::user()->id)
            ->get();

        $data['filter'] = \DB::table('courses')
            ->join('course_schedules', 'course_schedules.kode_mp', '=', 'courses.kode_mp')
            ->get();

        $data['major'] = Major::pluck('nama_jurusan', 'kode_jurusan');

        return view('krs.index', $data);
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
