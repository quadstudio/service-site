<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class ActiveFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'active';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'active';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::user.active');
    }
}