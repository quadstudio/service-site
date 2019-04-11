<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\HasFilter;

class ProductHasImagesFilter extends HasFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'has_images';
    }

    /**
     * @return string
     */
    public function relation(): string
    {
        return 'images';
    }

    /**
     * @return string
     */
    public function label()
    {
        return trans('site::product.help.has_images');
    }
}