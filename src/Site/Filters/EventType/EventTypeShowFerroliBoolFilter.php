<?php

namespace QuadStudio\Service\Site\Filters\EventType;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class EventTypeShowFerroliBoolFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'show_ferroli';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'event_types.show_ferroli';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::messages.show_ferroli');
    }
}