<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class ProductBoolWarrantyFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'warranty';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'warranty';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::product.warranty');
    }
}