<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Region;

class RegionFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($status_id = $this->get($this->name()))) {
            $builder = $builder->whereHas('user', function ($query) use ($status_id) {
                $query->whereHas('addresses', function ($query) use ($status_id) {
                    $query->where(DB::raw($this->column()), $this->operator(), $status_id);
                });
            });
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'region_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'region_id';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return Region::whereHas('addresses', function ($query) {
            $query->whereTypeId(2);
        })
            ->pluck('name', 'id')
            ->prepend(trans('site::address.help.region_defaults'), '')
            ->toArray();
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::address.region_id');
    }
}