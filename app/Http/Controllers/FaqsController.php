<?php

namespace App\Http\Controllers;

use App\Models\FaqsCategory;
use App\Models\FaqView;
use App\Models\FrequentlyAskedQuestion;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqsController extends Controller
{
    public function registerView()
    {
        $faq = FrequentlyAskedQuestion::find(request()->faqId);
        FaqView::create(['faq_id' => $faq->id]);
        $faq->increment('views'); // Assuming you have a 'views' column in your FAQ table

        return response()->json(['success' => true]);
    }

    public function index(){
        SEOMeta::setTitle('Frequently Asked Questions');
        SEOMeta::setDescription('Most questions that our users ask together with their answers, find helpful information here');
        $faqs = FrequentlyAskedQuestion::limit(8)->get();
        return view('faqs', compact('faqs'));
    }

    public function manage(){
        $categories = FaqsCategory::all();
        $faqs = FrequentlyAskedQuestion::orderBy('id', 'desc')->paginate(10)->toArray();
        //dd($faqs);
        return Inertia::render('Faqs/FaqsManager', compact('categories', 'faqs'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category_id' => 'required|exists:faqs_categories,id',
        ]);

        // Create a new FAQ
        $validatedData['slug'] = urlencode(substr(makeSlug($request->question), 0, 200));
        $faq = FrequentlyAskedQuestion::create($validatedData);

        // Optionally, you can return a response or redirect
        return response()->json(['message' => 'FAQ created successfully', 'faq' => $faq], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category_id' => 'required|exists:faqs_categories,id',
        ]);

        $faq = FrequentlyAskedQuestion::findOrFail($id);

        $faq->update([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'category_id' => $request->input('category_id'),
        ]);

        return response()->json(['message' => 'FAQ updated successfully']);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q');

        // Perform the search in the database
        $results = FrequentlyAskedQuestion::where('question', 'like', '%' . $searchTerm . '%')
            ->orWhere('answer', 'like', '%' . $searchTerm . '%')
            ->get();

        // Return the search results (you might want to format this as needed)
        return response()->json(['results' => $results]);
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
