<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Traits\Models\SortOrderTrait;


class EventType extends Model
{

    use SortOrderTrait;
    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['name', 'annotation', 'active', 'sort_order'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'event_types';
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


    /**
     * Мероприятия
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'type_id');
    }

}
