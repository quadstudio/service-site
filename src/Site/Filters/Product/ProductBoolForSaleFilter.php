<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class ProductBoolForSaleFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'forsale';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'forsale';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::product.forsale');
    }
}