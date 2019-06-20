<?php

namespace QuadStudio\Service\Site\Filters\Contract;

use QuadStudio\Repo\Filters\PerPageFilter;

class ContractPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.contract', 10)];
    }
}