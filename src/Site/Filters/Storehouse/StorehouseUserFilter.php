<?php

namespace QuadStudio\Service\Site\Filters\Storehouse;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\User;

class StorehouseUserFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($id = $this->get($this->name()))) {
            $builder = $builder->where(DB::raw($this->column()), $this->operator(), $id);
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'user';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'storehouses.user_id';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return User::query()->has('storehouses')->orderBy('name')
            ->pluck('name', 'id')
            ->map(function ($item, $key) {
                return str_limit($item, config('site.name_limit', 25));
            })
            ->prepend(trans('site::messages.select_no_matter'), '')
            ->toArray();
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::storehouse.user_id');
    }
}