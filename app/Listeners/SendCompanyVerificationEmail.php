<?php

namespace App\Listeners;

use App\Events\ApplicationRejected;
use App\Events\CompanyVerified;
use App\Events\InterviewScheduled;
use App\Mail\ApplicationRejectionEmail;
use App\Mail\CompanyVerifiedEmail;
use App\Mail\ScheduleInterviewEmail;
use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\JobApplication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendCompanyVerificationEmail
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
     * @param  \App\Providers\App\Events\CompanyVerified  $event
     * @return void
     **/
    public function handle(CompanyVerified $event)
    {
        $company = Company::with('user')->where('id', $event->company_id)->first();

        return Mail::to($company->user)->send(new CompanyVerifiedEmail($event->company_id, ''));
    }
}
