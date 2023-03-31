<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'keywords'
    ];

    


    public function active_jobs(){
        return $this->hasManyThrough(Job::class, AssignedJobCategory::class, 'category_id', 'id', 'id', 'job_id')->where('deadline', '>=', date('Y-m-d'));
    }
}
