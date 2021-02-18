@extends('layouts.app')

@section('content')
    <header class="flex justify-between items-end mb-3 py-4">
        <h2 class="title">{{ __('My Projects') }}</h2>
        <button @click.prevent="$modal.show('new-project')" class="button">{{ __('New Project') }}</button>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.parts.card')
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </main>

    <new-project></new-project>
@endsection