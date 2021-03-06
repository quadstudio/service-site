<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class MountingDateMountingToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_mounting_to';

    /**
     * @return string
     */
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
        return trans('site::messages.date_to');
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
        return '<=';
    }


}