<?php

namespace QuadStudio\Service\Site\Filters\Authorization;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\AuthorizationRole;
use QuadStudio\Service\Site\Models\AuthorizationType;

class AuthorizationRoleSelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($this->get($this->name()))) {
            $builder = $builder
                ->join(
                'authorization_roles',
                'authorization_roles.role_id',
                '=',
                'authorizations.role_id'
            )
                ->where(DB::raw($this->column()), $this->operator(), $this->get($this->name()));
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
        return AuthorizationRole::query()
            ->pluck('name', 'id')
            ->prepend(trans('site::messages.select_from_list'), '')
            ->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'role';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'authorization_roles.id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::authorization_role.authorization_roles');
    }
}