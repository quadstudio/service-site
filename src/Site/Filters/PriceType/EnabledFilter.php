<?php

namespace QuadStudio\Service\Site\Filters\PriceType;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class EnabledFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where("enabled", 1);
    }
}