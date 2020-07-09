<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use DataTables;
use Session;

class CourseController extends Controller
{
    public function datatable()
    {
        return DataTables::of(Course::all())
            ->addColumn('action', function ($course) {
                return view('layouts.action._action', [
                    'course'      => $course,
                    'url_edit'    => route('course.edit', $course->kode_mp),
                    'url_destroy' => route('course.show', $course->kode_mp),
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
        return view('course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $input = $request->all();

        Course::create($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menambahkan data mata pelajaran: " . $request->nama_mp;
        $logActivities->save();

        Session::flash('message', 'Data has been saved!');

        return redirect('course');
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
    public function edit(Course $course)
    {
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $input = $request->all();

        $course->update($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Mengubah data mata pelajaran: " . $request->nama_mp;
        $logActivities->save();

        Session::flash('message', 'Data has been updated!');

        return redirect('course');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        Course::destroy($course->kode_mp);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menghapus data mata pelajaran: " . $course->nama_mp;
        $logActivities->save();

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('course');
    }
}
