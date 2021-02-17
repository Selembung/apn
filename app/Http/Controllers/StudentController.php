<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Http\Requests\StudentRequest;
use App\Models\LogActivity;
use App\Models\Major;
use App\Models\Rombel;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class StudentController extends Controller
{
    public function datatable()
    {
        $student = \DB::table('students')
            ->join('majors', 'majors.kode_jurusan', '=', 'students.kode_jurusan')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'students.kode_tahun_akademik')
            ->Leftjoin('users', 'users.id', '=', 'students.user_id')
            ->get();

        return DataTables::of($student)
            ->addColumn('action', function ($student) {
                return view('layouts.action._action', [
                    'student'     => $student,
                    'url_edit'    => route('student.edit', $student->nis),
                    'url_destroy' => route('student.show', $student->nis),
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
        return view('student.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['major'] = Major::pluck('nama_jurusan', 'kode_jurusan');
        $data['academic'] = AcademicYear::pluck('tahun_akademik', 'kode_tahun_akademik');

        return view('student.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        // Insert ke table User
        $user = new User;
        $user->role = 'siswa';
        $user->name = $request->nama;
        $user->kode_jurusan = $request->kode_jurusan;
        $user->email = $request->email;
        $user->password = bcrypt('rahasia');
        // $user->remember_token = Str::random(60);
        $user->save();

        // Insert ke table Student
        $request->request->add(['user_id' => $user->id]);
        $input = $request->all();
        Student::create($input);

        // Insert ke table Log Activities
        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data siswa ( NIS: " . $request->nis . ", Nama: " . $request->nama . " )";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data siswa: '.$request->nis.' - '.$request->nama;
        $filename = 'Log Data Siswa - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('student');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $data['major'] = Major::pluck('nama_jurusan', 'kode_jurusan');
        $data['user'] = User::pluck('password', 'id');
        $data['academic'] = AcademicYear::pluck('tahun_akademik', 'kode_tahun_akademik');

        return view('student.edit', $data, compact('student'));
    }

    public function editRombel(Student $student)
    {
        $data['rombel'] = Rombel::all();

        return view('student.edit-rombel', compact('student'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        User::where('id', $student->user_id)
            ->update([
                'name'         => $request->nama,
                'kode_jurusan' => $request->kode_jurusan,
                'email'        => $request->email,
            ]);

        $input = $request->all();

        $student->update($input);

        // Insert ke table Log Activities
        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data siswa ( NIS: " . $request->nis . ", Nama: " . $request->nama . " )";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data siswa: '.$request->nis.' - '.$request->nama;
        $filename = 'Log Data Siswa - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('student');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $query = 'DELETE students,users FROM students 
        INNER JOIN users ON users.id = students.user_id  
        WHERE students.user_id = ?';

        \DB::delete($query, [$student->user_id]);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data siswa ( NIS: " . $student->nis . ", Nama: " . $student->nama . " )";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data siswa: '.$student->nis.' - '.$student->nama;
        $filename = 'Log Data Siswa - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('student');
    }
}
