<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Artesaos\SEOTools\Facades\SEOMeta;
use FontLib\Table\Type\post;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\OpenGraph;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Blog');
        SEOMeta::setDescription('Collection of useful articles good for your career progress and your life in-general, read comment and share with your friends');
        //dd('blog is here');
        $posts = BlogPost::orderBy('created_at', 'DESC')->get();
        return view('Blog.index', compact('posts'));
    }

    public function viewPost($slug){
        $post = BlogPost::where('slug', $slug)->first();
        SEOMeta::addMeta('theme-color', '#6ad3ac');
        SEOMeta::setTitle($post->Title);
        SEOMeta::addMeta('description', $post->Summary);
        SEOMeta::addMeta('language', 'English');
        SEOMeta::addMeta('revist-after', '1 days');
        OpenGraph::setTitle($post->Title);
        OpenGraph::addImage(asset($post->cover_photo));
        //dd($post);
        return view('Blog.view-post', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function employers(){
        SEOMeta::setTitle('Post a Job and Hire in Tanzania');
        SEOMeta::setDescription('Find the right talent for your company with Ajiriwa Platform, Create Job posts, accept and reject applications, filter and create a list of shortlisted candidates. You can do all of these on site for free.');
        return view('Blog.employers');
    }
}
