@extends('layouts.app')

@section('content')
    <div>

        <div class="flex items-center mb-3">
            <h5 class="mr-auto">{{ __('My Projects') }}</h5>
            <a href="{{ route('projects.create') }}">{{ __('New Project') }}</a>
        </div>

        <div class="projects-wrap">
            @forelse($projects as $project)
                <div class="project">
                    <a href="{{ $project->href() }}">{{ $project->title }}</a>
                    <div>{{ $project->description }}</div>
                </div>
            @empty
                <div>Not projects yet.</div>
            @endforelse
        </div>

    </div>
@endsection
