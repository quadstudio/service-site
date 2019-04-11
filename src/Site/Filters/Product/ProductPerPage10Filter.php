<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\PerPageFilter;

class ProductPerPage10Filter extends PerPageFilter
{

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return config('site.per_page_range.r10', [10 => 10]);
    }

    public function defaults(): array
    {
        return [config('site.per_page.product_admin', 10)];
    }
}