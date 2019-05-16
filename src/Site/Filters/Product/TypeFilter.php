<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\ProductType;

class TypeFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options():array
    {
        $options = ProductType::query()->whereHas('products', function ($query) {
            $query->where('products.enabled', 1)
                ->where(config('site.check_field'), 1)
                ->whereNull('equipment_id')
            ;
        })->orderBy('name')->pluck('name', 'id');
        $options->prepend(trans('site::product.type_defaults'), '');
        return $options->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'type_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'products.type_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::product.type_id');
    }

}