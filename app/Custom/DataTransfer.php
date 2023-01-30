<?php
namespace App\Custom;

use App\Events\ProfileUpdated;
use App\Models\Candidate;
use App\Models\CandidateCertificate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateReferee;
use App\Models\CandidateSkill;
use App\Models\Company;
use App\Models\Gender;
use App\Models\Job;
use App\Models\MaritalStatus;
use App\Models\User;
use App\Repositories\UserRepository;
use DB;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\Models\Media;

class DataTransfer {
    const ORIGINAL_PATH = '/var/www/html/';

    public static function transferCompanies(){
        // get the signeup users
        $existing_companies = Company::pluck('name')->toArray();
    
        $data = DB::connection('old_db')->table('jobs')/* ->whereNotIn('Company_name', $existing_companies) */->get();
        $original_project_path = self::ORIGINAL_PATH;
        $new_companies = [];

        //return $data->count();

        $iteration = 0;
    
        foreach($data as $company){
            if(in_array($data->Company_name, $existing_companies)){
                continue;
            }
            // check if logo exists and move it to the right location
            if($company->image_dir){
                $logo = str_replace('//', '/', $company->image_dir);
                $logo_array = explode('\/', $logo);
                $logo_file = $logo_array[count($logo_array)-1];

                // copy the logo from previous location to the new one
                copy($original_project_path.$logo, public_path('temporary-files/'.$logo));    
            }
            //return urlencode($logo_file);

            //return '/var/www/ajiriwa/html/'.$logo;
            
            //create company
            $company_data = [
                'name' => $company->Company_name,
                'website' => $company->Company_website,
                "location" => '',
                "primary_email" => null,
                "description" => null,
                "tin_number" => null,
                "logo" => null,
                "slug" => makeSlug($company->Company_name)
            ];
            // save the company information
            $saved_company = Company::create($company_data);

            // create the media entry
            if($company->image_dir)
                $savedMedia = $saved_company->addMedia(public_path("temporary-files/".$logo))->toMediaCollection('logo');
                Company::where('id', $saved_company->id)->update(['logo' => $savedMedia->id]);
                //Media::create($saved_company->id);
            
            $new_companies[] = $saved_company->name;
            $iteration++;
            
        }
        return count($new_companies);
    }

    public static function transferJobs(){
        $existing_jobs = Job::whereNotNull('old_id')->pluck('old_id');

        $new_jobs = $data = DB::connection('old_db')->table('jobs')->whereNotIn('ID', $existing_jobs)->get();
        $created_jobs = [];
        // loop through the jobs
        foreach($new_jobs as $new_job){
            // find the company responsible for the job
            $company = Company::where('name', $new_job->Company_name)->first();
            $apply_method = '';
            if($new_job->application_email_url){
                $apply_method = 'email';
            }else if($new_job->Application_url){
                $apply_method = 'url';
            }else{
                $apply_method = 'description';
            }
            switch($new_job->Job_type){
                case 'full-time':
                default:
                    $job_type = 1;
                    break;
                case 'part-time':
                    $job_type = 2;
                    break; 
                case 'internship':
                    $job_type = 3;
                    break; 
                case 'consultancy':
                    $job_type = 4;
                    break; 
                    
            }
            $update = [
                'title' => $new_job->Job_title,
                'application_email'=> $new_job->application_email_url,
                'application_email_cc' => $new_job->application_email_cc?json_encode([$new_job->application_email_cc]):null,
                'application_url' => $new_job->Application_url,
                'application_url' => $new_job->Application_url,
                'description' => htmlspecialchars(base64_decode($new_job->Job_requirement)),
                'reports_to' => $new_job->Reports_to,
                'job_type' => $job_type,
                'deadline' => $new_job->Application_deadline,
                'cover_letter' => $new_job->cover_letter,
                'slug' => makeSlug($new_job->Job_title).'-'.uniqid(),
                'apply_method' => $apply_method,
                'email_subject' => $new_job->emailTitle,
                'company_id' => $company->id,
                'counted_views' => $new_job->Views,
                'status' => 1,
                'location' => $new_job->Location,
                'is_remote' => false,
                'is_remote' => false,
                'keywords' => $new_job->keywords,
                'old_id' => $new_job->ID,
            ];
            $created = Job::create($update);
            if($created){
                $created_jobs[] = $created->id;
            }
        }
        return count($created_jobs);
    }

    public static function transferCandidates(){
        $new_candidates = DB::connection('old_db')->table('subscribers')->get();
        $marital_statuses = MaritalStatus::all();
        $genders = Gender::pluck('id', 'name');
        foreach($new_candidates as $new_candidate){
            $name_array = explode(" ", $new_candidate->full_name);
            switch(count($name_array)){
                case 3:
                    $first_name = $name_array[0];
                    $middle_name = $name_array[1];
                    $last_name = $name_array[2];
                    break;
                case 2:
                    $first_name = $name_array[0];
                    $middle_name = null;
                    $last_name = $name_array[1];
                    break;
                case 1: 
                    $first_name = $name_array[0];
                    $middle_name = null;
                    $last_name = null;
                    break;
                case 0:
                    $first_name = null;
                    $middle_name = null;
                    $last_name = null;
                default:
                    $count = count($name_array);
                    $first_name = $name_array[0];
                    $middle_name = "";
                    $x = 1;
                    while($x < $count - 1){
                        if($x == 1){
                            $middle_name .= $name_array[$x];
                        }else{
                            $middle_name .= " ".$name_array[$x];
                        }
                        $x++;
                    }
                    break;
            }
            $logo = $new_candidate->image_dir;
            $copied = false;
            //return public_path('temporary-files/'.$logo);
            // copy the profile photo if exists
            if($logo && file_exists(self::ORIGINAL_PATH.$logo)){
                $logo_array = explode("/", $logo);
                $valid_dir = "";
                //return $logo_array;
                $logo_name = $logo_array[count($logo_array)-1];
                //return $logo_name;
                for($x = 0; $x < count($logo_array) - 1; $x++){
                    $valid_dir.=$logo_array[$x];
                    if(!is_dir(public_path('temporary-files/'.$valid_dir))){
                        mkdir(public_path('temporary-files/'.$valid_dir));
                        $valid_dir.="/";
                    }
                }
                copy(self::ORIGINAL_PATH.$logo, public_path('temporary-files/'.$logo_name));
                //return public_path('temporary-files/'.$logo_name);
                $copied = true;
            }
    
            $marital = $marital_statuses->where('marital_status', $new_candidate->marital_status);
            
            // create user account for the candidate
            $new_user = User::where('email', $new_candidate->email)->first();
            if(!$new_user){
                $user_data = [
                    "email" => $new_candidate->email,
                    "name" => $new_candidate->username,
                    "phone" => $new_candidate->phone,
                    "role" => "candidate",
                    "password" => Hash::make(base64_decode($new_candidate->password)),
                ];
                
                $new_user = User::create($user_data);
            }
            
            $candidate_to_save = [
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'nationality' => $new_candidate->nationality,
                'career_objective' => htmlspecialchars(base64_decode($new_candidate->resume_content)),
                'address' => $new_candidate->location,
                'immediate_available' => $new_candidate->working_status == "Not Working"?true:false,
                'professional_title' => $new_candidate->proffesional_title,
                'marital_status' => count($marital) ? $marital[0]->id:null,
                'logo' => null,
                'user_id' => $new_user->id,
                'phone' => $new_candidate->phone,
                'dob' => $new_candidate->date_of_birth,
                'gender' => $genders[$new_candidate->gender]??null,
            ];
            
            // create the candidate
            $created = Candidate::create($candidate_to_save);

            // update the profile photo
            if($copied){
                Candidate::find($created->id)->addMedia(public_path('temporary-files/'.$logo_name))->toMediaCollection("DPs");
            }

            $logo_media = Media::where('model_type', 'App\Models\Candidate')->where('collection_name', 'DPs')->where('model_id', $created->id)->orderBy('id', 'DESC')->first();        

            if($logo_media){
                $created->update(["logo" => $logo_media->id]);
            }

            // update the experiences
            $experiences = json_decode($new_candidate->Experience);
            if(is_array($experiences)){
                $new_experiences = [];
                for($x = 0; $x < count($experiences); $x+=5){
                    if(!$experiences[$x] && !$experiences[$x + 1]){
                        continue;
                    }
                    $experience = [
                        'candidate_id' => $created->id,
                        'title' => $experiences[$x+1],
                        'company' => $experiences[$x],
                        'start_date' => $experiences[$x+2],
                        'end_date' => $experiences[$x+3],
                        'currently_working' => 0,
                        'description' => $experiences[$x+4],
                    ];
                    $new_experiences[] = $experience;
                }
                if(count($new_experiences)){
                    CandidateExperience::insert($new_experiences);
                }
            }
            
            // update the education
            $educations = json_decode($new_candidate->Education);
           
            if(is_array($educations)){
                $new_educations = [];
                for($x = 0; $x < count($educations); $x+=5){
                    if(!$educations[$x] && !$educations[$x + 1]){
                        continue;
                    }
                    $education = [
                        'candidate_id' => $created->id,
                        'degree_title' => $educations[$x+1],
                        'institute' => $educations[$x],
                        'start_year' => $educations[$x+2],
                        'year' => $educations[$x+3],
                        'currently_studying' => 0,
                        'description' => $educations[$x+4],
                    ];
                    CandidateEducation::create($education);
                    /* return $education; */
                    $new_education[] = $education;
                }
                /* if(count($new_educations)){
                    CandidateEducation::insert($new_educations);
                } */
            }
            
            // update candidate languages
            $languages = json_decode($new_candidate->languages);
            if(is_array($languages)){
                $new_languages = [];
                for($x = 0; $x < count($languages); $x+=5){
                    if(!$languages[$x] && !$languages[$x + 1]){
                        continue;
                    }
                    $language = [
                        'candidate_id' => $created->id,
                        'name' => $languages[$x],
                        'speaking' => $languages[$x+1],
                        'listening' => $languages[$x+2],
                        'writing' => $languages[$x+3],
                        'reading' => $languages[$x+4],
                    ];
                    $new_languages[] = $language;
                }
                if(count($new_languages)){
                    CandidateLanguage::insert($new_languages);
                }
            }
            
            // update candidate referees
            $referees = json_decode($new_candidate->reference);
            if(is_array($referees)){
                $new_referees = [];
                for($x = 0; $x < count($referees); $x+=4){
                    if(!$referees[$x] && !$referees[$x + 1]){
                        continue;
                    }
                    $referee = [
                        'candidate_id' => $created->id,
                        'name' => $referees[$x],
                        'company' => $referees[$x+1],
                        'email' => $referees[$x+3],
                        'phone' => $referees[$x+2],
                        'postal_address' => '-',
                    ];
                    $new_referees[] = $referee;
                }
                if(count($new_referees)){
                    CandidateReferee::insert($new_referees);
                }
            }
            
            // update candidate skills
            $skills = json_decode($new_candidate->skills);
            if(is_array($skills)){
                $new_skills = [];
                

                for($x = 0; $x < count($skills); $x+=2){
                    if(!$skills[$x] && !$skills[$x + 1]){
                        continue;
                    }
                    switch( $skills[$x+1]){
                        case "Begginer":
                            $rating = 2;
                            break;
                        case "Intermediate":
                            $rating = 3;
                            break;
                        case "Advanced":
                            $rating = 4;
                            break;
                        case "Expert":
                            $rating = 5;
                            break;
                        default:
                            $rating = 1;    
                    }
                    $skill = [
                        'candidate_id' => $created->id,
                        'name' => $skills[$x],
                        'rating' => $rating,
                    ];
                    $new_skills[] = $skill;
                }
        
                if(count($new_skills)){
                    CandidateSkill::insert($new_skills);
                }
            }
            
            // update awards and certificates
            $certificates = json_decode($new_candidate->other_certificates);
            
            if(is_array($certificates)){
                $new_certificates = [];
                for($x = 0; $x < count($certificates); $x+=2){
                    if(!$certificates[$x] && !$certificates[$x + 1]){
                        continue;
                    }
                    // copy the profile photo if exists
                    $attachment_path = self::ORIGINAL_PATH."web/".$certificates[$x+1];
                    if($logo && file_exists($attachment_path)){
                        copy($attachment_path, public_path('temporary-files/'.$certificates[$x+1]));
                        $copied = true;
                    }
                    
                    // create the new entry
                    $created_candidate = Candidate::where('id', $created->id)->first();
                    $created_candidate->addMedia(public_path('temporary-files/'.$certificates[$x+1]))
                             ->withCustomProperties([
                                   'title'      => $certificates[$x],
                            ])->toMediaCollection(Candidate::CERTIFICATE_PATH);
                    $media = Media::where('model_type', 'App\Models\Candidate')->where('collection_name', 'certifications')->where('model_id', $created->id)->orderBy('id', 'DESC')->first();
                    // create the entry
                    $certificate = [
                        'candidate_id' => $created->id,
                        'name' => $certificates[$x],
                        'media_id' => $media->id,
                    ];
                    CandidateCertificate::create($certificate);
                    $new_certificates[] = $certificate;
                }
            }
            

            // update profile completion
            event(new ProfileUpdated($new_user->id));

            // assign candidate role to the user
            UserRepository::updateUserRole($new_user->id, "candidate");
            return Candidate::where('id', $created->id)->with(['certificates', 'education', 'experiences', 'languages', 'referees', 'skills'])->first();
        }
    }

    public static function transferEmployers(){
        $existing_employers = Company::pluck('name');
        return $existing_employers;
    }
}