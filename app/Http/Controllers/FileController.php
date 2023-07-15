<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\Models\Media;

class FileController extends Controller
{

    public function saveMedia($file){
        $model = request()->model;
        $collection = request()->collection;
        $model_id = request()->model_id;
        //$model =  new $model;
        $model =  Company::find($model_id);
        $model->addMedia($file)->toMediaCollection($collection);
    }

    public function SaveFile(){

        request()->validate([
            'files' => ''
        ]);
        $file = request()->file('files');

        $destination = request()->upload_dir?request()->upload_dir:'temporary-files';

        $destinationFolder = public_path($destination);
        if(!File::isDirectory($destinationFolder)){
            File::makeDirectory($destinationFolder, 0776, true, true);
        }
        $uniqid = uniqid();
        $nameArray = explode('.', $file->getClientOriginalName());
        $ext = $nameArray[count($nameArray)-1];
        unset($nameArray[count($nameArray)-1]);
        $unique_name = makeSlug(implode('.', $nameArray))."-".$uniqid.".".$ext;
        //$file->move($destinationFolder, $unique_name);


        $model = request()->model;
        $collection = request()->collection;
        $model_id = request()->model_id;
        $model =  new $model;
        $model =  $model->find($model_id);
        $savedMedia = $model->addMediaFromRequest('files')->toMediaCollection($collection, 'public');
        if(request()->collection == 'logo' || request()->collection == 'DPs')
        {
            $model->update(['logo' => $savedMedia->id ]);
        }
        else if(request()->collection == 'cover')
        {
            $model->update(['cover' => $savedMedia->id ]);
        }

        if(request()->remove_media && request()->remove_media != 'null'){
            Media::where('id', request()->remove_media)->delete();
        }
        return [
            "original"=> $file->getClientOriginalName(),
            "saved" => $unique_name,
            "link" => asset($savedMedia->getUrl()),
        ];
    }

    public function RemoveFile(){
        $file = request()->name;

        $destination = request()->remove_dir?request()->remove_dir:'temporary-files';
        if(File::isFile(public_path($destination.'/'.$file))){
            if(File::delete(public_path($destination.'/'.$file))){
                return true;
            }
        }
        return false;
    }
}
