<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Rbac\Models\Role;
use QuadStudio\Repo\Contracts\RepositoryInterface;

use QuadStudio\Repo\Filters\BootstrapDropdownCheckbox;
use QuadStudio\Repo\Filters\CheckboxFilter;

class UserRoleFilter extends CheckboxFilter
{
    use BootstrapDropdownCheckbox;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if($this->has($this->name()) && $this->filled($this->name())){
            $builder = $builder->whereHas('roles', function ($query){
                $query->whereIn('id', $this->get($this->name()));
            });
            //$builder = $builder->where('quantity', '>', 0);
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
        return Role::where('id', '!=', 1)->get()->pluck('title', 'id')->toArray();
    }

    /**
     * @return string
     */
    function name(): string
    {
        return 'roles';
    }

    /**
     * Options
     *
     * @return string
     */
    function value(): string
    {
        return '';
    }

    protected function label()
    {
        return trans('rbac::role.roles');
    }
}