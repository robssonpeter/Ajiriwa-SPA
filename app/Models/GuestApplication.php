<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'username', 'full_name', 'cover_letter'
    ];
}
