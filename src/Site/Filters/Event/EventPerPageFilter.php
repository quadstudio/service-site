<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Filters\PerPageFilter;

class EventPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.event', 10)];
    }
}