<?php

namespace QuadStudio\Service\Site\Filters\Contract;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\User;

class ContractUserSelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && !is_null($this->get($this->name()))) {
            $builder = $builder
                ->whereHas('contragent', function ($contragent) {
                    $contragent->where(DB::raw($this->column()), $this->operator(), $this->get($this->name()));
                });

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

        return 'contragents.user_id';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return ['' => trans('site::messages.select_no_matter')] +
            User::query()
                ->whereHas('contragents', function ($contragent){
                    $contragent->has('contracts');
                })
                ->orderBy('name')
                ->pluck('name', 'id')
                ->map(function ($item, $key) {
                    return str_limit($item, config('site.name_limit', 25));
                })
                ->toArray();
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::contragent.user_id');
    }

}