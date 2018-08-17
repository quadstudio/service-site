<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class HasApprovedRepairFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->whereHas("repairs", function($query){
                $query->whereStatusId(5);
            })
            ->orderBy("name");

        return $builder;
    }
}