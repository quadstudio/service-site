<?php

namespace QuadStudio\Service\Site\Filters\FileType;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DatasheetFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereGroupId(2);
        return $builder;
    }

}