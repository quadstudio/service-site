<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class RepairCalledClientSelectFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'called_client';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'called_client';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::repair.called_1');
    }
}