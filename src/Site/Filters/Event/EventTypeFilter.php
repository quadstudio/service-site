<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\EventType;

class EventTypeFilter extends Filter
{

    /**
     * @var null|EventType
     */
    private $event_type;

    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where("type_id", $this->event_type->getAttribute('id'));
    }

    /**
     * @param EventType $event_type
     * @return $this
     */
    public function setEventType(EventType $event_type)
    {
        $this->event_type = $event_type;

        return $this;
    }
}
