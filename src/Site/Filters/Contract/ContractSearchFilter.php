<?php

namespace QuadStudio\Service\Site\Filters\Contract;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class ContractSearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search';

    public function label()
    {
        return trans('site::contract.placeholder.search');
    }

    public function tooltip()
    {
        return trans('site::contract.help.search');
    }

    protected function columns()
    {
        return [
            'contracts.number',
            'contracts.territory',
            'contracts.signer',
        ];
    }

}