@extends('layouts.app')

@section('content')
    <div class="project-wrap">

        <h1>{{ $project->title }}</h1>

        <div>{{ $project->description }}</div>

        <h5>{{ __('Tasks') }}</h5>

        <ul>
            @foreach($tasks as $task)
                <li>{{ $task->title }}</li>
            @endforeach
        </ul>
    </div>
@endsection
