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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            $task->project->recordActivity('created_task');
        });
    }


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

        $this->project->recordActivity('completed_task');
    }
}
