<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use Illuminate\Support\Facades\Auth;

class BelongsUserFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->where($repository->getTable().'.user_id', Auth::user()->getAuthIdentifier());
        return $builder;
    }
}