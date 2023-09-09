<?php

namespace App\Models;

use App\Http\Controllers\CandidateController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * Class Candidate
 * @property-read Industry|null $industry
 * @property-read MaritalStatus $maritalStatus
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read User $user
 * @property-read mixed $candidate_url
 */

class Candidate extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaTrait;

    const CERTIFICATE_PATH = 'certifications';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'nationality',
        'career_objective',
        'career_level_id',
        'industry_id',
        'expected_salary',
        'salary_currency',
        'address',
        'immediate_available',
        'professional_title',
        'marital_status',
        'logo',
        'profile_completion',
        'gender',
        'dob',
        'phone',
        'slug',
    ];

    protected $appends = [
        'applied_jobs', 'full_name', 'email', 'dob_formatted', 'logo_url'
    ];

    protected $with = [
        'sex', 'marital'
    ];

    public function getLogoUrlAttribute(){
        $media_id = $this->logo;
        if($media_id){
            return asset(Media::find($media_id)->getUrl());
        }
        return asset('/images/no-profile-pic.png');
    }

    public function marital(){
        return $this->hasOne(MaritalStatus::class, 'id', 'marital_status');
    }

    public function getDobFormattedAttribute(){
        return Carbon::parse($this->dob)->format('dS F Y');
    }

    public function getEmailAttribute(){
        $user = User::where('id', $this->user_id)->pluck('email');
        return $user ? $user[0] : null;
    }

    public function sex(){
        return $this->hasOne(Gender::class, 'id', 'gender');
    }

    /*public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }*/

    public function getAppliedJobsAttribute(){
        return JobApplication::where('candidate_id', $this->id)->pluck('job_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name." ".$this->last_name;
    }

    public function applications(){
        return $this->hasMany(JobApplication::class, 'candidate_id', 'id');
    }

    public function certificates(){
        return $this->hasMany(CandidateCertificate::class, 'candidate_id', 'id');
    }

    public function education(){
        return $this->hasMany(CandidateEducation::class, 'candidate_id', 'id');
    }

    public function experiences(){
        return $this->hasMany(CandidateExperience::class, 'candidate_id', 'id');
    }

    public function languages(){
        return $this->hasMany(CandidateLanguage::class, 'candidate_id', 'id');
    }

    public function referees(){
        return $this->hasMany(CandidateReferee::class, 'candidate_id', 'id');
    }

    public function skills(){
        return $this->hasMany(CandidateSkill::class, 'candidate_id', 'id')->orderBy('rating', 'DESC');
    }
}
