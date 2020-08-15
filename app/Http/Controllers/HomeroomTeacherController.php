<?php

namespace App\Http\Controllers;

use App\HomeroomTeacher;
use App\Teacher;
use App\Rombel;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use App\Http\Requests\HomeroomTeacherRequest;
use Illuminate\Http\Request;
use Session;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class HomeroomTeacherController extends Controller
{
    public function datatable()
    {
        $wk = \DB::table('homeroom_teachers')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->get();

        return DataTables::of($wk)
            ->addColumn('action', function ($wk) {
                return view('layouts.action._action', [
                    'homeroomTeacher'   => $wk,
                    'url_edit'    => route('homeroom-teacher.edit', $wk->id),
                    'url_destroy' => route('homeroom-teacher.show', $wk->id),
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
        return view('homeroom-teacher.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['teacher'] = Teacher::pluck('nama', 'kode_guru');
        $data['rombel']  = Rombel::pluck('nama_rombel', 'kode_rombel');

        return view('homeroom-teacher.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeroomTeacherRequest $request)
    {
        $input = $request->all();

        HomeroomTeacher::create($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data wali kelas ( Rombel: " . $request->kode_rombel . " , dengan Wali Kelas: " . $request->kode_rombel . " )";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log 
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s') . date(' T \| ') . 'ID User: ' . Auth::user()->id . ' | Melakukan penambahan data wali kelas: Rombel: ' . $request->kode_rombel . ' dengan Wali Kelas: ' .  $request->kode_rombel;
        $filename = 'Log Wali Kelas - ' . date('Y-m-d') . '.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('homeroom-teacher');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HomeroomTeacher  $homeroomTeacher
     * @return \Illuminate\Http\Response
     */
    public function show(HomeroomTeacher $homeroomTeacher)
    {
        $data['teacher'] = Teacher::pluck('nama', 'kode_guru');
        $data['rombel']  = Rombel::pluck('nama_rombel', 'kode_rombel');

        return view('homeroom-teacher.edit', compact('wk'), $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HomeroomTeacher  $homeroomTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeroomTeacher $homeroomTeacher)
    {
        $data['teacher'] = Teacher::pluck('nama', 'kode_guru');
        $data['rombel']  = Rombel::pluck('nama_rombel', 'kode_rombel');

        return view('homeroom-teacher.edit', compact('homeroomTeacher'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HomeroomTeacher  $homeroomTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(HomeroomTeacherRequest $request, HomeroomTeacher $homeroomTeacher)
    {
        $input = $request->all();

        $homeroomTeacher->update($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data wali kelas ( Rombel: " . $request->kode_rombel . " , dengan Wali Kelas: " . $request->kode_rombel . " )";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log 
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s') . date(' T \| ') . 'ID User: ' . Auth::user()->id . ' | Melakukan perubahan data wali kelas | Rombel: ' . $request->kode_rombel . ' dengan Wali Kelas: ' .  $request->kode_rombel;
        $filename = 'Log Wali Kelas - ' . date('Y-m-d') . '.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('homeroom-teacher');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HomeroomTeacher  $homeroomTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeroomTeacher $homeroomTeacher)
    {
        HomeroomTeacher::destroy($homeroomTeacher->id);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data wali kelas ( Rombel: " . $homeroomTeacher->kode_rombel . " , dengan Wali Kelas: " . $homeroomTeacher->kode_rombel . " )";
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log 
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s') . date(' T \| ') . 'ID User: ' . Auth::user()->id . ' | Melakukan perubahan data wali kelas | Rombel: ' . $homeroomTeacher->kode_rombel . ' dengan Wali Kelas: ' .  $homeroomTeacher->kode_rombel;
        $filename = 'Log Wali Kelas - ' . date('Y-m-d') . '.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('homeroom-teacher');
    }
}
