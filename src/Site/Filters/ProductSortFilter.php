<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\SortFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class ProductSortFilter extends SortFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    function name(): string
    {
        return 'sort';
    }

    /**
     * Options
     *
     * @return array
     */
    function options(): array
    {
        return [
            ''                                             => '- По умолчанию -',
            'name' . config('site.delimiter') . 'asc'      => 'По наименованию ▲',
            'name' . config('site.delimiter') . 'desc'     => 'По наименованию ▼',
            //'price' . config('site.delimiter') . 'asc'     => 'По цене ▲',
            //'price' . config('site.delimiter') . 'desc'    => 'По цене ▼',
            'quantity' . config('site.delimiter') . 'asc'  => 'По остаткам ▲',
            'quantity' . config('site.delimiter') . 'desc' => 'По остаткам ▼',
        ];
    }

    public function defaults(): array
    {
        return [
            'name'  => 'asc',
            //'price' => 'desc',
        ];
    }

    /**
     * @return array
     */
    protected function columns(): array
    {
        return [
            'name'     => $this->table . '.name',
            'price'    => $this->table . '.price',
            'quantity' => $this->table . '.quantity',
        ];
    }

    protected function label()
    {
        return trans('site::product.sort');
    }
}