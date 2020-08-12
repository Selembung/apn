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
            ->all();

        return view('krs.ajax');
    }

    public function datatable()
    {
        $courses = \DB::table('courses')
            ->join('course_schedules', 'course_schedules.kode_mp', '=', 'courses.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'course_schedules.kode_tahun_akademik')
            // ->where('status', 'Aktif')
            ->where('kode_jurusan', '=', Auth::user()->kode_jurusan)
            ->get();

        return DataTables::of($courses)
            ->addColumn('action', function ($courses) {
                if ($courses->status == 'Nonaktif') {
                    $action = '<button class="btn btn-sm btn-neutral btn-round btn-icon disabled" data-toggle="tooltip" data-original-title="Belum bisa dipilih">
                    <i class="fas fa-user-edit"></i>
                    </button>';
                } else {
                    $action = '<button class="btn btn-sm btn-neutral btn-round btn-icon" onClick="tambah_krs(\'' . $courses->kode_mp . '\')" data-toggle="tooltip" data-original-title="Ambil">
                    <i class="fas fa-user-edit"></i>
                    </button>';
                }
                return $action;
            })
            ->make(true);
    }

    public function check_semester()
    {
        $siswa = \DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'students.kode_tahun_akademik')
            ->where('id', '=', Auth::user()->id)
            ->get();

        $user_id = Auth::user()->id;
        $khs = \DB::table('khs')->where('user_id', $user_id);
        if ($khs->count() > 0) {
            $student = \DB::table('students')->where('user_id', $user_id)->first();

            Student::where('user_id', $siswa[0]->id)
                ->update([
                    'semester_aktif' => $siswa[0]->semester_aktif + 1
                ]);

            return $student->semester_aktif;
        } elseif ($siswa[0]->semester_aktif == '6') {
            Student::where('user_id', $siswa[0]->id)
                ->update([
                    'semester_aktif' => '6'
                ]);
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
        $student = \DB::table('students')
            ->where('user_id', Auth::user()->id)
            ->first();

        $tahun_akademik = \DB::table('academic_years')->where('status', 'Aktif')->first();

        $validator = \Validator::make($request->all(), [
            'kode_mp' => 'required|unique:krs,kode_mp,NULL,id,user_id,' . Auth::user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $krs = new Krs;
        $krs->kode_mp             = $request->kode_mp;
        $krs->user_id             = Auth::user()->id;
        $krs->kode_tahun_akademik = $tahun_akademik->kode_tahun_akademik;
        // $krs->semester            = $this->check_semester();
        $krs->semester            = $student->semester_aktif;
        $krs->guru_id             = $this->get_jadwal($request->kode_mp, Auth::user()->kode_jurusan);
        // $krs->guru_id             = $this->get_jadwal($request->kode_mp, $student->kode_jurusan);
        $krs->save();

        return response()->json(['success' => 'Record is successfully added']);
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

        $siswa = \DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'students.kode_tahun_akademik')
            ->where('id', '=', Auth::user()->id)
            ->get();

        Student::where('user_id', $siswa[0]->id)
            ->update([
                'semester_aktif' => $siswa[0]->semester_aktif + 1
            ]);

        \DB::table('krs')->where('user_id', $user_id)->delete();

        return redirect('khs');
    }

    public function tampilKrs()
    {
        $krs = \DB::table('krs')
            ->join('courses', 'krs.kode_mp', '=', 'courses.kode_mp')
            ->join('students', 'students.user_id', '=', 'krs.user_id')
            ->where('krs.user_id', Auth::user()->id)
            ->get();

        $total_sks = \DB::table('krs')
            ->join('courses', 'krs.kode_mp', '=', 'courses.kode_mp')
            ->where('user_id', Auth::user()->id)->sum('jumlah_sks');

        if ($krs->count() > 0) {
            $result = '<h5 class="mb-3">Total SKS: ' . $total_sks . '</h5>
            <table class="table align-items-center table-flush" id="haha">
                <thead class="thead-light">
                    <tr>
                        <th>Kode MP</th>
                        <th>Mata Pelajaran</th>
                        <th class="text-center">SKS</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>';
        } else {
            $result = '<table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kode MP</th>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-center">SKS</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tr>
                                <td colspan="4" class="text-center">Belum terdapat mata pelajaran yang dipilih</td>
                            </tr>';
            return $result;
        }

        foreach ($krs as $row) {
            $result .= '<tr>
                            <td>' . $row->kode_mp . '</td>
                            <td>' . $row->nama_mp . '</td>
                            <td class="text-center">' . $row->jumlah_sks . '</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" onClick="hapus_krs(' . $row->id . ')" data-toggle="tooltip"
                                data-original-title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>';
        }
        if ($krs[0]->semester_aktif == 1) {
            if ($total_sks > 46) {
                $result .= '<tr>
                                <td colspan="2" class="">
                                    <a class="btn btn-success text-center" href="/krs/selesai"><i class="fas fa-cart-plus"></i> Saya Selesai Mengisi KRS</a>
                                </td>
                                <td colspan="1" class="text-center font-weight-bold">
                                ' . $total_sks . '
                                </td>
                                <td colspan="1"></td>
                            </tr>';
                $result .= '</table>';
            }
        } elseif ($krs[0]->semester_aktif == 2) {
            if ($total_sks > 46) {
                $result .= '<tr>
                                <td colspan="2" class="">
                                    <a class="btn btn-success text-center" href="/krs/selesai"><i class="fas fa-cart-plus"></i> Saya Selesai Mengisi KRS</a>
                                </td>
                                <td colspan="1" class="text-center font-weight-bold">
                                ' . $total_sks . '
                                </td>
                                <td colspan="1"></td>
                            </tr>';
                $result .= '</table>';
            }
        } elseif ($krs[0]->semester_aktif == 3) {
            if ($total_sks > 48) {
                $result .= '<tr>
                                <td colspan="2" class="">
                                    <a class="btn btn-success text-center" href="/krs/selesai"><i class="fas fa-cart-plus"></i> Saya Selesai Mengisi KRS</a>
                                </td>
                                <td colspan="1" class="text-center font-weight-bold">
                                ' . $total_sks . '
                                </td>
                                <td colspan="1"></td>
                            </tr>';
                $result .= '</table>';
            }
        } elseif ($krs[0]->semester_aktif == 4) {
            if ($total_sks > 48) {
                $result .= '<tr>
                                 <td colspan="2" class="">
                                    <a class="btn btn-success text-center" href="/krs/selesai"><i class="fas fa-cart-plus"></i> Saya Selesai Mengisi KRS</a>
                                </td>
                                <td colspan="1" class="text-center font-weight-bold">
                                    ' . $total_sks . '
                                </td>
                                <td colspan="1"></td>
                            </tr>';
                $result .= '</table>';
            }
        } elseif ($krs[0]->semester_aktif == 5) {
            if ($total_sks > 48) {
                $result .= '<tr>
                                 <td colspan="2" class="">
                                    <a class="btn btn-success text-center" href="/krs/selesai"><i class="fas fa-cart-plus"></i> Saya Selesai Mengisi KRS</a>
                                </td>
                                <td colspan="1" class="text-center font-weight-bold">
                                ' . $total_sks . '
                                </td>
                                <td colspan="1"></td>
                            </tr>';
                $result .= '</table>';
            }
        } elseif ($krs[0]->semester_aktif == 6) {
            if ($total_sks > 48) {
                $result .= '<tr>
                                <td colspan="2" class="">
                                    <a class="btn btn-success text-center" href="/krs/selesai"><i class="fas fa-cart-plus"></i> Saya Selesai Mengisi KRS</a>
                                </td>
                                <td colspan="1" class="text-center font-weight-bold">
                                ' . $total_sks . '
                                </td>
                                <td colspan="1"></td>
                            </tr>';
                $result .= '</table>';
            }
        }
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

        $data['student'] = \DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('id', Auth::user()->id)
            ->get();

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
