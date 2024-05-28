<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php
    $livewire_routes = ["jobs.by-category", "jobs.search", "jobs.browse.ext"];
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    @if(!JsonLd::isEmpty())
    {!! JsonLd::generate() !!}
    @endif
    @if(!JsonLdMulti::isEmpty())
    {!! JsonLdMulti::generate() !!}
    @endif
    {!! Twitter::generate() !!}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="icon" type="image/x-icon" href="{{asset('/images/favicon/favicon.ico')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/images/favicon/apple-touch-icon.png')}}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/images/favicon/apple-touch-icon.png')}}" />

    @if(session()->has('amp-page'))
    <link rel="amphtml" href="{{ session()->get('amp-page') }}">
    @endif
    @php
    $no_ads_pages = ['root', 'employers']
    @endphp
    @if(!in_array(\Route::current()->getName(), $no_ads_pages))
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2822549997571103" crossorigin="anonymous"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-104559642-1"></script>
    @endif

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-V0L92N1SB1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'TAG_ID');
    </script>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/essential.js') }}" defer></script> --}}
    @if(in_array(\Route::current()->getName(), $livewire_routes))
    @livewireStyles
    @endif
    <style>
        div.description li {
            list-style-type: none;
            list-style-position: inside;
            margin-left: 10px;

            /*margin-inside: 10px;*/

        }

        div.description li::before {
            content: '\2022'; /* Unicode character for a bullet point */
            color: #3498db; /* Color of the filled circle */
            font-size: 1.5rem; /* Adjust the size of the bullet */
            margin-right: 1rem; /* Adjust the spacing between the bullet and text */
        }

        div.description li::before {
            color: mediumseagreen;
        }

        div.description h1 {
            font-size: x-large;
            font-weight: bold;
            margin-top: 10px;
        }

        div.description h2 {
            font-size: large;
            font-weight: bold;
            margin-top: 8px
        }

        div.description h3 {
            font-size: medium;
            font-weight: bold;
        }

        div.description h4 {
            margin-top: 8px;
        }

        div.description h5 {
            margin-top: 8px;
        }

        .w-24 {
            width: 6rem !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    @if(in_array(\Route::current()->getName(), $livewire_routes))
    @livewireScripts
    @endif

    <div class="min-h-screen bg-gray-100" id="app">

        <div class="relative bg-white sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-1 sm:px-4 md:px-6">
                <div class="flex justify-between items-center border-gray-100 py-2 md:justify-start md:space-x-10">
                    <div class="flex justify-start lg:w-0 lg:flex-1">
                        <a href="/" class="flex space-x-2" id="home-link">
                            <span class="sr-only">Workflow</span>
                            <!-- <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt=""> -->
                            <img class="h-8 w-auto sm:h-10" src="{{asset('images/ajiriwa-new-logo.png')}}" alt="Ajiriwa Network">
                            <span class=" self-center text-2xl font-bold text-gray-500">Ajiriwa.net</span>
                        </a>
                    </div>
                    <div class="mr-1 -my-2 md:hidden">
                        <button type="button" onclick="document.getElementById('mobile-menu').classList.remove('hidden')" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                            <span class="sr-only">Open menu</span>
                            <!-- Heroicon name: outline/menu -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    <nav class="hidden md:flex space-x-10">
                        <a href="{{route('jobs.browse.ext')}}" class="text-gray-500 self-center">Jobs</a>
                        <a href="{{route('blog.index')}}" class="text-gray-500 self-center">Blog</a>
                        <a href="{{ route('employers') }}" class="text-gray-500 self-center">Employers</a>

                        <!--<router-link :to="{ name: 'Jobs'}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                              Jobs
                            </router-link>
                            <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                              Blog
                            </a>
                            <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                              Employers
                            </a>-->
                    </nav>


                    <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                        @if(!Auth::check())
                        <a href="{{route('login')}}" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">
                            Sign in
                        </a>
                        <a href="{{route('register')}}" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-500 hover:bg-green-700">
                            Register
                        </a>
                        @else
                        <div class="relative inline-block text-left">
                            <button id="dropdown-button" type="button" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md hover:bg-gray-50 focus:outline-none active:bg-gray-100 active:text-gray-800">
                                {{ Auth::user()->name }}
                                <!-- Heroicon name: chevron-down -->
                                <svg class="w-5 h-5 ml-2 -mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M6.293 7.293a1 1 0 011.414 0L10 9.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            @php
                            $user_menu = userMenu();
                            @endphp

                            <div id="dropdown-menu" class="absolute right-0 w-40 mt-2 origin-top-right bg-white border border-gray-300 divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                    @foreach($user_menu as $menu)
                                    <a href="{{ $menu['link'] }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ $menu['name'] }}</a>
                                    @endforeach
                                    <a href="#" onclick="document.getElementById('logout-form').submit()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</a>
                                </div>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                    {{-- <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a> --}}
                                </form>

                            </div>
                        </div>

                        @endif
                    </div>
                </div>
            </div>
            {{-- <owl-slider></owl-slider> --}}
            <!--
                  Mobile menu, show/hide based on mobile menu state.

                  Entering: "duration-200 ease-out"
                    From: "opacity-0 scale-95"
                    To: "opacity-100 scale-100"
                  Leaving: "duration-100 ease-in"
                    From: "opacity-100 scale-100"
                    To: "opacity-0 scale-95"
                -->
            <Menu>
                <div id="mobile-menu" class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right hidden md:hidden">
                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                        <div class="pt-5 pb-6 px-5 pr-4">


                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <img class="h-8 w-auto sm:h-10" src="{{asset('images/ajiriwa-new-logo.png')}}" alt="Ajiriwa Network">
                                    <span class=" self-center text-2xl font-bold text-gray-500">Ajiriwa.net</span>
                                </div>
                                <div class="-mr-2">
                                    <button type="button" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                        <span class="sr-only">Close menu</span>
                                        <!-- Heroicon name: outline/x -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-6">
                                <nav class="grid gap-y-8">
                                    <a href="{{ route('jobs.browse.ext') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                        <!-- Heroicon name: outline/chart-bar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                        </svg>

                                        <span class="ml-3 text-base font-medium text-gray-900">
                                            Jobs
                                        </span>
                                    </a>

                                    <a href="{{ route('blog.index') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                        <!-- Heroicon name: outline/cursor-click -->
                                        <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                        </svg>
                                        <span class="ml-3 text-base font-medium text-gray-900">
                                            Blog
                                        </span>
                                    </a>

                                    <a href="{{ route('employers') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                        <!-- Heroicon name: outline/shield-check -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>

                                        <span class="ml-3 text-base font-medium text-gray-900">
                                            Employers
                                        </span>
                                    </a>

                                    {{-- <a href="{{ route('employers') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                    <!-- Heroicon name: outline/view-grid -->
                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    <span class="ml-3 text-base font-medium text-gray-900">
                                        Integrations
                                    </span>
                                    </a>

                                    <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                        <!-- Heroicon name: outline/refresh -->
                                        <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="ml-3 text-base font-medium text-gray-900">
                                            Automations
                                        </span>
                                    </a> --}}
                                </nav>
                            </div>
                        </div>
                        <div class="py-6 px-5 space-y-6">
                            {{-- <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                        Pricing
                                    </a>

                                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                        Docs
                                    </a>

                                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                        Help Center
                                    </a>

                                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                        Guides
                                    </a>

                                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                        Events
                                    </a>

                                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                        Security
                                    </a>
                                </div> --}}
                            <div>
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-500 hover:bg-gray-600">
                                    Sign up
                                </a>
                                <p class="mt-6 text-center text-base font-medium text-gray-500">
                                    Existing customer?
                                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-500">
                                        Sign in
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </Menu>
        </div>


        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    <!--  Footer  -->
    <footer class="bg-gray-800 text-gray-400 px-6 lg:px-8 py-12">

        <div class="max-w-screen-xl mx-auto grid md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-x-8">
            <div>
                <img class="h-8" src="{{ asset('/images/ajiriwa-new-logo.png') }}" alt="UptimeMate logo">
                <p class="mt-3">Ajiriwa Net was created to bridge the gap between the Recruiters and their potential employees. It is the ideal place to find the right job for the job seekers.</p>
            </div>
            <div>
                <h5 class="text-xl font-bold text-white">Company</h5>
                <nav class="mt-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="/about" class="font-normal text-base hover:text-gray-200">About Us</a>
                        </li>
                        <li>
                            <a href="{{ route('blog.index') }}" class="font-normal text-base hover:text-gray-200">Our Blog</a>
                        </li>
                        <li>
                            <a href="{{ route('privacy.policy') }}" class="font-normal text-base hover:text-gray-200">Privacy Policy</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div>
                <h5 class="text-xl font-bold text-white">Browse</h5>
                <div class="space-y-4 md:space-y-6 mt-4">
                    <nav class="mt-4">
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('jobs.browse.ext') }}" class="font-normal text-base hover:text-gray-200">Find Jobs</a>
                            </li>
                            <li>
                                <a href="{{ route('faqs.index') }}" class="font-normal text-base hover:text-gray-200">Frequently Asked Questions</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
            <div>
                <h5 class="text-xl font-bold text-white">Contact</h5>
                <div class="space-y-8 mt-4">
                    <div class="flex items-start space-x-4">
                        <div>
                            <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <address class="not-italic self-center">
                                Dar es Salaam, Tanzania<br>
                            </address>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>

                        </div>
                        <div class="flex-1">
                            <a href="#" class="hover:text-gray-200">+255 759 867 315</a>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div>
                            <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <a href="#" class="hover:text-gray-200">info@ajiriwa.net</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="max-w-screen-xl mx-auto flex flex-col items-center mt-16">
            <div class="flex items-center space-x-2">
                <a href="https://www.facebook.com/ajiriwa/" rel="no-follow" class="hover:text-gray-200">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/ajiriwa_network/" rel="no-follow" class="hover:text-gray-200">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="https://tz.linkedin.com/company/ajiriwa-network" class="hover:text-gray-200">
                    <span class="sr-only">Linkedin</span>
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" xml:space="preserve">
                        <g>
                            <path fill="#808184" d="M12.5,12h-3C9.224,12,9,12.224,9,12.5v11C9,23.776,9.224,24,9.5,24h3c0.276,0,0.5-0.224,0.5-0.5v-11
		C13,12.224,12.776,12,12.5,12z M12,23h-2V13h2V23z" />
                            <path fill="#808184" d="M11,7C9.897,7,9,7.897,9,9s0.897,2,2,2s2-0.897,2-2S12.103,7,11,7z M11,10c-0.552,0-1-0.449-1-1
		s0.448-1,1-1s1,0.449,1,1S11.552,10,11,10z" />
                            <path fill="#808184" d="M19.515,11.986c-0.534,0-1.097,0.119-1.554,0.32C17.886,12.126,17.707,12,17.5,12h-3
		c-0.276,0-0.5,0.224-0.5,0.5v11c0,0.276,0.224,0.5,0.5,0.5h3c0.276,0,0.5-0.224,0.5-0.5l-0.002-6.661
		c0-0.003-0.012-0.336,0.2-0.565C18.365,16.092,18.65,16,19.044,16C19.696,16,20,16.279,20,16.879V23.5c0,0.276,0.224,0.5,0.5,0.5h3
		c0.276,0,0.5-0.224,0.5-0.5v-6.842C24,13.21,21.584,11.986,19.515,11.986z M23,23h-2v-6.121C21,15.72,20.251,15,19.044,15
		c-0.684,0-1.216,0.2-1.581,0.595c-0.507,0.549-0.468,1.246-0.463,1.284V23h-2V13h2v0.355c0,0.276,0.224,0.5,0.5,0.5
		c0.245,0,0.448-0.176,0.491-0.408c0.134-0.146,0.722-0.46,1.523-0.46c0.817,0,3.485,0.265,3.485,3.671V23z" />
                            <path fill="#808184" d="M16-0.035C7.158-0.035-0.034,7.159-0.034,16S7.158,32.035,16,32.035S32.034,24.841,32.034,16
		S24.842-0.035,16-0.035z M16,30.965C7.748,30.965,1.034,24.252,1.034,16S7.748,1.035,16,1.035S30.966,7.748,30.966,16
		S24.252,30.965,16,30.965z" />
                        </g>
                    </svg>
                </a>
            </div>
            <div class="text-sm mt-4">
                ©{{ date('Y')}} Ajiriwa Network. All rights reserved.
            </div>
        </div>
    </footer>
</body>
<script>
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownMenu = document.getElementById('dropdown-menu');

    if (dropdownButton){
        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });
    }
    

    // Close the dropdown when clicking outside of it
    if (dropdownMenu){
        window.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }
    
</script>

</html>