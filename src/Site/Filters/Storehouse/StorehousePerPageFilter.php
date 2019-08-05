<?php

namespace QuadStudio\Service\Site\Filters\Storehouse;

use QuadStudio\Repo\Filters\PerPageFilter;

class StorehousePerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.storehouse', 10)];
    }
}