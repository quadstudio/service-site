<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapCheckbox;
use QuadStudio\Repo\Filters\CheckboxFilter;

class ProductInStockFilter extends CheckboxFilter
{
    use BootstrapCheckbox;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if($this->has($this->name())){
            $builder = $builder->where('quantity', '>', 0);
        }

        return $builder;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return [
            ''  => trans('site::product.in_stock_defaults'),
            '1' => trans('site::product.yes'),
        ];
    }

    protected function label()
    {
        return trans('site::product.quantity');
    }

    /**
     * @return string
     */
    function name(): string
    {
        return 'in_stock';
    }

    /**
     * Options
     *
     * @return string
     */
    function value(): string
    {
        return '';
    }
}