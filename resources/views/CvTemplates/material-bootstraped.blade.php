<!DOCTYPE html>

<title>{{ $candidate->full_name }} Resume</title>
<!--<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.ajiriwa.net/css/w3.css">-->
<link href='https://fonts.googleapis.com/css?family=IBM%20Plex%20Sans' rel='stylesheet'>
<style>
    .body {
        font-family: 'IBM Plex Sans'
    }
</style>
<div class="container ">
    <div>
        <h1 align="center">
            <u>CURRICULUM VITAE</u>
        </h1>
        <p>
            <strong></strong>
        </p>
        <h5 class="bg-primary text-white">
            PERSONAL PARTICULARS
        </h5>
        <span>
            <span style="font-weight: bold">Name</span>
            <strong>:</strong>
            {{ $candidate->full_name }} </span><br>
        <span>
            <strong>Date </strong>
            <strong>of </strong>
            <strong>Birth:</strong>
            @php
            $dob = Carbon\Carbon::parse($candidate->dob);
            @endphp
            {{$dob->format('d')}}<sup>{{$dob->format('S')}}</sup> {{$dob->format('F')}} {{$dob->format('Y')}}
        </span><br>
        <span>
            <strong>Nationality:</strong>
            {{ $candidate->nationality }} </span><br>
        <!-- <span>
            <strong>Sex:</strong>
            Male </span><br>
        <span>
            <strong>Marital status:</strong>
            Single </span><br> -->
        <span>
            <strong>Phone Number:</strong>
            {{$candidate->phone}} </span><br>
        @if($candidate->user)
        <span>
            <strong>Email Address:</strong>
            {{$candidate->user->email}} </span><br>
            @endif
        <p>
        </p>
        <h5 class="bg-primary text-white">
            PERSONAL PROFILE
        </h5>
        <p>
        <p>{!! htmlspecialchars_decode($candidate->career_objective) !!}</p>
        </p>
        <!--<p class="w3-green">
        <strong>CAREER OBJECTIVES</strong>
    </p>
    <p>
        <strong> </strong>
    </p>
    <p>
        To earn a job that utilizes my skills and experience, to succeed in an
        environment of growth and excellence, to work hard with full
        determination and dedication and to achieve personal as well as
        organizational goals.
    </p>
    <p>-->

        </p>
        @if($candidate->experiences && $candidate->experiences->count())
        <h5 class="bg-primary text-white">
            WORK EXPERIENCE
        </h5>
        @foreach($candidate->experiences as $experience)
        @php
        $start_date = Carbon\Carbon::parse($experience->start_date);
        $end_date = $experience->currently_working ? 'Present' : Carbon\Carbon::parse($experience->end_date)->format('F, Y');
        @endphp
        <p>
            <span style="font-weight: bold">{{$start_date->format('F, Y')}} - {{$end_date}} </span><span class="w3-text-green" style="font-weight: bold">{{ $experience->company }}</span> : <em>{{ $experience->title }}</em><strong></strong>
            <br><span>{!! $experience->description !!}</span>
        </p>
        @endforeach
        @endif
        @if($candidate->education->count())
        <h5 class="bg-primary text-white">
            EDUCATION AND QUALIFICATIONS
        </h5>
        @foreach($candidate->education as $education)
        <p>
            <strong>{{$education->start_year}} - {{$education->currently_studying ? 'Present' : $education->year }} </strong><span class="w3-text-green" style="font-weight: bold">Bachelor of Business Administration</span> : <em>Okan University</em><strong></strong>
        </p>
        @endforeach
        @endif

    </div>

    <!-- <br clear="all" />
    <div>
        <h5 class="bg-primary text-white">
            ACHIEVEMENTS
        </h5>
        <p><b>Development of ajiriwa.net recruitment platform&nbsp;</b> - with inspiration from working at the HR Department at DHL Supply Chain. The platform connects employers and job seekers, assisting employers to get the candidate they need and allowing job seekers to be found, the platform would even assist people in making a professional CV. This CV was created using the platform.
        </p>
        <p><b>
                Development of payroll management software</b>&nbsp;that handles a company's payroll, recruitment, performance management, attendance, and employee management needs. This software is currently used by various companies in industries such as banking, tourism, insurance as well as NGO.</p>
        <p><b>Development of an Inventory Management and POS </b>A business management software that helps to keep track of inventory movements of a business as well as its finances</p>
    </div> -->


    @if($candidate->skills->count())
    <!-- <br clear="all" /> -->
    <div>
        <h5 class="bg-primary text-white">
            SKILLS
        </h5>
    </div>
    <div>
        <table border="0" cellspacing="0" cellpadding="0" align="left">
            <tbody>
                @foreach($candidate->skills as $skill)
                <tr>
                    <td width="315" valign="top">
                        <span>
                            § {{$skill->name}} </span>
                    </td>
                    <td width="215" valign="top">
                        <span>
                            {{App\Models\CandidateSkill::Levels[$skill->rating]??'Begginer'}} </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!--<div>
		<p class="w3-green">
			<strong>COMPUTER AND INFORMATION TECHNOLOGY SKILLS</strong>
		</p>
	</div>-->
    @if($candidate->languages->count())
    <br clear="all" />
    <div>

        <br clear="all" />
        <p>
        </p>
        <h5 class="bg-primary text-white">
            LANGUAGE PROFICIENCY
        </h5>
        @foreach($candidate->languages as $language)
        <p>
            § {{$language->name}}: Advanced<!--<br>Speaking - <em>Advanced</em>, Listening - <em>Advanced</em>, Writing - <em>Advanced</em>, Reading - <em>Advanced</em>-->
        </p>
        @endforeach

        <!-- <h5 class="bg-primary text-white">
            PERSONAL INTERESTS, HOBBIES AND TALENTS
        </h5>
        <div>
            <p><b>Programming </b>- I enjoy coding and spend most of my free time doing so, to solve problems</p>
            <p><br></p>
        </div> -->
    </div>
    @endif
    <div class="container">

    </div>
    @if($candidate->referees->count())
    <div>
        <h5 class="bg-primary text-white">
            REFEREES
        </h5>
    </div>
    <div class="border-bottom">
        <p>
            Apart from my personal information mentioned in this Curriculum Vitae
            other information with some recommendations may be sought freely from:
        </p>
        @foreach($candidate->referees as $referee)
        <p>
            <strong>{{$referee->name}}</strong>
        </p>
        <p>
        {{$referee->company}}</p>
        <p>
        {{$referee->phone}}</p>
        <p>

        </p>
        <p>
            Email: {{$referee->email}}</p>

        <p>
            @endforeach
        </p>
    </div>
    @endif
    <p>Powered By <a href="https://www.ajiriwa.net">ajiriwa.net</a> via <a href="https://www.pay-r.net">Pay-R Hr Software</a></p>
</div>