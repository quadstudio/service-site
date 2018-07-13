<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Catalog;

class EquipmentCatalogSelectFilter extends WhereFilter
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
        return ['' => trans('site::messages.select_from_list')] + Catalog::orderBy('name')->has('equipments')->pluck('name', 'id')->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'catalog_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'catalog_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::equipment.catalog_id');
    }

}