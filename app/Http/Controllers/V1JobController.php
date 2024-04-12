<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\JobType;
use DB;
use Exception;
use Illuminate\Http\Request;

class V1JobController extends Controller
{
    public function postJob(Request $request){
        try{
            DB::beginTransaction();
            // get the data from the request
            $data = $request->validate([
                'title' => 'required|string',
                'location' => 'required|string',
                'deadline' => 'required|date',
                'description' => 'required|string',
                'job_type' => 'required|string',
            ]);
            //dd('hello there');
            $company = session()->get('client');
            // create a slug for the job
            $slug = makeSlug($request->JobTitle).'-'.uniqid();
            $data['slug'] = $slug;
            // resolve the job type 
            $job_type_array = explode('-', $data['job_type']); 
            $job_type = JobType::where('id', '>', 0);
            foreach($job_type_array as $type){
                $job_type = $job_type->where('name', 'like', '%'.$type.'%');
            }
            $job_type = $job_type->first();
            $data['job_type'] = $job_type->id;
            // get the url from where the request is coming from
            $url = $request->header('Origin') ? $request->header('Origin') : $request->header('Referer');
            // check if the company exists if not create it
            $existing_company = Company::where('name', $company->name)->first();
            // if it does not exist create it
            if (!$existing_company){
                $existing_company = Company::create([
                    'name' => $company->name,
                    'slug' => makeSlug($company->name)
                ]);
            }
            // remove the script tags from the description
            $data['description'] = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $data['description']);
            // create the job
            $data['company_id'] = $existing_company->id;
            $data['apply_method'] = 'url';
            $data['status'] = 1;
            //$data['application_url'] = 
            $posted = Job::create($data);
            $response = [
                'status' => 'passed',
                'job' => $posted,
                'url' => route('job.view', $posted->slug)
            ];
            DB::commit();
            return response()->json($response);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
        }
        
    }

    /**
     * End point for remotely deleting a job
     * expects header ```job_slug, clk```
     */
    public function deleteJob(){
        // get the job_slug from the job_slug header
        $job_slug = request()->header('job_slug');
        $job = Job::where('slug', $job_slug)->first();
        // verify that the job was posted by who is trying to delete it
        $company = Company::where('id', $job->company_id)->first();
        // find the company name from the clk header
        $company_key = request()->header('clk');
        $client = DB::connection('clients')->table('clients')->where('hashslug', $company_key)->first();
        if($company->name == $client->name){
            $job->delete();
            return response()->json([
                'status' => 'passed'
            ]);
        }else{
            return response()->json([
                'status' => 'failed',
                'error' => 'Client mismatch',
            ]);
        }
    }
}
