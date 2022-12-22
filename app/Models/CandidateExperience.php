<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id', 'title', 'company', 'country_id', 'start_date', 'end_date', 'currently_working', 'description'
    ];

    protected $appends = [
        'saving', 'start_date_formatted', 'end_date_formatted', 'country', 'duration'
    ];

    public function getDurationAttribute(){
        $start_date = $this->start_date;
        $end_date = $this->currently_working ? date('Y-m-d') : $this->end_date;
        $carbonStart = Carbon::parse($start_date);
        $carbonEnd = Carbon::parse($end_date);
        return $carbonStart->diffForHumans($carbonEnd, true);
    }

    public function getCountryAttribute(){
        if($this->country_id){
            return country($this->country_id)->getName();
        }
        return '';
    }

    public function getSavingAttribute(){
        return false;
    }

    public function getStartDateFormattedAttribute(){
        if($this->start_date){
            return Carbon::parse($this->start_date)->format('M, Y');
        }
        return null;
    }

    public function getEndDateFormattedAttribute(){
        if($this->end_date){
            return Carbon::parse($this->end_date)->format('M, Y');
        }
        return null;
    }
}
