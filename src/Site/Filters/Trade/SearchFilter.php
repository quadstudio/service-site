<?php

namespace QuadStudio\Service\Site\Filters\Trade;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class SearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_trade';

    public function label()
    {
        return trans('site::trade.placeholder.search');
    }

    protected function columns()
    {
        return [
            'trades.name',
            'trades.address',
            'trades.phone',
        ];
    }

    protected function attributes()
    {
        $attributes = parent::attributes();
        $attributes->put('style', 'min-width: 208px;');

        return $attributes;
    }
}