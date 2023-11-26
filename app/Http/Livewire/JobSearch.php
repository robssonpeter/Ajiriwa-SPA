<?php

namespace App\Http\Livewire;

use App\Custom\Promoter;
use App\Models\AssignedJobCategory;
use App\Models\CategorizedJob;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
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
        //dd($this->job_category);
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
        $search = request()->search??(request()->keyword?request()->keyword." ".request()->comp:$this->search);
        //dd($search);
        $slug = makeSlug(urldecode(request()->search));


        
        $keyword = \DB::table('keywords')->where('keyword', urldecode($search))/* ->orWhere('keyword', 'LIKE', '%'.$search.'%') */->orWhere(function($q) use ($slug){
            return $q->whereNotNull('slug')->where('slug', $slug);
        })->first();
        
        /* if(request()->search){
            // check if there is any category matching
            $categories = JobCategory::where('name', 'LIKE', request()->search)->orWhere(function($q){
                $splitted = explode(" ", request()->search);
                foreach($splitted as $split){
                    $q = $q->orWhere('name', 'LIKE', '%'.$split.'%');
                }
            })->pluck('id');

            $assigned_jobs = AssignedJobCategory::whereIn()
        } */
        
        if($keyword){
            $this->search = $search;
            $search = strlen($keyword->main_words)?$keyword->main_words:$this->search;
        }else{
            if(request()->search){
                $self->search =  request()->search;
            }
            $search = $self->search;
        }  
        $companies = [];
        if(request()->comp || request()->search){
            $comp_like = request()->comp??$search;
            $companies = Company::where('name', 'LIKE', '%'.$comp_like.'%')->pluck('id');
        }
        
        $active_index = array_search('Active', Job::STATUS);
        $date = date('Y-m-d');
        $jobs =  Job::orderBy('id', 'DESC')->when(!$keyword, function($q) use($date){
            $q->where('deadline', '>=', $date);
        })->where('status', $active_index)/* ->when($companies, function($q) use ($companies){
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
            $assigned = CategorizedJob::where('category_id', $self->job_category)->pluck('job_id');
            $q->whereIn("id", $assigned);
        }) ->when($this->remote, function($q) use($self){
            $q->where('is_remote', true);
        })->when($this->selected_industries, function($q) use($self, $companies){
            $comp_by_industry = Company::whereIn('industry_id', $self->selected_industries)->pluck('id')->toArray();
            $companies = array_merge($companies, $comp_by_industry);
            $q->whereIn('company_id', $companies);
        })->when(request()->comp || count($companies), function($q) use($companies){
            $q->whereIn('company_id', $companies);
        })->when($this->selected_employment_types, function($q) use($self){
            $q->whereIn('job_type', $self->selected_employment_types);
        })->when(request()->location, function($q){
            $q->where('location', 'LIKE', "%".request()->location."%");
        })->paginate(10);
        //dd($companies);
        //dd($companies);
        //dd($jobs->lastPage());
        $promo = new Promoter();
        $rand = $promo->randomProm();
        if($rand)
            $promotion = $promo->promotionFetch($rand->PromotionID);
        else
            $promotion = null;
        //dd($promotion);
        return view('livewire.job-search', compact('jobs', 'promotion'));
    }
}
