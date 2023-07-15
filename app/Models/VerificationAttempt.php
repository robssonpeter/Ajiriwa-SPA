<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VerificationAttempt extends Model
{
    //
    protected $fillable = [
        'role', 'document', 'company_id', 'verified', 'is_profile_claim', 'user_id'
    ];

    protected $appends = [
        'documents', 'time_ago'
    ];

    protected $with = [
        'rejected'
    ];

    public function getTimeAgoAttribute(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getDocumentsAttribute(){
        return json_decode($this->document);
    }

    public function rejected(){
        return $this->hasOne(CompanyVerificationRejection::class, 'attempt_id', 'id')->orderBy('id', 'DESC');
    }

}

