<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id', 'job_id'
    ];

    protected $with = [
        'job'
    ];

    public function job(){
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}
