<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! file_exists(storage_path('logs/activity-user'))) {
            return [];
        }

        $page = (int) $request->input('page') ?: 1;
        $logFiles = collect(\File::allFiles(storage_path('logs/activity-user')))->sort(function ($a, $b) {
            return -1 * strcmp($a->getMTime(), $b->getMTime());
        });

        $onPage = 10;

        $slice = $logFiles->slice(($page - 1) * $onPage, $onPage);

        // usort($logFiles, function ($a, $b) {
        //     return -1 * strcmp($a->getMTime(), $b->getMTime());
        // });
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($slice, $logFiles->count(), $onPage);

        return view('log-activity.index', compact('logFiles'))->with('logFiles', $paginator);
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
     * @param  \App\Models\LogActivity  $logActivity
     * @return \Illuminate\Http\Response
     */
    public function show($fileName)
    {
        if (file_exists(storage_path('logs/activity-user/'.$fileName))) {
            $path = storage_path('logs/activity-user/'.$fileName);

            return response()->file($path, ['content-type' => 'text/plain']);
        }

        return 'Invalid file name.';
    }

    public function download($fileName)
    {
        if (file_exists(storage_path('logs/activity-user/'.$fileName))) {
            $path = storage_path('logs/activity-user/'.$fileName);
            $downloadFileName = env('APP_ENV').'.'.$fileName;

            return response()->download($path, $downloadFileName);
        }

        return 'Invalid file name.';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogActivity  $logActivity
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
     * @param  \App\Models\LogActivity  $logActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogActivity $logActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogActivity  $logActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($fileName)
    {
        if (file_exists(storage_path('logs/activity-user/'.$fileName))) {
            Storage::disk('activityLog')->delete($fileName);

            return redirect('log-activity');
        }

        return 'Invalid file name.';
    }
}
