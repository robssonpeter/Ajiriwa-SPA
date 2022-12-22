<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreeningResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'job_id', 'type', 'response', 'screening_id'
    ];

    public function job_screening(){
        return $this->belongsTo(JobScreening::class, 'screening_id', 'id');
    }

    public function screening_question(){
        return $this->belongsTo(JobScreening::class, 'screening_id', 'id');
    }
}
