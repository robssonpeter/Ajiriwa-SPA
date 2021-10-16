<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 0;
    const STATUS_APPLIED = 1;
    const REJECTED  = 2;
    const COMPLETE = 5;
    const SHORT_LIST = 3;
    const INTERVIEWED = 4;

    const STATUS = [
        0 => 'Drafted',
        1 => 'Applied',
        2 => 'Rejected',
        3 => 'Shortlisted',
        4 => 'Interviewed',
        5 => 'Selected'
    ];

    protected $fillable = [
        'job_id', 'candidate_id', 'cover_letter', 'status'
    ];

    public function candidate(){
        return $this->hasOne(Candidate::class, 'id', 'candidate_id');
    }

}
