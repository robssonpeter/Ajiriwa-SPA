<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $job_id;
    public $uniqid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($job_id, $uniqid)
    {
        $this->job_id = $job_id;
        $this->uniqid = $uniqid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
