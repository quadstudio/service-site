<?php

namespace QuadStudio\Service\Site\Filters\Announcement;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class PublishedFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where(config('site.check_field'), 1);
    }
}