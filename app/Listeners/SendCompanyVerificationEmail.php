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
        $message = "<p>Dear ".$company->name.",</p>
        <p>We hope this email finds you well. We are thrilled to inform you that your account on the Ajiriwa Net platform has been successfully verified! Thank you for submitting the necessary verification documents promptly. We appreciate your cooperation throughout the verification process.</p>
        <p>As a verified member of Ajiriwa Net, you now have access to the full range of features and benefits offered by our platform. You can confidently proceed to post jobs and connect with potential candidates, knowing that your account carries a verified tick, which enhances your credibility and trustworthiness.</p>
        <p>At Ajiriwa Net, we strive to provide an exceptional experience for both employers and job seekers. By joining our platform, you gain access to a vast talent pool and a user-friendly interface designed to simplify the hiring process. We are committed to helping you find the perfect fit for your company's requirements.</p>
        <p>We encourage you to explore the various features available to you, such as advanced job posting options, candidate search filters, and seamless communication tools. Our dedicated support team is always ready to assist you with any inquiries or concerns you may have along the way.</p>
        <p>Once again, welcome to Ajiriwa Net! We are excited to have you on board and look forward to assisting you in finding the ideal candidates for your organization. Should you need any guidance or have any questions, please don't hesitate to reach out to our support team at <a href='mailto:support@ajiriwa.net' target='_new'>support@ajiriwa.net</a>.</p>
        <p>Best regards,</p>
        <p>Ajiriwa.net Team</p>";

        return Mail::to($company->user)->send(new CompanyVerifiedEmail($event->company_id, $message));
    }
}
