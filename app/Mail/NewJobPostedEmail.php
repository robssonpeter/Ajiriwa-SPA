<?php

namespace App\Mail;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewJobPostedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $job_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job_id)
    {
        //
        $this->job_id = $job_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $job = Job::find($this->job_id);
        return $this->subject('New job posted at ajiriwa')->view('Mail.job-posted', compact('job'));
    }
}
