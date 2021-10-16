<?php

namespace App\Http\Controllers;

use App\Functionalities\Candidate as CandidateFunction;
use App\Models\Candidate;
use App\Models\CandidateCertificate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateReferee;
use App\Models\CandidateSkill;
use App\Models\CertificateCategory;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\Industry;
use App\Models\Media;
use App\Repositories\CandidateRepository;
use App\Repositories\ResumeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myResume(){
        return Inertia::render('MyResume', []);
    }

    public function myResumeEdit($section = null){
        //dd($section);
        $candidate = Candidate::where('user_id', Auth::user()->id)->first();
        $countries = Country::select('name', 'id')->get();
        $industries = Industry::select('name', 'id')->get();
        $data = [
            'candidate_id' => $candidate->id
        ];
        //dd($countries);
        switch ($section){
            case 'personal':
                $data['personal'] = $candidate;
                $data['personal2'] = $candidate;
                break;
            case 'experience':
                $data['experience'] = CandidateExperience::where('candidate_id', $candidate->id)->get();
                break;
            case 'education':
                $data['education'] = CandidateEducation::where('candidate_id', $candidate->id)->get();
                $data['education_levels'] = EducationLevel::all();
                break;
            case 'language':
                $data['languages'] = CandidateLanguage::where('candidate_id', $candidate->id)->get();
                $data['language_levels'] = CandidateLanguage::Levels;
                break;
            case 'skills':
                $data['skills'] = CandidateSkill::where('candidate_id', $candidate->id)->get();
                $data['skill_levels'] = CandidateSkill::Levels;
                break;
            case 'reference':
                $data['referees'] = CandidateReferee::where('candidate_id', $candidate->id)->get();
                break;
            case 'awards':
                $data['certificates'] = CandidateCertificate::where('candidate_id', $candidate->id)->get();
                $data['categories'] = CertificateCategory::all();
                break;
        }
        return Inertia::render('MyResumeEdit', [
            'section' => $section,
            'countries' => $countries,
            'industries' => $industries,
            'data' => $data,
        ]);
    }

    public function saveData($type){
        $saved = [];
        $candidate = Candidate::where('user_id', Auth::user()->id)->select('id')->first();
        switch ($type){
            case 'personal':
                $saved = ResumeRepository::addPersonal(request()->data, $candidate->id);
                return $saved;
            case 'experience':
                $saved = ResumeRepository::addExperience(request()->data);
                break;
            case 'education':
                //return request()->data;
                $saved = ResumeRepository::addEducation(request()->data);
                break;
            case 'language':
                //return request()->data;
                $saved = ResumeRepository::addLanguage(request()->data);
                break;
            case 'skills':
                //return request()->data;
                $saved = ResumeRepository::addSkill(request()->data);
                break;
            case 'referee':
                //return request()->data;
                $saved = ResumeRepository::addReferee(request()->data);
                break;
            case 'certificates':
                //return request()->data;
                $saved = ResumeRepository::addCertificate(request()->data);
                break;
        }
        return $saved;
    }

    public function deleteData($type, $id){
        $deleted = null;
        switch ($type){
            case 'experience':
                $deleted = ResumeRepository::removeExperience($id, Auth::user()->id);
                break;
            case 'education':
                $deleted = ResumeRepository::removeEducation($id, Auth::user()->id);
                break;
            case 'language':
                $deleted = ResumeRepository::removeLanguage($id, Auth::user()->id);
                break;
            case 'skill':
                $deleted = ResumeRepository::removeSkill($id, Auth::user()->id);
                break;
            case 'referee':
                $deleted = ResumeRepository::removeReferee($id, Auth::user()->id);
                break;
            case 'certificate':
                $deleted = ResumeRepository::removeCertificate($id, Auth::user()->id);
                break;
        }
        return $deleted;
    }

    public function uploadFile(Request $request){
        $input = $request->all();

        CandidateRepository::uploadFile($input);

        // profile completion calculator
        $candidate = Candidate::find(1);
/**/
        \Spatie\MediaLibrary\Models\Media::find(1);
        if(isset($input['return'])){
            $certificate = Media::where('model_type', 'App\Models\Candidate')->where('collection_name', 'certifications')->where('model_id', $request->candidate_id)->orderBy('id', 'DESC')->first();
            return $this->sendResponse($certificate, 'Successfully Uploaded');
        }
    }

    public function removeFile(Media $media){
        $media->delete();

        //CandidateFunction::profileCompletion(Auth::user()->id);

        return $this->sendSuccess('Media deleted successfully.');
    }
}
