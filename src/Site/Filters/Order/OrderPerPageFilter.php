<?php

namespace QuadStudio\Service\Site\Filters\Order;

use QuadStudio\Repo\Filters\PerPageFilter;

class OrderPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.order', 10)];
    }
}