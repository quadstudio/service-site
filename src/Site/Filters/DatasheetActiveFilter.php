<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DatasheetActiveFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->where($repository->getTable().'.active', 1);
        return $builder;
    }

}