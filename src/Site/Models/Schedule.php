<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'status', 'action_id', 'url'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'schedules';
    }

    /**
     * Get all of the owning contactable models.
     */
    public function schedulable()
    {
        return $this->morphTo();
    }

    /**
     * Статус
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(ScheduleStatus::class, 'status');
    }

    /**
     * Действие
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action()
    {
        return $this->belongsTo(ScheduleAction::class);
    }

}
