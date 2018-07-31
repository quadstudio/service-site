<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class EnabledFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->where('enabled', 1);
        return $builder;
    }
}