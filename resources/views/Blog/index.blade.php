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
    <div class="w-full md:max-w-7xl mx-auto pt-5 mb-12 md:grid md:grid-cols-6 gap-1" id="job-page">
        <div class="col-span-4 mr-8 md:mr-0">
            @foreach($posts as $post)
            <div class="bg-white shadow-lg  ml-8 p-4 mb-2">
                <img src="https://www.ajiriwa.net/uploads/blog/hr-management-system-comp.jpg" class="max-h-80 w-100" alt="hr-management-system">
                <section class="py-2">
                    <small class="text-gray-500">{{ Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}</small> <span class="text-sm text-gray-500">|</span>
                    <span class="text-sm text-green-500">Peter Robert Mgembe</span>
                </section>
                <a href="" class="font-bold text-gray-500 text-lg">{{ $post->Title }}</a>
                <div>
                    <span class="text-gray-500">{{ $post->Summary }}</span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="bg-white w-80 ml-8 col-span-2 mr-24 px-4 self-start py-4 shadow-lg hidden md:block sticky top-16">
            <section class="flex flex-row border-b pb-2 flex flex-col">
                <img src="https://blogs.microsoft.com/wp-content/uploads/prod/2022/09/MS-WTViva_Banner_1900x1000-v2-960x540.png" alt="">
            </section>
            <section>
                <a href="" class="text-gray-500 font-bold">How to beat lazyness</a>
            </section>
        </div>
    </div>
@endsection
