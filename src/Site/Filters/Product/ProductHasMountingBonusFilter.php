<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\HasFilter;

class ProductHasMountingBonusFilter extends HasFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'has_mounting_bonus';
    }

    public function relation(): string
    {
        return 'mounting_bonus';
    }

    public function label()
    {
        return trans('site::product.help.has_mounting_bonus');
    }
}