<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class DateToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_to';

    public function label()
    {
        return trans('site::messages.date') . ' ' . trans('site::member.date_to');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'members.date_from';
    }

    protected function operator()
    {
        return '<=';
    }


}