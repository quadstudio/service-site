<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class EventStatus extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'event_statuses';

    /**
     * Мероприятия
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'status_id');
    }

}
