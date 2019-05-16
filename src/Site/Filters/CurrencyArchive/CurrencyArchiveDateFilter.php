<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class CurrencyArchiveDateFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date';

    public function label()
    {
        return trans('site::archive.date');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'currency_archives.date';
    }

    /**
     * @return string
     */
    protected function placeholder()
    {
        return trans('site::archive.placeholder.date');
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
        return '=';
    }


}