@extends('layouts.app')
@section('content')
    <style>
        /*#search-section {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
        }*/
    </style>
            <div class="max-w-7xl mx-auto pt-5 mb-12 grid grid-cols-4 gap-2" id="search-section">
                <div class="rounded-lg shadow-lg bg-white sticky top-20 self-start p-4 ">
                    <section class="flex flex-col mb-4">
                        <small>Search</small>
                        <input type="text" value="{{request()->search}}">
                    </section>

                    <section class="flex flex-col">
                        <small>City</small>
                        <select name="" id="">
                            <option value="">Select</option>
                            <option value="">Dar es Salaam</option>
                        </select>
                    </section>

                    <div class="form-check py-2">
                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                            Remote
                        </label>
                    </div>

                    <div class="border-t py-4">
                        <span>Industry</span>
                        <section class="h-32 bg-gray-200 px-2 overflow-y-auto">
                            @foreach($industries as $industry)
                            <div class="form-check py-2">
                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                                    {{ $industry->name }}
                                </label>
                            </div>
                            @endforeach
                        </section>
                    </div>

                    <div class="border-t py-4">
                        <span>Employment Type</span>
                        <section class="h-32 bg-gray-200 px-2 overflow-y-auto">
                            @foreach($job_types as $job_type)
                            <div class="form-check py-2">
                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                                    {{ $job_type->name }}
                                </label>
                            </div>
                            @endforeach
                        </section>
                    </div>
                </div>
                <section class="col-span-2">
                    @foreach($jobs as $job)
                    <div class="rounded-lg shadow-lg bg-white mb-2 px-4 py-2 cursor-pointer">
                        <a href="{{route('job.view', $job->slug)}}">
                            <section class="flex flex-row mb-2">
                                <img src="{{ $job->company->logo_url }}" class="rounded h-20">
                                <div class="flex flex-col px-4">
                                    <span class="font-bold text-green-500 text-md">{{ $job->title }}</span>
                                    <span>{{ $job->company->name }}</span>
                                    <span>{{ $job->location }}</span>
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

                </section>

                <div class="rounded-lg shadow-lg bg-white sticky top-20 self-start">
                    <p>hello there</p>
                </div>

            </div>

    </div>
@endsection
