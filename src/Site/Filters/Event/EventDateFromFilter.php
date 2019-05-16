<?php

namespace QuadStudio\Service\Site\Filters\Event;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class EventDateFromFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_from';

    public function label()
    {
        return trans('site::event.date');
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
        return 'events.date_to';
    }

    protected function operator()
    {
        return '>=';
    }

    /**
     * @return Collection
     */
    protected function attributes()
    {
        return parent::attributes()->merge(['style' => 'width:100px;']);
    }

}