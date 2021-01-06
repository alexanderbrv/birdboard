<div class="card" style="height: 200px;">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">
        <a href="{{ $project->path() }}" class="no-underline text-black">{{ $project->title }}</a>
    </h3>

    <div class="text-grey">
        {{ Str::limit($project->description, 100) }}
    </div>

    <div class="mt-3 text-right">
        <form action="{{ $project->path() }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="text-sm">{{ __('Delete') }}</button>
        </form>
    </div>
</div>
