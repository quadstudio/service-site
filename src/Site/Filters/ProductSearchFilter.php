<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\SearchFilter;
use QuadStudio\Repo\Filters\BootstrapInput;

class ProductSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;

    public function label()
    {
        return trans('site::product.search_placeholder');
    }

    protected function columns()
    {
        return [
            'name',
            'sku'
        ];
    }

}