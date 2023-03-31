<?php

namespace App\Http\Controllers;

use App\Models\AjiriwaTransaction;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Repositories\SubscriptionRepository;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function Packages(){
        $user = Auth::user();
        $plans = SubscriptionPlan::where('user_type', $user->role)->get();
        $current_plan = SubscriptionRepository::currentPlan($user->id);
        $currency = 'Tshs. ';
        return Inertia::render("Company/SelectSubscriptionPlan", compact('plans', 'currency', 'current_plan'));
    }

    public function CurrentBalance(){
        $user = User::find(Auth::user()->id);
        return $user->ajiriwa_balance;
    }

    public function Charge(){
        $amount = request()->amount;
        $plan_id = request()->plan_id;
        // create transaction details from the table
        $transaction = [
            'user_id' => Auth::user()->id, 
            'type' => "-", 
            'description' => "", 
            'plan_id' => $plan_id, 
            'amount' => $amount,
        ];
        $created = AjiriwaTransaction::create($transaction);
        // decrement the amount from the users table
        if($created){
            User::where('id', Auth::user()->id)->decrement('ajiriwa_balance', $amount);
            User::where('id', Auth::user()->id)->update(['subscription_id' => $plan_id]);
        }
        return $created;
    }
}
