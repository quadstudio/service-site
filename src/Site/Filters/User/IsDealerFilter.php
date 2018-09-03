<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class IsDealerFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->whereHas('roles', function ($query) {
            $query->where('name', 'dealer');
        });

        return $builder;
    }
}