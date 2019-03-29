<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use QuadStudio\Repo\Filters\PerPageFilter;

class MountingPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.mounting', 10)];
    }
}