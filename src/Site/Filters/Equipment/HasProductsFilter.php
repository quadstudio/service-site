<?php

namespace QuadStudio\Service\Site\Filters\Equipment;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\Product;

class HasProductsFilter extends Filter
{

    /**
     * @param $builder
     * @param RepositoryInterface $repository
     * @return mixed
     */
    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->has('products');

        return $builder;
    }

}