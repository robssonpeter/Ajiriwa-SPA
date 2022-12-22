<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 0;
    const STATUS_APPLIED = 1;
    const REJECTED  = 2;
    const SELECTED = 6;
    const SHORT_LIST = 3;
    const INTERVIEW_SCHEDULED = 4;
    const INTERVIEWED = 5;

    const STATUS = [
        0 => 'Drafted',
        1 => 'Applied',
        2 => 'Rejected',
        3 => 'Shortlisted',
        4 => 'To be interviewed',
        5 => 'Interviewed',
        6 => 'Selected',
    ];


    protected $fillable = [
        'job_id', 'candidate_id', 'cover_letter', 'status'
    ];

    protected $appends  = [
        'applied_on', 'application_date', 'application_date_time','application_status', 'current_status'
    ];

    protected $with = [
        'attachments'
    ];

    public function getCurrentStatusAttribute(){
        return self::STATUS[$this->status]??'';
    }

    public function getApplicationStatusAttribute(){
        return self::STATUS[$this->status] ?? self::STATUS[self::STATUS_APPLIED];
    }

    public function getApplicationDateTimeAttribute(){
        $date = Carbon::parse($this->created_at);
        return $date->format('d M Y, h:i A');
    }

    public function getApplicationDateAttribute(){
        $date = Carbon::parse($this->created_at);
        return $date->format('jS F Y');
    }

    public function getAppliedOnAttribute(){
        return Carbon::parse(($this->created_at))->format('F j, Y');
    }

    public function candidate(){
        return $this->hasOne(Candidate::class, 'id', 'candidate_id')->join('users', 'users.id', 'candidates.user_id')->select('candidates.*', 'users.email');
    }

    public function attachments(){
        return $this->hasManyThrough(CandidateCertificate::class, ApplicationAttachment::class, 'job_application_id', 'id', 'id', 'certificate_id');
    }

    public function job(){
        return $this->belongsTo(Job::class );
    }

    public function logs(){
        return $this->hasMany(ApplicationLog::class, 'application_id', 'id');
    }

    public function user() {
        return $this->hasOneThrough(User::class, Candidate::class, 'id', 'id', 'candidate_id', 'user_id');
    }

    public function company(){
        return $this->hasOneThrough(Company::class, Job::class, 'id', 'id', 'job_id', 'company_id');
    }

    public function screening_responses(){
        return $this->hasMany(ScreeningResponse::class, 'application_id', 'id')->join('job_screenings', 'job_screenings.id', 'screening_responses.screening_id')->select('screening_responses.*', 'job_screenings.question');
    }

    public function schedule(){
        return $this->hasOne(InterviewSchedule::class, 'application_id', 'id');
    }
    
    public function interview(){
        return $this->hasOne(InterviewSchedule::class, 'application_id', 'id');
    }

    public function interview_type(){
        return $this->hasOneThrough('App\interview_type', 'App\interview_schedule', 'interview_type', 'id', 'id');
    }
}
