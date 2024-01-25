@extends('layouts.app')

@section('content')
<style>
    /*#search-section {
                    background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
                }*/
    input[type=file]::file-selector-button {
        background: rgba(243, 244, 246, var(--tw-bg-opacity)) !important;
        color: black;
    }
</style>
<div class="w-full md:max-w-7xl md:mx-auto mb-12 md:grid md:grid-cols-6 md:gap-2" id="job-page">
    <div class="md:col-span-4 md:mr-0 mt-2">
        <div class="bg-white shadow-lg md:hidden md:ml-8 px-2 mb-2">
            <nav class="flex py-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 py-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="inline-flex items-center text-sm font-medium text-green-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('jobs.browse.ext') }}" class="ml-1 text-sm font-medium text-green-500 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Jobs</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $job->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="bg-white shadow-lg md:ml-8 mx-1 sm:mx-1 p-2 rounded-md">
            <section class="md:grid grid-cols-4">
                <div class="col-span-3 flex flex-col">
                    <span class="text-xl text-gray-500 font-bold">{{ $job->title }}</span>
                    <span class="text-green-500">{{ $job->company->name }}</span>
                    <span class="text-gray-500" v-on:click="apply">{{ $job->location }}</span>
                </div>
                <div class="md:grid md:grid-cols-2 md:gap-4 hidden md:block">
                    @if (!in_array($job->id, $applied))
                    @if (Auth::check())
                    {{-- When the user is signed in --}}
                    @if ($job->apply_method == 'ajiriwa' || $job->apply_method == 'email')
                    <a href="{{ $apply_url }}" class="bg-green-500 hover:bg-green-600 rounded-md text-white text-center p-2 self-center">Apply</a>
                    @elseif($job->apply_method == 'url')
                    <a href="{{ $apply_url }}" target="_blank" class="bg-green-500 hover:bg-green-600 rounded-md text-white p-2 text-center self-center">Apply</a>
                    @endif
                    @else
                    {{-- This will render if the user is not signed in --}}
                    <button class="bg-green-500 hover:bg-green-600 rounded-md text-white p-2 self-center" v-on:click="apply()">Apply</button>
                    @endif
                    @else
                    <button class="border border-green-500 rounded-md text-green-500 p-2 self-center flex space-x-1">
                        <span>Applied</span>
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>  --}}
                    </button>
                    @endif
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 self-center text-green-500 cursor-pointer"
                            data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                        </svg> --}}
                    <div class="relative inline-block text-left">
                        <button id="show-sharing-links" class="inline-flex items-center mt-5 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500">
                            Share
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="sharing-links" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(Request::url()) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex space-x-1" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="30px" height="30px">
                                        <path fill="#0288D1" d="M42,37c0,2.762-2.238,5-5,5H11c-2.761,0-5-2.238-5-5V11c0-2.762,2.239-5,5-5h26c2.762,0,5,2.238,5,5V37z" />
                                        <path fill="#FFF" d="M12 19H17V36H12zM14.485 17h-.028C12.965 17 12 15.888 12 14.499 12 13.08 12.995 12 14.514 12c1.521 0 2.458 1.08 2.486 2.499C17 15.887 16.035 17 14.485 17zM36 36h-5v-9.099c0-2.198-1.225-3.698-3.192-3.698-1.501 0-2.313 1.012-2.707 1.99C24.957 25.543 25 26.511 25 27v9h-5V19h5v2.616C25.721 20.5 26.85 19 29.738 19c3.578 0 6.261 2.25 6.261 7.274L36 36 36 36z" />
                                    </svg>
                                    <span class="self-center">LinkedIn</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex space-x-1" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="30px" height="30px">
                                        <path fill="#03A9F4" d="M42,12.429c-1.323,0.586-2.746,0.977-4.247,1.162c1.526-0.906,2.7-2.351,3.251-4.058c-1.428,0.837-3.01,1.452-4.693,1.776C34.967,9.884,33.05,9,30.926,9c-4.08,0-7.387,3.278-7.387,7.32c0,0.572,0.067,1.129,0.193,1.67c-6.138-0.308-11.582-3.226-15.224-7.654c-0.64,1.082-1,2.349-1,3.686c0,2.541,1.301,4.778,3.285,6.096c-1.211-0.037-2.351-0.374-3.349-0.914c0,0.022,0,0.055,0,0.086c0,3.551,2.547,6.508,5.923,7.181c-0.617,0.169-1.269,0.263-1.941,0.263c-0.477,0-0.942-0.054-1.392-0.135c0.94,2.902,3.667,5.023,6.898,5.086c-2.528,1.96-5.712,3.134-9.174,3.134c-0.598,0-1.183-0.034-1.761-0.104C9.268,36.786,13.152,38,17.321,38c13.585,0,21.017-11.156,21.017-20.834c0-0.317-0.01-0.633-0.025-0.945C39.763,15.197,41.013,13.905,42,12.429" />
                                    </svg>
                                    <span class="self-center">Share on Twitter</span>
                                </a>
                                <a href="whatsapp://send?text={{ urlencode(Request::url()) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex space-x-1" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="30px" height="30px" clip-rule="evenodd">
                                        <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" />
                                        <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" />
                                        <path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" />
                                        <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" />
                                        <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="self-center">WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>


            </section>
            <div class="bg-gray-200 w-full p-3 mt-2 md:grid md:grid-cols-3 rounded-md">
                <section class="md:flex md:flex-col flex-row">
                    <span class="font-bold hidden md:block">Job Type:</span>
                    <div class="items-center md:hidden block px-2 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                        </svg>
                        <span class="pl-4 md:pl-0 self-center md:self-start">{{ $job->type->name }}</span>
                    </div>
                    <span class="pl-4 md:pl-0 hidden md:block self-start">{{ $job->type->name }}</span>
                </section>
                <section class="md:flex md:flex-col flex-row">
                    <span class="font-bold hidden md:block">Closing Date:</span>
                    <div class="items-center md:hidden block px-2 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                        <span class="pl-4 md:pl-0 self-center md:self-start">{{ Carbon\Carbon::parse($job->deadline)->format('jS F Y') }}</span>
                    </div>
                    <span class="pl-4 md:pl-0 hidden md:block self-start">{{ Carbon\Carbon::parse($job->deadline)->format('jS F Y') }}</span>
                </section>
                <!-- <section class="md:flex md:flex-col flex-row">
                        <span class="font-bold hidden md:block">Location:</span>
                        <div class="items-center md:hidden block px-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span class="pl-4 md:pl-0 self-center md:self-start">{{ $job->location }}</span>
                        </div>
                        <span class="pl-4 md:pl-0 hidden md:block self-start">{{ $job->location }}</span>
                    </section> -->
                <section class="md:flex md:flex-col flex-row">
                    <span class="font-bold hidden md:block">Views:</span>
                    <div class="items-center md:hidden block px-2 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="pl-4 md:pl-0 self-center md:self-start">{{ $job->counted_views + $views }}</span>
                    </div>
                    <span class="pl-4 md:pl-0 hidden md:block self-start">{{ $job->counted_views + $views }}</span>
                </section>
                <div class="flex flex-row py-2 md:hidden">
                    <button class="bg-green-500 rounded-md w-full text-white p-2 self-center" @click="apply">Apply</button>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg md:ml-8 md:mx-2 px-2 py-3 mx-1 md:p-4 mt-2 description text-gray-600 rounded-lg">
            {!! $job->description !!}
        </div>
    </div>
    <div class="col-span-2 px-1 md:mx-2 md:px-4" id="side-section">
        <section>
            <div id="company-section" class="bg-white self-start py-4 mt-2 sticky top-16 shadow-lg hidden md:block rounded-lg">
                <section class="flex flex-row border-b pb-2">
                    <div class="h-16 w-16 bg-green-200 rounded-lg">
                        <img src="{{ $job->company->logo_url }}" class="rounded-lg" alt="">
                    </div>
                    <section class="px-4 flex flex-col ">
                        <a href="{{ route('company.show', $job->company->slug) }}" class="font-bold text-green-600 cursor-pointer">{{ $job->company->name }}</a>
                        <span class="text-gray-600">Banking</span>
                        @if ($job->company->website)
                        <small class="text-green-500" onclick="window.location.href = '{{ $job->company->website }}'">Website</small>
                        @endif
                    </section>
                </section>
            </div>
            @if ($prom)
            <a href="{{ $prom['Link'] }}" rel="no-follow">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col mb-2 mt-4">
                    <div class="bg-green-500 text-white text-center py-1">
                        <span class="text-xs">Sponsored Listing</span>
                    </div>
                    <div class="px-4 py-6 flex-1 bg-green-100">
                        <div class="flex items-center mb-4">
                            @if (isset($prom['Logo']))
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="{{ $prom['Logo'] }}" alt="Company Logo">
                            </div>
                            @endif
                            <div class="ml-3">
                                <span class="font-bold text-green-500 text-lg">{{ $prom['Job_Title'] }}</span>
                                <span class="text-gray-400 block">{{ $prom['Company'] }}</span>
                                <span class="text-gray-400 block">{{ $prom['Location'] }}</span>
                            </div>
                        </div>
                        <div><span class="text-gray-500 text-sm">{!! \Illuminate\Support\Str::limit($prom['Summary'], 80) !!}</span></div>
                    </div>
                </div>
            </a>
            @endif
        </section>
    </div>
    <TransitionRoot :show="true" as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
        <Dialog as="div" :open="application_means.show_modal" class="relative z-50">
            <!-- The backdrop, rendered as a fixed sibling to the panel container -->
            <!-- <div class="fixed inset-0 bg-black/40" aria-hidden="true" /> -->

            <!-- Full-screen container to center the panel -->
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <!-- The actual dialog panel -->
                <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-600 p-4">
                        <strong>Application</strong>
                        <button type="button" @click="closeApply" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline text-xs float-right" data-bs-dismiss="modal" aria-label="Close"></button>

                    </DialogTitle>
                    <DialogDescription>
                        <div class="mt-2">
                            @if ($allow_apply)
                            <div class="modal-body relative p-4 text-gray-700">
                                <span>How do you want to apply?</span>
                            </div>
                            <div class="mt-4 px-4 flex flex-col md:flex-row space-y-1">
                                <a type="button" href="{{route('job.apply', $job->slug)}}" class="inline-flex justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                    {{-- @click="loginToApply"> --}}
                                    Login to Quickly Apply
                                </a>
                                <button type="button" class="inline-flex justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" @click="applyWithoutLogin">
                                    Apply Without Login
                                </button>
                            </div>
                            @else
                            <div class="mt-4 px-4">
                                <span><p class="text-red-500">Sorry, this job no longer accepts new
                                    applications.</p></span>
                                    @if(count($suggestions))
                                    <div class="flex flex-col pt-4">
                                        <span class="text-gray-600"><strong>Check these similar jobs</strong></span>
                                        @foreach($suggestions as $suggestion)
                                            <a href="{{ route('job.view', $suggestion->slug) }}" class="text-green-500">{{ $suggestion->title }}</a>
                                        @endforeach
                                    </div>
                                    @endif
                                <div class="pt-4">
                                    <button class="bg-gray-700 rounded-md float-right text-white p-2 text-white" @click="closeApply">Okay</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </DialogDescription>

                    <!-- ... -->
                </DialogPanel>
            </div>
        </Dialog>

        <Dialog as="div" :open="guest_application.show_modal" class="relative z-50">
            <!-- The backdrop, rendered as a fixed sibling to the panel container -->
            <div class="fixed inset-0 bg-black/40" aria-hidden="true" />

            <!-- Full-screen container to center the panel -->
            <div class="fixed inset-0 flex items-center justify-center px-2 md:px-4 py-4">
                <!-- The actual dialog panel -->
                <DialogPanel class="w-full max-w-3xl transform overflow-hidden rounded-2xl bg-gray-100 p-6 text-left align-middle shadow-xl transition-all">
                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-600 md:px-4 py-4">
                        <strong>Applying...</strong>
                        <button type="button" @click="guest_application.show_modal=false" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline text-xs float-right" data-bs-dismiss="modal" aria-label="Close"></button>

                    </DialogTitle>
                    <DialogDescription>
                        <div class="mt-2">
                            <form action="" id="guest-application" @submit.prevent="">
                                <div class="modal-body relative md:px-4 py-4 text-gray-700">
                                    <div class="md:flex justify-start">
                                        <div class="mb-3 w-full flex flex-col">
                                            <label for="exampleFormControlInput1" class="form-label inline-block mb-2 text-gray-700 font-bold">Full
                                                Name</label>
                                            <input type="text" name="full_name" v-model="application.name" placeholder="Your name" class="w-full focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                        </div>
                                        <div class="mb-3 w-full flex flex-col md:ml-2">
                                            <label for="exampleFormControlInput1" class="form-label inline-block mb-2 text-gray-700 font-bold">Email</label>
                                            <input type="email" name="email" v-model="application.email" placeholder="Your email" class="w-full focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                        </div>
                                    </div>
                                    <section>
                                        <span class="font-bold">Cover Letter</span>
                                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                                        <input type="hidden" name="cover_letter" v-model="application.cover_letter">
                                        <text-editor @change="editorChanged" text="Write you cover letter here" class="bg-white max-h-52 overflow-y-auto" v-model="application.cover_letter"></text-editor>
                                    </section>

                                    <div class="flex">
                                        <div class="mb-3 w-full pt-4">
                                            <label for="formFileMultiple" class="form-label inline-block mb-2 text-gray-700 font-bold">Attachments</label>
                                            <input name="attachments[]" class="form-control
                                                            button
                                                            block
                                                            w-full
                                                            px-3
                                                            py-1
                                                            font-normal
                                                            text-gray-600
                                                            bg-white bg-clip-padding
                                                            border border-solid border-gray-300
                                                            file:bg-amber-500, file:text-sm
                                                            transition
                                                            ease-in-out
                                                            m-0
                                                            focus:text-gray-700 focus:bg-white focus:border-green-600 focus:ring focus:ring-green-200 focus:outline-none" type="file" id="formFileMultiple" multiple>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 md:px-4 py-4">
                                    <button type="button" class="inline-flex justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" @click="sendApplication" :disabled="applying">
                                        <loader v-if="applying" color="white"></loader>
                                        <span v-else>Send Application</span>
                                    </button>
                                    <button type="button" class="ml-2 inline-flex justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" @click="guest_application.show_modal=false">
                                        Cancel
                                    </button>
                                    <!--                                    <button v-if="applying" @click="applying = false">Unload</button>-->
                                </div>
                            </form>
                        </div>
                    </DialogDescription>

                    <!-- ... -->
                </DialogPanel>
            </div>
        </Dialog>
    </TransitionRoot>
</div>
<script type="text/javascript">
    //const checkbox = document.getElementById("flexCheckIndeterminate");
    //checkbox.indeterminate = true;
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.getElementById('show-sharing-links');
        const sharingLinks = document.getElementById('sharing-links');

        // Toggle the dropdown menu when the button is clicked
        dropdownButton.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent this click from propagating to the document
            sharingLinks.classList.toggle('hidden'); // Toggle the 'hidden' class
        });

        // Hide the dropdown menu when a click occurs anywhere on the document
        document.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target)) {
                sharingLinks.classList.add('hidden'); // Hide the menu
            }
        });
    });
</script>


<script>
    var job = @json($job);
    let loginPage = "{{ route('login') }}";
    let applyUrl = "{{ route('job.guest-apply') }}";
    let sessionUrl = "{{ route('session.create') }}";
    let application_url = "{{ urlencode(route('redirect') . '?jobid=' . $job->id) }}";
    let link = "{{ 'link=' . $job->application_url }}"
    //var url = @json(request()->query())

    let url_query = @json(request()->query())

    //console.log(job);
    console.log(Object.keys(url_query));
</script>
<script src="{{ mix('js/job.js') }}"></script>
@endsection