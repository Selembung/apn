<?php

namespace App\Listeners;

use App\LogActivity;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s') . date(' T \| ') . 'ID User: ' . Auth::user()->id . ' | Melakukan Login';
        $filename = 'LogLogin - ' . date('Y-m-d') . '.log';
        Storage::disk('activityLog')->append($filename, $logActivities);
    }
}
