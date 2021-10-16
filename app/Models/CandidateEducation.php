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
        'saving'
    ];

    public function getSavingAttribute(){
        return false;
    }
}
