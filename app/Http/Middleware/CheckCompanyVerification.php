<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\Job;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Setting;

class CheckCompanyVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->hasRole('employer'))
        {
            $company = Company::where('original_user', Auth::user()->id)->with('verification', 'verification_attempt')->first();

            $job_count = Job::where('company_id', $company->id)->count();
            

            if($job_count && !$company->verification){
                if($company->verification_attempt && !$company->verification_attempt->verified){
                    $verifying = true;
                    return Inertia::render("Company/Verification", compact('verifying'));
                }
                $verification_documents = Setting::where('key', 'verification_document')->get();
                return Inertia::render("Company/Verification", compact('verification_documents'));
            }

        }
        return $next($request);
    }
}
