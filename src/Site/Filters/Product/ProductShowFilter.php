<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ProductShowFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where(config('site.check_field'), 1);
    }
}