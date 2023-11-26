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
    public $job_id;
    public $uniqid;
    public function __construct($job_id, $uniqid)
    {
        $this->job_id = $job_id;
        $this->uniqid = $uniqid;
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
