<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapCheckbox;
use QuadStudio\Repo\Filters\CheckboxFilter;

class CatalogEnabledFilter extends CheckboxFilter
{
    use BootstrapCheckbox;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if($this->has($this->name())){
            $builder = $builder->where('enabled', 1);
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
            ''  => trans('site::catalog.in_stock_defaults'),
            '1' => trans('site::catalog.yes'),
        ];
    }

    protected function label()
    {
        return trans('site::catalog.enabled');
    }

    /**
     * @return string
     */
    function name(): string
    {
        return 'enabled';
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