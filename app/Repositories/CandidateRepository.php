<?php


namespace App\Repositories;


use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Exception;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CandidateRepository
{


    public static function uploadFile($input, $resume = true)
    {

        /**
         * if $resume  == true -> the user is uploading a cv
         * if $resume == null -> the user is uploading a salary slip
         * else the user just uploaded a certificate
         */

        try {
            $user = Auth::user();
            /** @var Candidate $candidate */

            //$candidate = Candidate::findOrFail($user->candidate->id);
            $candidate = Candidate::where('user_id', $user->id)->first();
            $input['is_default'] = isset($input['is_default']) ? true : false;

            $fileExtension = getFileName('download', $input['file']);
            //throw new UnprocessableEntityHttpException($resume?Candidate::RESUME_PATH:Candidate::CERTIFICATE_PATH);

            if(is_null($resume)){
                $mediaCollection = Candidate::CERTIFICATE_PATH;
            }else{
                $mediaCollection = Candidate::CERTIFICATE_PATH;
            }
            $candidate->addMedia($input['file'])
                ->withCustomProperties([
                    //'is_default' => isset($input['is_default'])?$input['is_default']:false,
                    'title'      => $input['title'],
                ])/*->usingFileName($fileExtension)*/->toMediaCollection($mediaCollection);
            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
