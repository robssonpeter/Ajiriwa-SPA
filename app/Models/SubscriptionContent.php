<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ### Subscription Content
 * This contains the contents of a subscription containts fields such as **name** and **value**. The name field
 * hold the name of the subscription content and the value represent how much of the subscription content
 * is allowed ```eg $subscription = 5```
 */
class SubscriptionContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'value', 'plan_id', 'label'
    ];
}
