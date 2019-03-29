<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class MountingDateFromFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_mounting_from';

    public function label()
    {
        return trans('site::mounting.date_mounting');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'mountings.date_mounting';
    }

    /**
     * @return string
     */
    protected function placeholder()
    {
        return trans('site::messages.date_from');
    }

    /**
     * @return Collection
     */
    protected function attributes()
    {
        return parent::attributes()->merge(['style' => 'width:100px;']);
    }

    /**
     * @return string
     */
    protected function operator()
    {
        return '>=';
    }


}