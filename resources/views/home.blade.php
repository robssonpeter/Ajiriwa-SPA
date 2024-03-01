@extends('layouts.app')
@section('content')
<style>
    #search-section {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
    }

    /* Hide scrollbar for Chrome, Safari and Opera */
    .flex-viewport::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .flex-viewport {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>
<div class="overflow-hidden shadow-xl pb-12 bg-green-400 bg-opacity-70 -mt-4" id="search-section">
    <div class="h-full px-4 px-2 lg:px-4 z-40" id="banner">
        <div class="max-w-7xl mt-12 mx-auto px-4 sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12">
            <h1 class=" text-white text-4xl mb-3 mt-8">Find a job</h1>
            <form method="get" action="{{ route('jobs.search') }}" class="sm:flex sm:flex-row gap-10 space-y-6 sm:space-y-0">
                <div class="flex-grow">
                    <input name="search" class=" w-full border-1 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 border-green-400 rounded-xl p-2 md:p-3 text-xl md:text-2xl text-gray-500" type="text" placeholder="Job Title or Company Name">
                </div>
                <div class=" flex-grow">
                    <input name="location" class=" w-full border-1 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 border-green-400 rounded-xl p-2 md:p-3 text-xl md:text-2xl" type="text" placeholder="Location">
                </div>
                <button class="w-full sm:w-auto rounded-xl py-2 md:py-3 sm:px-5 text-xl md:text-2xl bg-green-500 hover:bg-green-600 text-white">

                    <span class="hidden sm:block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 md:w-6 place-self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <span class="uppercase block sm:hidden">Search</span>
                </button>
            </form>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12 pt-5 text-white">
            <span class="text-xl text-white">We’ve over <strong>11630</strong> job offers for you!</span>
        </div>
        <div class="h-8">

        </div>

    </div>

</div>
<div class="max-w-7xl px-4 mx-auto sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12 pt-5 mb-12 -mt-16" id="swiper">
    <div class="bg-gray-200 rounded-lg py-4 slider">

        <div class="flexslider">

            <div class="flex-viewport" style="overflow-x: scroll; position: relative;">
                <ul class="slides style" style="width: 3000%; ">
                    @foreach($latest_jobs as $job)
                    <li class="highlighted text-green-500 font-bold" style="width: 210px; float: left; display: block;"><a title="{{ $job->title }}" href="{{ route('job.view', $job->slug) }}">
                            <p style="text-align: center; font: 13px"><strong>{{ Illuminate\Support\Str::limit($job->title, 22, '...')  }}</strong></p>
                            <div class="job-list-content">
                                <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="bg-white" style="margin-left: auto; margin-right: auto; height: 150px; width:150px; border-radius: 5%;" draggable="false">
                        </a>
                        <div class="clearfix"></div>
                    </li>
                    @endforeach
                </ul>
            </div>
            {{-- <swiper
                        :modules="modules"
                        :slides-per-view="6"
                        :space-between="30"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                        class="default-slider"
                    >
                        <swiper-slide v-for="n in 7" :key="n">
                            <img src="https://placeimg.com/150/150/any?1" :alt="'image-'+n">
                            @{{ n }}
            </swiper-slide>
            </swiper> --}}
        </div>

    </div>

    <div class="max-w-7xl  pt-5 mb-12 flex grid md:grid-cols-3 gap-3">
        @foreach($job_categories as $category)
        @if($category->active_jobs_count)
            <section class="py-4 border bg-white rounded-lg shadow-md border-green-400 px-4 cols-5 flex cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <div class=" flex flex-col flex-grow">
                    <span class="font-bold"><a href="{{ route('jobs.by-category', $category->slug) }}">{{ $category->name }}</a></span>
                    <span class="mt-4 text-gray-500 font-bold">{{ $category->active_jobs_count}} Jobs</span>
                </div>
                {!! $category->icon !!}
            </section>
        @endif
        @endforeach
    </div>

    <div class="max-w-7xl  pt-5 mb-12 ">
        <span class="text-xl font-bold text-gray-500 mb-4">Recent Posts</span>
        <div class="flex flex-col md:flex-row md:space-x-6 mb-2">
            @foreach($blog_posts as $post)
            <div class="bg-white rounded-lg overflow-hidden flex-1 m-1 md:m-2 lg:w-1/3 flex flex-col">
                <div style="height: 200px; overflow-y: hidden">
                    <img width="400" height="200" src="{{ strlen($post->scaled_down_cover)?$post->scaled_down_cover:$post->cover_photo }}" alt="{{$post->Title}}" class="w-25 h-40">
                </div>
                <div class="flex-grow p-4">
                    <h2 class="text-xl font-semibold mb-2">{{$post->Title}}</h2>
                    <section class="flex flex-col">
                        <div class="flex-grow h-full">
                            <p class="text-gray-600">{{ \Illuminate\Support\Str::limit($post->Summary, 200) }}</p>
                        </div>
                        <a href="{{ route('blog.post.view', $post->slug) }}" class="bottom-0 bg-green-500 text-white px-4 py-2 mt-4 self-start rounded-md">Read More</a>
                    </section>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="{{ mix('js/homepage.js') }}">

</script>
@endsection