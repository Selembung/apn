<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoreRequest;
use App\Score;
use App\Khs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use Session;
use DataTables;

class ScoreController extends Controller
{
    // public function datatable()
    // {

    //     $schedule = \DB::table('course_schedules')->where('id', $id_jadwal)->first();
    //     $khs = \DB::table('khs')
    //         ->join('students', 'students.nis', '=', 'khs.nis')
    //         ->where('khs.kode_guru', $schedule['kode_guru'])
    //         ->get();

    //     return DataTables::of($khs)
    //         ->addColumn('action', function ($khs) {
    //             // return view('layouts.action._action', [
    //             //     'score'       => $score,
    //             //     'url_edit'    => route('score.edit', $score->id),
    //             //     'url_destroy' => route('score.show', $score->id),
    //             // ]);
    //         })
    //         ->make(true);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_jadwal)
    {
        $schedule = \DB::table('course_schedules')
            ->join('teachers', 'teachers.guru_id', '=', 'course_schedules.user_id')
            ->join('courses', 'courses.kode_mp', '=', 'course_schedules.kode_mp')
            ->where('id', $id_jadwal)->first();

        $data['siswa'] = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->where('khs.guru_id', $schedule->user_id)
            ->where('khs.kode_mp', $schedule->kode_mp)
            ->get();

        $data['schedule'] = $schedule;


        return view('score.index', $data);
    }

    public function update_score(Request $request)
    {
        $score = \DB::table('khs')
            ->where('id', $request->id_khs)
            ->update([
                'nilai_harian'  => $request->nilai_harian,
                'nilai_praktek' => $request->nilai_praktek,
                'nilai_uts'     => $request->nilai_uts,
                'nilai_uas'     => $request->nilai_uas,
                'nilai_akhir'   => $request->nilai_akhir,
                'grade'         => $request->grade,
                'nilai_sikap'   => $request->nilai_sikap,
                'nilai_sikap'   => $request->nilai_sikap,
            ]);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Melakukan perubahan nilai pada siswa dengan ID KHS: " . $request->id_khs;
        $logActivities->save();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     return view('score.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(ScoreRequest $request)
    // {
    //     $input = $request->all();

    //     Score::create($input);

    //     Session::flash('message', 'Data has been saved!');

    //     return redirect('score');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Score  $major
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Score $score)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Score  $major
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Score $score)
    // {
    //     return view('score.edit', compact('score'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Score  $major
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(ScoreRequest $request, Score $score)
    // {
    //     $input = $request->all();

    //     $score->update($input);

    //     Session::flash('message', 'Data has been updated!');

    //     return redirect('score');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Score  $major
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Score $score)
    // {
    //     Score::destroy($score->kode_jurusan);

    //     Session::flash('message', 'Data has been deleted!');
    //     Session::flash('important', true);

    //     return redirect('score');
    // }
}
