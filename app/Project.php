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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function path()
    {
        return "/projects/{$this->getIndetificator()}";
    }

    public function href()
    {
        return route('projects.show', $this->getIndetificator());
    }

    private function getIndetificator()
    {
        return $this->id;
    }
}
