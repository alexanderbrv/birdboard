@extends('layouts.app')

@section('content')
    <div class="project-wrap">

        <h1>{{ $project->title }}</h1>

        <div>{{ $project->description }}</div>

        <h5>{{ __('Tasks') }}</h5>

        <ul>
            @forelse($tasks as $task)
                <li>{{ $task->title }}</li>
            @empty
                <li>{{ __('Not added yet') }}</li>
            @endforelse
        </ul>

        <a href="{{ route('projects.index') }}">{{ __('Go Back') }}</a>
    </div>
@endsection
