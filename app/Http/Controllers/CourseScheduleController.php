<?php

namespace App\Http\Controllers;

use App\CourseSchedule;
use App\Major;
use App\Course;
use App\Teacher;
use App\User;
use App\Room;
use App\CourseHour;
use App\AcademicYear;
use App\Http\Requests\CourseScheduleRequest;
use Session;
use DataTables;
use Illuminate\Http\Request;

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
        $data['ay']      = AcademicYear::select('kode_tahun_akademik', 'tahun_akademik')->where('status', 'Aktif')->get();
        $data['major']   = Major::pluck('nama_jurusan', 'kode_jurusan');
        $data['course']  = Course::pluck('nama_mp', 'kode_mp');
        $data['teacher'] = Teacher::pluck('nama', 'guru_id');
        $data['room']    = Room::pluck('nama_ruangan', 'kode_ruangan');
        $data['ch']      = CourseHour::all('jam_masuk', 'jam_keluar');
        $data['user']    = User::select('name', 'id')->get();

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
        $data['ay']      = AcademicYear::select('kode_tahun_akademik', 'tahun_akademik')->where('status', 'Aktif')->get();
        $data['major']   = Major::pluck('nama_jurusan', 'kode_jurusan');
        $data['course']  = Course::pluck('nama_mp', 'kode_mp');
        $data['teacher'] = Teacher::pluck('nama', 'guru_id');
        $data['room']    = Room::pluck('nama_ruangan', 'kode_ruangan');
        $data['ch']      = CourseHour::all('jam_masuk', 'jam_keluar');
        $data['user']    = User::pluck('name', 'id');

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

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('course-schedule');
    }
}
