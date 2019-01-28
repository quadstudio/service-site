<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class DateFromFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_from';

    public function label()
    {
        return trans('site::messages.date').' '.trans('site::event.date_from');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'events.date_to';
    }

    protected function operator()
    {
        return '>=';
    }


}