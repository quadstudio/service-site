<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Repo\Filters\BootstrapCheckbox;

class UserIsServiceFilter extends Filter
{
    use BootstrapCheckbox;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->where('admin', 0);

        return $builder;
    }

}