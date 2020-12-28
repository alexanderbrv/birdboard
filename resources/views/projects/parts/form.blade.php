@csrf

<div class="mt-3">
    <input
            name="title"
            type="text"
            class="w-full border p-3"
            placeholder="Let's start new project"
            required
            value="{{ $project->title }}"
    >
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

@if ($errors->any())
    <div class="field">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red">{{ $error }}</li>
        @endforeach
    </div>
@endif
