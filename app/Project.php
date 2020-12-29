<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'notes',
    ];

    protected $casts = [
        'owner_id' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * @param $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create(compact('description'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @param null $body
     * @return Model
     */
    public function addTask($body = null)
    {
        if ($body) {
            return $this->tasks()->create(compact('body'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Shortcuts of sources
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return string
     */
    public function path(): string
    {
        return "/projects/{$this->getIdentificator()}";
    }

    /**
     * @return string
     */
    public function pathToAddTask(): string
    {
        return $this->path() . '/tasks';
    }

    /**
     * @return int
     */
    private function getIdentificator(): int
    {
        return (int) $this->id;
    }
}
