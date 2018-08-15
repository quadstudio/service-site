<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Equipment;

class EquipmentFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * @param $builder
     * @param RepositoryInterface $repository
     * @return mixed
     */
    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && $this->filled($this->name())) {

            $equipment_id = $this->get($this->name());
            $builder = $builder->whereHas('back_relations', function ($query) use ($equipment_id) {
                $query->whereEquipmentId($equipment_id);
            });
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'equipment_id';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        $options = Equipment::whereHas('products', function ($query) {
            $query->where(env('DB_PREFIX', '') . 'products.enabled', 1);
            $query->whereHas('relations', function ($query) {
                $query->where('enabled', 1)->where('active', 1)->whereNull('equipment_id');
            });
        })->pluck('name', 'id');
        $options->prepend(trans('site::messages.select_from_list'), '');

        return $options->toArray();
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return env('DB_PREFIX', '') . 'products.equipment_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::product.equipment_id');
    }

}