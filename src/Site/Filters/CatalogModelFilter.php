<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class CatalogModelFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->where('model', 1);
        return $builder;
    }
}