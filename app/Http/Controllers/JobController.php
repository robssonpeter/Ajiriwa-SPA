<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{
    public function browse(){
        $jobs = Job::orderBy('id', 'DESC')->limit(15)->get();
        return Inertia::render('Jobs', [
           'jobs' => $jobs,
           'count' => $jobs->count()
        ]);
    }

    public function viewJob($slug){
        //dd($slug);
        return Inertia::render('ViewJob', [
            'data' => [],
            'slug' => $slug
        ]);
    }

    public function saveJob(Request $request){
        $data = $request->all();
        $data['slug'] = makeSlug($data['title']).'-'.uniqid();
        $saved = Job::create($data);
        return $saved;
    }

    public function sendApplication(){
        $data = request()->all();
        $applied = JobApplication::create($data);
        return $applied;
    }

}
