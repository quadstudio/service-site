<?php

namespace QuadStudio\Service\Site\Filters\Act;

use QuadStudio\Repo\Filters\PerPageFilter;

class ActPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.act', 10)];
    }
}