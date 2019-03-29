<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class RepairDateToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_repair_to';

    public function label()
    {
        return trans('site::repair.date_repair');
    }

    protected function placeholder()
    {
        return trans('site::messages.date_to');
    }
    protected function attributes()
    {
        return parent::attributes()->merge(['style' => 'width:100px;']);
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