<?php


namespace App\Repositories;


use App\Events\ProfileUpdated;
use App\Models\Candidate;
use App\Models\CandidateCertificate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateReferee;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SubscriptionRepository
{
    public static function currentPlan($user_id){
        $user = User::where('id', $user_id)->first();
        //dd($user);
        if(!is_null($user->subscription_end_date) && Carbon::parse($user->subscription_end_date) < Carbon::now()){
            $plan = SubscriptionPlan::where('id', $user->subscription_id)->first();
        }else if(is_null($user->subscription_id)){
            // fall back to the plan free tier plan
            $plan = SubscriptionPlan::where('user_type', $user->role)->where('level', 1)->first();
        }else{
            $plan = SubscriptionPlan::where('id', $user->subscription_id)->first();
        }
        return $plan;
    }
}
