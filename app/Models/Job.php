<?php

namespace App\Models;

use App\Custom\Promoter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    use HasFactory;

    CONST STATUS = [
       "Draft", 'Active', 'Paused', 'Closed'
    ];

    protected $fillable = [
        'title',
        'application_email',
        'application_email_cc',
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
        'counted_views',
        'status',
        'location',
        'is_remote',
        'min_salary',
        'max_salary',
        'keywords',
        'application_display_columns',
        'old_id'
    ];

    protected $with = [
        'company', 'type', 'promotion'
    ];

    protected $appends = [
        'applied', 'current_status', 'time_ago', 'promotion_details', 'categorized_jobs', 'closing_time', 'expired'
    ];

    protected $withCount = [
        'applications', 'views', 'clicks'
    ];

    public function views(){
        return $this->hasMany(JobView::class, 'job_id', 'id');
    }

    public function clicks(){
        return $this->hasMany(LinkClick::class, 'job_id', 'id');
    }

    public function getCategorizedJobsAttribute(){
        /* if($this->categories){
            return $this->categoris->pluck('category_id');
        } */
        return null;
    }

    public function getPromotionDetailsAttribute(){
        $prom = new Promoter();
        return [
            'cost_per_click' => $prom->costperclick,
            'cost_per_application' => $prom->costperapplication,
            'cost_per_impression' => $prom->costperimpression,
        ];
    }

    public function getExpiredAttribute(){
        return date('Y-m-d') > $this->deadline;
    }

    public function getClosingTimeAttribute(){
        return Carbon::parse($this->deadline)->diffForHumans();
    }

    public function getTimeAgoAttribute(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getAppliedAttribute(){
        /*if(Auth::check() && Auth::user()->hasRole('candidate')){
            $applied = JobApplication::
        }*/
        return false;
    }

    public function getCurrentStatusAttribute(){
        return self::STATUS[$this->status];
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

    public function Job_screening(){
        return $this->hasMany(JobScreening::class, 'job_id', 'id');
    }

    public function promotion(){
        return $this->hasOne(JobPromotion::class, 'Job_ID', 'id');
    }

    public function categories()
    {
        return $this->hasManyThrough(
            JobCategory::class,
            CategorizedJob::class,
            'job_id', // Foreign key on CategorizedJob table
            'id',      // Local key on Category table
            'id',      // Local key on Job table
            'category_id' // Foreign key on CategorizedJob table
        );
    }
}
