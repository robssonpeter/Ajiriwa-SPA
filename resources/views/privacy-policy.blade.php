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
    <div class="w-full md:max-w-7xl mx-auto pt-5 mb-12 bg-white px-8 text-gray-600" id="job-page">
        <h2 class="mb-8 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Privacy Policy</h2>
        <div class="pt-8 text-left border-t border-gray-200 md:gap-16 dark:border-gray-700 md:grid-cols-2 ">
            <p>This Privacy Policy describes how your personal information is collected, used, and shared when you visit https://www.ajiriwa.net (the &ldquo;Site&rdquo;). PERSONAL</p>
            <h2 class="text-lg font-bold mt-4">INFORMATION WE COLLECT</h2>
            <p>When you visit the Site, we automatically collect certain information about your device, including information about your web browser, IP address, time zone, and some of the cookies that are installed on your device. Additionally, as you browse the Site, we collect information about the individual web pages or products that you view, what websites or search terms referred you to the Site, and information about how you interact with the Site. We refer to this automatically-collected information as &ldquo;Device Information.&rdquo;</p>
            <p>We collect Device Information using the following technologies:</p>
            <p>- &ldquo;Cookies&rdquo; are data files that are placed on your device or computer and often include an anonymous unique identifier.</p>
            <p>- &ldquo;Log files&rdquo; track actions occurring on the Site, and collect data including your IP address, browser type, Internet service provider, referring/exit pages, and date/time stamps.</p>
            <p>- &ldquo;Web beacons,&rdquo; &ldquo;tags,&rdquo; and &ldquo;pixels&rdquo; are electronic files used to record information about how you browse the Site.</p>
            <p>When we talk about &ldquo;Personal Information&rdquo; in this Privacy Policy, we are talking both about Device Information and CV Information that you may enter on account creation.</p>
            <h2 class="text-lg font-bold mt-4">HOW DO WE USE YOUR PERSONAL INFORMATION?</h2>
            <p>We use the CV information that you enter to show employers to whom you make application for jobs, your CV may also appear on search when employers are searching for a specific person, you cv may only appear on search if you allow it. We also you use your information to communicate with you or send you useful information:</p>
            <p>We use the Device Information that we collect to help us screen for potential risk and fraud (in particular, your IP address), and more generally to improve and optimize our Site (for example, by generating analytics about how our customers browse and interact with the Site, and to assess the success of our marketing and advertising campaigns).</p>
            <h2 class="text-lg font-bold mt-4">SHARING YOUR PERSONAL INFORMATION</h2>
            <p>We only share your CV information to employers to whom you make applications and of course if you allow, then your CV can appear on search.</p>
            <p>Finally, we may also share your Personal Information to comply with applicable laws and regulations, to respond to a subpoena, search warrant or other lawful requests for information we receive, or to otherwise protect our rights.</p>
            <h2 class="text-lg font-bold mt-4">DO NOT TRACK</h2>
            <p>Please note that we do not alter our Site&rsquo;s data collection and use practices when we see a Do Not Track signal from your browser.</p>
            <p>YOUR RIGHTS The information we store about you is fully yours and you are fully in control, you can at any time alter or delete part of it.</p>
            <h2 class="text-lg font-bold mt-4">DATA RETENTION</h2>
            <p>When your information is saved in our server we will keep it for as long as you don&rsquo;t tell us to remove, if you want your remove your information kindly login to your account and do so.</p>
            <h2 class="text-lg font-bold mt-4">CHANGES</h2>
            <p>We may update this privacy policy from time to time in order to reflect, for example, changes to our practices or for other operational, legal or regulatory reasons.</p>
            <h2 class="text-lg font-bold mt-4">CONTACT US</h2>
            <p>For more information about our privacy practices, if you have questions, or if you would like to make a complaint, please contact us by e-mail at info@ajiriwa.net or by the contact page</p>
        </div>
    </div>
    <script type="text/javascript">
        const checkbox = document.getElementById("flexCheckIndeterminate");
        checkbox.indeterminate = true;
    </script>
    <script>
        let loginPage = "{{ route('login') }}";
        let applyUrl = "{{ route('job.guest-apply') }}";
        let sessionUrl = "{{ route('session.create') }}";
    </script>
<!--    <script src="{{ mix('js/job.js') }}"></script>-->
@endsection
