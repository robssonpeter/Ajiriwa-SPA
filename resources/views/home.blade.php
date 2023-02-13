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
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
        }
    </style>
            <div class="overflow-hidden shadow-xl pb-12 bg-green-400 bg-opacity-70 -mt-4" id="search-section">
                <div class="h-full px-4 px-2 lg:px-4 z-40" id="banner" >
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
                <div class="bg-gray-200 py-4 slider">
                    
                    <div class="flexslider" >
	
                        <div class="flex-viewport" style="overflow-x: scroll; position: relative;">
                            <ul class="slides style" style="width: 3000%; ">
                                @foreach($latest_jobs as $job)
                                    <li class="highlighted text-green-500 font-bold" style="width: 210px; float: left; display: block;"><a title="{{ $job->title }}" href="{{ route('job.view', $job->slug) }}">
                                        <p style="text-align: center; font: 13px"><strong>{{ Illuminate\Support\Str::limit($job->title, 22, '...')  }}</strong></p><div class="job-list-content">
                                        <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="bg-white" style="margin-left: auto; margin-right: auto; height: 150px; width:150px; border-radius: 5%;" draggable="false">	</a>
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

        <div class="max-w-7xl  pt-5 mb-12 flex grid md:grid-cols-3 gap-1">
            @foreach($job_categories as $category)
                <section class="py-4 border border-green-400 px-4 cols-5 flex cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                    <div class=" flex flex-col flex-grow">
                        <span class="font-bold"><a href="{{ route('jobs.by-category', $category->slug) }}">{{ $category->name }}</a></span>
                        <span class="mt-4 text-gray-500 font-bold">{{ $category->active_jobs_count}} Jobs</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12 self-center">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </section>
            @endforeach
            <section class="py-4 border border-green-400 px-4 cols-5 flex flex-col cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <span class="font-bold">Transport & Logistics</span>
                <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <div class=" flex flex-col flex-grow">
                    <span class="font-bold">Recruitment & HR</span>
                    <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12 self-center">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                  </svg>
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <div class=" flex flex-col flex-grow">
                    <span class="font-bold">Information & Technology</span>
                    <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12 self-center">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                  </svg>
                  
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <div class=" flex flex-col flex-grow">
                    <span class="font-bold">Creative Arts & Media</span>
                    <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12 self-center">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l1.5 1.5.75-.75V8.758l2.276-.61a3 3 0 10-3.675-3.675l-.61 2.277H12l-.75.75 1.5 1.5M15 11.25l-8.47 8.47c-.34.34-.8.53-1.28.53s-.94.19-1.28.53l-.97.97-.75-.75.97-.97c.34-.34.53-.8.53-1.28s.19-.94.53-1.28L12.75 9M15 11.25L12.75 9" />
                  </svg>
                  
                  
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <div class=" flex flex-col flex-grow">
                    <span class="font-bold">Telecommunication</span>
                    <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546M5.106 18.894c-3.808-3.808-3.808-9.98 0-13.789m13.788 0c3.808 3.808 3.808 9.981 0 13.79M12 12h.008v.007H12V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                  </svg>
                  
                  
                  
            </section>
        
        </div>

        <div class="max-w-7xl  pt-5 mb-12 ">
            <span class="text-xl font-bold text-gray-500 mb-4">Recent Posts</span>

            <div class="flex space-x-2 pb-4">
                @foreach($blog_posts as $post)
                    <div >
                        <div class="recent-post block rounded-lg shadow-lg bg-white">
                            <div class="recent-post-img">
                                <a href="blog-single-post.php?id=14"><img class="rounded-t-lg" src="https://www.ajiriwa.net/uploads/blog/productivity%20improvement.jpg{{-- {{ strlen($post->scaled_down_cover)?$post->scaled_down_cover:$post->cover_photo }} --}}" alt="{{$post->Title}}"></a>
                                <div class="hover-icon"></div>
                            </div>
                            <div class="px-4">
                                <a href="blog-single-post.php?id=14" class="">
                                    <h4 class="text-green-600 font-bold mt-2 text-md leading-tight font-medium mb-2">{{$post->Title}}</h4>
                                </a>
                            </div>
                            <div class="mb-2 px-4">
                                <span><a href="#" class="text-sm">59 Comments</a></span>
                            </div>
                            <div class="px-4">
                                <p class="text-gray-900 leading-tight font-medium mb-2">{{ \Illuminate\Support\Str::limit($post->Summary, 200) }}</p>
                                <br>
                                <a href="blog-single-post.php?id=14" class="button bg-green-500 rounded-md p-2 text-white mt-2">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="{{ mix('js/homepage.js') }}">

    </script>
@endsection
