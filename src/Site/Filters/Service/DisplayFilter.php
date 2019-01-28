<?php

namespace QuadStudio\Service\Site\Filters\Service;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DisplayFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->where(env('DB_PREFIX', '') . $repository->getTable() . '.display', 1);

        return $builder;
    }
}