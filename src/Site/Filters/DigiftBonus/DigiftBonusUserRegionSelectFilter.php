<?php

namespace QuadStudio\Service\Site\Filters\DigiftBonus;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\SelectFilter;
use QuadStudio\Service\Site\Models\Region;

class DigiftBonusUserRegionSelectFilter extends SelectFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && !is_null($this->get($this->name()))) {
            $builder = $builder->where('users.region_id', '=', $this->get($this->name()));
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
        return Region::query()->where('country_id', config('site.country'))->orderBy('name')
            ->pluck('name', 'id')
            ->prepend(trans('site::messages.select_no_matter'), '')
            ->toArray();
        /**
         * ->map(function ($item, $key) {
         * return str_limit($item, 50);
         * })
         */
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'region';
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