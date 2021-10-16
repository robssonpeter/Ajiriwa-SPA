<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateReferee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'company',
        'email',
        'phone',
        'postal_address',
        'candidate_id'
    ];
}
