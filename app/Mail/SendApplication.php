<?php

namespace App\Mail;

use App\Models\CandidateSkill;
use App\Models\JobApplication;
use App\Models\User;
use App\Repositories\ResumeRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendApplication extends Mailable
{
    use Queueable, SerializesModels;

    public $application_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application_id)
    {
        $this->application_id = $application_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = JobApplication::where('id', $this->application_id)->with('candidate', 'job')->first();

        $candidate = $application->candidate;
        $skills = CandidateSkill::Levels;
        $user = User::find($candidate->user_id);
        $file_name = makeSlug($candidate->full_name)."-".$candidate->id."-cv.pdf";
        //$pdf = Pdf::loadView('CvTemplates.material', compact('candidate', 'skills', 'user'));
        // check if there is https connection if yes then we use the wkhtml to render cv
        $url = route('root');
        //if (str_contains($url, 'https:')){
            ResumeRepository::renderCV($candidate->id, 'render');
        //}
        //$pdf->save(public_path('temp-files/'.$file_name));
        $email = $this->from('applications@ajiriwa.net', 'Ajiriwa Applications')
                    ->replyTo($application->candidate->email, $application->candidate->full_name);
        $email = $email->attach(public_path('temp-files/'.$file_name), [
            'as' => makeSlug($candidate->full_name)."-cv.pdf"
        ]);
        foreach($application->attachments as $attachment){
            $extension = explode(',', $attachment->media_url);
            $email = $email->attach($attachment->media->getFullUrl(), [
                'as' => $attachment->name.".".$extension[count($extension) - 1],
            ]);
        }
        $cc = json_decode($application->job->application_email_cc);
        if(is_array($cc) && count($cc)){
            foreach($cc as $cc_email){
                $email = $email->cc($cc_email);
            }
        }
        $subject = $application->job->email_subject??'Application for '.$application->job->title;
        return $email->subject($subject)->with([
            'application' => $application
        ])->view('Mail.application');
    }
}
