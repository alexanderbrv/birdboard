<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'body',
        'finished',
        'due',
    ];

    protected $touches = ['project'];

    protected $casts = ['finished' => 'boolean'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * @param $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'project_id'  => $this->project_id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Shortcuts of sources
    |--------------------------------------------------------------------------
    |
    */

    public function path()
    {
        return "/projects/{$this->project_id}/tasks/{$this->id}";
    }

    /*
    |--------------------------------------------------------------------------
    | ...
    |--------------------------------------------------------------------------
    |
    */

    public function complete()
    {
        $this->update(['finished' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['finished' => false]);

        $this->recordActivity('incompleted_task');
    }
}
