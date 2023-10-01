<!DOCTYPE html>
<html amp lang="en">

<head>
    <meta charset="utf-8">
    {{-- <title>AMP Page</title> --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    @if (!JsonLd::isEmpty())
        {!! JsonLd::generate() !!}
    @endif
    @if (!JsonLdMulti::isEmpty())
        {!! JsonLdMulti::generate() !!}
    @endif
    <link rel="canonical" href="{{ route('job.view', $job->slug) }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-custom>
        /* Your Tailwind CSS classes go here */
        /* Translated Tailwind CSS classes */
        .bg-white {
            background-color: #fff;
        }

        .shadow-lg {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mx-2 {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .grid {
            display: grid;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .col-span-3 {
            grid-column: span 3;
        }

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-green-500 {
            color: #10b981;
        }

        .hidden {
            display: none;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .gap-4 {
            gap: 1rem;
        }

        .bg-green-500 {
            background-color: #10b981;
        }

        .hover\:bg-green-600:hover {
            background-color: #059669;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .text-white {
            color: #fff;
        }

        .self-center {
            align-self: center;
        }

        .w-6 {
            width: 1.5rem;
        }

        .h-6 {
            height: 1.5rem;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        a.apply {
            margin-top: 10px;
            text-decoration: none;
            padding: 5px;
            text-align: center;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }

        .logo-container {
            text-align: center;
            margin: 20px 0; /* Adjust the margin as needed */
        }

        .logo-img {
            max-width: 100%; /* Ensure the logo fits within the viewport */
            height: auto;
        }
    </style>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
</head>

<body>
    
    <div class="bg-white shadow-lg mx-2 p-4 rounded-md">
        <div class="logo-container">
            <amp-img
                src="{{ asset('images/ajiriwa-logo-with-text.png') }}"
                alt="Your Logo"
                width="200"
                height="50">
            </amp-img>
            
        </div>
        
        <section class="grid grid-cols-4">
            <div class="col-span-3 flex flex-col">
                <span class="text-xl text-gray-500 font-bold">{{ $job->title }}</span>
                <span class="text-green-500">{{ $job->company->name }}</span>
                <span class="text-gray-500">{{ $job->location }}</span>
            </div>
            <div class="grid grid-cols-2 gap-4 hidden">
                <button class="bg-green-500 hover:bg-green-600 rounded-md text-white p-2" on="tap:apply">Apply</button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-green-500 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#exampleModalCenter">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                </svg>
            </div>
        </section>
        <div class="bg-gray-200 mt-2 rounded-md">
            <section>
                <span class="font-bold text-gray-500">Job Type:</span>
                <span class="block md:hidden text-gray-500">Full-Time</span>
                <span class="hidden md:block self-start">Full-Time</span>
            </section>
            <section>
                <span class="font-bold text-gray-500">Closing Date:</span>
                <span class="block md:hidden text-gray-500">30th October 2023</span>
            </section>
            <section>
                <span class="font-bold text-gray-500">Location:</span>
                <span class="block md:hidden text-gray-500">Dar es Salaam, Tanzania</span>
            </section>

            <div class="flex py-2 md:hidden">
                <a style="width: 100%" href="{{ $apply_url }}"
                    class="apply bg-green-500 rounded-md w-full text-white p-2">Apply</a>
            </div>
        </div>
    </div>

    <div class="bg-white mx-2 p-4 mt-2 description text-gray-600 rounded-lg">
        <div class="text-gray-500">
            <p class="text-gray-600">{!! $job->description !!}</p>
        </div>
    </div>
</body>

</html>
