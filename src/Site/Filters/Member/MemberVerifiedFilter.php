<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class MemberVerifiedFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where("verified", 1);
    }
}