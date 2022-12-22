<?php

namespace App\Providers;

use App\Events\JobViewed;
use App\Models\JobView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterView
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
     * @param  JobViewed  $event
     * @return void
     */
    public function handle(JobViewed $event)
    {
        $job_id = $event->job_id;
        $uniqid = $event->uniqid;
        JobView::create(['job_id' => $job_id, 'user_id' => $uniqid, 'is_logged' => \Auth::check()]);
    }
}
