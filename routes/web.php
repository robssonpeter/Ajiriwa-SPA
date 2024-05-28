<?php

use App\Custom\DataTransfer;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SEOController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\CorsMiddleware;
use App\Models\BlogPost;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    if(Auth::check()){
        return redirect()->route('dashboard');
    }

    $blog_posts = \App\Models\BlogPost::limit(3)->orderBy('id', 'ASC')->get();
    $today = date('Y-m-d');
    $select = [
        'id',
        'title',
        'slug',
        'created_at',
        'company_id',
    ];
    $latest_jobs = Job::select($select)->orderBy('id', 'DESC')->where('deadline', '>=', $today)->limit(10)->get();
    SEOMeta::addMeta('theme-color', '#6ad3ac');
    SEOMeta::setTitle("Jobs in Tanzania ".date('Y'));
    SEOMeta::addMeta('description', 'A great place to look for the job that will suit you. Build your profile by adding information to your resume and easily make application for any job in our system. We bring employers and job seekers together.');
    SEOMeta::addMeta('keywords', 'Jobs in tanzania, nafasi za kazi, ajira mpya, nafasi za kazi serikalini, ajira zetu, ajira, employement oppotunities, kazi tanzania, kazi, ajira tanzania, all jobs, kazi mpya, kazini, zoom tanzania jobs, brighter monday');
    SEOMeta::addMeta('robots', 'index, follow');
    SEOMeta::addMeta('language', 'English');
    SEOMeta::addMeta('revist-after', '1 days');
    OpenGraph::setTitle("Jobs in Tanzania ".date('Y'));
    OpenGraph::addImage(asset('images/ajiriwa-new-logo.png'));
    OpenGraph::setUrl(route('root'));
    OpenGraph::setSiteName("Ajiriwa");
    OpenGraph::setType('website');

    $job_categories = JobCategory::withCount('active_jobs')->orderBy('active_jobs_count', 'desc')->limit(15)->get();
    //dd($latest_jobs->count());

    return view('home', compact('blog_posts', 'latest_jobs', 'job_categories'));
    /*return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);*/
})->name('root');

Route::get('/sitemap', [SEOController::class, 'sitemap'])->name('sitemap');

Route::get('/about', [FaqsController::class, 'about'])->name('about');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'viewPost'])->name('blog.post.view');
Route::get('/blog-single-post.php', function(){
    $blog = BlogPost::where('old_id', request()->id)->first();
    
    if(!$blog){
        abort(404);
    }
    return redirect()->route('blog.post.view', $blog->slug, 301);
})->name('old.post.view');
Route::get('/employer', [BlogController::class, 'employers'])->name('employers');
Route::get('/contact', [FaqsController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [FaqsController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/showcv.php', [ResumeController::class, 'oldCv'])->name('guest.cv');
Route::get('/profile/{slug}', [ResumeController::class, 'guestCv'])->name('candidate.profile');
Route::get('/resume/{slug}', [ResumeController::class, 'exportCv'])->name('resume.pdf');



Route::get('/browse-jobs', [JobController::class, 'browseGuest'])->middleware(CorsMiddleware::class)->name('jobs.browse.ext');
Route::get('/jobs', [JobController::class, 'browseGuest'])->name('jobs.browse.alt');

Route::match(['GET', 'POST'], '/search', [JobController::class, 'search'])->name('jobs.search');
Route::get('/search/{keyword}', [JobController::class, 'search'])->name('jobs.search.friendly');

Route::get('/browse/jobs', [JobController::class, 'browse'])->name('jobs.browse')->middleware('auth');

Route::get('/job-by/category/{slug}', [JobController::class, 'jobsByCategory'])->name('jobs.by-category');
Route::get('/browse-jobs-categories.php', [JobController::class, 'oldJobsByCategory'])->name('jobs.by-category.old');


Route::get('/job-page.php', [JobController::class, 'oldJob'])->name('old-job.view');
Route::get('/view-job/{slug}', [JobController::class, 'viewJob'])->name('job.view');
Route::get('/job-amp/{slug}', [JobController::class, 'viewJob'])->name('job.amp');
Route::get('/apply/{slug}', [JobController::class, 'applyJob'])->middleware('auth')->name('job.apply');
Route::post('/can-apply', [CandidateController::class, 'canApplyForJob'])->middleware('auth')->name('job.can-apply');

Route::post('/job/register-view', [JobController::class, 'registerView'])->name('job.view.register');

Route::post('/job/guest-apply', [JobController::class, 'guestApplicationSubmit'])->name('job.guest-apply');

Route::post('/session/make', [SessionController::class, 'createSession'])->name('session.create');

Route::get('/company/view/{slug}', [CompanyController::class, 'show'])->name('company.show');
Route::post('/company/new', [CompanyController::class, 'saveNewCompany'])->middleware("role:admin")->name('company.new');


Route::group(['middleware' => ['auth']], function() {
    Route::get('/user/role/select', [UserController::class, 'userSelect'])->name('user.role.select');

    Route::get('user/selected-role/{role}', [UserController::class, 'userAssignRole'])->name('user.role.selected');

    Route::post('/candidate/job/apply', [JobController::class, 'sendApplication'])->name('application.send');
    Route::post('/candidate/job/apply/store', [JobController::class, 'storeApplication'])->name('application.store');
    Route::post('/candidate/info/{candidate_id}', [CandidateController::class, 'getCandidateInfo'])->name('candidate.get-info');
    Route::post('/candidate/profile-completion', [CandidateController::class, 'profileCompletion'])->name('candidate.profile.completion');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/my-resume', [CandidateController::class, 'myResume'])->name('my-resume');

    Route::get('/cv-template/{candidate_id}', [CandidateController::class, 'nakedCv'])->name('cv.template');

    Route::get('/print-cv/{candidate_id}', [CandidateController::class, 'cvDownload'])->name('cv.print');

    Route::get('/my-applications', [CandidateController::class, 'myApplications'])->name('my-applications');

    Route::get('/save-jobs', [CandidateController::class, 'savedJobs'])->name('saved-jobs');
    
    Route::get('/candidate/job/{slug}', [CandidateController::class, 'viewJob'])->name('candidate.view-job');

    Route::post('/save-job/toggle', [CandidateController::class, 'toggleFavorite'])->name('job-save.toggle');

    Route::post('/application/withdraw', [CandidateController::class, 'withdrawApplication'])->name('application.withdraw');

    Route::get('/my-resume/edit', [CandidateController::class, 'myResumeEdit'])->name('my-resume.edit');

    Route::get('/my-resume/edit/{section}', [CandidateController::class, 'myResumeEdit'])->name('my-resume.edit.sectional');

    Route::post('/candidate/data/{type}/save', [CandidateController::class, 'saveData'])->name('save.candidate.data');

    Route::delete('/candidate/data/{type}/delete/{id}', [CandidateController::class, 'deleteData'])->name('delete.candidate.data');

    Route::post('/certificates', [CandidateController::class, 'uploadFile'])->name('candidate.certificates');
    
    Route::post('/file-upload', [FileController::class, 'SaveFile'])->name('file.uploads');

    Route::delete('/certificate/{media}', [CandidateController::class, 'removeFile'])->name('delete.candidate.file');

});

Route::group(['middleware' => ['auth', 'role:employer|admin']], function(){
    Route::get('/company/info', [CompanyController::class, 'initialInformation'])->name('my-company.edit');
    Route::get('/company/customize', [CompanyController::class, 'customize'])->name('my-company.customize');
    Route::post('/company/info/save', [CompanyController::class, 'saveInitialInformation'])->name('company.initial.save');

    Route::get('/company/post-job', [CompanyController::class, 'postJob'])->middleware('verifier')->name('company.post-job');
    Route::get('/company/edit-job/{slug}', [CompanyController::class, 'editJob'])->name('company.edit-job')->middleware('verifier');
    Route::post('/company/save-job', [JobController::class, 'saveJob'])->name('job.save');
    Route::post('/company/promotion-submit', [JobController::class, 'submitPromotion'])->name('promotion.submit');
    Route::post('/company/promotion-insight', [PromotionController::class, 'promotionInsight'])->name('promotion.insights');
    Route::post('/company/job-status/change', [JobController::class, 'changeJobStatus'])->name('job.status.change');
    Route::post('/company/save-description', [CompanyController::class, 'saveDescription'])->name('company.description.save');
    Route::get('/company/job/{slug}', [CompanyController::class, 'viewJob'])->name('company.job.view');
    Route::post('/company/job/{job_id}/store_application_columns', [CompanyController::class, 'storeApplicationColumns'])->name('company.job-attributes.store');
    Route::post('/company/schedule_interview', [CompanyController::class, 'scheduleInterview'])->name('company.schedule-interview');
    Route::get('/company/job/applications/{slug}', [CompanyController::class, 'jobApplications'])->name('company.job.applications');
    Route::get('/company/job/applications/{slug}/{application_id}', [CompanyController::class, 'jobApplication'])->name('company.job.application');
    Route::post('company/applications/filter', [CompanyController::class, 'FilterApplications'])->name('job.applications.filter')->middleware(['auth']);
    Route::get('/company/jobs', [CompanyController::class, 'showJobs'])->name('company.jobs.index')->middleware('verifier');
    Route::post('/company/jobs/search', [CompanyController::class, 'searchJobs'])->name('company.jobs.search')->middleware('verifier');
    Route::get('/company/browse-candidates', [CompanyController::class, 'browseCandidates'])->name('company.candidates.browse')->middleware('verifier');
    Route::post('/company/search-candidates', [CompanyController::class, 'searchCandidates'])->name('company.candidates.search');
    Route::post('/company/recommend-candidates', [CompanyController::class, 'showRecommendedCandidates'])->name('company.candidates.recommend');
    Route::post('/application/change-status', [CompanyController::class, 'changeApplicationStatus'])->name('application.change-status');

});
Route::post('/company/search', [CompanyController::class, 'searchCompanies'])->name('companies.search');
Route::post('/company/claiming', [CompanyController::class, 'markClaimingCompany'])->name('company.claiming');


    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    if(session()->has('redirect')){
        $link = session()->get('redirect');
        session()->forget('redirect');
        return redirect()->to($link);
    }
    if($user->hasRole('employer')){
        $component = 'Company/Dashboard';
        $candidate = false;
        $company = \App\Models\Company::where('original_user', Auth::user()->id)->first();
        // if the user does not have the account information
        if(!$company->name){
            $industries = \App\Models\Industry::orderBy('name', 'ASC')->get();
            $user = Auth::user();
            // check if the user already attempted to claim their account
            if($user->claiming_company_id){
                return redirect()->route('company.claim.verify');
            }
            return Inertia::render('Company/InitialInfo', [
                'industries' => $industries,
                'company' => $company,
                'user' => $user
            ]);
        }
        $jobs = \App\Models\Job::where('company_id', $company->id)->pluck('id');
        $job_views = \App\Models\JobView::whereIn('job_id', $jobs)->count();
        $props = [
            'candidate' =>false,
            'job_views' => number_format($job_views),
            'total_applications' => number_format(\App\Models\JobApplication::when(Auth::user()->hasRole('employer'), function($q) use($jobs){
                return $q->whereIn('job_id', $jobs);
            })->count()),
            'active_jobs' => Job::where('status', array_search('Active', Job::STATUS))->when(Auth::user()->hasRole('employer'), function($q) use($jobs){
                return $q->whereIn('id', $jobs);
            })->count(),
            'total_spending' => 0,
            'recent_applications' => \App\Models\JobApplication::when(Auth::user()->hasRole('employer'), function($q) use($jobs){
                return $q->whereIn('job_id', $jobs);
            })->join('jobs', 'jobs.id', 'job_applications.job_id')->orderBy('job_applications.id', 'DESC')->with('candidate')->limit(4)->get()
        ];
        //dd($props);
    }else if($user->hasRole('admin')){
        $component = 'Admin/Dashboard';
        $candidate = false;
        $job_views = \App\Models\JobView::count() + Job::sum('counted_views');
        $props = [
            'candidate' =>false,
            'job_views' => number_format($job_views),
            'total_applications' => number_format(\App\Models\JobApplication::count()),
            'active_jobs' => Job::where('status', array_search('Active', Job::STATUS))->where('deadline', '>=', date('Y-m-d'))->count(),
            'total_spending' => 0,
            'pending_companies' => Company::with('verification_attempt', 'verification', 'user')->whereHas('verification_attempt')->whereDoesntHave('verification')->count(),
            'recent_applications' => \App\Models\JobApplication::join('jobs', 'jobs.id', 'job_applications.job_id')->orderBy('job_applications.id', 'DESC')->with('candidate')->limit(4)->get()
        ];
    }else{
        $candidate = \App\Models\Candidate::where('user_id', $user->id)->first();
        //dd($candidate);
        $greeting = greet();
        $jobs = Job::where('deadline', '>=', date('Y-m-d'))->orderBy('id', 'DESC')->limit(4)->get();
    
        $props = compact('candidate', 'greeting', 'jobs');
        $component = 'Dashboard';
    }

    return Inertia::render($component, $props);
})->name('dashboard');

/*
 |------------------------------------------------------------------------------------------------------------
 |          File Management Routes
 |------------------------------------------------------------------------------------------------------------
 */
Route::post('/file/upload/save', [FileController::class, 'SaveFile'])->name('file.save');
Route::post('/file/remove', [FileController::class, 'RemoveFile'])->name('file.remove');

/*
 |------------------------------------------------------------------------------------------------------------
 |          Notification Push Routes
 |------------------------------------------------------------------------------------------------------------
 */
Route::post('/push',[PushController::class, 'store']);
Route::patch('/fcm-token', [PushController::class, 'updateToken'])->name('fcmToken');
Route::get('/send-notification',[PushController::class,'sendNotification'])->name('notification');

/*
 |------------------------------------------------------------------------------------------------------------
 |          Authentication Routes
 |------------------------------------------------------------------------------------------------------------
 */

Route::post('logout',[UserController::class, 'logout'])->name('logout');

/*
 |------------------------------------------------------------------------------------------------------------
 |          Social Login Routes
 |------------------------------------------------------------------------------------------------------------
 */
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
Route::get('auth/{provider}', [LoginController::class, 'redirectToProvider'])->name('provider.redirect');
Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);


/*
 * -----------------------------------------------------------------------------------------------------------
 *          Email Template Routes
 * -----------------------------------------------------------------------------------------------------------
 */
Route::get('company/email-templates', [CompanyController::class,'emailTemplates'])->name('company.email-templates')->middleware(['auth','role:employer', 'verifier']);
Route::get('company/email-template/get', [CompanyController::class,'getEmailTemplates'])->name('email.templates.get')->middleware(['auth','role:employer']);
Route::get('company/{template_id}/email-template', [CompanyController::class, 'showEmailTemplate'])->name('email.template.get')->middleware(['auth','role:employer']);
Route::get('company/available-templates/{type}', [CompanyController::class, 'availableTemplates'])->name('templates.available')->middleware(['auth','role:employer']);
Route::post('company/template/store', [CompanyController::class, 'saveNewTemplate'])->name('template.store')->middleware(['auth','role:employer']);
Route::post('company/template/update', [CompanyController::class, 'updateTemplate'])->name('template.update')->middleware(['auth','role:employer']);
Route::post('company/template/delete', [CompanyController::class, 'deleteTemplate'])->name('template.delete')->middleware(['auth','role:employer']);
Route::post('company/template/set-default', [CompanyController::class, 'setDefaultTemplate'])->name('email.template.set-default')->middleware(['auth','role:employer']);


/*
 * -----------------------------------------------------------------------------------------------------------
 *          Job Screening Routes
 * -----------------------------------------------------------------------------------------------------------
 */
Route::get('/job-posting/assessments/{hash}', [CompanyController::class, 'Assessments'])->name('job.assessment')->middleware(['auth']);
Route::post('/job/assessments/get', [JobController::class, 'GetAssessment'])->name('job.assessment.get');
Route::post('/job/assessments/delete', [JobController::class, 'DeleteAssessment'])->name('job.assessment.delete');
Route::post('/application/assessment', [CompanyController::class, 'ApplicationAssessment'])->name('job.application.assessment')->middleware(['auth']);
Route::post('/job-posting/assessments/{hash}/save', [JobController::class, 'StoreAssessment'])->middleware(['auth'])->name('job.assessment.save');


/**
 * ----------------------------------------------------------------------------------------------------------
 *          Company Verification Routes
 * ----------------------------------------------------------------------------------------------------------
 */
Route::get('company/verify', [CompanyController::class, 'verificationAttempt'])->name('company.verify')->middleware(['auth']);
Route::get('company/claim/verify', [CompanyController::class, 'claimVerificationAttempt'])->name('company.claim.verify')->middleware(['auth']);
Route::group(["prefix" => 'admin/', 'middleware' => 'role:admin'], function(){
    Route::get('companies/verify', [CompanyController::class, 'verify'])->name('admin.company.verify');
    Route::post('companies/verify/{id}', [CompanyController::class, 'verifySave'])->name('admin.company.verify.save');
    Route::post('companies/verify/{id}/revoke', 'CompanyController@verifyRevoke')->name('admin.company.verify.revoke');
    Route::post('companies/reject/{id}', 'CompanyController@verificationReject')->name('admin.company.verification.reject');
    Route::post('companies/required/verification-documents', 'CompanyController@saveVerificationDocuments')->name('admin.verification.documents.save');
});

/**
 * ----------------------------------------------------------------------------------------------------------
 *          Payment Routes
 * ----------------------------------------------------------------------------------------------------------
 */
Route::post('/payment/init', [PaymentController::class, 'PaymentInit'])->middleware(['auth'])->name('payment.init');
Route::get('/payment-status.php', [PaymentController::class, 'PaymentStatus'])->name('payment.status');

Route::post('company/verification/upload', [CompanyController::class, 'uploadVerificationAttachment'])->name('company.verification.upload')->middleware(['auth']);
Route::post('company/verify', [CompanyController::class, 'verificationSave'])->name('company.verification.save')->middleware(['auth']);
require 'admin.php';

/**
 * ----------------------------------------------------------------------------------------------------------
 *          Subscription Routes
 * ----------------------------------------------------------------------------------------------------------
 */
Route::get('/subscription/select', [SubscriptionController::class, 'Packages'])->name('subscription.packages')->middleware(['auth']);
Route::post('/subscription/current-balance', [SubscriptionController::class, 'CurrentBalance'])->name('current.balance')->middleware(['auth']);
Route::post('/subscription/charge', [SubscriptionController::class, 'Charge'])->name('subscription.charge')->middleware(['auth']);

Route::get('/php-info', function(){
    phpinfo();
});

/**
 * ----------------------------------------------------------------------------------------------------------
 *          Promotion Routes
 * ----------------------------------------------------------------------------------------------------------
 */
Route::get('/ads-trck.php', [PromotionController::class, 'adTrack'])->name('promotion.track');
Route::post('/promotion/change-status', [PromotionController::class, 'changeStatus'])->name('promotion.change.status');
Route::post('/promotion/change-budget', [PromotionController::class, 'changeBudget'])->name('promotion.change.budget');
Route::get('/redirects', [JobController::class, 'externalRedirect'])->name('redirect');

/**
 * ----------------------------------------------------------------------------------------------------------
 *          Transfer Routes
 * ----------------------------------------------------------------------------------------------------------
 */
Route::get('/transfer-companies', function() {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    return DataTransfer::transferCompanies();
})->name('companies.transfer');
Route::get('/transfer-candidates', function() {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    return DataTransfer::transferCandidates();
})->name('candidates.transfer');
Route::get('/transfer-jobs', function() {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    return DataTransfer::transferJobs();
})->name('candidates.jobs');

/**
 * ----------------------------------------------------------------------------------------------------------
 *          CV Faces Routes
 * ----------------------------------------------------------------------------------------------------------
 */
Route::get('/cv-faces/Material/bootstraped', [CvController::class, 'materialBootstrap'])->name('material.bootstraped');
Route::get('/apis/candidates/', [CvController::class, 'candidateSearch'])->name('candidate.search.remote');

/**
 * ----------------------------------------------------------------------------------------------------------
 *          CV Maker Routes
 * ----------------------------------------------------------------------------------------------------------
 */
Route::get('/app/cv-maker/', [CvController::class, 'cvMaker'])->name('app.cv-maker');

/**
 * ------------------------------------------------------------------------------------------
 *          Faqs Related Routes
 * ------------------------------------------------------------------------------------------
 */
Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');
Route::group(['prefix' => 'admin', 'middleware' => AdminOnly::class], function(){
    Route::get('/faqs', [FaqsController::class, 'manage'])->name('faqs.manage');
    Route::post('/faqs/store', [FaqsController::class, 'store'])->name('faq.store');
    Route::put('/faqs/{id}', [FaqsController::class, 'update'])->name('faq.update');
});
Route::post('/faq/register-view', [FaqsController::class, 'registerView'])->name('faqs.register-view');
Route::post('/faq/search', [FaqsController::class, 'search'])->name('faq.search');
