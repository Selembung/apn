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
        LogActivity::create([
            'user_id'        => Auth::user()->id,
            'activity_name'  => "Melakukan Logout",
        ]);
    }
}
