@extends('layouts.app')

@section('content')
    <div class="card">

        <h1 class="title text-center">{{ __('Update a Project') }}</h1>

        <form method="POST" action="{{ route('projects.update', $project->id) }}">
            @method('PATCH')

            @include('projects.parts.form', [
                'buttonText' => 'Edit Project',
                'linkAfterCancel' => $project->path(),
            ])
        </form>
    </div>
@endsection