@extends('layouts.app')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <h6 class="title">{{ __('Create a Project') }}</h6>

            <div class="mt-3">
                <input name="title" type="text" class="w-full border p-3" placeholder="My next awesome project">
            </div>

            <div class="mt-2">
                <textarea name="description" class="w-full border p-3" placeholder="{{ __('Description') }}"></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="button">Create Project</button>

                <a href="{{ route('projects.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
