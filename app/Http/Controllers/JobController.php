<?php

namespace App\Http\Controllers;

use App\Events\JobViewed;
use App\Mail\SendApplication;
use App\Models\ApplicationAttachment;
use App\Models\AssignedJobCategory;
use App\Models\Candidate;
use App\Models\CandidateCertificate;
use App\Models\Company;
use App\Models\FavoriteJob;
use App\Models\GuestApplication;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobScreening;
use App\Models\JobType;
use App\Models\JobView;
use App\Models\ScreeningResponse;
use App\Models\User;
use App\Repositories\JobRepository;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Auth;
use Carbon\Carbon;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PHPMailer\PHPMailer\PHPMailer;
use Route;
use Spatie\Image\Image;
use Spatie\MediaLibrary\Models\Media;
use App\Repositories\SubscriptionRepository;

class   JobController extends Controller
{

    public function browseGuest(){
        //dd(request()->keyword);
        $current_route = Route::current()->getName();
        /* dd(request()->all()); */
        /* if(request()->currentpage){
            return redirect(route($current_route)."?page=".request()->currentpage, 301);
        } */
        switch(request()->url()){
            case route('jobs.browse.alt'):
                if(request()->keyword){
                    $title = request()->keyword." ".request()->comp;
                    $description = "Find the job that suits you, we have tons of jobs for you to view, you may also search using specific keywords. Latest jobs in Tanzania";
                    $keywords = "Jobs Tanzania,vacancies tanzania, nafasi za kazi, ajira, ajiriwa, create cv, manage applications, add job, find jobs tanzania, ajiriwa tanzania, employement tanzania";
                }else{
                    $title = "Jobs in Tanzania - Nafasi za kazi, Ajira Zetu, ajira, Zoom Tanzania, Kazibongo, TAYOA, Kijiwe, ajira portal, Nafasi za internship, Ajira bongo";
                    $description = "Find the job that suits you, we have tons of jobs for you to view, you may also search using specific keywords. Latest jobs in Tanzania";
                    $keywords = "Jobs Tanzania,vacancies tanzania, nafasi za kazi, ajira, ajiriwa, create cv, manage applications, add job, find jobs tanzania, ajiriwa tanzania, employement tanzania";
                }
                break;
            default:
                $title = 'Browse Jobs - Nafasi za kazi leo, Ajira Tanzania, ajira zetu '.date('Y').', Ajira Mpya Serikalini, Vacancies in Tanzania, Ajira Portal '.date('Y');
                $description = 'Find the right job for yourself in our database that gets updated daily, you may also search using a specific keyword. Pitia nafasi mpya za ajira nchini Tanzania na ufanye maombi kwa urahisi';
                $keywords = 'Jobs Tanzania,vacancies tanzania, nafasi za kazi, ajira, ajiriwa, create cv, manage applications, add job, find jobs tanzania, ajiriwa tanzania, employement tanzania, ajira tanzania, ajira mpya';
                break;
        }
        $is_plain = !request()->keyword && !request()->comp;
        $company = request()->comp;
        $companies = Company::where('name', 'like', '%'.$company.'%')->pluck('id');
        //dd($company);
        $industries = Industry::orderBy('name', 'ASC')->get();
        $job_types = JobType::all();
        //dd($companies);
        /* $jobs = Job::orderBy('id', 'DESC')->when($companies, function($q) use ($companies){
            $q->whereIn('company_id', $companies);
        })->limit()->get(); */
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setKeywords($keywords);
        SEOMeta::addMeta('theme-color', '#6ad3ac');

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(route('jobs.browse.ext'));
        OpenGraph::setSiteName('Ajiriwa Network');
        OpenGraph::setType('website');
        OpenGraph::setUrl(route('jobs.browse'));
        JsonLdMulti::addValue('itemListElement', [
            ['@type' => 'ListItem',
                'position' => 1,
                'name' => 'Browse Jobs',
                'item' => route('jobs.browse')],
        ]);


        return view('jobs.browse', compact('companies', 'job_types', 'industries'));
    }

    public function search($keyword = null){
        $search = $keyword?str_replace('-', ' ', $keyword):request()->search;
        $location = request()->location;
        $slug = makeSlug($search);
        $keyword = \DB::table('keywords')->where('keyword', $search)->orWhere(function($q) use ($slug){
            return $q->whereNotNull('slug')->where('slug', $slug);
        })->first();
        if($keyword){
            $search = strlen($keyword->main_words)?$keyword->main_words:$search;
        }
        $industries = Industry::orderBy('name', 'ASC')->get();
        $job_types = JobType::all();
        //dd($search);
        $url = $keyword?route('jobs.search.friendly', $slug):route('jobs.browse');
        $companies = Company::where('name', 'like', '%'.$search.'%')->orWhere('website', 'like', '%'.$search.'%')->pluck('id');
        $categories = JobCategory::where('name', 'like', '%'.$search.'%')->pluck('id');
        $jobs_by_category = AssignedJobCategory::whereIn('category_id', $categories)->pluck('job_id');
        $joined = [];
        $all = explode(" ", $search);
        $x=3;
        foreach($all as $one){
            if($location){
                $joined[] = " ((title like '%$one%' OR keywords like '%$search%' OR application_url like '%$search%' OR location like '%$search%') AND (location like '%$location%')) " ;
            }else{
                $joined[] = " ((title like '%$one%' OR keywords like '%$search%' OR application_url like '%$search%') OR (location like '%$search%')) " ;
            }

            $arraytotal = count($all);
            $casextra = $x+1;
            $order[] = "WHEN job_title LIKE '%$one%' THEN '$x' WHEN company_name LIKE '%$one%' THEN '$casextra'";
            $x+=2;
        }
        //dd($search);

        $joinedstring = implode("OR", $joined);
        //dd($jobs_by_category);
        $jobs = Job::where(function($q) use ($joinedstring, $companies, $jobs_by_category){
            $q->whereRaw($joinedstring)->orWhere(function($q) use ($companies, $jobs_by_category){
                //dd('hello');
                return $q->when($companies, function($q) use($companies){
                    return $q->whereIn('company_id', $companies);
                })->orWhere(function($q) use($jobs_by_category){
                    $q->whereIn('id', $jobs_by_category);
                });
            });
        })->when(!$keyword, function($q){
            return $q->where('deadline', '>=', date('Y-m-d'));
        })->orWhere(function($q) use($keyword, $joinedstring){
            $q->when($keyword && !strlen($keyword->main_words), function($q){
                return $q->where('title', 'like', '%%');
            })->when($keyword && strlen($keyword->main_words), function($q) use($joinedstring){
                //dd($joinedstring);
            });
        })->orderBy('id', 'DESC')->paginate(15);

        //dd(request()->method());
        //dd($jobs);
        if(request()->ajax && request()->method() == "POST"){
            return response()->json($jobs);
        }
        $meta_description = $keyword?$keyword->description:"Find the latest ".ucfirst($search)." Jobs in different companies and organization and be able to make your application easily and fast today. Click to learn more";
        $title = $keyword?$keyword->keyword:ucfirst($search)." Jobs";
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($meta_description);
        SEOMeta::addMeta('theme-color', '#6ad3ac');
        SEOMeta::setCanonical($url);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($meta_description);
        OpenGraph::setUrl($url);
        return view('jobs.browse', compact('jobs', 'industries', 'job_types'));
    }

    public function browse(){
        $breadcrumb = [
            [
                "label" => "Home",
                "url" => route('dashboard')
            ],
            [
                "label" => "Browse Jobs",
            ]
        ];
        $candidate = \Auth::check() && \Auth::user()->role == 'candidate'? Candidate::where('user_id', \Auth::user()->id)->with('certificates')->first() : null;
        $applied_jobs = $candidate ? JobApplication::where('candidate_id', $candidate->id)->pluck('job_id') : [];


        $viewedJobs = JobView::where('user_id', session()->get('uniqid'))->whereRaw('created_at >= NOW() - INTERVAL 10 MINUTE')->pluck('job_id');
        $savedJobs = $candidate? FavoriteJob::where('candidate_id', $candidate->id)->pluck('job_id'):[];
        $certificates = CandidateCertificate::where('candidate_id', 'candidate_id')->get();
        $today = date('Y-m-d');
        $jobs = Job::orderBy('id', 'DESC')->limit(15)->where('status', 1)->where('deadline', '>=', $today)->paginate(10);
        //dd($jobs);

        $certificates = array_map(function($array){
            return ['label' => $array['name'], 'code' => $array['id']];
        }, $candidate->certificates->toArray());
        //dd($certificates );
        return Inertia::render('Jobs', [
            'jobs' => $jobs,
            'count' => $jobs->count(),
            'certificates' => $certificates,
            'breadcrumb' => $breadcrumb,
            'viewedJobs' => $viewedJobs,
            'appliedJobs' => $applied_jobs,
            'savedJobs' => $savedJobs
        ]);
    }

    public function oldJob(){
        $old_id = request()->data;
        $job = Job::where('old_id', $old_id)->first();
        if(!$job){
            abort(404);
        }
        return redirect(route('job.view', $job->slug), 301);
        //dd($old_id);
    }

    public function viewJob($slug){
        $job = Job::where('jobs.slug', $slug)
                ->join('job_types', 'job_types.id', 'jobs.job_type')
                ->join('companies', 'companies.id', 'jobs.company_id')
                ->select('jobs.*', 'job_types.name as type_of_job', 'companies.name as company_name', 'companies.website', 'companies.logo' )
                ->first();


        //dd($job);
        $image = Image::load(\Spatie\MediaLibrary\Models\Media::first()->getUrl())->height(200)->width(200);
        $media = $job->logo?Media::where('id', $job->logo)->first():null;
        //dd($media->getUrl);
        if(!$job){
            abort(404);
        }
        $company_name = $job->company_name;
        SEOTools::setTitle($job->title);

        // Meta
        SEOMeta::setTitle($job->title." Job | ".$company_name);
        SEOMeta::addMeta('theme-color', '#6ad3ac');

        // jsonld
        JsonLd::setTitle($job->title);
        JsonLd::setType('JobPosting');
        JsonLd::setDescription('');
        JsonLd::addValue('datePosted', $job->created_at);
        JsonLd::addValue('validThrough', $job->deadline);
        JsonLd::addValue('employmentType', $job->type_of_job);
        JsonLd::addValue('hiringOrganization', [
            '@type' => 'Organization',
            'name' => $company_name,
            'sameAs' => $job->website??'',
            'logo' => $job->company->logo_url
        ]);
        JsonLd::addValue('jobLocation', [
            '@type' => 'Place',
            'address' => [
                'addressLocality' => "",
                'addressRegion' => $job->location,
                'addressCountry' => "Tanzania"
            ],
        ]);

        JsonLdMulti::setType('BreadcrumbList');
        JsonLdMulti::addValue('itemListElement', [
            ['@type' => 'ListItem',
            'position' => 1,
            'name' => 'Jobs in Tanzania',
            'item' => route('jobs.browse')],
            ['@type' => 'ListItem',
            'position' => 2,
            'name' => $job->title,
            'item' => route('job.view', $job->slug)],
        ]);

        TwitterCard::setType($job->title);
        TwitterCard::setSite('@AjiriwaNetwork');
        if($job->company->logo_url)
            TwitterCard::addImage($job->company->logo_url);

        $allow_apply = $job->deadline>=date('Y-m-d');
        /*if(\Auth::check()){
            return Inertia::render('ViewJob', [
                'data' => [],
                'slug' => $slug,
                'allow_apply' => $allow_apply,
            ]);
        }*/
        $applied = [12];

        JobRepository::addToViewedJobs($job->id);
        
        if(\Auth::check() && Auth::user()->hasRole('candidate')){
            $deadline_formated = \Carbon\Carbon::parse($job->deadline)->format('jS F Y');
            return redirect(route('jobs.browse')."#".$job->slug);
        }
        return view('jobs.view', compact('job', 'allow_apply', 'applied'));
    }

    public function saveJob(Request $request){
        
        $keywords =  implode(", ", $request->keywords);
        $data['keywords'] = $keywords;
        if(request()->job_id){
            $data = request()->only((new Job)->getFillable());
            $data['keywords'] = $keywords;
            // make the update
            Job::where('id', request()->job_id)->update($data);
            return Job::find(request()->job_id);
        }
        
        $email_cc = is_array(request()->application_email_cc) && count(request()->application_email_cc)?json_encode(request()->application_email_cc):null;
        $data = $request->all();
        $data['application_email_cc'] = $email_cc;
        $data['keywords'] = $keywords;
        $data['slug'] = makeSlug($data['title']).'-'.uniqid();
        $saved = Job::create($data);

        // assign job categories
        AssignedJobCategory::create(['category_id' => request()->category, 'job_id' => $saved->id]);
        return $saved;
    }

    public function changeJobStatus(){
        $job_id = request()->job_id;
        $status = request()->status;
        $active_status = array_search("Active", Job::STATUS);

        // check if the user has a role as employee
        if(Auth::check() && Auth::user()->hasRole('employer')){
            $company = Company::where('original_user', \Auth::user()->id)->first();
            $subscription = SubscriptionRepository::currentPlan(Auth::user()->id);
            $allowed_active_jobs = $subscription->contents->where('name', 'allowed_active_jobs')->first()->value??1;
            $active_jobs_count = activeJobs($company->id);
            if( $active_status == $status && $active_jobs_count >= $allowed_active_jobs){
                Throw new \Exception('Your plan does not allow more than '.$active_jobs_count." active jobs");
            }
        }
        // yes check if there are any active jbs
        return Job::where('id', $job_id)->update(['status' => $status]);
    }

    public function sendApplication(){
        $data = request()->all();
        $applied = JobApplication::create($data);
        $shared_certs = request()->selected_certificates;
        $data = array_map(function($row) use($applied){
            return ['job_application_id' => $applied->id, 'candidate_id' => request()->candidate_id, 'certificate_id' => $row['code']];
        }, $shared_certs);
        ApplicationAttachment::insert($data);

        // check if the application was supposed to be sent via email
        $job = Job::find(request()->job_id);
        if($job->apply_method == 'email'){
            $candidate = Candidate::find(request()->candidate_id);
            $user = User::find($candidate->user_id);
            \Mail::to($user)->send(new SendApplication($applied->id));
        }

        // store assessment responses if any
        $responses = request()->assessment_responses;
        $responses_to_save = [];
        foreach($responses as $response){
           $row = [
            'application_id' => $applied->id,
            'job_id' => request()->job_id,
            'screening_id' => $response['id'],
            'type' => $response['type'],
            'response' => $response['applicant_answer']
           ];
           $responses_to_save[] = $row;
        }
        if(count($responses_to_save)){
            ScreeningResponse::insert($responses_to_save);
        }

        return $applied;
    }

    public function registerView(){
        event(new JobViewed(request()->job_id, session()->get('uniqid')));
    }

    public function oldJobsByCategory(){
        if(request()->search){
            return redirect(route('jobs.by-category', makeSlug(request()->search)), 301);
        }
        return abort(404);
    }

    public function jobsByCategory($slug){
        $category = JobCategory::where('slug', $slug)->first();
        if(!$category){
            abort(404);
        }

        SEOMeta::setTitle($category->name." Jobs");
        SEOMeta::setDescription($category->description);
        if($category->keywords)
            SEOMeta::setKeywords($category->keywords);
        SEOMeta::addMeta('theme-color', '#6ad3ac');

        OpenGraph::setTitle($category->name." Jobs");
        OpenGraph::setDescription($category->description);
        OpenGraph::setUrl(route('jobs.by-category', $category->slug));
        OpenGraph::setSiteName('Ajiriwa Network');
        OpenGraph::setType('website');
        OpenGraph::setUrl(route('jobs.browse'));
        JsonLdMulti::addValue('itemListElement', [
            ['@type' => 'ListItem',
                'position' => 1,
                'name' => 'Browse '.$category->name.' Jobs',
                'item' => route('jobs.by-category', $category->slug)],
        ]);

        $assignments = AssignedJobCategory::where('category_id', $category->id)->pluck('job_id');
        $jobs = Job::whereIn('id', $assignments)->where('deadline', '>=', date('Y-m-d'))->get();
        $industries = Industry::all();
        $job_types = JobType::all();
        session()->flash('presets', [
            'category' => $category->id
        ]);
        //dd(\Route::current()->getName());
        return view('jobs.browse', compact('jobs', 'industries', 'job_types'));
        dd($jobs);
    }

    public function guestApplicationSubmit(){
        if(isset($_COOKIE['temp-user'])){
            $username = $_COOKIE['temp-user'];
            setcookie("temp-user", $username, time() + (86400 * 60));
        }else{
            $username = uniqid();
            setcookie("temp-user", $username, time() + (86400 * 60));
        }
        $name = request()->full_name;
        $email = request()->email;
        $cover = request()->cover_letter;
        $encodedCover = base64_encode($cover);
        $attachments =request()->attachments;
        $uploadedFiles = array();
        if(count($_FILES['attachments'])>0){
            for($x=0; $x<count($_FILES['attachments']['name']); $x++){
                $fileName = $_FILES['attachments']['name'][$x];
                $explodedName = explode(".", $fileName);
                $ext = end($explodedName);
                $target_dir = public_path("temp-files/");
                $target_file = $target_dir . basename($_FILES["attachments"]["name"][$x]);
                if (move_uploaded_file($_FILES["attachments"]["tmp_name"][$x], $target_file)) {
                    $uploaded = true;
                    array_push($uploadedFiles, $target_file);
                }else{
                    $uploaded = false;
                }
            }
        }else{
            $target_file = "";
        }
        $jobid = request()->job_id;
        $job = Job::find($jobid);
        if($job){
            $recepient = $job->application_email;
            $cc = json_decode($job->application_email_cc);
            $jobTitle = $job->title;

            if($job->email_subject_line){
                $subject = $job->email_subject_line;
            }else{
                $subject = $jobTitle." Application From ".$name;
            }

            if(isset($_FILES)){
                //echo "<br>".json_encode($_FILES);
            }

            if($job->apply_method == 'email'){
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.1and1.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@ajiriwa.net';//'accounts@ajiriwa.net';
                $mail->Password = '07570237Robsson!';//'07570237';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('applications@ajiriwa.net', 'Ajiriwa Job Applications');
                $mail->addAddress($recepient);
            }
            if($cc != ""){
                foreach($cc as $cc_email){
                    $mail->addCC($cc_email);
                }
            }
            $mail->addReplyTo($email, $name);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            foreach($uploadedFiles as $uploadedFile){
                $mail->AddAttachment($uploadedFile);
            }
            $mail->Body = $cover;
            if($mail->send()) {
                // create an entry to the unsigned applications table
                $inserted = GuestApplication::create(['job_id' => $job->id, 'username' => $username, 'full_name' => $name, 'cover_letter' => $cover]);
                if($inserted){
                    foreach($uploadedFiles as $uploadedFile){
                        unlink($uploadedFile);
                    }

                    if(isset($_COOKIE['guest-apply'])){
                        $cookie = unserialize($_COOKIE['guest-apply']);
                        if(!in_array($jobid, $cookie)){
                            array_push($cookie, $jobid);
                            $cookie = serialize($cookie);
                            //setcookie("guest-apply", $cookie, time() + (86400 * 30), "/");
                            cookie('guest-apply', $cookie, time() + (86400 * 30));
                        }
                    }else{
                        $cookie = serialize(array($jobid));
                        cookie('guest-apply', $cookie, time() + (86400 * 30));
                        //setcookie("guest-apply", $cookie, time() + (86400 * 30), "/");
                        return true;
                    }
                }
            }else{
                return $mail->ErrorInfo;
            }
        }
    }

    public function changeApplicationStatus(){
        $status = request()->to_status;
        $application_id = request()->application_id;

        switch ((int) $status){
            case 2:
                // marking the application as rejected
        }
        return JobApplication::where('id', $application_id)->update(['status' => $status]);
    }

    public function StoreAssessment($job_id){

        $job_id = request()->job_id;
        $data = request()->data;
        $saved = 0;
        //dd($data);
        foreach($data as $question){

            $check = [
                'job_id' => $job_id,
                'name' => $question['name'],
                'type' => $question['type'],
            ];
            $row = [
              'question' => $question['question']??'',
              'answer' => $question['answer'],
              'type' => $question['type'],
              'question_type' => $question['answer_type'],
              'input_type' => $question['input'],
              'options' => json_encode($question['options'])=='null'?null:json_encode($question['options']),
              'necessity' => $question['necessity'],
              'job_id' => $job_id,
              'name' => $question['name'],
            ];
            if(isset($question['id'])){
                // this means that the question is not new therefore update the existing entry
                $savedRow = JobScreening::find($question['id'])->update($row);
            }else{
                // the question is new hence create a new entry
                $savedRow = JobScreening::create($row);
            }

            if($savedRow){
                $saved++;
            }
        }
        /* $manager_approvals = \App\hiring_manager_approval_request::where('job_id', $job_id)->get();
        $job = \App\job::find($job_id);
        if(!is_null($job->hiring_manager) && !$manager_approvals->count()){
            // if the hiring manager is specified create a notification for the hiring manager to approve
            \App\Classes\recruitment::hiringManagerApprovalRequest($job->hashslug);
        } */
        return $saved;
    }

    public function GetAssessment(){
        $jobId = request()->job_id;
        
        $questions = JobScreening::where('job_id', $jobId)->get();
        return $questions;
    }

    public function DeleteAssessment(){
        $id = request()->question_id;
        return JobScreening::where('id', $id)->delete();
    }

    public function submitPromotion(){	
        //echo "here are your postings";
        $user = Auth::user();
        $ajiriwa_balance = $user->ajiriwa_balance;
            
        $budget = request()->budget;
        $gender = request()->gender;
        $location = request()->location;
        $title = request()->professional_title;
        $skills = request()->skills;
        $jobid = request()->jobid;
    
        if($ajiriwa_balance>$budget OR $ajiriwa_balance==$budget){
            
            // this will deduct the amount stated in the budget from the employer ajiriwa balance
            $charge = "UPDATE employer SET ajiriwa_balance = ajiriwa_balance-$budget WHERE username = '$user'";
            $charge = User::where('id', Auth::user()->id)->decrement('ajiriwa_balance', $budget);
            // When the deduction is successful insert the promotion into the promotion table
            if($charge){
                $data = [
                    "Job_ID" => $jobid,
                    "Budget" => $budget,
                    "Location" => $location,
                    "Professional_title" => $title,
                    "Skills" => $skills,
                    "Available_balance" => $budget,
                    "Gender" => $gender,
                    "Promoter" => $user->id,
                    "Status" => 'Active',
                ];              
                $promoted = \DB::table('job_promotions')->insert($data);
                
                /* if($promoted){
                    echo "The transaction is complete, your promotion is now active";
                } */
                return $promoted;
            }else{
                return false;
            }
        }else{
            //insufficient balance
            return -1;
            return "insufficient";
            echo "<p>Sorry, your ajiriwa balance is not sufficient. Please top up to continue</p>";	
            echo "<p><strong>Current Balance: </strong>".$remaining['ajiriwa_balance']."</p>";
            echo "<a href='#back-to-promote-".$jobid."' id='".$jobid."' class='promote w3-black w3-margin-right w3-button' onclick='openPromotion()'>Go Back</a>";
            echo "<a class='w3-button w3-green' onclick='howMuchToTopup()' id='topup'>Topup</a>";
        }
    }
}
