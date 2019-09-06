<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class BelongsUserFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->where($repository->getTable().'.user_id', auth()->user()->getAuthIdentifier());
        return $builder;
    }
}