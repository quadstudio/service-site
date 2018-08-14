<?php

namespace QuadStudio\Service\Site\Filters\Serial;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class SearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_serial';

    public function label()
    {
        return trans('site::serial.placeholder.search');
    }

    protected function columns()
    {
        return [
            env('DB_PREFIX', '') . 'serials.id',
            env('DB_PREFIX', '') . 'serials.product_id',
        ];
    }

    protected function attributes()
    {
        $attributes = parent::attributes();
        $attributes->put('style', 'min-width: 208px;');

        return $attributes;
    }
}