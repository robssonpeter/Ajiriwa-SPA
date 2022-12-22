<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index(){
        SEOMeta::setTitle('Frequently Asked Questions');
        SEOMeta::setDescription('Most questions that our users ask together with their answers, find helpful information here');
        return view('faqs');
    }

    public function contact(){
        return view('contact');
    }

    public function privacyPolicy(){
        SEOMeta::setTitle('Privacy Policy');
        SEOMeta::setDescription('Ajiriwa.net platform privacy policy, learn your rights entitled to your ajiriwa.net account and how we handle your information for safety purposes. Read this before creating an account in our website');
        return view('privacy-policy');
    }
}
