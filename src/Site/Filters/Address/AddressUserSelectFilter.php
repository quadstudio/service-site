<?php

namespace QuadStudio\Service\Site\Filters\Address;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\User;

class AddressUserSelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && !is_null($this->get($this->name()))) {
            $builder = $builder
                ->where('addressable_type', $this->operator(), 'users')
                ->where(DB::raw($this->column()), $this->operator(), $this->get($this->name()))
            ;

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
        return User::query()->has('addresses')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->map(function ($item, $key) {
                return str_limit($item, config('site.name_limit', 25));
            })
            ->prepend(trans('site::messages.select_no_matter'), '')
            ->toArray();
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

        return 'addressable_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::address.user_id');
    }

}