<?php

namespace App\Listeners;

use App\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s') . date(' T \| ') . 'ID User: ' . Auth::user()->id . ' | Melakukan Logout';
        $filename = 'Log Logout - ' . date('Y-m-d') . '.log';
        Storage::disk('activityLog')->append($filename, $logActivities);
    }
}
