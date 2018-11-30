<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Equipment;

class EquipmentFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($equipment_id = $this->get($this->name()))) {
            $builder = $builder->whereHas('product', function ($query) use ($equipment_id) {
                $query->where(DB::raw($this->column()), $this->operator(), $equipment_id);

            });
        }
        //dump($builder->toSql());
        //dd($builder->getBindings());
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
     * @return string
     */
    public function column(): string
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
        return Equipment::whereHas('products', function ($query) {
            $query->has('repairs');
        })->orderBy('name')
            ->pluck('name', 'id')
            ->prepend(trans('site::messages.select_no_matter'), '')
            ->toArray();
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