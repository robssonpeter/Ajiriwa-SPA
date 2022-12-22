<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleInterviewEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application_id, $email_body)
    {
        $this->application_id = $application_id;
        $this->email_body = $email_body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = JobApplication::where('id', $this->application_id)->with('candidate', 'job')->first();
        $mail_body = $this->email_body;
        return $this->from('applications@ajiriwa.net', 'Ajiriwa Applications')
                    ->to($application->candidate->email, $application->candidate->full_name)
                    ->subject("Invitation for Interview for  ".$application->job->title)
                    ->view('Mail.interview-invite', compact('mail_body'));
    }
}
