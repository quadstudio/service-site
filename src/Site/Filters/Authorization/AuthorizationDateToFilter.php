<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class AuthorizationDateToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_to';

    /**
     * @return string
     */
    public function label()
    {
        return trans('site::authorization.created_at');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'authorizations.created_at';
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