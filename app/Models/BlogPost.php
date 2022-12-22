<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'Post', 'Title', 'Summary', 'Views', 'language', 'cover_photo', 'scaled_down_cover', 'keywords'
    ];
}
