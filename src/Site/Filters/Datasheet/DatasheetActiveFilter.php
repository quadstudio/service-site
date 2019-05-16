<?php

namespace QuadStudio\Service\Site\Filters\Datasheet;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DatasheetActiveFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        return $builder->where('active', 1);
    }
}