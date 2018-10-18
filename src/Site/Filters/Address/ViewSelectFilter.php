<?php

namespace QuadStudio\Service\Site\Filters\Address;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;

class ViewSelectFilter extends WhereFilter
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
        return 'is_shop';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'is_shop';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return [
            '' => trans('site::messages.select_from_list'),
            '0' => trans('site::address.is_shop_0'),
            '1' => trans('site::address.is_shop_1')
        ];
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::address.is_shop');
    }
}