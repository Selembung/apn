<?php

namespace App\Http\Controllers;

use App\Models\CourseHour;
use App\Http\Requests\CourseHourRequest;
use App\Models\LogActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;

class CourseHourController extends Controller
{
    public function datatable()
    {
        return DataTables::of(CourseHour::all())
            ->addColumn('action', function ($courseHour) {
                return view('layouts.action._action', [
                    'courseHour'  => $courseHour,
                    'url_edit'    => route('course-hour.edit', $courseHour->id_jam),
                    'url_destroy' => route('course-hour.show', $courseHour->id_jam),
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
        return view('course-hour.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course-hour.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseHourRequest $request)
    {
        $input = $request->all();

        CourseHour::create($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data jam pelajaran: " . $request->jam_masuk . " - " . $request->jam_keluar;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data jam pelajaran: '.$request->jam_masuk.' - '.$request->jam_keluar;
        $filename = 'Log Jam Pelajaran - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('course-hour');
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
    public function edit(CourseHour $courseHour)
    {
        return view('course-hour.edit', compact('courseHour'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseHourRequest $request, CourseHour $courseHour)
    {
        $input = $request->all();

        $courseHour->update($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data jam pelajaran: " . $request->jam_masuk . " - " . $request->jam_keluar;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data jam pelajaran: '.$request->jam_masuk.' - '.$request->jam_keluar;
        $filename = 'Log Jam Pelajaran - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('course-hour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseHour $courseHour)
    {
        CourseHour::destroy($courseHour->id_jam);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data jam pelajaran: " . $courseHour->jam_masuk . " - " . $courseHour->jam_keluar;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penghapusan data jam pelajaran: '.$courseHour->jam_masuk.' - '.$courseHour->jam_keluar;
        $filename = 'Log Jam Pelajaran - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('course-hour');
    }
}
