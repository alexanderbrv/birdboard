<b>{{ auth()->id() === $activity->user_id  ? 'You' : $activity->user->name }}</b>
