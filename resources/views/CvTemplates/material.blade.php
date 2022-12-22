<html>
<head>
    <title>Curriculum Vitae</title>
    <style>
        /* cyrillic-ext */
        @font-face {
            font-family: 'Nunito';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/nunito/v25/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTk3j77e.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }
        /* cyrillic */
        @font-face {
            font-family: 'Nunito';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/nunito/v25/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTA3j77e.woff2) format('woff2');
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* vietnamese */
        @font-face {
            font-family: 'Nunito';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/nunito/v25/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTs3j77e.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }
        /* latin-ext */
        @font-face {
            font-family: 'Nunito';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/nunito/v25/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTo3j77e.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Nunito';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/nunito/v25/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTQ3jw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        body{
            font-family: 'Nunito';
        }
        .text-gray-500{
            color: #6B7280;
        }
        .max-w-7xl{
            max-width: 80rem;
        }
        .py-6{
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .container{
            width: 100%
        }

        .bg-green-400{
            background-color: #34D399;
        }
        .text-white{
            color: #ffffff;
        }
        p{
            margin-top: -10px;
        }

    </style>
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
                            {{ $candidate->full_name }}    </span><br>
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
                            {{ $candidate?$candidate->sex->name:'' }}</span><br>
                        <span>
                            <strong>Marital status:</strong>
                            {{ $candidate->marital?$candidate->marital->marital_status:'' }}</span><br>
                        <span>
                            <strong>Phone Number:</strong>
                            {{ $candidate->phone }}</span><br>
                        <span>
                            <strong>Email Address:</strong>
                            {{ $user->email }}   </span>
                    </div>

                    <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                        PERSONAL PROFILE
                    </h2>

                    <p class="px-2">{!! $candidate->career_objective !!}</p>
                    @if(count($candidate->experiences))
                    <section class="mt-2">
                        <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                            WORK EXPERIENCE
                        </h2>
                        <div class="px-2">
                            @foreach($candidate->experiences as $experience)
                            <p>
                                <span style="font-weight: bold" class="font-light">{{ $experience->start_date_formatted }} - </span>
                                <span class="{{$experience->currently_working?'font-bold text-green-400':'font-bold'}}">{{ $experience->currently_working?'Present': $experience->end_date_formatted }}</span>
                                <span class="w3-text-green ml-1" style="font-weight: bold">{{ $experience->company }}</span>
                                : <em>{{ $experience->title }}</em><strong></strong>
                                <br><span>{{ $experience->description }}</span>
                            </p>
                            @endforeach
                            <p></p>
                        </div>
                    </section>
                    @endif
                    @if(count($candidate->education))
                    <section class="mt-2">
                        <h2 class="bg-green-400 text-xl text-white px-2">
                            EDUCATION AND QUALIFICATIONS
                        </h2>
                        @foreach($candidate->education as $education)
                        <p class="px-2">
                            <span class="font-bold">{{ $education->start_year }} - </span>
                            <span class="{{$education->currently_studying?'font-bold text-green-400':'font-bold'}}">{{ $education->currently_studying?'Present':$education->year }}</span>
                            <span class="w3-text-green ml-1" style="font-weight: bold">{{ $education->degree_title }}</span>
                            : <em>{{ $education->institute }}</em><strong></strong>
                        </p>
                        @endforeach
                    </section>
                    @endif
                </div>

                @if(count($candidate->skills))
                <section class="mt-2">
                    <div>
                        <h2 class="bg-green-400 text-xl text-white px-2">
                            SKILLS
                        </h2>
                    </div>
                    <div class="px-2">
                        <table class="text-gray-700">
                            <tbody>
                            @foreach($candidate->skills as $skill)
                                <tr>
                                    <td width="215">
                                        <span>§ {{ $skill->name }}</span>
                                    </td>
                                    <td width="215">
                                        <span>{{ $skills[$skill->rating] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
                @endif

                @if(count($candidate->languages))
                <section class="mt-2">
                    <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                        LANGUAGE PROFICIENCY
                    </h2>
                    <div class="px-2">
                        @foreach($candidate->languages as $language)
                        <p>
                            § {{ $language->name }}: {{ $language->rating_label }}
                        </p>
                        @endforeach
                    </div>
                </section>
                @endif

                @if(count($candidate->referees))
                <section class="mt-2" v-if="$page.props.candidate.referees.length">
                    <div>
                        <h2 class="bg-green-400 text-xl text-white px-2 ">
                            REFEREES
                        </h2>
                    </div>
                    <div class="w3-border-bottom px-2">
                            <span class="text-sm">
                                Apart from my personal information mentioned in this Curriculum Vitae
                                other information with some recommendations may be sought freely from:
                            </span>
                        <div>
                        <table>
                        @foreach($candidate->referees as $referee)
                            <tr>
                                <td><span><strong>{{ $referee->name }}</strong></p></span></td>
                            </tr>
                            <tr>
                                <td>{{ $referee->company }}</td>
                            </tr>
                            <tr>
                                <td>{{ $referee->phone }}</td>
                            </tr>
                            <tr>
                                <td>Email: {{ $referee->email }}</td>
                            </tr>
                        @endforeach
                        </table>
                        </div>
                    </div>
                </section>
                @endif
            </div>

            <!-- End Right Column -->
        </div>
    </section>
</body>
</html>
