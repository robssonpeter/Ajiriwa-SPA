@extends('layouts.app')
@section('content')
    @livewire('job-search', ['industries'=>$industries, 'job_types' => $job_types], key(4))
@endsection
