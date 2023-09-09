<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'reference_number', 'email', 'transaction_type', 'transaction_tracking_id',
        'status', 'redeemed', 'amount', 'currency', 'description', 'attempted'
    ];
}
