<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Filters\PerPageFilter;

class RepairPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.repair', 10)];
    }
}