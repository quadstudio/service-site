<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Filters\BootstrapDate;
use QuadStudio\Repo\Filters\DateFilter;

class DateRepairToFilter extends DateFilter
{

    use BootstrapDate;

    protected $render = true;
    protected $search = 'date_repair_to';

    public function label()
    {
        return trans('site::repair.placeholder.date_repair_to');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'repairs.date_repair';
    }

    protected function operator()
    {
        return '<=';
    }


}