@extends('layouts.app')

@section('content')
    <div>

        <h5>{{ __('My Projects') }}</h5>

        <div class="projects-wrap">
            @foreach($projects as $project)
                <div class="project">
                    <a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                    <p>{{ $project->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
