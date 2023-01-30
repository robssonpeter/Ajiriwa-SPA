@extends('layouts.app')
@section('content')
    <style>
        /*#search-section {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
        }*/
        input[type=file]::file-selector-button{
            background: rgba(243, 244, 246, var(--tw-bg-opacity)) !important;
            color: black;
        }
    </style>
    <div class="w-full md:max-w-7xl mx-auto pt-5 mb-12 " id="job-page">
        <div class="md:grid grid-cols-3 bg-white mb-2 px-4 mx-8"><!-- Main Content -->
            <div class = "col-span-2 py-4">
                <h2 class = "text-4xl text-gray-500 font-bold"> Find the right talent </h2>
                <p class = "text-lg text-gray-500 mt-4 mb-8">Post jobs. Find employees. 
                Create a Job Post for free and reach many jobs seekers in our network. Accept applications onsite and have your shortlisting tools at your disposal so that you can pick the Qualified candidate real fast.</p>
                <a class = "text-white bg-green-500 rounded-md p-2 mt-4" href="{{route('register') }}">Post A Job for Free</a>
            </div>
            <div class = "w3-third w3-margin-top">
                <img src = "https://www.ajiriwa.net/employers/img/find-talent.png" style = "width: 100%">
            </div>
        </div>
    
        <div class="md:grid grid-cols-3 bg-white mb-2 pl-4 mx-8"><!-- Main Content -->
            <div class = "col-span-1">
                <img src = "https://www.ajiriwa.net/employers/img/network-of-people.jpg" style="width: 100%">
            </div>
            <div class = "col-span-2 pt-4 bg-white px-4">
                <h2 class = "text-4xl text-gray-500 font-bold">Get Candidates Recommendation </h2>
                
                <p class = "text-lg text-gray-500 mt-4 mb-8">For every job that you post, you can instantly get suggestions of who is a proper fit for the position with just a click of a button. We'll search through our growing database of job seeker and give you the right suggestion. Create a post and see for yourself</p>
                <a class = "text-white bg-green-500 rounded-md p-2 mt-4" href = "{{route('register') }}">Sign up</a>
            </div>
        </div>
    
        <div class="md:grid grid-cols-3 bg-white mb-2 pl-4 mx-8"><!-- Main Content -->
            <div class = "col-span-2 py-4">
                <h2 class = "text-4xl text-gray-500 font-bold">Reach More People</h2>
                <p class = "text-lg text-gray-500 mt-4 mb-8">Want to reach more people? We've got you covered! With our job promotion tool depending on your budget our system will prioritize you job post so that it becomes visible to more of our visitor and hence give you more exposure. All you have to do is click the promote button, specify your budget and your targeted audience and watch the applications flowing.</p>
                <a class = "text-white bg-green-500 rounded-md p-2 mt-4" href="{{route('register') }}">Post A Job for Free</a>
                </div>
            <div class = "col-span-1">
                <img src = "https://www.ajiriwa.net/employers/img/promote.png" style ="width: 100%">
            </div>
        </div>
    </div>
@endsection
