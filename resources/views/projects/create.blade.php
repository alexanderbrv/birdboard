@extends('layouts.app')

@section('content')
    <div class="card">

        <h1 class="title text-center">{{ __('Create a Project') }}</h1>

        <form method="POST" action="{{ route('projects.store') }}">
            @include('projects.parts.form', [
                'project' => new \App\Project(),
                'buttonText' => 'Create Project',
                'linkAfterCancel' => route('projects.index'),
            ])
        </form>
    </div>
@endsection
