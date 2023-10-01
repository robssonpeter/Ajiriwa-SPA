<html>

<head>
    <title>Curriculum Vitae</title>
    @if (isset($tailwind))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            body {
                font-family: 'Nunito';
            }

            .text-gray-500 {
                color: #6B7280;
            }

            .max-w-7xl {
                max-width: 80rem;
            }

            .py-6 {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }

            .container {
                width: 100%
            }

            .text-green-400 {
                color: #34D399;
            }

            .bg-green-400 {
                background-color: #34D399;
            }

            .text-white {
                color: #ffffff;
            }

            p {
                margin-top: -10px;
            }
            table {
                border: none;
            }
            .mb-2 {
                margin-bottom: 0.5rem;
            }
            .mt-2 {
                margin-top: 0.5rem;
            }
            .mr-2 {
                margin-right: 0.5rem;
            }
            .ml-2 {
                margin-left: 0.5rem;
            }
        </style>
    @endif
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
</head>

<body>
    <section class="text-gray-500 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div>
            <title>{{ $candidate->full_name }} Resume</title>

            <div class="container text-gray-700 body bg-white">
                <div class="">
                    <h1 class="text-center text-3xl ">
                        CURRICULUM VITAE
                    </h1>

                    <h2 class="bg-green-400 text-xl text-white px-2">
                        PERSONAL PARTICULARS
                    </h2>
                    <div class="px-2">
                        <span>
                            <span style="font-weight: bold">Name</span>
                            <strong>:</strong>
                            {{ $candidate->full_name }} </span><br>
                        <span>
                            <strong>Date </strong>
                            <strong>of </strong>
                            <strong>Birth:</strong>
                            {{ $candidate->dob_formatted }}
                        </span><br>
                        <span>
                            <strong>Nationality:</strong>
                            {{ $candidate->nationality }}</span><br>
                        <span>
                            <strong>Sex:</strong>
                            {{ $candidate ? $candidate->sex->name : '' }}</span><br>
                        <span>
                            <strong>Marital status:</strong>
                            {{ $candidate->marital ? $candidate->marital->marital_status : '' }}</span><br>
                        <span>
                            <strong>Phone Number:</strong>
                            {{ $candidate->phone }}</span><br>
                        <span>
                            <strong>Email Address:</strong>
                            {{ $user->email }} </span>
                    </div>

                    @if ($candidate->career_objective)
                        <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                            PERSONAL PROFILE
                        </h2>
                        <br>
                        <div class="px-2">
                            <p class="px-2">{!! htmlspecialchars_decode($candidate->career_objective) !!}</p>
                        </div>
                    @endif

                    @if (count($candidate->experiences))
                        <section class="mt-2">
                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                WORK EXPERIENCE
                            </h2>
                            <div class="px-2">
                                @foreach ($candidate->experiences as $experience)
                                    <p class="mt-2">
                                        <span style="font-weight: bold"
                                            class="font-light">{{ $experience->start_date_formatted }} - </span>
                                        <span
                                            class="{{ $experience->currently_working ? 'font-bold text-green-400' : 'font-bold' }}">{{ $experience->currently_working ? 'Present' : $experience->end_date_formatted }}</span>
                                        <span class="w3-text-green ml-1"
                                            style="font-weight: bold">{{ $experience->company }}</span>
                                        : <em>{{ $experience->title }}</em><strong></strong>
                                        <br><p class="mt-2">{!! htmlspecialchars_decode($experience->description) !!}</p>
                                    </p>
                                    <br>
                                @endforeach
                                <p></p>
                            </div>
                        </section>
                    @endif
                    @if (count($candidate->education))
                        <section class="mt-2">
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                EDUCATION AND QUALIFICATIONS
                            </h2>

                            @foreach ($candidate->education as $education)
                                <p class="px-2 mt-2">
                                    <span class="font-bold">{{ $education->start_year }} - </span>
                                    <span
                                        class="{{ $education->currently_studying ? 'font-bold text-green-400' : 'font-bold' }}">{{ $education->currently_studying ? 'Present' : $education->year }}</span>
                                    <span class="w3-text-green ml-1"
                                        style="font-weight: bold">{{ $education->degree_title }}</span>
                                    : <em>{{ $education->institute }}</em><strong></strong>
                                </p>
                            @endforeach
                        </section>
                    @endif
                </div>

                @if (count($candidate->skills))
                    <section class="mt-2 text-gray-500">
                        <div>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                SKILLS
                            </h2>
                        </div>
                        <div class="px-2">
                            <table class="text-gray-500 mt-2">
                                <tbody>
                                    @foreach ($candidate->skills as $skill)
                                        <tr>
                                            <td>
                                                <span class="mb-2 mr-2">§ {{ $skill->name }}</span>
                                            </td>
                                            <td >
                                                <span class="mb-2 mr-2 ml-2">{{ $skills[$skill->rating] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endif

                @if (count($candidate->languages))
                    <section class="mt-2">
                        <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                            LANGUAGE PROFICIENCY
                        </h2>
                        <div class="px-2 mt-2">
                            @foreach ($candidate->languages as $language)
                                <p class="mb-2">
                                    § {{ $language->name }}: {{ $language->rating_label }}
                                </p>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (count($candidate->referees))
                    <section class="mt-2 text-gray-500" v-if="$page.props.candidate.referees.length">
                        <div>
                            <h2 class="bg-green-400 text-xl text-white px-2 ">
                                REFEREES
                            </h2>
                        </div>
                        <div class="w3-border-bottom px-2 text-gray-500">
                            <span class="text-sm">
                                Apart from my personal information mentioned in this Curriculum Vitae
                                other information with some recommendations may be sought freely from:
                            </span>
                            <div>
                                {{-- <table class="mt-2 text-gray-500 border-none"> --}}
                                    <br>
                                    @foreach ($candidate->referees as $referee)
                                        <div>
                                            <p class="mb-2"><span><strong>{{ $referee->name }}</strong></p></span></p>
                                        </div>
                                        <div>
                                            <p class="mb-2">{{ $referee->company }}</p>
                                        </div>
                                        <div>
                                            <p class="mb-2">{{ $referee->phone }}</p>
                                        </div>
                                        <div>
                                            <p class="mb-2">Email: {{ $referee->email }}</p>
                                        </div>
                                        <br>
                                    @endforeach
                               {{--  </table> --}}
                            </div>
                        </div>
                    </section>
                @endif
            </div>

            <!-- End Right Column -->
        </div>
        <section >
            <p calss="mt-2"><em>Resume created using <a href="{{ route('root') }}" class="text-green-400"><strong>ajiriwa.net</strong></a></em></p>
        </section>
    </section>
</body>

</html>
