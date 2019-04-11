<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\HasFilter;

class ProductHasRelationsFilter extends HasFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'has_details';
    }

    /**
     * @return string
     */
    public function relation(): string
    {
        return 'details';
    }

    /**
     * @return string
     */
    public function label()
    {
        return trans('site::product.help.has_details');
    }
}