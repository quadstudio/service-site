<?php

namespace QuadStudio\Service\Site\Filters\Contragent;

use QuadStudio\Repo\Filters\PerPageFilter;

class ContragentPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.contragent', 10)];
    }
}