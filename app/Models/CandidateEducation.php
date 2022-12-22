<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateEducation extends Model
{
    use HasFactory;

    public $fillable = [
        'candidate_id',
        'degree_level_id',
        'degree_title',
        'country_id',
        'institute',
        'result',
        'year',
        'start_year',
        'currently_studying',
        'description'
    ];

    protected $appends = [
        'saving', 'country'
    ];

    public function getSavingAttribute(){
        return false;
    }

    public function getCountryAttribute(){
        if($this->country_id){
            return country($this->country_id)->getName();
        }
        return '';
    }
}
