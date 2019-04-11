<?php

namespace QuadStudio\Service\Site\Filters\Trade;

use QuadStudio\Repo\Filters\PerPageFilter;

class TradePerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.trade', 10)];
    }
}