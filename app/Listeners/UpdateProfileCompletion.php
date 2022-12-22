<?php

namespace App\Listeners;

use App\Events\ProfileUpdated;
use App\Repositories\CandidateRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateProfileCompletion
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
    public function handle(ProfileUpdated $event)
    {
        CandidateRepository::profileCompletion($event->user_id);
    }
}
