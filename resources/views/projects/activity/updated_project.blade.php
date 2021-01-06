@if (count($activity->changes['after']) == 1)
    @include('projects.activity.user_name') updated the {{ key($activity->changes['after']) }} of the project
@else
    @include('projects.activity.user_name') updated a project
@endif
