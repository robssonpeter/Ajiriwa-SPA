<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

    return view('home', compact('blog_posts'));
    /*return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);*/
})->name('root');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');
Route::get('/contact', [FaqsController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [FaqsController::class, 'privacyPolicy'])->name('privacy.policy');



Route::get('/browse-jobs.php', [JobController::class, 'browseGuest'])->name('jobs.browse.ext');
Route::get('/jobs.php', [JobController::class, 'browseGuest'])->name('jobs.browse.alt');

Route::get('/search.php', [JobController::class, 'search'])->name('jobs.search');
Route::get('/search/{keyword}', [JobController::class, 'search'])->name('jobs.search.friendly');

Route::get('/browse-jobs', [JobController::class, 'browse'])->name('jobs.browse');

Route::get('/jobs/category/{slug}', [JobController::class, 'browse'])->name('jobs.by-category');

Route::get('/view-job/{slug}', [JobController::class, 'viewJob'])->name('job.view');

Route::post('/job/register-view', [JobController::class, 'registerView'])->name('job.view.register');

Route::post('/job/guest-apply', [JobController::class, 'guestApplicationSubmit'])->name('job.guest-apply');

Route::post('/session/make', [SessionController::class, 'createSession'])->name('session.create');

Route::get('/company/view/{slug}', [CompanyController::class, 'show'])->name('company.show');


Route::group(['middleware' => ['auth']], function() {
    Route::get('/user/role/select', [UserController::class, 'userSelect'])->name('user.role.select');

    Route::get('user/selected-role/{role}', [UserController::class, 'userAssignRole'])->name('user.role.selected');

    Route::post('/candidate/job/apply', [JobController::class, 'sendApplication'])->name('application.send');
    Route::post('/candidate/info/{candidate_id}', [CandidateController::class, 'getCandidateInfo'])->name('candidate.get-info');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/my-resume', [CandidateController::class, 'myResume'])->name('my-resume');

    Route::get('/cv-template/{candidate_id}', [CandidateController::class, 'nakedCv'])->name('cv.template');

    Route::get('/print-cv/{candidate_id}', [CandidateController::class, 'cvDownload'])->name('cv.print');

    Route::get('/my-applications', [CandidateController::class, 'myApplications'])->name('my-applications');

    Route::get('/save-jobs', [CandidateController::class, 'savedJobs'])->name('saved-jobs');

    Route::post('/save-job/toggle', [CandidateController::class, 'toggleFavorite'])->name('job-save.toggle');

    Route::post('/application/withdraw', [CandidateController::class, 'withdrawApplication'])->name('application.withdraw');

    Route::get('/my-resume/edit', [CandidateController::class, 'myResumeEdit'])->name('my-resume.edit');

    Route::get('/my-resume/edit/{section}', [CandidateController::class, 'myResumeEdit'])->name('my-resume.edit.sectional');

    Route::post('/candidate/data/{type}/save', [CandidateController::class, 'saveData'])->name('save.candidate.data');

    Route::delete('/candidate/data/{type}/delete/{id}', [CandidateController::class, 'deleteData'])->name('delete.candidate.data');

    Route::post('/certificates', [CandidateController::class, 'uploadFile'])->name('candidate.certificates');

    Route::delete('/certificate/{media}', [CandidateController::class, 'removeFile'])->name('delete.candidate.file');

});

Route::group(['middleware' => ['auth', 'role:employer']], function(){
    Route::get('/company/info', [CompanyController::class, 'initialInformation'])->name('my-company.edit');
    Route::get('/company/customize', [CompanyController::class, 'customize'])->name('my-company.customize');
    Route::post('/company/info/save', [CompanyController::class, 'saveInitialInformation'])->name('company.initial.save');

    Route::get('/company/post-job', [CompanyController::class, 'postJob'])->name('company.post-job');
    Route::get('/company/edit-job/{slug}', [CompanyController::class, 'editJob'])->name('company.edit-job');
    Route::post('/company/save-job', [JobController::class, 'saveJob'])->name('job.save');
    Route::post('/company/job-status/change', [JobController::class, 'saveJob'])->name('job.status.change');
    Route::post('/company/save-description', [CompanyController::class, 'saveDescription'])->name('company.description.save');
    Route::get('/company/job/{slug}', [CompanyController::class, 'viewJob'])->name('company.job.view');
    Route::post('/company/job/{job_id}/store_application_columns', [CompanyController::class, 'storeApplicationColumns'])->name('company.job-attributes.store');
    Route::post('/company/schedule_interview', [CompanyController::class, 'scheduleInterview'])->name('company.schedule-interview');
    Route::get('/company/job/applications/{slug}', [CompanyController::class, 'jobApplications'])->name('company.job.applications');
    Route::get('/company/job/applications/{slug}/{application_id}', [CompanyController::class, 'jobApplication'])->name('company.job.application');
    Route::post('company/applications/filter', [CompanyController::class, 'FilterApplications'])->name('job.applications.filter')->middleware(['auth']);
    Route::get('/company/jobs', [CompanyController::class, 'showJobs'])->name('company.jobs.index');
    Route::get('/company/browse-candidates', [CompanyController::class, 'browseCandidates'])->name('company.candidates.browse');
    Route::post('/application/change-status', [CompanyController::class, 'changeApplicationStatus'])->name('application.change-status');

});


    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    if($user->hasRole('employer')){
        $component = 'Company/Dashboard';
        $candidate = false;
        $company = \App\Models\Company::where('original_user', Auth::user()->id)->first();
        $jobs = \App\Models\Job::where('company_id', $company->id)->pluck('id');
        $job_views = \App\Models\JobView::whereIn('job_id', $jobs)->count();
        $props = [
            'candidate' =>false,
            'job_views' => number_format($job_views),
            'total_applications' => number_format(\App\Models\JobApplication::whereIn('job_id', $jobs)->count()),
            'active_jobs' => 0,
            'total_spending' => 0,
            'recent_applications' => \App\Models\JobApplication::whereIn('job_id', $jobs)->join('jobs', 'jobs.id', 'job_applications.job_id')->orderBy('job_applications.id', 'DESC')->with('candidate')->limit(5)->get()
        ];
        ///dd($props);
    }else{
        $candidate = \App\Models\Candidate::where('user_id', $user->id)->first();
        //dd($candidate);
        $greeting = greet();
        $props = compact('candidate', 'greeting');
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
Route::get('company/email-templates', [CompanyController::class,'emailTemplates'])->name('company.email-templates')->middleware(['auth','role:employer']);
Route::get('company/email-template/get', 'CompanyController@getEmailTemplates')->name('email.templates.get')->middleware(['auth','role:Employer']);
Route::get('company/{template_id}/email-template', 'CompanyController@showEmailTemplate')->name('email.template.get')->middleware(['auth','role:Employer']);
Route::get('company/available-templates/{type}', 'CompanyController@availableTemplates')->name('templates.available')->middleware(['auth','role:Employer']);


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