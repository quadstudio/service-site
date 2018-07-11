<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\SearchFilter;
use QuadStudio\Repo\Filters\BootstrapInput;

class CatalogSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_catalog';

    public function label()
    {
        return trans('site::catalog.placeholder.search');
    }

    protected function columns()
    {
        return [
            'name',
            'name_plural',
            'description',
        ];
    }

    protected function attributes()
    {
        $attributes = parent::attributes();
        $attributes->put('style', 'min-width: 208px;');
        return $attributes;
    }

}