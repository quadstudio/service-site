<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class DateToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_to';

    public function label()
    {
        return trans('site::messages.date').' '.trans('site::event.date_to');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'events.date_from';
    }

    protected function operator()
    {
        return '<=';
    }


}