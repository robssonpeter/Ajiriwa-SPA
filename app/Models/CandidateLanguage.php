<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'candidate_id',
        'listening',
        'speaking',
        'reading',
        'writing'
    ];

    Const Levels = [
        1 => 'Elementary',
        2 => 'Limited',
        3 => 'Professional',
        4 => 'Full Professional',
        5 => 'Native / Bilingual'
    ];

    protected $appends = [
        'rating'
    ];

    public function getRatingAttribute(){
        return ($this->listening + $this->speaking + $this->reading + $this->writing)/4;
    }
}
