<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyView extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'viewer_user_id'
    ];
}
