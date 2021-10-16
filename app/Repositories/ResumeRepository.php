<?php


namespace App\Repositories;


use App\Models\Candidate;
use App\Models\CandidateCertificate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateReferee;
use App\Models\CandidateSkill;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ResumeRepository
{
    public static function addPersonal($data, $candidate_id){
        $fillable = new Candidate;
        $fillable->getFillable();
        return Candidate::where('id', $candidate_id)->update(Arr::only($data, $fillable->getFillable()));;
    }

    public static function addExperience($data){
        if(isset($data['id'])){
            // update the existing experience
            $fillable = new CandidateExperience;
            $fillable->getFillable();
            return CandidateExperience::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        }else{
            // add a new experience
            return CandidateExperience::create($data);
        }
    }

    public static function removeExperience($experience_id, $user_id){
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $experience = CandidateExperience::find($experience_id);
        if($experience->candidate_id == $candidate->id){
            // make a deletion
            return $experience->delete();
        }
        return null;
    }

    public static function removeEducation($education_id, $user_id){
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $education = CandidateEducation::find($education_id);
        if($education->candidate_id == $candidate->id){
            // make a deletion
            return $education->delete();
        }
        return null;
    }


    public static function addEducation($data){
        if(isset($data['id'])){
            // update the existing experience
            $fillable = new CandidateEducation();
            $fillable->getFillable();
            return CandidateEducation::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        }else{
            // add a new experience
            return CandidateEducation::create($data);
        }
    }

    public static function removeLanguage($language_id, $user_id){
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $language = CandidateLanguage::find($language_id);
        if($language->candidate_id == $candidate->id){
            // make a deletion
            return $language->delete();
        }
        return null;
    }

    public static function addLanguage($data){
        if(isset($data['id'])){
            // update the existing language
            $fillable = new CandidateLanguage();
            $fillable->getFillable();
            return CandidateLanguage::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        }else{
            // add a new language
            return CandidateLanguage::create($data);
        }
    }

    public static function addSkill($data){
        if(isset($data['id'])){
            // update the existing skill
            $fillable = new CandidateSkill();
            $fillable->getFillable();
            return CandidateSkill::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        }else{
            // add a new skill
            return CandidateSkill::create($data);
        }
    }

    public static function removeSkill($skill_id, $user_id){
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $skill = CandidateSkill::find($skill_id);
        if($skill->candidate_id == $candidate->id){
            // make a deletion
            return $skill->delete();
        }
        return null;
    }

    public static function addReferee($data){
        if(isset($data['id'])){
            // update the existing skill
            $fillable = new CandidateReferee();
            $fillable->getFillable();
            return CandidateReferee::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        }else{
            // add a new skill
            return CandidateReferee::create($data);
        }
    }

    public static function removeReferee($referee_id, $user_id){
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $referee = CandidateReferee::find($referee_id);
        if($referee->candidate_id == $candidate->id){
            // make a deletion
            return $referee->delete();
        }
        return null;
    }



    public static function addCertificate($data){
        if(isset($data['id'])){
            // update the existing skill
            $fillable = new CandidateCertificate();
            $fillable->getFillable();
            // add entry in the candidate database
            return CandidateCertificate::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        }else{
            // add a new skill
            return CandidateCertificate::create($data);
        }
    }

    public static function removeCertificate($certificate_id, $user_id){
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $certificate = CandidateCertificate::find($certificate_id);
        if($certificate->candidate_id == $candidate->id){
            // make a deletion
            return $certificate->delete();
            // remove the media if exists

        }
        return null;
    }
}
