<?php

namespace App\Listeners;

use App\Events\ApplicationStatusUpdated;
use App\Models\ApplicationLog;

class RecordApplicationLog
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
     * @param  \App\Events\ApplicationStatusUpdated  $event
     * @return void
     */
    public function handle(ApplicationStatusUpdated $event)
    {
        $data = [
            'application_id' => $event->application_id,
            'status' => $event->status,
            'label' => '',
            'description' => '',
            'user_id' => $event->user_id
        ];
        ApplicationLog::create($data);
    }
}
