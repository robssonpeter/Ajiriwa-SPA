<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function initialInformation(){
        $company = Company::where('original_user', \Auth::user()->id)->first();
        $user = User::find(\Auth::user()->id);
        return Inertia::render('Company/InitialInfo', [
            'company' => $company,
            'user' => $user
        ]);
    }

    public function saveInitialInformation(){
        $company = request()->company;
        $userData = request()->user;

        // update company information
        $update = Company::where('original_user', \Auth::user()->id)->update($company);
        // update user information
        $userUpdate = User::where('id', \Auth::user()->id)->update($userData);
        return 1;
    }

    public function customize(){
        return Inertia::render('Company/Customize', [

        ]);
    }

    public function dashboard(){
        return Inertia::render('Company/Dashboard', [

        ]);
    }

    public function postJob(){
        $categories = JobCategory::orderBy('name', 'DESC')->get();
        $jobTypes = JobType::all();
        $company = Company::where('original_user', \Auth::user()->id)->first();
        return Inertia::render('Company/Jobs/Post', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'company' => $company
        ]);
    }

    public function viewJob($slug){
        $job = Job::where('slug', $slug)->first();
        return Inertia::render('Company/Jobs/View', [
            'job' => $job
        ]);
    }

    public function showJobs(){
        $user = \Auth::user();
        $jobs = Job::where('company_id', $user->company->id)->get();
        return Inertia::render('Company/Jobs/Index', [
            'jobs' => $jobs
        ]);
    }

    public function jobApplications($slug){
        $company = Company::where('original_user', \Auth::user()->id)->first();
        $job = Job::where('slug', $slug)->where('company_id', $company->id)->first();
        $applications = JobApplication::where('job_id', $job->id)->with('candidate')->get();
        //dd($applications);
        if(!$job){
            abort(404);
        }
        dd($applications);
        return Inertia::render('Company/Jobs/Applications', [
            'job' => $job,
            'applications' => $applications
        ]);
    }

    public function jobApplication($slug, $application_id){
        $job = Job::where('slug', $slug)->first();
        $application = JobApplication::where('id', $application_id)->where('job_id', $slug)->with('candidate')->first();
        return Inertia::render('Company/Jobs/Applicant', [
            'application' => $application,
        ]);
    }
}
