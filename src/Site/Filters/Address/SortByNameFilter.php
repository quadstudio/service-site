<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class SortByNameFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->orderBy("addresses.name");
    }

}