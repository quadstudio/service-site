<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'schedules';

	/**
	 * @var array
	 */
    protected $fillable = [
        'status', 'action_id', 'url'
    ];

    /**
     * Get all of the owning contactable models.
     */
    public function schedulable()
    {
        return $this->morphTo();
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
