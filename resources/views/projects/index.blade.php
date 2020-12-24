@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-3">
        <h5 class="mr-auto">{{ __('My Projects') }}</h5>
        <a href="{{ route('projects.create') }}">{{ __('New Project') }}</a>
    </div>

    <div class="flex">
        @forelse ($projects as $project)
            <div class="bg-white mr-4 rounded p-5 shadow w-1/3" style="height: 200px;">
                <h3 class="font-normal text-xl py-4 mb-4">{{ $project->title }}</h3>

                <div class="text-grey">
                    {{ Str::limit($project->description, 100) }}
                </div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection