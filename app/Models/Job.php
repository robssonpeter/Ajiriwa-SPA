<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'application_email',
        'application_url',
        'description',
        'reports_to',
        'job_type',
        'deadline',
        'cover_letter',
        'slug',
        'apply_method',
        'email_subject',
        'company_id',
        'number_of_posts',
        'location'
    ];

    protected $with = [
        'company', 'type'
    ];

    protected $appends = [
        'applied'
    ];

    protected $withCount = [
        'applications'
    ];

    public function getAppliedAttribute(){
        /*if(Auth::check() && Auth::user()->hasRole('candidate')){
            $applied = JobApplication::
        }*/
        return false;
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function applications(){
        return $this->hasMany(JobApplication::class, 'job_id', 'id');
    }

    public function type(){
        return $this->hasOne(JobType::class, 'id', 'job_type');
    }

    /*public function applied(){
        $user = Auth::user();
        if(Auth::check() && $user->hasRole('candidate')){
            return $this->hasOne(JobApplication::class, 'job_id', 'id')
                    ->where('candidate_id', $user->candidate->id);
        }
        return null;
    }*/

}
