<?php

namespace QuadStudio\Service\Site\Filters\StorehouseLog;

use QuadStudio\Repo\Filters\PerPageFilter;

class StorehouseLogPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.storehouse_log', 10)];
    }
}