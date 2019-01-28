<?php

namespace QuadStudio\Service\Site\Filters\News;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class LimitSixFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->limit(6);
    }
}