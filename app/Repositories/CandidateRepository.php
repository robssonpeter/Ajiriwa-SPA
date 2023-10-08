<?php


namespace App\Repositories;


use App\Events\ProfileUpdated;
use App\Models\Candidate;
use App\Models\CandidateCertificate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateReferee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CandidateRepository
{


    public static function uploadFile($input, $resume = true)
    {

        /**
         * if $resume  == true -> the user is uploading a cv
         * if $resume == null -> the user is uploading a salary slip
         * else the user just uploaded a certificate
         */

        try {
            $user = Auth::user();
            /** @var Candidate $candidate */

            //$candidate = Candidate::findOrFail($user->candidate->id);
            $candidate = Candidate::where('user_id', $user->id)->first();
            $input['is_default'] = isset($input['is_default']) ? true : false;

            $fileExtension = getFileName('download', $input['file']);
            //throw new UnprocessableEntityHttpException($resume?Candidate::RESUME_PATH:Candidate::CERTIFICATE_PATH);

            if(is_null($resume)){
                $mediaCollection = Candidate::CERTIFICATE_PATH;
            }else{
                $mediaCollection = Candidate::CERTIFICATE_PATH;
            }
            $candidate->addMedia($input['file'])
                ->withCustomProperties([
                    'title'      => $input['title'],
                ])->toMediaCollection($mediaCollection);
            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public static function profileCompletion($user_id){
        $candidate = Candidate::where('user_id', $user_id)->first();
        $user = User::find($user_id);
        /*$achievements = CandidateAchievement::where('candidate_id', $candidate->id)->get();*/
        $reference = CandidateReferee::where('candidate_id', $candidate->id)->get();
        $education = CandidateEducation::where('candidate_id', $candidate->id)->get();
        $experience = CandidateExperience::where('candidate_id', $candidate->id)->get();
        $language = DB::table('candidate_languages')->where('candidate_id', $candidate->id)->get();
        $skills = DB::table('candidate_skills')->where('candidate_id', $candidate->id);
        $pictures = DB::table('media')->where('collection_name', 'profile-pictures')->where('model_id', $user_id)->get();
        $resumes = DB::table('media')->where('collection_name', 'resumes')->where('model_id', $candidate->id)->get();
        $certifications = DB::table('media')->where('collection_name', 'certifications')->where('model_id', $candidate->id)->get();
        $percentages = [
            'personal' => ['value' => 5, 'eligible' => $candidate->first_name],
            'personal_extra' => ['value' => 5, 'eligible' => $candidate->gender],
            'career_objective' => ['value' => 5, 'eligible' => strlen($candidate->career_objective)],
            'skills' => ['value' => 10, 'eligible' => $skills->count()],
            'experience' => ['value' => 10, 'eligible' => $experience->count()],
            'education' => ['value' => 20, 'eligible' => $education->count()],
            'reference' => ['value' => 10, 'eligible' => $reference->count()],
            /*'achievements' => ['value' => 5, 'eligible' => $achievements->count()],*/
            'languages' => ['value' => 5, 'eligible' => $language->count()],
            'picture' => ['value' => 5, 'eligible' => $candidate->logo],
            /*'social' => ['value' => 2, 'eligible' => Self::hasSocialAccount(User::find($user_id))],*/
            'resumes' => ['value' => 20, 'eligible' => $resumes->count()],
            'certification' => ['value' => 5, 'eligible' => $certifications->count()]
        ];
        //return $percentages;
        $sections = array_keys($percentages);
        $completion = 0;
        foreach ($sections as $section){
            if($percentages[$section]['eligible']){
                $completion += $percentages[$section]['value'];
            }
        }
        
        $candidate->update(['profile_completion' => $completion]);
        return $completion;
    }

    public static function searchCandidate($search){
        $search_term =  explode(" ", $search);
        
        $experiences = CandidateExperience::where(function($q) use($search){
            return $q->where('title', 'LIKE', "%".$search."%")->orWhere('company', 'LIKE', "%".$search."%");
        })->pluck('candidate_id')->toArray();
        $education = CandidateEducation::where(function($q) use($search){
            return $q->where('degree_title', 'LIKE', "%".$search."%")->orWhere('institute', 'LIKE', "%".$search."%");
        })->pluck('candidate_id')->toArray();
        $certificate = CandidateCertificate::where(function($q) use($search){
            return $q->where('name', 'LIKE', "%".$search."%");
        })->pluck('candidate_id')->toArray();

        $exeptions = array("and", "in", "on", "at", "with", "if", "be", "is", "by", "of", "for", "to", "up", "like", "as", "from", " ");
        $candidates = Candidate::where(function($q) use($search, $search_term, $exeptions){
            $q = $q ->where('first_name', "LIKE", "%".$search."%")
                    ->orWhere('middle_name', "LIKE", "%".$search."%")
                    ->orWhere('last_name', "LIKE", "%".$search."%");
            foreach($search_term as $term){
                if(in_array($term, $exeptions)){
                    continue;
                }
                $q = $q ->orWhere('first_name', "LIKE", "%".$term."%")
                        ->orWhere('middle_name', "LIKE", "%".$term."%")
                        ->orWhere('last_name', "LIKE", "%".$term."%");
            }
            return $q;
        })->orWhere(function($q) use($experiences, $education, $certificate){
            $candidate_ids = array_merge($experiences, $education, $certificate);
            return $q->whereIn('id', $candidate_ids);
        })->orWhere('professional_title', "LIKE", "%".$search."%")->paginate(12);
        return $candidates;        
    }
}
