<?php


namespace App\Repositories;

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
            }
            session()->put('viewed-jobs', $session);
        }
        else
        {
            session()->put('viewed-jobs', [$jobid]);
        }
    }
}
