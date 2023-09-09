<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function saveExperience(){

    }

    public function oldCV(){
        $username = request()->data;
        if(!$username){
            abort(404);
        }
        $user = User::where('name', $username)->first();
        if(!$user){
            abort(404);
        }
        $candidate = Candidate::where('user_id', $user->id)->first();
        return redirect(route('candidate.profile', $candidate->slug), 301);
    }

    public function guestCv($slug){
        $with = [
            'education',
            'experiences',
            'skills',
            'languages'
        ];
        
        $candidate = Candidate::where('slug', $slug)->with($with)->first();
        $description = strip_tags($candidate->career_objective);
        //dd($candidate);
        SEOMeta::setTitle($candidate->full_name." - ".$candidate->professional_title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('theme-color', '#6ad3ac');
        SEOMeta::addMeta('profile:first_name', $candidate->first_name);
        SEOMeta::addMeta('profile:middle_name', $candidate->middle_name);
        SEOMeta::addMeta('profile:last_name', $candidate->last_name);
        //SEOMeta::addMeta('url', );

        OpenGraph::setTitle($candidate->full_name." - ".$candidate->professional_title);
        OpenGraph::setDescription($description);
        OpenGraph::addImage($candidate->logo_url);
        OpenGraph::setType('profile');

        JsonLd::addValue('@type', 'person');
        JsonLd::addValue('name', $candidate->full_name);
        JsonLd::addValue('jobTitle', $candidate->professional_title);
        JsonLd::addValue('description', $description);
        if ($candidate->logo)
            JsonLd::addValue('image', $candidate->logo_url);
        JsonLd::addValue('url', route('candidate.profile', $candidate->slug));
        JsonLd::addValue('sameAs', route('candidate.profile', $candidate->slug));
        $experiences = [];
        //dd($candidate);
        foreach($candidate->experiences as $experience){
            $exp_row = [
                "@type" => "Organization",
                "name" => $experience->company,
                "member" => [
                    "@type" => "OrganizationRole",
                    "jobTitle" => $experience->title,
                    "startDate" => $experience->start_date,
                ]
            ];
            if($experience->currently_working){
                $experiences[] = $exp_row;
            }
        }
        if (count($experiences)){
            JsonLd::addValue('memberOf', $experiences);
        }
        $educations = [];
        foreach($candidate->education as $education){
            $edu_row = [
                "@type" => "EducationalOrganization",
                "name" => $education->institute,
                "member" => [
                    "@type" => "OrganizationRole",
                    "startDate" => $education->start_year,
                ]
            ];
            if ($education->currently_studying){
                $edu_row['member']['endDate'] = $education->year;
            }
            $educations[] = $edu_row;
        }

        if (count($educations)){
            JsonLd::addValue('alumniOf', $educations);
        }

        $languages = [];
        foreach ($candidate->languages as $language){
            $lang_row = [
                "@type" => "Language",
                "name" => $language->name
            ];
            $languages[] = $lang_row;
        }
        if (count($languages)){
            JsonLd::addValue('knowsLanguage', $languages);
        }

        
        
        return view('CvTemplates.summary', compact('candidate'));
    }
}
