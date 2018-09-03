<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ActiveFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->where('active', 1);

        return $builder;
    }
}