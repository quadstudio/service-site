<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class ProductBoolServiceFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'service';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'service';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::product.service');
    }
}