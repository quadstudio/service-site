<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class MemberDateFromFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_from';

    public function label()
    {
        return trans('site::member.date');
    }

    /**
     * @return string
     */
    protected function placeholder()
    {
        return trans('site::messages.date_from');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'members.date_to';
    }

    protected function operator()
    {
        return '>=';
    }


}