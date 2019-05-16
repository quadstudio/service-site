<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class MemberRunnedFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder
            ->whereIn("status_id", [2])
            ->where("verified", 1)
            ->orderBy('date_from', 'ASC');
    }
}
