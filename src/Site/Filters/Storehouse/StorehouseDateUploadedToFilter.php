<?php

namespace QuadStudio\Service\Site\Filters\Storehouse;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class StorehouseDateUploadedToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_uploaded_to';

    /**
     * @return string
     */
    public function label()
    {
        return trans('site::storehouse.uploaded_at');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'storehouses.uploaded_at';
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