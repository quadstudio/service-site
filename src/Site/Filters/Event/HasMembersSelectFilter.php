<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;

class HasMembersSelectFilter extends WhereFilter
{


    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->has($this->name()) && $this->filled($this->name())) {
            if ($this->get($this->name()) == 0) {
                $builder = $builder->whereDoesntHave('members');
            } else {
                $builder = $builder->whereHas('members');
            }

        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'has_members';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return [
            ''  => trans('site::messages.select_no_matter'),
            '0' => trans('site::messages.no'),
            '1' => trans('site::messages.yes'),
        ];
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return '';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::event.filter.has_members');
    }
}