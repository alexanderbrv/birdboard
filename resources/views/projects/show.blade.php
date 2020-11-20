@extends('layouts.app')

@section('content')
    <div class="project-wrap">

        <h3>{{ $project->title }}</h3>

        <h5>{{ __('Tasks') }}</h5>

        <ul>
            @foreach($tasks as $task)
                <li>{{ $task->title }}</li>
            @endforeach
        </ul>
    </div>
@endsection
