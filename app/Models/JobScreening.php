<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobScreening extends Model
{
    use HasFactory;

    const SCREENING_DESCRIPTION = [
        'experience' => '$description = $this->name.\' (Years)\';',
        'location' => '$description = \'Can work in \'.$this->name;',
        'education' => '$description = $this->name;',
        'expertise' => '$description = $this->name.\' (Years)\';',
        'certification' => '$description = $this->name." Certified";',
        'authorization' => '$description = "Can work in ".$this->name;',
        'custom' => '$description = $this->name;',
    ];

    protected $fillable = [
        'question', 'answer', 'type', 'question_type', 'necessity', 'job_id', 'name', 'options', 'input_type'
    ];


    protected $appends = ['applicant_answer', 'variable_name', 'filter_operator', 'filter_value', 'options_decoded', 'description'];

    public function getDescriptionAttribute(){
        //dd($this->name);
        $type = $this->type??$this->label;
        eval(self::SCREENING_DESCRIPTION[$type]);
        //dd($description);
        return $description??'';
    }
    
    public function getOptionsDecodedAttribute(){
        $options = $this->options;
        $options= str_replace('[', '', $options);
        $options= str_replace(']', '', $options);
        $options= str_replace('"', '', $options);
        $options= str_replace('\\', '', $options);
        if(is_array($options)){
            return $options;
        }else{
            return explode(',', $options);
        }
    }

    public function getApplicantAnswerAttribute(){
        return '';
    }

    public function getVariableNameAttribute(){
        $this->options = is_array($this->options)?$this->options:json_decode($this->options);
        if($this->type == 'custom'){
            return ucfirst($this->name);
        }else{
            return ucfirst($this->type);
        }
    }

    public function getFilterOperatorAttribute(){
        return '';
    }

    public function getFilterValueAttribute(){
        return '';
    }


    public function job(){
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function application(){
        return $this->belongsTo(JobApplication::class, 'application_id', 'id');
    }

    public function responses(){
        return $this->hasMany(ScreeningResponse::class, 'id', 'screening_id');
    }
}
