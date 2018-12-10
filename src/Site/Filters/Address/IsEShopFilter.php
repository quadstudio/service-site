<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class IsEShopFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where('is_eshop', 1);
    }

}