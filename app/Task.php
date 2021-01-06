<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;

    static protected $recordableEvents = [
        'created',
        'deleted',
    ];

    protected $fillable = [
        'body',
        'finished',
        'due',
    ];

    protected $touches = [
        'project',
    ];

    protected $casts = [
        'finished' => 'boolean',
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

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['finished' => false]);

        $this->recordActivity('incompleted_task');
    }
}
