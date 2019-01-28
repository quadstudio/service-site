<?php

namespace QuadStudio\Service\Site\Filters\EventType;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ActiveFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where('active', 1);
    }

}