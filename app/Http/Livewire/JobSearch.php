<?php

namespace App\Http\Livewire;

use App\Models\AssignedJobCategory;
use App\Models\Company;
use App\Models\Job;
use Livewire\Component;

class JobSearch extends Component
{

    public $name;
    public $industries;
    public $remote;
    public $location;
    public $job_types;
    public $search = "";
    public $job_category = '';
    public $selected_industries = [];
    public $selected_employment_types = [];

    public function render()
    {
        $self = $this;
        //dd($this->search);
        // check if there is a preset variable
        if(session()->get('presets')){
            $preset = session()->get('presets');
            if(isset($preset['category'])){
                $this->job_category = $preset['category'];
            }
        }

        $country = country('tz');
        //dd($country->getGeoData);

        $slug = makeSlug($this->search);
        $keyword = \DB::table('keywords')->where('keyword', $this->search)->orWhere(function($q) use ($slug){
            return $q->whereNotNull('slug')->where('slug', $slug);
        })->first();
        //dd($keyword);
        if($keyword){
            $search = strlen($keyword->main_words)?$keyword->main_words:$this->search;
        }else{
            if(request()->search){
                $self->search =  request()->search;
            }
            $search = $self->search;
        }

        //dd($keyword);
        $jobs =  Job::orderBy('id', 'DESC')/* ->when($companies, function($q) use ($companies){
            $q->whereIn('company_id', $companies);
        }) */->when($search, function($q) use ($search, $self){
            $all = explode(" ", $search);

            $x=3;
            foreach($all as $one){
                if($self->location){
                    $joined[] = " ((title like '%$one%' OR keywords like '%$search%' OR application_url like '%$search%' OR location like '%$search%') AND (location like '%$search%')) " ;
                }else{
                    $joined[] = " ((title like '%$one%' OR keywords like '%$search%' OR application_url like '%$search%') OR (location like '%$search%')) " ;
                }
    
                $arraytotal = count($all);
                $casextra = $x+1;
                $order[] = "WHEN job_title LIKE '%$one%' THEN '$x' WHEN company_name LIKE '%$one%' THEN '$casextra'";
                //dd('hello there');
                $x+=2;
            }
            $joinedstring = implode("OR", $joined);
            return $q->whereRaw($joinedstring);
        })->when($this->job_category, function($q) use($self){
            $assigned = AssignedJobCategory::where('category_id', $self->job_category)->pluck('job_id');
            $q->whereIn("id", $assigned);
        })->when($this->remote, function($q) use($self){
            $q->where('is_remote', true);
        })->when($this->selected_industries, function($q) use($self){
            $companies = Company::whereIn('industry_id', $self->selected_industries)->pluck('id');
            $q->whereIn('company_id', $companies);
        })->when($this->selected_employment_types, function($q) use($self){
            $q->whereIn('job_type', $self->selected_employment_types);
        })->limit(15)->get();
        //dd($jobs);
        return view('livewire.job-search', compact('jobs'));
    }
}
