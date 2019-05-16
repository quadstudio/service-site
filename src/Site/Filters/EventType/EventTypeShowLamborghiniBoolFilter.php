<?php

namespace QuadStudio\Service\Site\Filters\EventType;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class EventTypeShowLamborghiniBoolFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'show_lamborghini';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'event_types.show_lamborghini';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::messages.show_lamborghini');
    }
}