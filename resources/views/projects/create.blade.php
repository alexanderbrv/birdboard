@extends('layouts.app')

@section('content')

    @include('projects.parts.form', [
        'action' => route('projects.store'),
        'title' => __('Create a Project'),
        'project' => new \App\Project(),
        'buttonText' => 'Create Project',
        'linkAfterCancel' => route('projects.index'),
    ])

@endsection
