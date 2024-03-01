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


    public static function renderJobDescriptionMeta($job_slug){
        // find the job using the $job_id
        $job = Job::where('slug', $job_slug)->first();
        // find the name of the company
        $company_name = $job->company->name;
        // get the title of the job
        $job_title = $job->title;
        // get the job description
        $description = $job->description;
        // split the description into an array using new line as a separator
        $responsibilities = explode("\n", $description);
        $responsibilities_keywords = [
            'duties', 'responsibilities', 'accountabil', 'deliverable'
        ];
        $duties = [];

        // loop through the responsibilities
        $index = 0;
        //return $responsibilities;
        foreach ($responsibilities as $responsibility) {
            // determine if it contains a header tag
            $is_header = str_contains($responsibility, '<h'); //strpos($responsibility, '<h') !== false;

            $contains_keyword = false;
            foreach($responsibilities_keywords as $keyword){
                if(str_contains(strtolower($responsibility), $keyword)){
                    $contains_keyword = true;
                    break;
                }
            }
            // if is header and contains some of the keywords for responsibilities
            if ($is_header && $contains_keyword) {
                // starting from the index of the header
                $sub_responsibilities = array_slice($responsibilities, $index+1);
                // loop through sub-responsibilities
                foreach ($sub_responsibilities as $sub_responsibility) {
                    // if it contains a header tag then stop
                    if (strpos($sub_responsibility, '<h') !== false) {
                        break;
                    }
                    // if the item does not contain an empty string after striping tags
                    // if the item does not contain an empty string after stripping tags
                    if (trim(strip_tags($sub_responsibility)) !== '') {
                        // add the non-empty item to the duties array
                        $duties[] = $sub_responsibility;
                    }
                }
                break;
            }
            $index++;
        }
        // let us form the meta description text from the data
        $joined_responsibilities = implode(' ', $duties);
        $meta_description = "Join {$company_name} as {$job_title}. ";
        if(count($duties)){
            $meta_description .= "{$joined_responsibilities}. ";
        }
        $meta_description .= 'Apply before '.\Carbon\Carbon::parse($job->deadline)->format("F jS Y").'.';

        
        // try to extract the responsibilities
        return strip_tags($meta_description);
        
        // try to find the deadline of application
    }
}
