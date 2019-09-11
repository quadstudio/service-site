<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleAction extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'schedule_actions';

    protected $fillable = [
        'name'
    ];


}
