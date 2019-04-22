<?php

namespace QuadStudio\Service\Site\Filters\Mounter;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\User;

class MounterUserFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && !is_null($this->get($this->name()))) {
            $builder = $builder->whereHas('userAddress', function($address){
                $address
                    ->where('addressable_type', $this->operator(), 'users')
                    ->where('addressable_id', $this->operator(), $this->get($this->name()))
                ;
            });
        }
        //dump($builder->toSql());
        //dd($builder->getBindings());

        return $builder;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return User::query()->whereHas('addresses', function ($address) {
            $address->has('mounters');
        })
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
        return 'user_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'user_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::mounter.header.user_id');
    }

}