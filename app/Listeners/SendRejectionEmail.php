<?php

namespace App\Listeners;

use App\Events\ApplicationRejected;
use App\Mail\ApplicationRejectionEmail;
use App\Models\EmailTemplate;
use App\Models\JobApplication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendRejectionEmail
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
     * @param  \App\Providers\App\Events\ApplicationRejected  $event
     * @return void
     **/
    public function handle(ApplicationRejected $event)
    {
        $application = JobApplication::where('id', $event->application_id)->with('company', 'user')->first();
        $template = EmailTemplate::where(function($q) use($application){
            return $q->where('type', 'application_rejection')->where('company_id', $application->company->id)->where('is_default', true);
        })->orWhere(function($q) {
            return $q->whereNull('company_id')->where('type', 'application_rejection');
        })->orderBy('ID', 'DESC')->first(); 

        $mailContent = EmailTemplate::renderTemplate($event->application_id, $template->id);

        // if scheduled 
        //return $mailContent;


        // send instantly
        return Mail::to($application->user)->send(new ApplicationRejectionEmail($application->id, $mailContent));
    }
}
