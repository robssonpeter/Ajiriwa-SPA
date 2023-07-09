<?php


namespace App\Repositories;

use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FileRepository
{


    public static function uploadFile($input, $collection="media")
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
            $input['is_default'] = isset($input['is_default']) ? true : false;

            $fileExtension = getFileName('download', $input['file']);
            //throw new UnprocessableEntityHttpException($resume?Candidate::RESUME_PATH:Candidate::CERTIFICATE_PATH);

            
            $candidate->addMedia($input['file'])
                ->withCustomProperties([
                    'title'      => $input['title'],
                ])->toMediaCollection($collection);
            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
