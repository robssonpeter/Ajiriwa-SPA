@extends('layouts.app')
@section('content')
    <style>
        #search-section {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
        }
    </style>
            <div class="overflow-hidden shadow-xl pb-12 bg-green-400 bg-opacity-70" id="search-section">
                <div class="h-full px-4 px-2 lg:px-4 z-40" id="banner" >
                    <div class="max-w-7xl mt-12 mx-auto px-4 sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12">
                        <h1 class=" text-white text-4xl mb-3 mt-8">Find a job</h1>
                        <form method="get" action="{{ route('jobs.search') }}" class="sm:flex sm:flex-row gap-10 space-y-6 sm:space-y-0">
                            <div class="flex-grow">
                                <input name="search" class=" w-full border-1 border-green-400 rounded-xl p-3 text-2xl text-gray-500" type="text" placeholder="Job Title or Company Name">
                            </div>
                            <div class=" flex-grow">
                                <input name="location" class=" w-full border-1 border-green-400 rounded-xl p-3 text-2xl" type="text" placeholder="Location">
                            </div>
                            <button class="w-full sm:w-auto rounded-xl py-3 sm:px-5 text-2xl bg-green-500 hover:bg-green-600 text-white">

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
                    <div class="h-16">

                    </div>

                </div>

            </div>
            <div class="max-w-7xl px-4 mx-auto sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12 pt-5 mb-12 -mt-16" id="swiper">
                <div class="bg-gray-200 py-4 slider pl-4">
                    <swiper
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
                    </swiper>
                </div>

            </div>

        <div class="max-w-7xl px-4 mx-auto sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12 pt-5 mb-12 flex grid md:grid-cols-3 gap-1">
            <section class="py-4 border border-green-400 px-4 cols-5 flex flex-col cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <span class="font-bold">Accounting & Finance</span>
                <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex flex-col cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <span class="font-bold">Transport & Logistics</span>
                <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex flex-col cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <span class="font-bold">Recruitment & HR</span>
                <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex flex-col cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <span class="font-bold">Information & Technology</span>
                <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex flex-col cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <span class="font-bold">Creative Arts & Media</span>
                <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
            </section>
            <section class="py-4 border border-green-400 px-4 cols-5 flex flex-col cursor-pointer hover:bg-green-300 hover:text-white text-green-400">
                <span class="font-bold">Telecommunication</span>
                <span class="mt-4 text-gray-500 font-bold">1500 Jobs</span>
            </section>
        </div>

        <div class="max-w-7xl px-4 mx-auto sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12 pt-5 mb-12 ">
            <span class="text-xl font-bold text-gray-500 mb-4">Recent Posts</span>

            <div class="grid md:grid-cols-3 gap-1 pb-4">
                @foreach($blog_posts as $post)

                    <div class="">
                        <div class="recent-post block p-6 rounded-lg shadow-lg bg-white">
                            <div class="recent-post-img">
                                <a href="blog-single-post.php?id=14"><img src="{{ strlen($post->scaled_down_cover)?$post->scaled_down_cover:$post->cover_photo }}" alt="{{$post->Title}}"></a>
                                <div class="hover-icon"></div></div>
                            <a href="blog-single-post.php?id=14"><h4 class="text-green-600 font-bold mt-2 text-md leading-tight font-medium mb-2">{{$post->Title}}</h4></a>
                            <div class="mb-2">
                                <span><a href="#" class="text-sm">59 Comments</a></span>
                            </div>
                            <div>
                                <p class="text-gray-900 leading-tight font-medium mb-2">{{ \Illuminate\Support\Str::limit($post->Summary, 200) }}</p>
                                <br>
                                <a href="blog-single-post.php?id=14" class="button bg-green-500 rounded-md p-2 text-white mt-2">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="">
                    <div class="recent-post block p-6 rounded-lg shadow-lg bg-white">
                        <div class="recent-post-img">
                            <a href="blog-single-post.php?id=14" class="w-100">
                                <img src="https://www.ajiriwa.net/uploads/blog/the%20power%20of%20your%20mindset.png" class="w-100" alt="Benefits of Using HR and Payroll Software in Tanzania">
                            </a>
                        </div>
                        <a href="blog-single-post.php?id=14"><h4 class="text-green-600 font-bold mt-2 text-md leading-tight font-medium mb-2">Benefits of Using HR and Payroll Software in Tanzania</h4></a>
                        <div class="mb-2">
                            <span><a href="#" class="text-sm">59 Comments</a></span>
                        </div>
                        <div>
                            <p class="text-gray-900 leading-tight font-medium mb-2">Companies in Tanzania need to take advantage of HR Systems to automate their HR Activities and be more effficient here are some of the benefits of using a HR Management System in your company</p>
                            <br>
                            <a href="blog-single-post.php?id=14" class="button bg-green-500 rounded-md p-2 text-white mt-2">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="recent-post block p-6 rounded-lg shadow-lg bg-white">
                        <div class="recent-post-img">
                            <a href="blog-single-post.php?id=14" class="w-100">
                                <img src="https://www.ajiriwa.net/uploads/blog/productivity%20improvement.jpg" class="w-100" alt="Benefits of Using HR and Payroll Software in Tanzania">
                            </a>
                        </div>
                        <a href="blog-single-post.php?id=14"><h4 class="text-green-600 font-bold mt-2 text-md leading-tight font-medium mb-2">Benefits of Using HR and Payroll Software in Tanzania</h4></a>
                        <div class="mb-2">
                            <span><a href="#" class="text-sm">59 Comments</a></span>
                        </div>
                        <div>
                            <p class="text-gray-900 leading-tight font-medium mb-2">Companies in Tanzania need to take advantage of HR Systems to automate their HR Activities and be more effficient here are some of the benefits of using a HR Management System in your company</p>
                            <br>
                            <a href="blog-single-post.php?id=14" class="button bg-green-500 rounded-md p-2 text-white mt-2">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/homepage.js') }}">

    </script>
@endsection
