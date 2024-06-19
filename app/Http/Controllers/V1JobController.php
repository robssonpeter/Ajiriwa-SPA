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
                'application_url' => 'required|string',
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
        // find the company name from the clk header
        $company_key = request()->header('clk');
        $client = DB::connection('clients')->table('clients')->where('hashslug', $company_key)->first();
        // verify that the job was posted by who is trying to delete it        
        if($job->company->name == $client->name){
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


    /**
     * Updates a job with the provided data.
     *
     * @param Request $request The HTTP request object containing the job data.
     *                        The request should have the following headers:
     *                        - job_slug: The slug of the job to update.
     *                        - clk: The company key of the company posting the job.
     *                        The request should have the following data:
     *                        - title: The title of the job (optional).
     *                        - location: The location of the job (optional).
     *                        - deadline: The deadline of the job (optional).
     *                        - description: The description of the job (optional).
     *                        - job_type: The job type of the job (optional).
     *                        - application_url: The application URL of the job (optional).
     * @throws Exception If the job slug is not provided, if the job is not found,
     *                   if the company is not found, if the company key is not provided,
     *                   if the client mismatches, if the job type is not found,
     *                   or if there is an error updating the job.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the status,
     *                                       the updated job, and the URL to view the job.
     */
    public function updateJob(Request $request)
    {
        try {
            DB::beginTransaction();

            // get the job_slug from the job_slug header
            $job_slug = $request->header('job_slug')??$request->job_slug;
            if (!$job_slug) {
                throw new Exception("Job slug is required.");
            }

            $job = Job::where('slug', $job_slug)->first();
            if (!$job) {
                throw new Exception("Job not found.");
            }

            // verify that the job was posted by who is trying to update it
            $company = Company::find($job->company_id);
            if (!$company) {
                throw new Exception("Company not found.");
            }

            // find the company name from the clk header
            $company_key = $request->header('clk');
            if (!$company_key) {
                throw new Exception("Company key is required.");
            }

            $client = DB::connection('clients')->table('clients')->where('hashslug', $company_key)->first();
            if (!$client || $company->name != $client->name) {
                throw new Exception("Client mismatch.");
            }

            // Validate incoming data
            $data = $request->validate([
                'title' => 'sometimes|required|string',
                'location' => 'sometimes|required|string',
                'deadline' => 'sometimes|required|date',
                'description' => 'sometimes|required|string',
                'job_type' => 'sometimes|required|string',
                //'application_url' => 'sometimes|required|url',
            ]);

            // Update job type if provided
            if (isset($data['job_type'])) {
                $job_type_array = explode('-', $data['job_type']);
                $job_type = JobType::query();
                foreach ($job_type_array as $type) {
                    $job_type->where('name', 'like', '%' . $type . '%');
                }
                $job_type = $job_type->first();
                /* if (!$job_type) {
                    throw new Exception("Job type not found.");
                } */
                if($job_type){
                    $data['job_type'] = $job_type->id;
                }
            }

            // Remove script tags from the description if provided
            if (isset($data['description'])) {
                $data['description'] = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $data['description']);
            }

            // Update the job with the validated data
            $job->update($data);

            DB::commit();

            return response()->json([
                'status' => 'passed',
                'job' => $job,
                'url' => route('job.view', $job->slug)
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function updateJobStatus(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get the job_slug from the job_slug header
            $job_slug = $request->header('job_slug')??$request->job_slug;
            if (!$job_slug) {
                throw new Exception("Job slug is required.");
            }

            $job = Job::where('slug', $job_slug)->first();
            if (!$job) {
                throw new Exception("Job not found.");
            }

            // Verify that the job was posted by who is trying to update it
            $company = Company::find($job->company_id);
            if (!$company) {
                throw new Exception("Company not found.");
            }

            // Find the company name from the clk header
            $company_key = $request->header('clk');
            if (!$company_key) {
                throw new Exception("Company key is required.");
            }

            $client = DB::connection('clients')->table('clients')->where('hashslug', $company_key)->first();
            if (!$client || $company->name != $client->name) {
                throw new Exception("Client mismatch.");
            }

            // Validate incoming data
            $data = $request->validate([
                'status' => 'required|string|in:paused,closed,active',
            ]);

            // Update the job status
            $job->status = Job::JOB_STATUS_CODES[$data['status']];
            $job->save();

            DB::commit();

            return response()->json([
                'status' => 'passed',
                'job' => $job,
                'message' => 'Job status updated successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
