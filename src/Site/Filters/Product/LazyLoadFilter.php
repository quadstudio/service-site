<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class LazyLoadFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->with(['type', 'brand', 'prices', 'analogs', 'details', 'relations', 'images']);
        return $builder;
    }

}