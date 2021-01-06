<?php

namespace App\Traits;

use App\Activity;
use App\User;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    public $oldAttributes = [];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Boot the trait.
     */
    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * @param $description
     * @return string
     */
    public function activityDescription($description): string
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * @return array
     */
    protected static function recordableEvents(): array
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }

        return ['created', 'updated'];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | //
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @param $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id'     => $this->activityOwner()->id,
            'description' => $description,
            'changes'     => $this->activityChanges(),
            'project_id'  => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    /**
     * @return User
     */
    protected function activityOwner(): User
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return ($this->project ?? $this)->owner;
    }

    /**
     * Fetch the changes to the model.
     *
     * @return array
     */
    public function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'after'  => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), ['created_at', 'updated_at']),
                'before' => Arr::except($this->getChanges(), ['created_at', 'updated_at']),
            ];
        }
    }
}