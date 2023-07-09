<?php

namespace App\Http\Controllers;

use App\Custom\Promoter;
use App\Events\ApplicationRejected;
use App\Events\ApplicationStatusUpdated;
use App\Events\CompanyVerified;
use App\Events\InterviewScheduled;
use App\Models\ApplicationLog;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\CompanyVerification;
use App\Models\EmailTemplate;
use App\Models\Industry;
use App\Models\InterviewSchedule;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobScreening;
use App\Models\JobType;
use App\Models\ScreeningResponse;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VerificationAttempt;
use App\Repositories\CandidateRepository;
use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    public function saveNewCompany(){
        $data = request()->all();
        $data['slug'] = makeSlug(request()->name);
        return Company::create($data);
    }

    public function show($slug){
        $company = Company::where('slug', $slug)->first();
        return view('company.view', compact('company'));
    }

    public function initialInformation(){
        $company = Company::where('original_user', \Auth::user()->id)->first();
        $industries = Industry::orderBy('name', 'ASC')->get();
        $user = User::find(\Auth::user()->id);
        return Inertia::render('Company/InitialInfo', [
            'industries' => $industries,
            'company' => $company,
            'user' => $user
        ]);
    }

    public function saveInitialInformation(){
        $company = request()->company;
        $userData = request()->user;

        $company['slug'] = makeSlug($company['name']);

        // update company information
        $update = Company::where('original_user', \Auth::user()->id)->update($company);
        // update user information
        $userUpdate = User::where('id', \Auth::user()->id)->update($userData);
        return 1;
    }

    public function saveDescription(){
        $description = request()->description;
        $company_id =  request()->company_id;
        if(Company::where('id', $company_id)->update(['description' => htmlspecialchars($description)])){
            return $description;
        }
        return false;
    }

    public function customize(){
        $company = Company::where('original_user', \Auth::user()->id)->with('industry')->first();
        //dd($company);
        $today = date('Y-m-d');
        if(!$company){
            abort(401);
        }
        // current active jobs
        $jobs = Job::where('company_id', $company->id)->where('deadline', '>=', $today)->get();
        //dd($company);
        $company->description = htmlspecialchars_decode($company->description);
        //dd($company->logo);
        return Inertia::render('Company/Customize', [
            'company' => $company,
            'jobs' => $jobs,
        ]);
    }

    public function dashboard(){
        return Inertia::render('Company/Dashboard', [

        ]);
    }

    public function postJob(){
        $user = Auth::user();
        $company = Company::where('original_user', \Auth::user()->id)->first();
        $subscription = SubscriptionRepository::currentPlan($user->id);
        //dd($subscription);
        if(Auth::user()->hasRole('admin')){
            $is_admin = true;
        }else{
            $allowed_active_jobs = $subscription->contents->where('name', 'allowed_active_jobs')->first()->value??1;
            $is_admin = false;
        }
        if(!$is_admin && activeJobs($company->id) >= $allowed_active_jobs){
            // return the view that says that you can not have more that 1 active job with your subscription
            $subscription = SubscriptionRepository::currentPlan($user->id);
            return Inertia::render("Company/UpgradeSubscription", compact('company', 'subscription'));
        }
        $categories = JobCategory::orderBy('name', 'DESC')->get();
        $status = Job::STATUS;
        $jobTypes = JobType::all();
        $is_admin = false;
        if(Auth::user()->hasRole('admin')){
            $companies = DB::table('companies')->whereNotNull('name')->select('name', 'id')->get();
            $is_admin = true;
        }
        
        return Inertia::render('Company/Jobs/Post', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'company' => $companies??$company,
            'status' => $status,
            'is_admin' => $is_admin
        ]);
    }

    public function editJob($slug){
        $job = Job::where('slug', $slug)->first();
        $status = Job::STATUS;
        $categories = JobCategory::orderBy('name', 'DESC')->get();
        $jobTypes = JobType::all();
        $is_admin = false;
        if(Auth::user()->hasRole('admin')){
            $companies = DB::table('companies')->whereNotNull('name')->select('name', 'id')->get();
            $is_admin = true;
        }
        $company = Company::where('original_user', \Auth::user()->id)->first();
        return Inertia::render('Company/Jobs/Post', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'company' => $companies??$company,
            'job' => $job,
            'status' => $status,
            'is_admin' => $is_admin,
        ]);
    }

    public function viewJob($slug){
        $job = Job::where('slug', $slug)->first();
        
        return Inertia::render('Company/Jobs/View', [
            'job' => $job
        ]);
    }

    public function showJobs(){
        $user = \Auth::user();
        $jobs = Job::when($user->hasRole('employer'), function($q) use ($user){
            return $q->where('company_id', $user->company->id);
        })->orderBy('id', 'DESC')->simplePaginate(15);
        $promoter = new Promoter();
        //dd(Auth::user());
        //dd($jobs->previousPageUrl());
        return Inertia::render('Company/Jobs/Index', [
            'is_admin' => $user->hasRole('admin'),
            'jobs' => $jobs->items(),
            'status' => Job::STATUS,
            'paginate' => $jobs,
            'next' => $jobs->nextPageUrl(),
            'previous' => $jobs->previousPageUrl(),
            'cpc' => $promoter->costperclick,
            'cpa' => $promoter->costperapplication,
            'cpm' => $promoter->costperimpression,
        ]);
    }

    public function jobApplications($slug){   
        $company = Company::where('original_user', \Auth::user()->id)->first();
        $job = Job::where('slug', $slug)->when(\Auth::user()->hasRole('employer'), function($q) use ($company){
            return $q->where('company_id', $company->id);
        })->first();
        $applications = JobApplication::where('job_id', $job->id)->with('candidate', 'logs', 'screening_responses', 'interview')->orderBy('id', 'DESC')->get();
        $groupedApps = JobApplication::STATUS;
        $groupedApps['all'] = JobApplication::where('job_id', $job->id)->with('candidate')->get();
        //dd($applications);

        foreach(array_keys($groupedApps) as $applicationGroup){
            if($applicationGroup == 0){
                $groupedApps[0] = $applications;
            }
            $groupedApps[$applicationGroup] = $applications->where('status', $applicationGroup);
        }
        $statuses = JobApplication::STATUS;
        $log_colors = ApplicationLog::STATUS_DESCRIPTIONS;
        $assessments = JobScreening::where('job_id', $job->id)->get();
        $screening_filters = JobScreening::where('job_id', $job->id)->select('type', 'name as alternative_label', 'type as label', 'name','id as value', 'options')->get();

        /* $screening_filters = array_map(function($row){
            return [
                'label' => $row['label']
            ]
        }, $screening_filters->toArray()); */
        //dd($screening_filters);

        /* $filter_variables = array_map(function($row){
            $named = ['Custom', 'Location', 'Expertise', 'Certification'];
            $row['value'] = $row['label'];
            //$row['label'] = in_array(ucfirst($row['label']), $named)?$row['name']:ucfirst($row['label']);
            $row['label'] = ucfirst($row['label']);
            //(ucfirst($row['label']), $named)
            return [
                'value' => $row['label'],
                'label' =>ucfirst($row['label'])
            ];
        },$screening_filters->toArray()); */

        $filter_variables = [];
        $added_array = [];
        foreach($screening_filters as $filter){
            if(!in_array($filter->label, $added_array)){
                $row = [
                    'value' => ucfirst($filter->label),
                    'label' =>ucfirst($filter->label)
                ];
                $filter_variables[] = $row;
                $added_array[] = $filter->label;
            }
        }

        //dd($filter_variables);
        array_unshift($filter_variables, [
            'label' => 'Status',
            'value' => 'Status',
        ]);
        //dd($filter_variables);
        unset($statuses[0]);
        //unset($statuses[0]);
        //dd($screening_filters);
        if(!$job){
            abort(404);
        }

        $is_admin = Auth::user()->hasRole('admin');
        $status = Job::STATUS;

        //dd($screening_filters);

        return Inertia::render('Company/Jobs/ApplicationsNew', compact('job', 'applications', 'statuses', 'log_colors', 'screening_filters', 'filter_variables', 'assessments', 'is_admin', 'status'));
        //dd($groupedApps);
        return Inertia::render('Company/Jobs/Applications', [
            'all_applications' => $applications,
            'job' => $job,
            'applications' => $groupedApps,
            'statuses' => $statuses,
            'screening_filters' => $screening_filters
        ]);
    }

    public function jobApplication($slug, $application_id){
        $job = Job::where('slug', $slug)->first();
        $application = JobApplication::where('id', $application_id)->where('job_id', $slug)->with('candidate')->first();
        return Inertia::render('Company/Jobs/Applicant', [
            'application' => $application,
        ]);
    }

    public function changeApplicationStatus(){
        $application = JobApplication::find(request()->application_id);
        if(!$application){
            abort(404);
        }
        //$job = Job::find($application->job_id);
        if($application->update(['status' => request()->status])){
            event(new ApplicationStatusUpdated(\Auth::user()->id, request()->application_id, request()->status));
            // if the application is rejected send application rejection email
            if(request()->status == array_search('Rejected', JobApplication::STATUS)){
                event(new ApplicationRejected(request()->application_id));
            }
            return true;
        }
    }

    public function emailTemplates(){
        $company = Company::where('original_user', Auth::user()->id)->first();
        $emails = EmailTemplate::where('company_id', $company->id)->orWhereNull('company_id')->get();
        $template_types = EmailTemplate::typesAssoc();
        $table_types = EmailTemplate::TYPES_TABLES;

        return Inertia::render('Company/EmailTemplates', compact('emails', 'template_types', 'table_types'));
        //return \view('employer.email_templates.index-temp');
    }

    public function browseCandidates(){
        //dd('hello there how are you doing');
        $candidates = Candidate::orderBy('id', 'DESC')->whereNotNull('first_name')->limit(10)->get();
        //dd($candidates);

        return Inertia::render('Company/BrowseCandidates', compact('candidates'));
    }

    public function searchCandidates(){
        $keyword = request()->keyword;
        return CandidateRepository::searchCandidate($keyword);
    }

    public function showRecommendedCandidates(){
        $job = Job::find(request()->job_id);
        return Candidate::orderBy('id', 'DESC')->whereNotNull('first_name')->limit(5)->get();
    }

    public function GetAssessment(){
        $jobId = request()->job_id;
        $questions = JobScreening::where('job_id', $jobId)->get();
        return $questions;
    }

    public function ApplicationAssessment(){
        $application_id = request()->application_id;
        $responses = ScreeningResponse::where('application_id', $application_id)->with('screening_question')->get();
        return $responses;
    }

    public function Assessments($hash){
        $job = Job::where('slug', $hash)->first();
        $assessment_selection = ['job_screenings.*', 'job_screenings.input_type as input', 'job_screenings.question_type as answer_type'];
        $assessments = JobScreening::where('job_id', $job->id)->select($assessment_selection)->get();
        //dd($assessments);
        if(!is_null($job)){
            return Inertia::render('Company/Jobs/Assessment', compact('job', 'assessments'));
        }else{
            abort(404);
        }
    }

    /**
     * This function stores the selected columns to display when viewing application for future use these colums come from 
     * screening questions for a related job
     */
    public function storeApplicationColumns($job_id){
        $data = request()->data;
        return Job::where('id', $job_id)->update(['application_display_columns' => json_encode($data)]);
    }

    public function FilterApplications(){
        $job_id = request()->job_id;
        $keyword = request()->keyword;
        $limit = request()->limit;

        if(!$keyword){
            $where = '(job_id = '.$job_id.')';
        }else{
            $where = '(job_id = '.$job_id.') AND
                            (first_name like \'%'.$keyword.'%\' OR
                            last_name like \'%'.$keyword.'%\' OR
                            address like \'%'.$keyword.'%\' OR
                            email like \'%'.$keyword.'%\' OR phone like \'%'.$keyword.'%\')';
        }


        $filters = json_decode(request()->filters);


        //return '(screening_id = '.$filters[0]->id.' AND response '.$filters[0]->filter_operator.'\''.$filters[0]->filter_value.'\')';
        $GLOBALS['filters'] = $filters;
        $applications = JobApplication::whereRaw($where)->with('candidate', 'logs', 'screening_responses', 'interview'/* ,'shortlist' */)->limit($limit)/*->get()*/;
        //return $filters;
        $screenings = ScreeningResponse::where('job_id', $job_id)->where(function($q) use($filters, $job_id){
            foreach($filters as $filter){
                /* if(!$filter->operator_value || !$filter->filter_value){
                    continue;
                } */
                if($filter->type != 'status'){
                    return $q->orWhere(function($q)use($filter, $job_id){
                        return $q->where('job_id', $job_id)->where('screening_id', $filter->id)->where('response', $filter->operator_value??$filter->filter_operator, $filter->filter_value);
                    });
                }
            }
        });
        foreach($filters as $filter){
            $GLOBALS['filter'] = $filter;
            if($filter->type == 'status' && !isset($filter->id)){
                $applications = $applications->where('status', $filter->filter_value);
            }else{
                //dd('hello');
                /* $screenings = $screenings
                $screenings = $screenings->where('screening_id', $filter->id)->where('response', $filter->filter_operator, $filter->filter_value); */
                /* $applications = $applications->whereHas('screening_responses', function($q) use($filter){
                    //$q = $q->where('screening_id', $filter->id)->where('response', $filter->filter_operator, $filter->filter_value);
                    return $q->where('screening_id', $filter->id)->where('response', $filter->filter_operator, $filter->filter_value);
                    //$q = $q->whereRaw('(screening_id = '.$filter->id.' AND response '.$filter->filter_operator.'\''.$filter->filter_value.'\')');
                } ); */
            }
        }
        $screenings = $screenings->pluck('application_id');
        return $applications->whereIn('id', $screenings)->get();
        $filtered_applications = [];
        //return $applications;

        $filters = json_decode(request()->filters);

        foreach($applications as $application){
            $responses = $application->screening_responses;
            //return $responses;
            $matchCount = 0;
            $filter_id = [];

            foreach($filters as $filter){
                //return $responses->where('screening_id', $filter->id)->where('response', $filter->filter_operator, $filter->filter_value);
                if($responses->where('screening_id', $filter->id)->where('response', $filter->filter_operator, $filter->filter_value)->count()){
                    $matchCount++;
                }
                //return $responses->where('screening_id', $filter->id)->where('response', $filter->filter_operator, $filter->filter_value)->count();
            }
            //return $matchCount;
            if($matchCount && $matchCount == count($filters)){
                array_push($filtered_applications, $application);
            }
        }
        return $filtered_applications;
    }

    public function scheduleInterview(){
        $check = [
            'application_id' => request()->application_id,
        ];
        $update = [
            'date' => request()->date,
            'time' => request()->time,
            'interview_type' => request()->type,
            'venue' => request()->venue,
            'notes' => request()->notes,
            'set_by' => Auth::user()->id,
        ];
        
        $saved = InterviewSchedule::updateOrCreate($check, $update);
        $template = EmailTemplate::where('type', 'interview_schedule')->first();
        // send an email to the candidate
        if($saved->wasChanged() /* && !$saved->notified */){
            $application = JobApplication::where('id', request()->application_id)->with('job')->first();
            $to = $application->email;
            $subject = 'Invitation for Interview for '.$application->job->title;
            $email = EmailTemplate::renderTemplate(request()->application_id, $template->id);
            $mailData = [
                'to' => $to,
                'subject' => $subject,
                'body' => $email
            ];
            //$mail = \App\Classes\Mail::send($mailData);
            event(new InterviewScheduled($application->id));
            /* if($mail){ */
                // mark the schedule as notified
                $notified = InterviewSchedule::where('application_id', request()->application_id)->update(['notified' => 1]);
            /* } */
        }


        return $saved;
    }

    public function searchCompanies(){
        $keyword = request()->keyword;
        $companies = Company::where('name', 'LIKE', '%'.$keyword.'%')->select('id as code', 'name as label', 'logo')->get();
        return $companies;
    }

    public function verificationAttempt(){
        $user_id = Auth::user()->id;
        $company = Company::where('user_id', $user_id)->with('verification')->with('verification_attempt')->first();
        $docs = Setting::where('key', 'verification_documents')->first();
        $documents = [];
        if($docs){
            $documents = json_decode($docs->value);
        }
        !$company?abort(401):'';
        return view('employer.verification.index', compact('company', 'documents'));
    }

    public function verificationSave(Request $request){
        $rules = [
            'role_at_company' => 'required',
            'file' => 'required'
        ];
        $docs = Setting::where('key', 'verification_document')->get();
        //$documents = json_decode($docs->value);
        $validator = $request->validate($rules);
        $docsToSave =[];

        $x = 0;
        foreach($docs as $document){
            $row = [
                'name' => $document->name,
                'file' => $request->file[$x]
            ];
            array_push($docsToSave, $row);
            $x++;
        }

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->with('company')->first();
        $data = [
            'role' => $request->role_at_company,
            /*'document' => $request->file,*/
            'document' => json_encode($docsToSave),
            'company_id' => $user->company->id,
        ];
        
        $saved = VerificationAttempt::updateOrCreate(['company_id' => $user->company->id], $data);
        
        if($saved){
            return true;
        }
        return false;
    }

    public function uploadVerificationAttachment(){
        request()->validate([
            'attachment' => "file|mimes:pdf,png,jpg|max:120000"
        ]);
        $file = request()->file('attachment');
        $destinationFolder = public_path('verification_files');

        if(!File::isDirectory($destinationFolder)){
            File::makeDirectory($destinationFolder, 0776, true, true);
        }
        $uniqid = uniqid();
        $last_pos = strrpos($file->getClientOriginalName(), '.');
        $extension = substr($file->getClientOriginalName(), $last_pos);
        $fileName = str_replace($extension, '', $file->getClientOriginalName())."-".$uniqid.'-'.Auth()->user()->id.$extension;
        $file->move($destinationFolder, $fileName);
        return [
            "original"=>$file->getClientOriginalName(),
            "saved" =>"verification_files/".$fileName
        ];
    }

    public function verify(Request $request){
        $companies = Company::with('verification_attempt', 'verification', 'user')->whereHas('verification_attempt')->whereDoesntHave('verification')->get();
        if ($request->ajax) {
            /*return Datatables::of((new CompanyDataTable())->get($request->only([
                'is_featured', 'is_status',
            ])))->make(true);*/
            return $companies;

        }
        //dd($companies);
        $host = asset('');
        return Inertia::render('Admin/PendingCompanies', compact('companies', 'host'));
        //return view('companies.to-verify', compact('featured', 'statusArr', 'companies'));
    }

    public function verifySave($id){
        $attempt = \App\Models\VerificationAttempt::where('company_id', $id)->first();
        $data = [
            'document' => $attempt->document,
            'verified_by' => Auth::user()->id,
        ];
    
        $verified = CompanyVerification::updateOrCreate(['company_id' => $id], $data);

        // Create a notification telling the user
        event(new CompanyVerified($id));

        return $verified;
    }

    public function verificationReject($id){
        $attempt = VerificationAttempt::where('company_id', $id)->first();
        $data = [
            'reason' => request()->reason,
            'company_id' => $id,
            'rejected_by' => Auth::user()->id,
            'attempt_id' => $attempt->id
        ];
        $company = Company::where('id', $id)->with('user')->first();
        $message = '<p>Hello '.$company->user->first_name.',</p>
                    <p>&nbsp;</p>
                    <p>Thank you for attempting to verify your account. Your employer account could not be verified due to reason:</p>
                    <p><strong>'.request()->reason.'</strong></p>
                    <p>Please login to your account <a href="'.route('company.verify').'">here</a> to resolve this issue.</p>
                    <p>&nbsp;</p>
                    <p>Regards</p>
                    <p>'.env('APP_NAME').' Team</p>';
        $rejected =  CompanyVerificationRejection::create($data);
        $mail = Mail::to($company->user)->send(new VerificationRejected($message));
        if($rejected && $mail){
            $this->sendResponse( $rejected,'Successfully Rejected');
        }
        $this->sendError('Could not reject this attempt');
    }

    public function verifyRevoke($id){
        $revoked = CompanyVerification::find($id)->delete();
        return $this->sendSuccess('Verification successfully revoked');
    }

    public function saveVerificationDocuments(){
        if(request()->retrieve){
            $data = Setting::where('key', 'verification_documents')->first();
            if($data){
                return $this->sendResponse($data->value, 'retrieved successfully');
            }else{
                return $this->sendResponse([], 'no data');
            }
        }else{
            $documents = request()->documents;
            $save = Setting::updateOrCreate(['key'=>'verification_documents'], ['value'=>$documents]);
            return $this->sendSuccess('Required documents successfully saved');
        }
    }

    public function reAttachVerification(){
        $company = Company::where('user_id', Auth::user()->id)->first();
        $attempt = VerificationAttempt::where('company_id', $company->id)->first();
        $documents = json_decode($attempt->document);
        foreach($documents as $document){
            $file = public_path($document->file);
            unlink($file);
        }
        $attempt->delete();
        return $this->sendSuccess('Deleted');
    }
}
