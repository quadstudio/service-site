<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\HasFilter;

class RepairIsFoundSerialFilter extends HasFilter
{

    use BootstrapSelect;

    protected $render = true;


    /**
     * @return string
     */
    public function name(): string
    {
        return 'is_found';
    }

    public function relation(): string
    {
        return 'serial';
    }

    public function label()
    {
        return trans('site::repair.help.is_found');
    }
}