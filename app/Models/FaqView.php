<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqView extends Model
{
    use HasFactory;

    protected $fillable = ['faq_id'];

    // Define the relationship with FrequentAskedQuestion
    public function faq()
    {
        return $this->belongsTo(FrequentlyAskedQuestion::class, 'faq_id');
    }
}
