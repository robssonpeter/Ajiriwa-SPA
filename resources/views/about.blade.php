@extends('layouts.app')
@section('content')
<style>
    .description li {
        list-style-type: none;
        list-style-position: inside;
        margin-left: 10px;
    }

    .description li::before {
        content: '\2022'; /* Unicode character for a bullet point */
        color: mediumseagreen; /* Color of the filled circle */
        font-size: 1.5rem; /* Adjust the size of the bullet */
        margin-right: 1rem; /* Adjust the spacing between the bullet and text */
    }

    .description h1 {
        @apply text-3xl font-bold mt-4;
    }

    .description h2 {
        @apply text-2xl font-bold mt-6;
    }

    .description h3 {
        @apply text-xl font-bold mt-4;
    }

    .description h4,
    .description h5 {
        @apply mt-4;
    }

    .w-24 {
        @apply w-24;
    }
</style>

<div class="w-full md:max-w-7xl mx-auto pt-5 mb-12 description" id="job-page">
    <div class="bg-white shadow-lg rounded-lg mb-6 p-6 mx-4 md:mx-8 text-gray-500">
        <h2 class="text-4xl font-bold text-gray-500"><strong>Introduction</strong></h2>
        <p class="mt-4">Ajiriwa.net is a website created to streamline the recruitment process by facilitating direct contact between employers and potential employees. The name "Ajiriwa" is derived from the Swahili word meaning "get employed." Ajiriwa.net aims to revolutionize the recruitment system.</p>
    </div>
    <div class="bg-white shadow-lg rounded-lg mb-6 p-6 mx-4 md:mx-8 text-gray-500">
        <h2 class="text-4xl font-bold text-gray-500"><strong>Our Mission</strong></h2>
        <p class="mt-4">Our primary goal is to provide a platform where employers and job seekers can easily connect and fulfill their needs. We designed this site with both parties in mind, aiming to create a better, more efficient recruitment experience.</p>
    </div>
    <div class="bg-white shadow-lg rounded-lg mb-6 p-6 mx-4 md:mx-8 text-gray-500">
        <h2 class="text-4xl font-bold text-gray-500"><strong>Services for Job Seekers</strong></h2>
        <p class="mt-4">For job seekers, Ajiriwa.net offers a seamless job search experience regardless of education and experience levels. Key features include:</p>
        <ul class="mt-4 ml-4 list-disc list-inside text-lg">
            <li><strong>CV Creation Assistance:</strong> Our system guides job seekers through creating a professional CV by simply answering a series of questions. The generated CV is then saved and showcased to potential employers.</li>
            <li class="mt-2"><strong>CV Recommendations:</strong> With permission, we recommend your CV to various employers, even if you haven't applied to their job postings, enhancing your visibility.</li>
            <li class="mt-2"><strong>Job Notifications:</strong> We notify you of job opportunities that match your skills, ensuring you never miss a perfect job.</li>
        </ul>
    </div>
    <div class="bg-white shadow-lg rounded-lg mb-6 p-6 mx-4 md:mx-8 text-gray-500">
        <h3 class="text-2xl font-bold text-gray-500"><strong>Services for Employers</strong></h3>
        <p class="mt-4">Employers benefit from tools designed to simplify the candidate selection process:</p>
        <ul class="mt-4 ml-4 list-disc list-inside text-lg">
            <li><strong>Centralized Application Management:</strong> All applications are collected and organized in one easily accessible place.</li>
            <li class="mt-2"><strong>Advanced Filtering:</strong> Employers can filter candidates based on experience, education, location, skills, language, and more, making shortlisting efficient.</li>
            <li class="mt-2"><strong>Database Access:</strong> Employers can browse through our growing CV database to find candidates, even without posting a job ad, ideal for quick replacements.</li>
        </ul>
    </div>
    <div class="bg-white shadow-lg rounded-lg mb-6 p-6 mx-4 md:mx-8 text-gray-500">
        <h3 class="text-2xl font-bold text-gray-500"><strong>Recruitment Outsourcing Services</strong></h3>
        <p class="mt-4">In addition to our online platform, we offer comprehensive recruitment outsourcing services. Our team of experts can handle the entire recruitment process for your organization, from job posting and candidate screening to final selection and onboarding. This service ensures you find the best talent while saving time and resources.</p>
        <h2 class="text-2xl font-bold text-gray-500 mt-6"><strong>Enterprise System Development</strong></h2>
        <p class="mt-4">Beyond recruitment services, we develop systems at the enterprise level. Our expertise in creating tailored solutions ensures your organization can operate more efficiently and effectively.</p>
    </div>
    <div class="bg-white shadow-lg rounded-lg mb-6 p-6 mx-4 md:mx-8 text-gray-500">
        <h2 class="text-4xl font-bold text-gray-500"><strong>Commitment to Users</strong></h2>
        <p class="mt-4">We are dedicated to making the job search and hiring process easier for both employers and job seekers. Our services are offered for free, ensuring accessibility for everyone. Create your account today as an Employer or Job Seeker and enjoy the benefits our system provides.</p>
    </div>
    <div class="bg-white shadow-lg rounded-lg mb-6 p-6 mx-4 md:mx-8 text-gray-500">
        <h2 class="text-4xl font-bold text-gray-500"><strong>Our Belief</strong></h2>
        <p class="mt-4">We believe that numerous employment opportunities exist in the country; what is lacking is an effective means to connect employers with the right candidates. Ajiriwa.net aims to bridge this gap, fostering better employment connections.</p>
        <p class="mt-4">Together, we can create a more efficient and effective recruitment landscape.</p>
    </div>
</div>



@endsection