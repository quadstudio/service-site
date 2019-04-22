<?php

namespace QuadStudio\Service\Site\Filters\Region;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class RegionMounterMapFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereHas('addresses', function ($query) {
            $query
                ->where('type_id', 2)
                ->where('is_mounter', 1)
                ->where('active', 1)
                ->whereHas('users', function ($query) {
                    $query
                        ->where('active', 1)
                        ->where('display', 1);
                });
        });

        return $builder;
    }

}