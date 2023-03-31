<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "payer_name", "reference_number", "description", "amount", "tracking_id", "status", "executed", "user_id"
    ];
}
