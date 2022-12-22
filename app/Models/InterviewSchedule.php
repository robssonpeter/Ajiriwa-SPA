<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InterviewSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'date', 'time', 'set_by', 'interview_type', 'done', 'venue', 'notes', 'notified'
    ];

    protected $appends = [
        'formatted_date'
    ];

    public function getFormattedDateAttribute(){
        return Carbon::parse($this->attributes['date'])->format('jS F Y');
    }

    public function application(){
        return $this->belongsTo('App\job_application', 'id', 'application_id');
    }

    public function interview_type(){
        return $this->hasOne('App\interview_type', 'id', 'interview_type');
    }

    public function note(){
        return $this->hasOne('App\interview_note', 'interview_id', 'id');
    }
}
