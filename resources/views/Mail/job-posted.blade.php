<div>
    <p>{{ $job->company->name }} has posted a new job <a href="{{ route('job.view', $job->slug) }}">{{ $job->title }}</a>.</p>
</div>