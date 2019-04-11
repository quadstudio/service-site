<?php

namespace QuadStudio\Service\Site\Filters\Launch;

use QuadStudio\Repo\Filters\PerPageFilter;

class LaunchPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.launch', 10)];
    }
}