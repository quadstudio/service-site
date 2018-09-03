<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Repo\Filters\BootstrapCheckbox;

class IsServiceFilter extends Filter
{
    use BootstrapCheckbox;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->where('admin', 0);

        return $builder;
    }

}