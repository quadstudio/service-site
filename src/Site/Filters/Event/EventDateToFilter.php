<?php

namespace QuadStudio\Service\Site\Filters\Event;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class EventDateToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_to';

    public function label()
    {
        return trans('site::event.date');
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
        return 'events.date_from';
    }

    protected function operator()
    {
        return '<=';
    }

    /**
     * @return Collection
     */
    protected function attributes()
    {
        return parent::attributes()->merge(['style' => 'width:100px;']);
    }

}