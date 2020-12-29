<div class="card">

    <h1 class="title text-center">{{ $title }}</h1>

    <form method="POST" action="{{ $action }}">
        @csrf

        @if (isset($method))
            @method($method)
        @endif

        <div class="mt-3">
            <input
                name="title"
                type="text"
                class="w-full border p-3"
                placeholder="Let's start new project"
                required
                value="{{ $project->title }}">
        </div>

        <div class="mt-2">
            <textarea
                name="description"
                class="w-full border p-3"
                placeholder="{{ __('Description') }}"
            >{{ $project->description }}</textarea>
        </div>

        <div class="mt-3">
            <button type="submit" class="button">{{ $buttonText }}</button>

            <a href="{{ $linkAfterCancel }}">Cancel</a>
        </div>

        @include('projects.parts.validation-errors')
    </form>
</div>
