<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class MountingFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->has("mounting_bonus");

        return $builder;
    }

}