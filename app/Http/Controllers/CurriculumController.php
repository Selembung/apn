<?php

namespace App\Http\Controllers;

use App\Course;
use App\Curriculum;
use App\Http\Requests\CurriculumRequest;
use App\LogActivity;
use App\Major;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;

class CurriculumController extends Controller
{
    public function ajax()
    {
        $curriculum = Curriculum::all();
        $filter = $curriculum->sortBy('kode_jurusan');

        return view('curriculum.ajax', compact('filter'));
    }

    public function datatable()
    {
        $curriculum = \DB::table('curriculums')
            ->join('courses', 'courses.kode_mp', '=', 'curriculums.kode_mp')
            ->join('majors', 'majors.kode_jurusan', '=', 'curriculums.kode_jurusan')
            ->get();

        return DataTables::of($curriculum)
            ->addColumn('action', function ($curriculum) {
                $a = '<a href="/curriculum/'.$curriculum->id.'" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                            data-original-title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>';
                $a .= view('layouts.action._action', [
                    'curriculum'  => $curriculum,
                    'url_edit'    => route('curriculum.edit', $curriculum->id),
                    'url_destroy' => route('curriculum.destroy', $curriculum->id),
                ]);

                return $a;
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

        return view('curriculum.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['major'] = Major::pluck('nama_jurusan', 'kode_jurusan');
        $data['course'] = Course::pluck('nama_mp', 'kode_mp');

        return view('curriculum.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurriculumRequest $request)
    {
        $input = $request->all();

        Curriculum::create($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data kurikulum ( Kode Jurusan: " . $request->kode_jurusan . " , Kode MP: " . $request->kode_MP . " , Semester: " . $request->semester . " ) ";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data kurikulum: '.$request->kode_jurusan.' - '.$request->kode_mp.' - '.$request->semester;
        $filename = 'Log Kurikulum - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('curriculum');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function show(Curriculum $curriculum)
    {
        $data = \DB::table('curriculums')
            ->join('courses', 'courses.kode_mp', '=', 'curriculums.kode_mp')
            ->join('majors', 'majors.kode_jurusan', '=', 'curriculums.kode_jurusan')
            ->get();

        return view('curriculum.show', compact('curriculum', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function edit(Curriculum $curriculum)
    {
        $major = Major::pluck('nama_jurusan', 'kode_jurusan');
        $course = Course::pluck('nama_mp', 'kode_mp');

        return view('curriculum.edit', compact('curriculum', 'major', 'course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function update(CurriculumRequest $request, Curriculum $curriculum)
    {
        $input = $request->all();

        $curriculum->update($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data kurikulum ( Kode Jurusan: " . $request->kode_jurusan . " , Kode MP: " . $request->kode_MP . " , Semester: " . $request->semester . " ) ";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data kurikulum: '.$request->kode_jurusan.' - '.$request->kode_mp.' - '.$request->semester;
        $filename = 'Log Kurikulum - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('curriculum');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curriculum $curriculum)
    {
        Curriculum::destroy($curriculum->id);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data kurikulum ( Kode Jurusan: " . $curriculum->kode_jurusan . " , Kode MP: " . $curriculum->kode_MP . " , Semester: " . $curriculum->semester . " ) ";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penghapusan data kurikulum: '.$curriculum->kode_jurusan.' - '.$curriculum->kode_mp.' - '.$curriculum->semester;
        $filename = 'Log Kurikulum - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('curriculum');
    }
}
