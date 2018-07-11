<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class ContragentSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_contragent';

    public function label()
    {
        return trans('site::contragent.placeholder.search');
    }

    protected function columns()
    {
        return [
            env('DB_PREFIX', '') . 'contragents.name',
            env('DB_PREFIX', '') . 'contragents.inn',
            env('DB_PREFIX', '') . 'contragents.ogrn',
            env('DB_PREFIX', '') . 'contragents.rs',
        ];
    }

    protected function attributes()
    {
        $attributes = parent::attributes();
        $attributes->put('style', 'min-width: 208px;');

        return $attributes;
    }

}