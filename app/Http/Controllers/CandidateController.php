<?php

namespace App\Http\Controllers;

use App\Events\ProfileUpdated;
use App\Functionalities\Candidate as CandidateFunction;
use App\Models\ApplicationAttachment;
use App\Models\Candidate;
use App\Models\CandidateCertificate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateReferee;
use App\Models\CandidateSkill;
use App\Models\CandidateView;
use App\Models\CertificateCategory;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FavoriteJob;
use App\Models\Gender;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Media;
use App\Models\User;
use App\Repositories\CandidateRepository;
use App\Repositories\ResumeRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use mikehaertl\wkhtmlto\Pdf as WkhtmltoPdf;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myResume()
    {
        $breadcrumb = [
            [
                "label" => "Home",
                "url" => route('dashboard')
            ],
            [
                "label" => "My Resume",
            ]
        ];
        $with = [
            'certificates', 'education', 'experiences', 'languages', 'referees', 'skills'
        ];
        $candidate = Candidate::where('user_id', Auth::user()->id)->with($with)->first();
        $breadcrumb_actions = [
            [
                'label' => 'Download CV',
                'url' => route('cv.print', $candidate->id),
                'classes' => 'bg-gray-500 text-white rounded-md p-1 text-sm self-center mb-2',
                'is_spa' => false
            ],
            [
                'label' => 'Edit CV',
                'url' => route('my-resume.edit'),
                'classes' => 'bg-green-400 text-white rounded-md p-1 text-sm self-center mb-2',
                'is_spa' => true
            ],
        ];
        $skills = CandidateSkill::Levels;
        $user = Auth::user();
        $candidate->career_objective = htmlspecialchars_decode($candidate->career_objective);
        //dd($candidate);
        return Inertia::render('MyResume', compact('candidate', 'user', 'skills', 'breadcrumb', 'breadcrumb_actions'));
    }

    public function getCandidateInfo($candidate_id): array
    {
        if (!session()->has('profile_views')) {
            session()->put('profile_views', []);
        }
        if (!in_array($candidate_id, session()->get('profile_views'))) {
            $views = session()->get('profile_views');
            // create a profile view log
            $logged = CandidateView::create(['candidate_id' => $candidate_id, 'viewer_user_id' => Auth::user()->id]);

            // update the session variable for profile views
            if ($logged) {
                $views[] = $candidate_id;
                session()->put('profile_views', $views);
            }
        }
        $with = [
            'certificates', 'education', 'experiences', 'languages', 'referees', 'skills', 'sex'
        ];
        return [
            'candidate' => Candidate::join('users', 'users.id', 'candidates.user_id')->where('candidates.id', $candidate_id)->with($with)->select('candidates.*', 'users.email')->first(),
            'skills' => CandidateSkill::Levels,
        ];
    }

    public function myApplications()
    {
        $breadcrumb = [
            [
                "label" => "Home",
                "url" => route('dashboard')
            ],
            [
                "label" => "My Application",
            ]
        ];

        $candidate = Candidate::where('user_id', Auth::user()->id)->first();
        $status = JobApplication::STATUS;
        if (!$candidate) {
            abort(401);
        }
        $applications = JobApplication::where('candidate_id', $candidate->id)->with('job', 'attachments')->orderBy('created_at', 'DESC')->get();
        //dd($applications);
        return Inertia::render('Candidate/Applications', compact('applications', 'breadcrumb', 'status'));
    }

    public function savedJobs()
    {
        $breadcrumb = [
            [
                "label" => "Home",
                "url" => route('dashboard')
            ],
            [
                "label" => "Browse Jobs",
                "url" => route('jobs.browse')
            ],
            [
                "label" => "Saved Jobs",
            ]
        ];

        $candidate = Candidate::where('user_id', Auth::user()->id)->first();
        $status = JobApplication::STATUS;
        if (!$candidate) {
            abort(401);
        }
        $jobs = FavoriteJob::where('candidate_id', $candidate->id)->with('job')->get();
        return Inertia::render('Candidate/SavedJobs', compact('jobs', 'breadcrumb', 'status'));
    }

    public function viewJob($slug)
    {
        $job = Job::where('slug', $slug)->first();
        $allow_apply = false;
        return view('jobs.view-embed', compact('job', 'allow_apply'));
    }

    public function myResumeEdit($section = null)
    {
        $candidate = Candidate::where('user_id', Auth::user()->id)->first();
        $candidate->gender = $candidate->gender ?? '';
        $countries = countries();
        $industries = Industry::select('name', 'id')->get();
        $data = [
            'candidate_id' => $candidate->id,
            'profile_completion' => $candidate->profile_completion
        ];
        $sections = [
            'personal', 'career', 'experience', 'education', 'language', 'skills', 'awards', 'reference'
        ];
        //dd($countries);
        switch ($section) {
            case 'experience':
                $sectionIndex = array_search($section, $sections);
                $data['experience'] = CandidateExperience::where('candidate_id', $candidate->id)->get();
                if (isset($sections[$sectionIndex + 1])) {
                    $data['next'] = route('my-resume.edit.sectional', $sections[$sectionIndex + 1]);
                }
                if (isset($sections[$sectionIndex - 1])) {
                    $data['previous'] = route('my-resume.edit.sectional', $sections[$sectionIndex - 1]);
                }
                break;
            case 'education':
                $sectionIndex = array_search($section, $sections);
                $data['education'] = CandidateEducation::where('candidate_id', $candidate->id)->get();
                $data['education_levels'] = EducationLevel::all();
                if (isset($sections[$sectionIndex + 1])) {
                    $data['next'] = route('my-resume.edit.sectional', $sections[$sectionIndex + 1]);
                }
                if (isset($sections[$sectionIndex - 1])) {
                    $data['previous'] = route('my-resume.edit.sectional', $sections[$sectionIndex - 1]);
                }
                break;
            case 'language':
                $sectionIndex = array_search($section, $sections);
                $data['languages'] = CandidateLanguage::where('candidate_id', $candidate->id)->get();
                $data['language_levels'] = CandidateLanguage::Levels;
                if (isset($sections[$sectionIndex + 1])) {
                    $data['next'] = route('my-resume.edit.sectional', $sections[$sectionIndex + 1]);
                }
                if (isset($sections[$sectionIndex - 1])) {
                    $data['previous'] = route('my-resume.edit.sectional', $sections[$sectionIndex - 1]);
                }
                break;
            case 'skills':
                $sectionIndex = array_search($section, $sections);
                $data['skills'] = CandidateSkill::where('candidate_id', $candidate->id)->get();
                $data['skill_levels'] = CandidateSkill::Levels;
                if (isset($sections[$sectionIndex + 1])) {
                    $data['next'] = route('my-resume.edit.sectional', $sections[$sectionIndex + 1]);
                }
                if (isset($sections[$sectionIndex - 1])) {
                    $data['previous'] = route('my-resume.edit.sectional', $sections[$sectionIndex - 1]);
                }
                break;
            case 'reference':
                $sectionIndex = array_search($section, $sections);
                $data['referees'] = CandidateReferee::where('candidate_id', $candidate->id)->get();
                if (isset($sections[$sectionIndex + 1])) {
                    $data['next'] = route('my-resume.edit.sectional', $sections[$sectionIndex + 1]);
                }
                if (isset($sections[$sectionIndex - 1])) {
                    $data['previous'] = route('my-resume.edit.sectional', $sections[$sectionIndex - 1]);
                }
                break;
            case 'awards':
                $sectionIndex = array_search($section, $sections);
                $data['certificates'] = CandidateCertificate::where('candidate_id', $candidate->id)->get();
                $data['categories'] = CertificateCategory::all();
                if (isset($sections[$sectionIndex + 1])) {
                    $data['next'] = route('my-resume.edit.sectional', $sections[$sectionIndex + 1]);
                }
                if (isset($sections[$sectionIndex - 1])) {
                    $data['previous'] = route('my-resume.edit.sectional', $sections[$sectionIndex - 1]);
                }
                break;
            default:
                $section = $section ?? 'personal';
                $sectionIndex = array_search($section, $sections);
                $data['genders'] = Gender::all();
                $data['personal'] = $candidate;
                $data['old'] = $candidate;
                if (isset($sections[$sectionIndex + 1])) {
                    $data['next'] = route('my-resume.edit.sectional', $sections[$sectionIndex + 1]);
                }
                if (isset($sections[$sectionIndex - 1])) {
                    $data['previous'] = route('my-resume.edit.sectional', $sections[$sectionIndex - 1]);
                }
                break;
        }

        return Inertia::render('MyResumeEdit', [
            'section' => $section,
            'countries' => $countries,
            'industries' => $industries,
            'data' => $data,
            'return_to_link' => session()->get('return_to_link')
        ]);
    }

    public function saveData($type)
    {
        $saved = [];
        $candidate = Candidate::where('user_id', Auth::user()->id)->select('id')->first();
        switch ($type) {
            case 'personal':
                $make_slug = is_null($candidate->slug);
                $saved = ResumeRepository::addPersonal(request()->data, $candidate->id, $make_slug);
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
        event(new ProfileUpdated(Auth::user()->id));
        return $saved;
    }

    public function deleteData($type, $id)
    {
        $deleted = null;
        switch ($type) {
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
        event(new ProfileUpdated(Auth::user()->id));
        return $deleted;
    }

    public function uploadFile(Request $request)
    {
        $input = $request->all();

        CandidateRepository::uploadFile($input);

        // profile completion calculator
        $candidate = Candidate::find($input['candidate_id']);
        /**/
        //\Spatie\MediaLibrary\Models\Media::find(1);
        if (isset($input['return'])) {
            $certificate = Media::where('model_type', 'App\Models\Candidate')->where('collection_name', 'certifications')->where('model_id', $request->candidate_id)->orderBy('id', 'DESC')->first();
            event(new ProfileUpdated($candidate->user_id));
            return $this->sendResponse($certificate, 'Successfully Uploaded');
        }
    }

    public function removeFile(Media $media)
    {
        $media->delete();

        //CandidateFunction::profileCompletion(Auth::user()->id);

        return $this->sendSuccess('Media deleted successfully.');
    }


    public function withdrawApplication()
    {
        $application_id =  request()->application_id;
        $candidate = Candidate::where('user_id', Auth::user()->id)->first();
        $application =  JobApplication::find($application_id);

        if (!$candidate || $candidate->id != $application->candidate_id) {
            abort(401);
        }
        // delete shared attachments
        ApplicationAttachment::where('job_application_id', $application_id)->delete();

        return $application->delete();
    }

    public function toggleFavorite()
    {
        $job_id = request()->job_id;
        $user = Auth::user();
        $candidate = Candidate::where('user_id', $user->id)->first();
        $action = request()->action;
        $data = [
            'candidate_id' => $candidate->id,
            'job_id' => $job_id
        ];
        if ($action == 'add') {
            return FavoriteJob::updateOrCreate($data, $data);
        }
        return FavoriteJob::where('candidate_id', $candidate->id)->where('job_id', $job_id)->delete();
    }

    public function nakedCv($candidate_id)
    {
        $with = [
            'education', 'experiences', 'languages', 'referees', 'skills'
        ];
        $candidate = Candidate::where('id', $candidate_id)->with($with)->first();
        if (!$candidate) {
            abort(404);
        }
        $skills = CandidateSkill::Levels;
        $user = Auth::user();
        //dd($candidate->skills);

        return view('CvTemplates.material', compact('candidate', 'skills', 'user'));
    }



    public function cvDownload($candidate_id)
    {
        $with = [
            'education', 'experiences', 'languages', 'referees', 'skills'
        ];
        $candidate = Candidate::where('id', $candidate_id)->with($with)->first();
        $skills = CandidateSkill::Levels;
        $user = User::find($candidate->user_id);
        $url = asset('/');
        $options = array(
            'no-outline',         // Make Chrome not complain
            'margin-top'    => 1,
            'margin-right'  => 5,
            'margin-bottom' => 0,
            'margin-left'   => 5,
            // Default page options
            'disable-smart-shrinking',
        );
        // check the url if it contains https:
        if (str_contains($url, 'https:')) {
            return ResumeRepository::renderCV($candidate->id, 'download');
            // use the wk html to pdf
            /* $pdf = new WkhtmltoPdf($options);
            $pdf->addPage(route('resume.pdf', $candidate->slug));
            //dd($pdf);
            return $pdf->send(makeSlug($candidate->full_name) . '-cv.pdf'); */
        }
        // using wkhtmltopdf
        /* $pdf = new WkhtmltoPdf(route('cv.template', $candidate_id));
        
        return $pdf->send('test.pdf'); */
        $pdf = Pdf::loadView('CvTemplates.material', compact('candidate', 'skills', 'user'));
        return $pdf->download(makeSlug($candidate->full_name) . '-cv.pdf');
    }
}
