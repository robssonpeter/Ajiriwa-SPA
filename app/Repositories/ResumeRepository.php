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
use Barryvdh\DomPDF\Facade\Pdf;
use mikehaertl\wkhtmlto\Pdf as WkhtmltoPdf;

class ResumeRepository
{
    public static function addPersonal($data, $candidate_id, $make_slug = false)
    {
        $fillable = new Candidate;
        $fillable->getFillable();
        if ($make_slug) {
            $slug = $data['first_name'] . " " . $data['middle_name'] . " " . $data['last_name'] . " " . uniqid();
            $data['slug'] = makeSlug($slug);
        }
        return Candidate::where('id', $candidate_id)->update(Arr::only($data, $fillable->getFillable()));;
    }

    public static function addExperience($data)
    {
        if (isset($data['id'])) {
            // update the existing experience
            $fillable = new CandidateExperience;
            $fillable->getFillable();
            return CandidateExperience::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        } else {
            // add a new experience
            return CandidateExperience::create($data);
        }
    }

    public static function removeExperience($experience_id, $user_id)
    {
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $experience = CandidateExperience::find($experience_id);
        if ($experience->candidate_id == $candidate->id) {
            // make a deletion
            return $experience->delete();
        }
        return null;
    }

    public static function removeEducation($education_id, $user_id)
    {
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $education = CandidateEducation::find($education_id);
        if ($education->candidate_id == $candidate->id) {
            // make a deletion
            return $education->delete();
        }
        return null;
    }


    public static function addEducation($data)
    {
        if (isset($data['id'])) {
            // update the existing experience
            $fillable = new CandidateEducation();
            $fillable->getFillable();
            return CandidateEducation::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        } else {
            // add a new experience
            return CandidateEducation::create($data);
        }
    }

    public static function removeLanguage($language_id, $user_id)
    {
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $language = CandidateLanguage::find($language_id);
        if ($language->candidate_id == $candidate->id) {
            // make a deletion
            return $language->delete();
        }
        return null;
    }

    public static function addLanguage($data)
    {
        if (isset($data['id'])) {
            // update the existing language
            $fillable = new CandidateLanguage();
            $fillable->getFillable();
            return CandidateLanguage::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        } else {
            // add a new language
            return CandidateLanguage::create($data);
        }
    }

    public static function addSkill($data)
    {
        if (isset($data['id'])) {
            // update the existing skill
            $fillable = new CandidateSkill();
            $fillable->getFillable();
            return CandidateSkill::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        } else {
            // add a new skill
            return CandidateSkill::create($data);
        }
    }

    public static function removeSkill($skill_id, $user_id)
    {
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $skill = CandidateSkill::find($skill_id);
        if ($skill->candidate_id == $candidate->id) {
            // make a deletion
            return $skill->delete();
        }
        return null;
    }

    public static function addReferee($data)
    {
        if (isset($data['id'])) {
            // update the existing skill
            $fillable = new CandidateReferee();
            $fillable->getFillable();
            return CandidateReferee::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        } else {
            // add a new skill
            return CandidateReferee::create($data);
        }
    }

    public static function removeReferee($referee_id, $user_id)
    {
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $referee = CandidateReferee::find($referee_id);
        if ($referee->candidate_id == $candidate->id) {
            // make a deletion
            return $referee->delete();
        }
        return null;
    }



    public static function addCertificate($data)
    {
        if (isset($data['id'])) {
            // update the existing skill
            $fillable = new CandidateCertificate();
            $fillable->getFillable();
            // add entry in the candidate database
            return CandidateCertificate::where('id', $data['id'])->update(Arr::only($data, $fillable->getFillable()));
        } else {
            // add a new skill
            return CandidateCertificate::create($data);
        }
    }

    public static function removeCertificate($certificate_id, $user_id)
    {
        // check if the data belongs to the user
        $candidate = Candidate::where('user_id', $user_id)->first();
        $certificate = CandidateCertificate::find($certificate_id);
        if ($certificate->candidate_id == $candidate->id) {
            // make a deletion
            return $certificate->delete();
            // remove the media if exists

        }
        return null;
    }

    /**
     * This function is used to render a profile into a pdf of a cv
     *
     * @param [type] $candidate_id
     * @param string $type if type is download a download will be initiated else it will be rendered and stored at
     * `/temp-files/$first_name-$last_name-$candidate_id-cv.pdf` 
     * @return void
     */
    public static function renderCV($candidate_id, $type = 'download')
    {
        $options = array(
            'no-outline',         // Make Chrome not complain
            'margin-top'    => 1,
            'margin-right'  => 5,
            'margin-bottom' => 0,
            'margin-left'   => 5,
            // Default page options
            'disable-smart-shrinking',
        );
        $candidate = Candidate::find($candidate_id);
        if ($candidate) {
            // use the wk html to pdf
            $pdf = new WkhtmltoPdf($options);
            $pdf->addPage(route('resume.pdf', $candidate->slug));
            //dd($pdf);
            if ($type == 'download'){
                return $pdf->send(makeSlug($candidate->full_name) . '-cv.pdf');
            }
            else
            {
                $file_url = public_path('temp-files/'.makeSlug($candidate->full_name)."-".$candidate->id . '-cv.pdf');
                $pdf->saveAs($file_url);
            }
            return $file_url;
        }
    }
}
