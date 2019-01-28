<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class EventRunnedFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where("status_id", 2);
    }
}