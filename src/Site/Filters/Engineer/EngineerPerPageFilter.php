<?php

namespace QuadStudio\Service\Site\Filters\Engineer;

use QuadStudio\Repo\Filters\PerPageFilter;

class EngineerPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.engineer', 10)];
    }
}