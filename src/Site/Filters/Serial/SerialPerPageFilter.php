<?php

namespace QuadStudio\Service\Site\Filters\Serial;

use QuadStudio\Repo\Filters\PerPageFilter;

class SerialPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.serial', 10)];
    }
}