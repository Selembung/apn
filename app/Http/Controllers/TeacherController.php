<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\LogActivity;
use App\Teacher;
use App\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;

class TeacherController extends Controller
{
    public function datatableTeaching()
    {
        $teaching = \DB::table('course_schedules')
            ->join('rooms', 'rooms.kode_ruangan', '=', 'course_schedules.kode_ruangan')
            ->join('courses', 'courses.kode_mp', '=', 'course_schedules.kode_mp')
            ->join('course_hours', 'course_hours.id_jam', '=', 'course_schedules.jam')
            ->join('majors', 'majors.kode_jurusan', '=', 'course_schedules.kode_jurusan')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'course_schedules.kode_tahun_akademik')
            // ->join('users', 'users.id', '=', 'course_schedules.user_id')
            ->where('course_schedules.user_id', Auth::user()->id);

        return DataTables::of($teaching)
            ->addColumn('action', function ($teaching) {
                if ($teaching->status == 'Nonaktif') {
                    $action = '<button class="btn btn-sm btn-danger btn-round btn-icon disabled" data-toggle="tooltip"
                    data-original-title="Sudah tidak bisa input nilai"><i class="fas fa-minus-circle"></i></button>';
                } else {
                    $action = '<a href="/score/'.$teaching->id.'/'.$teaching->semester.'" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                    data-original-title="Input Nilai"><i class="fas fa-pencil-alt"></i></a>';
                }

                return $action;
            })
            ->make(true);
    }

    public function datatable()
    {
        return DataTables::of(Teacher::all())
            ->addColumn('action', function ($teacher) {
                return view('layouts.action._action', [
                    'teacher'     => $teacher,
                    'url_edit'    => route('teacher.edit', $teacher->nig),
                    'url_destroy' => route('teacher.show', $teacher->nig),
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
        return view('teacher.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        // Insert ke table User
        $user = new User;
        $user->role = 'guru';
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt('rahasia');
        // $user->remember_token = Str::random(60);
        $user->save();

        // Insert ke table Teacher
        $request->request->add(['guru_id' => $user->id]);
        $input = $request->all();

        Teacher::create($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data guru: " . $request->nama;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data guru: '.$request->nama;
        $filename = 'Log Data Guru - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('teacher');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherRequest $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        User::where('id', $teacher->guru_id)
            ->update([
                'name'  => $request->nama,
                'email' => $request->email,
            ]);

        $input = $request->all();

        $teacher->update($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data guru: " . $request->nama;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data guru: '.$request->nama;
        $filename = 'Log Data Guru - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('teacher');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $query = 'DELETE teachers,users FROM teachers 
        INNER JOIN users ON users.id = teachers.guru_id  
        WHERE teachers.guru_id = ?';

        \DB::delete($query, [$teacher->guru_id]);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data guru: " . $teacher->nama;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data guru: '.$teacher->nama;
        $filename = 'Log Data Guru - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        return redirect('teacher');
    }

    public function teachingSchedule()
    {
        return view('teacher.teaching-schedule');
    }
}
