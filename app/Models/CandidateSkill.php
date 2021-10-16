<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateSkill extends Model
{
    use HasFactory;

    const Levels = [
        2 => 'Novice',
        3 => 'Intermediate',
        4 => 'Proficient',
        5 => 'Expert',
    ];

    protected $fillable = [
        'name', 'rating', 'candidate_id'
    ];
}
