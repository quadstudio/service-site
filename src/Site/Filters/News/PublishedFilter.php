<?php

namespace QuadStudio\Service\Site\Filters\News;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class PublishedFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where("published", 1);
    }
}