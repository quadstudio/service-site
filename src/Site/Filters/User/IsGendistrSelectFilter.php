<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class IsGendistrSelectFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && $this->filled($this->name())) {
            switch ($this->get($this->name())) {
                case "1":
                    $builder = $builder->whereHas('roles', function ($query) {
                        $query->where($this->column(), "gendistr");
                    });
                    break;
                case "0":
                    $builder = $builder->whereDoesntHave('roles', function ($query) {
                        $query->where($this->column(), "gendistr");
                    });
                    break;
            }
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'gendistr';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'name';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::user.is_gendistr');
    }
}
