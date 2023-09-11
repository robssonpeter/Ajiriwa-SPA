<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjiriwaBalanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'description', 'change_type', 'amount'
    ];
}
