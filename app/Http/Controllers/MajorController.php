<?php

namespace App\Http\Controllers;

use App\Major;
use App\Http\Requests\MajorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use Session;
use DataTables;

class MajorController extends Controller
{
    public function datatable()
    {
        return DataTables::of(Major::all())
            ->addColumn('action', function ($major) {
                return view('layouts.action._action', [
                    'major'       => $major,
                    'url_edit'    => route('major.edit', $major->kode_jurusan),
                    'url_destroy' => route('major.show', $major->kode_jurusan),
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
        return view('major.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('major.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MajorRequest $request)
    {
        $input = $request->all();

        Major::create($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menambahkan data Jurusan: " . $request->nama_jurusan;
        $logActivities->save();

        Session::flash('message', 'Data has been saved!');

        return redirect('major');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        return view('major.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function update(MajorRequest $request, Major $major)
    {
        $input = $request->all();

        $major->update($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Mengubah data Jurusan: " . $request->nama_jurusan;
        $logActivities->save();

        Session::flash('message', 'Data has been updated!');

        return redirect('major');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        Major::destroy($major->kode_jurusan);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menghapus data Jurusan: " . $major->nama_jurusan;
        $logActivities->save();

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('major');
    }
}
