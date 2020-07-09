<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaliKelasRequest;
use App\Rombel;
use App\WaliKelas;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use DataTables;
use Session;

class WaliKelasController extends Controller
{
    public function datatable()
    {
        $wk = \DB::table('homeroom_teachers')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->get();

        return DataTables::of($wk)
            ->addColumn('action', function ($wk) {
                return view('layouts.action._action', [
                    'waliKelas'   => $wk,
                    'url_edit'    => route('wali-kelas.edit', $wk->id),
                    'url_destroy' => route('wali-kelas.show', $wk->id),
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
        return view('wali-kelas.index');
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

        return view('wali-kelas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WaliKelasRequest $request)
    {
        $input = $request->all();

        WaliKelas::create($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menambahkan data wali kelas ( Rombel: " . $request->kode_rombel . " , dengan Wali Kelas: " . $request->kode_rombel;
        $logActivities->save();

        Session::flash('message', 'Data has been saved!');

        return redirect('wali-kelas');
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
    public function edit($id)
    {
        $wk = WaliKelas::findOrFail($id);

        $data['teacher'] = Teacher::pluck('nama', 'kode_guru');
        $data['rombel']  = Rombel::pluck('nama_rombel', 'kode_rombel');

        return view('wali-kelas.edit', compact('wk'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WaliKelasRequest $request, $id)
    {
        $wk = WaliKelas::findOrFail($id);

        $input = $request->all();

        $wk->update($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Mengubah data wali kelas ( Rombel: " . $request->kode_rombel . " , dengan Wali Kelas: " . $request->kode_rombel;
        $logActivities->save();

        Session::flash('message', 'Data has been updated!');

        return redirect('wali-kelas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wk = WaliKelas::findOrFail($id);
        $wk->delete();

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menghapus data wali kelas ( Rombel: " . $wk->kode_rombel . " , dengan Wali Kelas: " . $wk->kode_rombel;
        $logActivities->save();

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('wali-kelas');
    }
}
