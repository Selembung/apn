<?php

namespace App\Http\Controllers;

use App\LogActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function ajax()
    {
        LogActivity::all();

        return view('log-activity.ajax');
    }

    public function datatable()
    {
        $logActivity = \DB::table('log_activities')
            ->join('users', 'users.id', '=', 'log_activities.user_id')
            ->select('users.role', 'users.name', 'log_activities.*')
            ->get();


        return DataTables::of($logActivity)
            ->addIndexColumn()
            ->addColumn('waktuTerakhir', function ($logActivity) {
                $date = $logActivity->created_at;
                $date = Carbon::parse($date);
                return $date->diffForHumans();
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
        return view('log-activity.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LogActivity  $logActivity
     * @return \Illuminate\Http\Response
     */
    public function show(LogActivity $logActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LogActivity  $logActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(LogActivity $logActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LogActivity  $logActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogActivity $logActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LogActivity  $logActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogActivity $logActivity)
    {
        //
    }
}
