<?php

namespace QuadStudio\Service\Site\Filters\Bank;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class SearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_bank';

    public function label()
    {
        return trans('site::bank.placeholder.search');
    }

    protected function columns()
    {
        return [
            env('DB_PREFIX', '') . 'banks.id',
            env('DB_PREFIX', '') . 'banks.name',
            env('DB_PREFIX', '') . 'banks.city',
        ];
    }

    protected function attributes()
    {
        $attributes = parent::attributes();
        $attributes->put('style', 'min-width: 208px;');

        return $attributes;
    }
}