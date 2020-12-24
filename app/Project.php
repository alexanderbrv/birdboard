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
    public function href(): string
    {
        return route('projects.show', $this->getIndetificator());
    }

    /**
     * @return int
     */
    private function getIndetificator(): int
    {
        return (int) $this->id;
    }
}
