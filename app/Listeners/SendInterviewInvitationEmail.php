<?php

namespace App\Listeners;

use App\Events\ApplicationRejected;
use App\Events\InterviewScheduled;
use App\Mail\ApplicationRejectionEmail;
use App\Mail\ScheduleInterviewEmail;
use App\Models\EmailTemplate;
use App\Models\JobApplication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendInterviewInvitationEmail
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
     * @param  \App\Providers\App\Events\InterviewScheduled  $event
     * @return void
     **/
    public function handle(InterviewScheduled $event)
    {
        $application = JobApplication::where('id', $event->application_id)->with('company', 'user')->first();
        $template = EmailTemplate::where(function($q) use($application){
            return $q->where('type', 'interview_schedule')->where('company_id', $application->company->id)->where('is_default', true);
        })->orWhere(function($q) {
            return $q->whereNull('company_id')->where('type', 'interview_schedule');
        })->orderBy('ID', 'DESC')->first(); 

        $mailContent = EmailTemplate::renderTemplate($event->application_id, $template->id);

        // if scheduled 
        //return $mailContent;


        // send instantly
        return Mail::to($application->user)->send(new ScheduleInterviewEmail($application->id, $mailContent));
    }
}
