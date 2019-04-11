<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\PerPageFilter;

class ProductPerPage16Filter extends PerPageFilter
{

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return config('site.per_page_range.r16', [16 => 16]);
    }

    public function defaults(): array
    {
        return [config('site.per_page.product', 16)];
    }
}