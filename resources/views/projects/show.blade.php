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
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input type="text" name="body" value="{{ $task->body }}" class="w-full {{ $task->finished ? 'text-grey' : ''}}">
                                    <input type="checkbox" name="finished" onchange="this.form.submit()" {{ $task->finished ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card">
                        <form action="{{ $project->pathToAddTask() }}" method="POST">
                            @csrf
                            <input name="body" placeholder="Add a new task" class="w-full">
                        </form>
                    </div>
                </div>

                <div class="mb-6">
                    <h6 class="title mb-3">{{ __('General Notes') }}</h6>

                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')

                        <textarea
                            name="notes"
                            class="card w-full min-h-200 mb-3"
                            placeholder="Anything special that you want to make a note off?"
                        >{{ $project->notes }}</textarea>

                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.parts.card')
            </div>
        </div>
    </main>
@endsection
