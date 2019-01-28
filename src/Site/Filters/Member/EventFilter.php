<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\Event;

class EventFilter extends Filter
{
    /**
     * @var Event
     */
    private $event;

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->event)) {
            $builder = $builder->whereEventId($this->event->id);
        }


        return $builder;
    }


    /**
     * @param Event $event
     * @return $this
     */
    public function setEvent(Event $event = null)
    {
        $this->event = $event;

        return $this;
    }
}