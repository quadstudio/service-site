<?php

namespace QuadStudio\Service\Site\Filters\Authorization;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\User;

class MountingUserFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return ['' => trans('site::messages.select_no_matter')] + User::query()->has('mountings')
                ->orderBy('name')
                ->pluck('name', 'id')
                ->map(function ($item, $key) {
                    return str_limit($item, config('site.name_limit', 25));
                })
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
        return trans('site::mounting.user_id');
    }

}