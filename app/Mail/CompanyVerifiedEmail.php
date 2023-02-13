<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyVerifiedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company_id, $email_body)
    {
        $this->company_id = $company_id;
        $this->email_body = $email_body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $company = Company::where('id', $this->company_id)->with('user')->first();
        $mail_body = $this->email_body;
        return $this->from('no-reply@ajiriwa.net', 'Ajiriwa Notification')
                    ->to($company->user->email, $company->user->name)
                    ->subject("Verification Complete")
                    ->view('Mail.company-verified', compact('mail_body', 'company'));
    }
}
