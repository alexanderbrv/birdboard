<div class="card mt-3">
    <ul class="text-sm list-reset">
        @foreach($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-2 pb-2 border-b' }}">
                @if (View::exists("projects.activity.{$activity->description}"))
                    @include ("projects.activity.{$activity->description}")
                @else
                    {{ $activity->description }}
                @endif

                <span class="text-grey">{{ $activity->created_at->diffForHumans(null, Carbon\CarbonInterface::DIFF_ABSOLUTE) }}</span>
            </li>
        @endforeach
    </ul>
</div>
