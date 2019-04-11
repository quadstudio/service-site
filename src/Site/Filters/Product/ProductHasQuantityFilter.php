<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;

class ProductHasQuantityFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->has($this->name()) && $this->filled($this->name())) {
            if ($this->get($this->name()) == 0) {
                $builder = $builder->where($this->column(), 0);
            } else {
                $builder = $builder->where($this->column(), '>', 0);
            }

        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'has_quantity';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'quantity';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return [
            ''  => trans('site::messages.select_no_matter'),
            '1' => trans('site::messages.yes'),
            '0' => trans('site::messages.no'),
        ];
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::product.help.has_quantity');
    }
}