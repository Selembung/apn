<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Http\Requests\AcademicYearRequest;
use App\Models\LogActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;

class AcademicYearController extends Controller
{
    public function datatable()
    {
        return DataTables::of(AcademicYear::all())
            ->addColumn('action', function ($academicYear) {
                return view('layouts.action._action', [
                    'academicYear' => $academicYear,
                    'url_edit'     => route('academic-year.edit', $academicYear->kode_tahun_akademik),
                    'url_destroy'  => route('academic-year.show', $academicYear->kode_tahun_akademik),
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
        return view('academic-year.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academic-year.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademicYearRequest $request)
    {
        $input = $request->all();

        AcademicYear::create($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data tahun akademik: " . $request->tahun_akademik;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data tahun akademik: '.$request->tahun_akademik;
        $filename = 'Log Tahun Akademik - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('academic-year');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $academicYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('academic-year.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(AcademicYearRequest $request, AcademicYear $academicYear)
    {
        $input = $request->all();

        $academicYear->update($input);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data tahun akademik: " . $request->tahun_akademik;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data tahun akademik: '.$request->tahun_akademik;
        $filename = 'Log Tahun Akademik - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('academic-year');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicYear $academicYear)
    {
        AcademicYear::destroy($academicYear->kode_tahun_akademik);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data tahun akademik: " . $academicYear->tahun_akademik;
        // $logActivities->save();

        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data tahun akademik: '.$academicYear->tahun_akademik;
        $filename = 'Log Tahun Akademik - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('academic-year');
    }
}
