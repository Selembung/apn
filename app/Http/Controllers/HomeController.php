<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Jadwal KBM
    public function datatable()
    {
        $courseSchedule = \DB::table('course_schedules')
            ->join('courses', 'courses.kode_mp', '=', 'course_schedules.kode_mp')
            ->join('rooms', 'rooms.kode_ruangan', '=', 'course_schedules.kode_ruangan')
            ->join('teachers', 'teachers.guru_id', '=', 'course_schedules.user_id')
            ->join('majors', 'majors.kode_jurusan', '=', 'course_schedules.kode_jurusan')
            ->join('course_hours', 'course_hours.id_jam', '=', 'course_schedules.jam')
            ->where('hari', Carbon::now()->translatedFormat('l'))
            ->get();

        return DataTables::of($courseSchedule)->make(true);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $student = \DB::table('students')->get();
        $teacher = \DB::table('teachers')->get();
        $dateStudent = \DB::table('students')
            ->select('created_at')
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get();

        $dateTeacher = \DB::table('teachers')
            ->select('created_at')
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get();

        $dateStudent = Carbon::parse($dateStudent[0]->created_at)->diffForHumans();
        $dateTeacher = Carbon::parse($dateTeacher[0]->created_at)->diffForHumans();

        $infoSiswa = \DB::table('students')
            ->join('rombels', 'rombels.kode_rombel', '=', 'students.kode_rombel')
            ->join('majors', 'majors.kode_jurusan', '=', 'students.kode_jurusan')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('id', Auth::user()->id)
            ->get();

        $academicYear = \DB::table('academic_years')
            ->where('status', 'aktif')
            ->get();

        $major = \DB::table('majors')->get();

        $homeroomTeacher = \DB::table('homeroom_teachers')
            ->join('rombels', 'rombels.kode_rombel', '=', 'homeroom_teachers.kode_rombel')
            ->join('students', 'students.kode_rombel', '=', 'rombels.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('users.id', Auth::user()->id)
            ->first();

        $homeroom = \DB::table('homeroom_teachers')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('rombels', 'rombels.kode_rombel', '=', 'homeroom_teachers.kode_rombel')
            ->join('users', 'users.id', '=', 'teachers.guru_id')
            ->where('users.id', Auth::user()->id)
            ->get();

        return view('dashboard', compact('student', 'teacher', 'dateStudent', 'dateTeacher', 'academicYear', 'major', 'infoSiswa', 'homeroomTeacher', 'homeroom'));
    }
}
