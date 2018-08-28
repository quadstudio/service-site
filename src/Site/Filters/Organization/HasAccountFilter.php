<?php

namespace QuadStudio\Service\Site\Filters\Organization;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class HasAccountFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereNotNull('account_id');
        return $builder;
    }

}