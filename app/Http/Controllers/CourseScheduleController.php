<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseHour;
use App\Models\CourseSchedule;
use App\Http\Requests\CourseScheduleRequest;
use App\Models\LogActivity;
use App\Models\Major;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;

class CourseScheduleController extends Controller
{
    public function ajax()
    {
        $courseSchedule = CourseSchedule::all();

        return view('course-schedule.ajax', compact('filter'));
    }

    public function datatable()
    {
        $courseSchedule = \DB::table('course_schedules')
            ->join('courses', 'courses.kode_mp', '=', 'course_schedules.kode_mp')
            ->join('rooms', 'rooms.kode_ruangan', '=', 'course_schedules.kode_ruangan')
            ->join('teachers', 'teachers.guru_id', '=', 'course_schedules.user_id')
            ->join('majors', 'majors.kode_jurusan', '=', 'course_schedules.kode_jurusan')
            ->join('course_hours', 'course_hours.id_jam', '=', 'course_schedules.jam')
            ->get();

        return DataTables::of($courseSchedule)
            ->addColumn('action', function ($courseSchedule) {
                return view('layouts.action._action', [
                    'courseSchedule' => $courseSchedule,
                    'url_edit'       => route('course-schedule.edit', $courseSchedule->id),
                    'url_destroy'    => route('course-schedule.destroy', $courseSchedule->id),
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
        $data['major'] = Major::pluck('nama_jurusan', 'kode_jurusan');

        return view('course-schedule.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['ay'] = AcademicYear::select('kode_tahun_akademik', 'tahun_akademik')->where('status', 'Aktif')->get();
        // $data['ay']      = AcademicYear::pluck('tahun_akademik', 'kode_tahun_akademik');
        $data['major'] = Major::pluck('nama_jurusan', 'kode_jurusan');
        $data['course'] = Course::pluck('nama_mp', 'kode_mp');
        $data['teacher'] = Teacher::pluck('nama', 'guru_id');
        $data['room'] = Room::pluck('nama_ruangan', 'kode_ruangan');
        $data['ch'] = CourseHour::all();
        $data['user'] = User::select('name', 'id')->get();

        return view('course-schedule.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseScheduleRequest $request)
    {
        $input = $request->all();

        CourseSchedule::create($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data jadwal pelajaran";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data jadwal pelajaran: '.$request->kode_tahun_akademik.' - '.$request->kode_mp.' - '.$request->semester.' - '.$request->kode_jurusan;
        $filename = 'Log Jadwal Pelajaran-'.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('course-schedule');
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
    public function edit(CourseSchedule $courseSchedule)
    {
        // $data['ay']      = AcademicYear::select('kode_tahun_akademik', 'tahun_akademik')->where('status', 'Aktif')->get();
        $data['ay'] = AcademicYear::pluck('tahun_akademik', 'kode_tahun_akademik');
        $data['major'] = Major::pluck('nama_jurusan', 'kode_jurusan');
        $data['course'] = Course::pluck('nama_mp', 'kode_mp');
        $data['teacher'] = Teacher::pluck('nama', 'guru_id');
        $data['room'] = Room::pluck('nama_ruangan', 'kode_ruangan');
        $data['ch'] = CourseHour::all('jam_masuk', 'jam_keluar');
        $data['user'] = User::pluck('name', 'id');

        return view('course-schedule.edit', compact('courseSchedule'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseScheduleRequest $request, CourseSchedule $courseSchedule)
    {
        $input = $request->all();

        $courseSchedule->update($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data jadwal pelajaran";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data jadwal pelajaran: '.$request->kode_tahun_akademik.' - '.$request->kode_mp.' - '.$request->semester.' - '.$request->kode_jurusan;
        $filename = 'Log Jadwal Pelajaran-'.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('course-schedule');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseSchedule $courseSchedule)
    {
        CourseSchedule::destroy($courseSchedule->id);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data jadwal pelajaran";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penghapusan data jadwal pelajaran: '.$courseSchedule->kode_tahun_akademik.' - '.$courseSchedule->kode_mp.' - '.$courseSchedule->semester.' - '.$courseSchedule->kode_jurusan;
        $filename = 'Log Jadwal Pelajaran-'.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('course-schedule');
    }
}
