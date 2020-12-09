@extends('layouts.app')

@section('content')
    <div>

        <h5>{{ __('My Projects') }}</h5>

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
