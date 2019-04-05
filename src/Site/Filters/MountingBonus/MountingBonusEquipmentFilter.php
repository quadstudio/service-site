<?php

namespace QuadStudio\Service\Site\Filters\MountingBonus;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Equipment;

class MountingBonusEquipmentFilter extends WhereFilter
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
            $builder = $builder->whereHas('product', function ($query) use ($equipment_id) {
                $query->where('equipment_id',$equipment_id);
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
            $query->has('mounting_bonus');
        })->orderBy('name')->pluck('name', 'id');
        $options->prepend(trans('site::messages.select_from_list'), '');

        return $options->toArray();
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'products.equipment_id';

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