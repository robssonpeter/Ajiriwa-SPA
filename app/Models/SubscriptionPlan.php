<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'level', 'user_type', 'price'
    ];

    protected $with = [
        "contents"
    ];

    public function contents(){
        return $this->hasMany(SubscriptionContent::class, 'plan_id', 'id');
    }
}
