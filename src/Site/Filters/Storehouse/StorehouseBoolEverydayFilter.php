<?php

namespace QuadStudio\Service\Site\Filters\Storehouse;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class StorehouseBoolEverydayFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'everyday';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'storehouses.everyday';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::storehouse.everyday');
    }
}