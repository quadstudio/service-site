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
        $this->table = env('DB_PREFIX', '') . 'schedules';
    }

    /**
     * Get all of the owning contactable models.
     */
    public function schedulable()
    {
        return $this->morphTo();
    }

}
