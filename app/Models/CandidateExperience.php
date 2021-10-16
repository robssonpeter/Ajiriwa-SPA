<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id', 'title', 'company', 'country_id', 'start_date', 'end_date', 'currently_working', 'description'
    ];

    protected $appends = [
        'saving'
    ];

    public function getSavingAttribute(){
        return false;
    }

}
