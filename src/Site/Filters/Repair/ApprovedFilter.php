<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ApprovedFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->where("repairs.status_id", 5)
            ->join("users", "repairs.user_id", '=', "users.id")
            ->orderBy("users.name");

        return $builder;
    }
}