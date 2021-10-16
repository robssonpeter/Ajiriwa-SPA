<?php

namespace App\Models;

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
        'career_level_id',
        'industry_id',
        'expected_salary',
        'salary_currency',
        'address',
        'immediate_available',
        'professional_title',
        'marital_status',
        'profile_completion',
        'gender',
        'dob',
        'phone'
    ];

    protected $appends = [
        'applied_jobs', 'full_name'
    ];

    protected $with = [
        'user'
    ];


    public function getAppliedJobsAttribute(){
        return JobApplication::where('candidate_id', $this->id)->pluck('job_id');
    }

    public function getFullNameAttribute(){
        return $this->first_name." ".$this->last_name;
    }

    public function applications(){
        return $this->hasMany(JobApplication::class, 'candidate_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
