<?php

namespace QuadStudio\Service\Site\Filters\EventType;

use QuadStudio\Repo\Filters\PerPageFilter;

class EventTypePerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.event_type', 10)];
    }
}