<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  {!! SEOMeta::generate() !!}
        {!! OpenGraph::generate() !!}
        @if(!JsonLd::isEmpty())
        {!! JsonLd::generate() !!}
        @endif
        @if(!JsonLdMulti::isEmpty())
        {!! JsonLdMulti::generate() !!}
        @endif
        {!! Twitter::generate() !!}
</head>
<body>
  <div class="bg-green-500 bg-opacity-70 min-h-screen flex justify-center items-center">
    <div class="bg-white shadow-lg rounded-lg w-6/6 md:w-96 p-8">
      <div class="text-center">
        <img class="w-24 h-24 rounded-full mx-auto mb-4" src="{{ $candidate->logo_url }}" alt="Profile Picture">
        <h2 class="text-2xl font-semibold">{{ $candidate->full_name }}</h2>
        <p class="text-gray-600">{{ $candidate->professional_title }}</p>
      </div>
      <div class="mt-4">
        <p>{!! htmlspecialchars_decode($candidate->career_objective) !!}</p>
      </div>
      @if(count($candidate->experiences))
      <div class="mt-4">
        <h3 class="text-lg font-semibold mb-2">Experience</h3>
        @foreach($candidate->experiences as $experience)
        <section class="py-4 border-b">
            <h4 class="text-md font-semibold mb-2">{{ $experience->title }}</h4>
            <h5 class="text-sm text-green-500 font-semibold mb-2">{{ $experience->company }}</h4>
            <p class="text-gray-700">{{ $experience->description }}</p>
        </section>
        @endforeach
      </div>
      @endif
      @if(count($candidate->education))
      <div class="mt-4">
        <h3 class="text-lg font-semibold mb-2">Education</h3>
        @foreach($candidate->education as $education)
        <p class="text-gray-700">{{ $education->degree_title }}, {{ $education->institute }}</p>
        @endforeach
      </div>
      @endif
      @if(count($candidate->skills))
      <div class="mt-4">
        <h3 class="text-lg font-semibold mb-2">Skills</h3>
        <ul class="list-disc list-inside text-gray-700">
          @foreach($candidate->skills as $skill)
          <li>{{ $skill->name }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <div class="mt-8">
        <p class="text-gray-600 text-center mb-4">Create account to view the full profile.</p>
        <a href="{{ route('register') }}" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-full">Create Account</a>
      </div>
    </div>
  </div>
</body>
</html>