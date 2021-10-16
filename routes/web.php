<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('root');

Route::get('/browse-jobs.php', [JobController::class, 'browse'])->name('jobs.browse');

Route::get('/view-job/{slug}', [JobController::class, 'viewJob'])->name('job.view');


Route::group(['middleware' => ['auth']], function() {
    Route::get('/user/role/select', [UserController::class, 'userSelect'])->name('user.role.select');

    Route::get('user/selected-role/{role}', [UserController::class, 'userAssignRole'])->name('user.role.selected');

    Route::post('/candidate/job/apply', [JobController::class, 'sendApplication'])->name('application.send');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/my-resume', [CandidateController::class, 'myResume'])->name('my-resume');

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
    Route::post('/company/save-job', [JobController::class, 'saveJob'])->name('job.save');
    Route::get('/company/job/{slug}', [CompanyController::class, 'viewJob'])->name('company.job.view');
    Route::get('/company/job/applications/{slug}', [CompanyController::class, 'jobApplications'])->name('company.job.applications');
    Route::get('/company/job/applications/{slug}/{application_id}', [CompanyController::class, 'jobApplication'])->name('company.job.application');
    Route::get('/company/jobs', [CompanyController::class, 'showJobs'])->name('company.jobs.index');

});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    if($user->hasRole('employer')){
        $component = 'Company/Dashboard';
    }else{
        $component = 'Dashboard';
    }
    return Inertia::render($component);
})->name('dashboard');

