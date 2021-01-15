<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | //
    |--------------------------------------------------------------------------
    |
    */

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

    /**
     * @param User $user
     */
    public function invite(User $user)
    {
        return $this->members()->attach($user);
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
