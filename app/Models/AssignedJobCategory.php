<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedJobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'job_id'
    ];
}