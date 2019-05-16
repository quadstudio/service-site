<?php

namespace QuadStudio\Service\Site\Filters\Datasheet;

use QuadStudio\Repo\Filters\PerPageFilter;

class DatasheetPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.datasheet', 10)];
    }
}