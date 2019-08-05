<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class UserDoesntHaveUnsubscribeFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->doesntHave("unsubscribe");

    }
}