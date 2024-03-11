<?php

namespace App\Listeners;

use App\Models\Job;
use App\Models\QueuedEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewJobNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // create an entry in the queued_emails table
        $data = [
            'class' => 'App\Mail\NewJobPostedEmail',
            'parameters' => json_encode([
                'job_id' => $event->job_id
            ]),
        ];
        QueuedEmail::updateOrCreate($data, $data);
    }
}
