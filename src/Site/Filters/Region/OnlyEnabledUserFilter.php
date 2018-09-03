<?php

namespace QuadStudio\Service\Site\Filters\Region;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class OnlyEnabledUserFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereHas('addresses', function ($query) {
            $query
                ->where('addresses.type_id', 2)
                ->whereHas('users', function ($query) {
                    $query
                        ->where('users.active', 1)
                        ->where('users.display', 1);
                });
        });

        return $builder;
    }

}