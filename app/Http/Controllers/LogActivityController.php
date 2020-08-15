<?php

namespace App\Http\Controllers;

use App\LogActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogActivityController extends Controller
{
    // public function ajax()
    // {
    //     LogActivity::all();

    //     return view('log-activity.ajax');
    // }

    // public function datatable()
    // {
    //     $logActivity = \DB::table('log_activities')
    //         ->join('users', 'users.id', '=', 'log_activities.user_id')
    //         ->select('users.role', 'users.name', 'log_activities.*')
    //         ->get();


    //     return DataTables::of($logActivity)
    //         ->addIndexColumn()
    //         ->addColumn('waktuTerakhir', function ($logActivity) {
    //             $date = $logActivity->created_at;
    //             $date = Carbon::parse($date);
    //             return $date->diffForHumans();
    //         })
    //         ->make(true);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!file_exists(storage_path('logs/activity-user'))) {
            return [];
        }

        $logFiles = \File::allFiles(storage_path('logs/activity-user'));
        usort($logFiles, function ($a, $b) {
            return -1 * strcmp($a->getMTime(), $b->getMTime());
        });

        return view('log-activity.index', compact('logFiles'));
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
    public function show($fileName)
    {
        if (file_exists(storage_path('logs/activity-user/' . $fileName))) {
            $path = storage_path('logs/activity-user/' . $fileName);

            return response()->file($path, ['content-type' => 'text/plain']);
        }
        $path = storage_path('logs/activity-user/' . $fileName);
        return response()->file($path, ['content-type' => 'text/plain']);
        return 'Invalid file name.';
    }

    public function download($fileName)
    {
        if (file_exists(storage_path('logs/activity-user/' . $fileName))) {
            $path = storage_path('logs/activity-user/' . $fileName);
            $downloadFileName = env('APP_ENV') . '.' . $fileName;

            return response()->download($path, $downloadFileName);
        }

        return 'Invalid file name.';
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
