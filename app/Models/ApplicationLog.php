<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model
{
    use HasFactory;

    const STATUS_DESCRIPTIONS = [
        1 => [
            'label' => "Applied",
            'color' => 'bg-gray-500'
        ],
        2 => [
            'label' => "Application Rejected",
            'color' => 'bg-red-500'
        ],
        3 => [
            'label' => "Shortlisted",
            'color' => 'bg-blue-500'
        ],
        4 => [
            'label' => "Listed for interview",
            'color' => 'bg-gray-400'
        ],
        5 => [
            'label' => "Interviewed",
            'color' => "bg-gray-500"
        ],
        6 => [
            'label' => "Selected",
            'color' => 'bg-green-500'
        ]
    ];

    protected $fillable = [
        'application_id', 'status', 'user_id'
    ];

    protected $appends = [
        'label', 'description', 'log_date'
    ];

    public function getLogDateAttribute(){
        return Carbon::parse($this->created_at)->format('d M Y, h:i A');
    }

    public function getLabelAttribute(){
        return self::STATUS_DESCRIPTIONS[$this->status]['label']??null;
    }

    public function getDescriptionAttribute(){
        return self::STATUS_DESCRIPTIONS[$this->status]['description']??null;
    }
}
