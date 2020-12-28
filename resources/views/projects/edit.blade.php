@extends('layouts.app')

@section('content')

    @include('projects.parts.form', [
        'action' => route('projects.update', $project->id),
        'title' => __('Update a Project'),
        'method' => 'PATCH',
        'buttonText' => __('Edit Project'),
        'linkAfterCancel' => $project->path(),
    ])

@endsection