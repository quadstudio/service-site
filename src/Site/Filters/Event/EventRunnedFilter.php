<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class EventRunnedFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->whereIn("status_id", [1,2,3] );
    }
}