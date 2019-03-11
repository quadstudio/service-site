<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class EventFsfFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where("type_id", 1);
    }
}
