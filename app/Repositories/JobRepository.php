<?php


namespace App\Repositories;

use App\Events\JobViewed;
use App\Models\CategorizedJob;
use App\Models\Job;
use App\Models\JobView;

/**
 * Class for job related operations mostly session based
 */
class JobRepository
{
    /**
     * This method return an array of job ids that have been viewed in the current session 
     * @return array
     */
    public static function viewedJobs(){
        if(session()->has('viewed-jobs')){
            return session()->get('viewed-jobs');
        }
        return [];
    }

    /**
     * This method will add a new job id to the list of viewed jobs
     * @param $jobid
     * @return void
     */
    public static function addToViewedJobs($jobid){
        if(session()->has('viewed-jobs')){
            $session = session()->get('viewed-jobs');
            if(!in_array($jobid, $session)){
                array_push($session, $jobid);
                // create an entry to the database
                //event(new JobViewed($jobid, session()->get('uniqid')));
                JobView::create(['job_id' => $jobid, 'user_id' => session()->get('uniqid'), 'is_logged' => \Auth::check()]);
            }
            session()->put('viewed-jobs', $session);
        }
        else
        {
            session()->put('viewed-jobs', [$jobid]);
            JobView::create(['job_id' => $jobid, 'user_id' => session()->get('uniqid'), 'is_logged' => \Auth::check()]);
        }
    }


    public static function syncJobCategories($jobId, $categoryIds)
    {
        // Get the existing category IDs associated with the job
        $existingCategoryIds = CategorizedJob::where('job_id', $jobId)
                                                ->pluck('category_id')
                                                ->toArray();

        // Find categories to be added
        $categoriesToAdd = array_diff($categoryIds, $existingCategoryIds);

        // Find categories to be removed
        $categoriesToRemove = array_diff($existingCategoryIds, $categoryIds);

        // Add new categories
        foreach ($categoriesToAdd as $categoryId) {
            CategorizedJob::create([
                'job_id' => $jobId,
                'category_id' => $categoryId,
            ]);
        }

        // Remove categories
        CategorizedJob::where('job_id', $jobId)
            ->whereIn('category_id', $categoriesToRemove)
            ->delete();
    }

    public static function jobSuggestByTitle($job_title, $max_results = 3){
        $names = explode(" ", $job_title);
        $date = date('Y-m-d');
        $jobnameSuggest = [];
        foreach($names as $name){
            $prepositions = array("and", "or", "in", "at", "of");
            if(!is_numeric(array_search($name, $prepositions))){
                $jobnameSuggest[] = "title like '%$name%'";
            }
        }
        $jobnameSuggest = implode(' OR ', $jobnameSuggest);
        return Job::where(function($q) use ($jobnameSuggest){
            $q->whereRaw($jobnameSuggest);
        })->whereDate('deadline', '>=', $date)->limit($max_results)->get();
    }
}
