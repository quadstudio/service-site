<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class SortByWeightFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->orderBy("addresses.sort_order");
    }

}