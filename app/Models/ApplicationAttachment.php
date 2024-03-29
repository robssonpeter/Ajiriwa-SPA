<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id', 'certificate_id', 'candidate_id'
    ];
}
