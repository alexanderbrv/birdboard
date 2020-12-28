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
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @param $value
     * @return int
     */
    public function getOwnerIdAttribute($value): int
    {
        return (int) $value;
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
        return "/projects/{$this->getIndetificator()}";
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
    private function getIndetificator(): int
    {
        return (int) $this->id;
    }
}
