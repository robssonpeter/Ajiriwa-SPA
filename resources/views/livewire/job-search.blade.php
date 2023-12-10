<div>
    <div class="bg-white shadow-lg md:hidden px-2 mx-4 mb-2">
        <nav class="flex py-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 py-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-sm font-medium text-green-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-400 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Jobs</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <form method="GET" class="mx-4 md:hidden rounded-b-md bg-white flex">
        <input type="text" name="search" wire:model="" value="{{request()->search}}" class="text-gray-600 w-full border border-gray-300" placeholder="Search Jobs">
        <button class="bg-green-400 hover:bg-green-500 text-white -ml-8 px-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>

        </button>
    </form>

    <div class="max-w-7xl mx-4 md:mx-auto pt-5 mb-12 md:grid md:grid-cols-4 gap-2" id="search-section">
        <div class="rounded-lg shadow-lg bg-white sticky top-20 self-start p-4 hidden md:block">
            <section class="flex flex-col mb-4">
                <small><strong>Search</strong></small>
                <input wire:model="search" class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" type="text" value="{{request()->search}}">
            </section>

            <section class="flex flex-col">
                <small><strong>City</strong></small>
                <select name="" id="" class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    <option value="">Select</option>
                    <option value="">Dar es Salaam</option>
                </select>
            </section>

            <div class="form-check py-2">
                <input wire:model="remote" class="border-gray-300 form-check-input appearance-none h-4 w-4 accept-pink-300 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label inline-block text-gray-800 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" for="flexCheckDefault">
                    Remote
                </label>
            </div>

            <div class="py-4 flex flex-col">
                <span><strong>Job Category</strong></span>
                <select name="" id="" class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" wire:model="job_category" {{ session()->has('presets') && isset(session()->get('presets')['category']) ? 'disabled' : '' }}>
                    <option value="">Select</option>
                    @foreach(\App\Models\JobCategory::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="border-t py-4">
                <span><strong>Industry</strong></span>
                <section class="h-32 bg-gray-200 px-2 overflow-y-auto">
                    @foreach($industries as $industry)
                    <div class="form-check py-2">
                        <input wire:model="selected_industries" value="{{ $industry->id }}" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" id="{{ $industry->id }}">
                        <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                            {{ $industry->name }}
                        </label>
                    </div>
                    @endforeach
                </section>
            </div>

            <div class="border-t py-4">
                <span><strong>Employment Type</strong></span>
                <section class="h-32 bg-gray-200 px-2 overflow-y-auto">
                    @foreach($job_types as $job_type)
                    <div class="form-check py-2">
                        <input wire:model="selected_employment_types" value="{{ $job_type->id }}" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                            {{ $job_type->name }}
                        </label>
                    </div>
                    @endforeach
                    {{ var_export($selected_employment_types) }}
                </section>
            </div>
        </div>
        <section class="col-span-2">
            @if($promotion)
            <a href="{{ $promotion['Link'] }}">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col mb-2">
                    <div class="bg-green-500 text-white text-center py-1">
                        <span class="text-xs">Sponsored Listing</span>
                    </div>
                    <div class="px-4 py-6 flex-1 bg-green-100">
                        <div class="flex items-center mb-4">
                            @if(isset($promotion['Logo']))
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="{{ $promotion['Logo'] }}" alt="Company Logo">
                            </div>
                            @endif
                            <div class="ml-3">
                                <span class="font-bold text-green-500 text-lg">{{ $promotion['Job_Title'] }}</span>
                                <span class="text-gray-400 block">{{ $promotion['Company'] }}</span>
                                <span class="text-gray-400 block">{{ $promotion['Location'] }}</span>
                            </div>
                        </div>
                        <div><span class="text-gray-500 text-sm">{!! \Illuminate\Support\Str::limit($promotion['Summary'], 100) !!}</span></div>
                    </div>
                </div>
            </a>
            @endif
            @foreach($jobs as $job)
            @if($loop->iteration == 2)
            <div class="rounded-lg shadow-lg bg-white mb-2 px-4 py-2 cursor-pointer" style="min-height: 100px;">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2822549997571103" crossorigin="anonymous"></script>
                <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2822549997571103" data-ad-slot="6157450170"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            @endif
            <div class="rounded-lg shadow-lg bg-white mb-2 px-4 py-2 cursor-pointer">
                <a href="{{route('job.view', $job->slug)}}">
                    <section class="flex flex-row mb-2">
                        <img src="{{ $job->company->logo_url }}" class="rounded h-20">
                        <div class="flex flex-col px-4">
                            <span class="font-bold text-green-500 text-md">{{ $job->title }}</span>
                            <span class="text-gray-600">{{ $job->company->name }}</span>
                            <span class="text-gray-400">{{ $job->location }}</span>
                        </div>
                    </section>
                    <span class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-gray-200 text-gray-700 rounded">{{ $job->type->name }}</span>
                    <small class="float-right text-gray-500">{{ $job->time_ago }}</small>
                </a>
            </div>
            @endforeach
            @if(!count($jobs))
            <div class="rounded-lg shadow-lg bg-white mb-2 px-4 py-2 cursor-pointer">
                <span>No results to display</span>
            </div>
            @endif
            <div class="rounded-lg shadow-lg bg-white mb-2 px-4 py-2 cursor-pointer">
                @if($jobs->lastPage() > 1)
                {{ $jobs->appends(request()->except('page'))->onEachSide(1)->links() }}
                @endif
            </div>
        </section>

        <div class="rounded-lg shadow-lg bg-white sticky top-20 self-start hidden md:block">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2822549997571103" crossorigin="anonymous"></script>
            <!-- Side Ad Vert -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2822549997571103" data-ad-slot="6027627770" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>