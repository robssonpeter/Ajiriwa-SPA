<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateView extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id', 'viewer_user_id'
    ];
}
