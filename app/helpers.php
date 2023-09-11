<?php

use App\Models\AjiriwaBalanceLog;
use App\Models\User;
use App\Models\Job;

function getFileName($fileName, $attachment)
{
    $fileNameExtension = $attachment->getClientOriginalExtension();
    $newName = $fileName.'-'.time();

    return $newName.'.'.$fileNameExtension;
}

function greet(){
    $hour = \Carbon\Carbon::now()->format('H');
    if ($hour < 12) {
        return 'Good morning';
    }
    if ($hour < 17) {
        return 'Good afternoon';
    }
    return 'Good evening';
}

function makeSlug($text, $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function unitSeparator($product_id, $quantity){

    $output_array = [];
    $unitRelations = [
        'carton' => 20,
        'nusu-carton' => 10,
        'robo-carton' => 5,
        'pc' => 1,
    ];
    // define a remainder and assign the initial value as the quantity
    $remainder = $quantity;
    $keys = array_keys($unitRelations);
    $x = 0;
    while($remainder > 0){
        $current_unit = $unitRelations[$keys[$x]];
        // excute the below if only the remainder is greater or equal to the current unit
        if($remainder >= $current_unit){
            $current_qty = (int) ($remainder/$current_unit);
            $remainder = $remainder % $current_unit;
            // if the current qty is greater than 0 add it to the output array
            if($current_qty){
                $output_array[] = $current_qty." ".$keys[$x];
            }
        }
        $x++;
    }
    return implode(' ', $output_array);
}

function activeJobs($company_id){
    return Job::where('company_id', $company_id)->where('deadline', '>=', date('Y-m-d'))->where('status', 1)->count();
}

function userMenu(){
    if(Auth::check()){
        if(Auth::user()->role == 'candidate'){
            return [
                ['name' => 'Dashboard', 'link' => route('dashboard')],
                ['name' => 'My Profile', 'link' => route('my-resume')],
                ['name' => 'My Applications', 'link' => route('my-applications')],
            ];
        }else if (Auth::user()->hasRole('employer')){
            return [
                ['name' => 'Dashboard', 'link' => route('dashboard')],
                ['name' => 'Post A Job', 'link' => route('company.post-job')],
                ['name' => 'Manage Jobs', 'link' => route('company.jobs.index')],
                ['name' => 'Search Candidates', 'link' => route('company.candidates.search')],
            ];
        }else{
            return [];
        }
    }else{
        return [];
    }
}

/**
 * Undocumented function
 *
 * @param number $amount amount to be charged
 * @param string $change_type change type if + or -
 * @param integer $user_id id of the user who is to charged
 * @return void
 */
function chargeAjiriwaBalance($amount, $change_type, $user_id, $description=""){
    if ($change_type == '+') {
        $charged = User::where('id', $user_id)->increment('ajiriwa_balance', $amount);
    }else {
        $charged = User::where('id', $user_id)->decrement('ajiriwa_balance', $amount);
    }
    if ($charged){
        // record the entry in to ajiriwa_balance_logs table
        $entry = [
            'user_id' => $user_id, 
            'description' => $description, 
            'change_type' => $change_type,
            'amount' => $amount,
        ];
        AjiriwaBalanceLog::create($entry);
    }
    return $charged;
}
