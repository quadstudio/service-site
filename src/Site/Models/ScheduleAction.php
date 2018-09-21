<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleAction extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'schedule_actions';
    }

}
