<?php

namespace QuadStudio\Service\Site\Filters\Address;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Country;

class CountrySelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($country_id = $this->get($this->name()))) {
            $builder = $builder->where(DB::raw($this->column()), $this->operator(), $country_id);
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'country_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'country_id';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return Country::has('addresses')
            ->pluck('name', 'id')
            ->prepend(trans('site::messages.select_from_list'), '')
            ->toArray();
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::address.country_id');
    }
}