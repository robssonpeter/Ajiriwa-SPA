<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'name',
        'website',
        'location',
        'primary_email',
        'description',
        'tin_number',
        'logo',
        'ajiriwa_balance',
        'hires_per_year',
        'source',
        'type',
        'original_user',
        'page_views'
    ];
}
