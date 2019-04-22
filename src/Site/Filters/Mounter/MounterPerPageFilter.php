<?php

namespace QuadStudio\Service\Site\Filters\Mounter;

use QuadStudio\Repo\Filters\PerPageFilter;

class MounterPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.mounter', 10)];
    }
}