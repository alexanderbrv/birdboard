@extends('layouts.app')

@section('content')
    <div>
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <h6>{{ __('Create a Project') }}</h6>

            <div class="input-group mb-3">
                <input name="title" type="text" class="form-control" placeholder="Title">
            </div>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Description</span>
                </div>
                <textarea name="description" class="form-control" aria-label="With textarea"></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-outline-secondary">Create Project</button>
                <a href="{{ route('projects.index') }}">Cancel</a>
            </div>

        </form>
    </div>
@endsection
