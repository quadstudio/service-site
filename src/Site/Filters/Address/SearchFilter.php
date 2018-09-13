<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class SearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_address';

    protected function columns()
    {
        return [
            'addresses.name',
            'addresses.full',
        ];
    }

    public function label()
    {
        return trans('site::address.placeholder.search');
    }

    public function tooltip()
    {
        return trans('site::address.help.search');
    }

}