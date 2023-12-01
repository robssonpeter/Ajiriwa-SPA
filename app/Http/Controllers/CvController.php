<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CvController extends Controller
{
    //

    /**
     * Returns the cv for rendering in pay-r hr system
     * #### Must get the slug from request()->data 
     *
     * @return void
     */
    public function materialBootstrap(){
        $username = request()->slug;
        $with = [
            'experiences', 'education', 'languages', 'referees', 'user'
        ];
        $candidate = Candidate::where('slug', $username)->with($with)->first();
        //dd($candidate);
        return view('CvTemplates.material-bootstraped', compact('candidate'));
    }

    public function candidateSearch(){
        $search = request()->get('resume-search');
        $candidates = CandidateRepository::searchCandidate($search)->items();
        $optimized_candidates = array_map(function($element){
            return [
                'name' => $element['full_name'],
                'title' => $element['professional_title'],
                'id' => $element['id'],
                'user' => $element['slug'],
                'image' => $element['logo_url'],
                'link' => route('material.bootstraped')."?slug=".$element['slug']
            ];
        }, $candidates);
        return response()->json($optimized_candidates);
    }

    public function cvMaker(){
        return Inertia::render('Apps/CvMaker/Start');
    }
}
