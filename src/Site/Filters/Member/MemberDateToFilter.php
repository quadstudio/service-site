<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class MemberDateToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_to';

    public function label()
    {
        return trans('site::member.date');
    }

    /**
     * @return string
     */
    protected function placeholder()
    {
        return trans('site::messages.date_to');
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