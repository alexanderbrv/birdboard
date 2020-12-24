@extends('layouts.app')

@section('content')
    <header class="flex justify-between items-end mb-3 py-4">
        <h2 class="title">
            <a href="{{ route('projects.index') }}" class="title no-underline">{{ __('My Projects') }}</a>
            / {{ $project->title }}
        </h2>

        <a href="{{ route('projects.create') }}" class="button">{{ __('New Project') }}</a>
    </header>

    <main>
        <h6 class="title mb-3">{{ __('Tasks') }}</h6>

        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <div class="card mb-3">Tasks</div>
                    <div class="card mb-3">Tasks</div>
                    <div class="card mb-3">Tasks</div>
                    <div class="card">Tasks</div>
                </div>

                <div class="mb-6">
                    <h6 class="title mb-3">{{ __('General Notes') }}</h6>
                    <textarea class="card w-full min-h-200" placeholder="Add notes"></textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.parts.card')
            </div>
        </div>
    </main>
@endsection
